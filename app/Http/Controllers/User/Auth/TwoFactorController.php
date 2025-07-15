<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TwoFactorController extends Controller
{
    protected TwoFactorService $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    public function show(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => __('auth.session_expired')
            ]);
        }
        return view('user.auth.two-factor', compact('user'));
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required|in:email,sms'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = Auth::guard('web')->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
        $method = $request->get('method');
        if ($method === 'sms' && !$user->phone_number) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number not set up for SMS verification'
            ], 400);
        }
        try {
            $verificationCode = $this->twoFactorService->generateCode($user, $method);
            $response = null;
            if ($method === 'email' || $method === 'sms') {
                if ($method === 'email') {
                    $response = $this->twoFactorService->sendEmailCode($user, $verificationCode->code);
                } elseif ($method === 'sms') {
                    $response = $this->twoFactorService->sendSmsCode($user, $verificationCode->code);
                }
                if ($response['success'] === false) {
                    return response()->json([
                        'success' => false,
                        'error' => $response['error'],
                        'method' => $method
                    ], 500);
                }
                $response_data = [
                    'success' => true,
                    'message' => $response['message'],
                    'method' => $method,
                ];
                if ($method === 'sms' && isset($response['response_id'])) {
                    $response_data['response_id'] = $response['response_id'];
                }
                return response()->json($response_data);
            }
            return response()->json([
                'success' => false,
                'error' => 'Failed to send verification code. Please try again later.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to send verification code. Please try again later.', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function verifyShow(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => __('auth.failed')
            ]);
        }
        $lastCode = VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->valid()
            ->latest()
            ->first();
        if (!$lastCode) {
            return redirect()->route('2fa.show');
        }
        return view('user.auth.two-factor-verify', [
            'method' => $lastCode->method,
            'email' => $user->email,
            'status' => $lastCode->status,
            'response_id' => $lastCode->response_id,
        ]);
    }

    public function verify(Request $request)
    {
        $code = is_array($request->input('code')) ? implode('', $request->input('code')) : $request->input('code');
        $request->merge(['code' => $code]);
        $request->validate([
            'code' => 'required|size:6'
        ]);
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => __('auth.failed')
            ]);
        }
        $code = $request->get('code');
        $lastCode = VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->valid()
            ->latest()
            ->first();
        if (!$lastCode) {
            return back()->withErrors(['code' => 'No verification code found. Please request a new one.']);
        }
        if ($this->twoFactorService->verifyCode($user, $code, $lastCode->method)) {
            $request->session()->put('web_2fa_verified', true);
            return redirect()->intended(route('user.dashboard', absolute: false));
        }
        return back()->withErrors(['code' => 'Invalid verification code']);
    }
}
