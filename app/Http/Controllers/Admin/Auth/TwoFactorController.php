<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\VerificationCode;
use App\Services\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\LoginRequest as AdminLoginRequest;

class TwoFactorController extends Controller
{
    protected $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    public function show(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors([
                'email' => __('auth.session_expired')
            ]);
        }
        return view('admin.auth.two-factor', compact('user'));
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required|in:email,sms',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors([
                'email' => __('auth.session_expired')
            ]);
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
                        'message' => $response['message'],
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
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors([
                'email' => __('auth.session_expired')
            ]);
        }
        $lastCode = VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->latest()
            ->valid()
            ->first();
        if (!$lastCode) {
            return redirect()->route('admin.2fa.show');
        }
        return view('admin.auth.two-factor-verify', [
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
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors([
                'email' => __('auth.session_expired')
            ]);
        }
        $code = $request->get('code');
        $lastCode = VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->latest()
            ->valid()
            ->first();
        if (!$lastCode) {
            return back()->withErrors(['code' => 'No verification code found. Please request a new one.']);
        }
        if ($this->twoFactorService->verifyCode($user, $code, $lastCode->method)) {
            $request->session()->put('admin_2fa_verified', true);
            if (!session()->has('session_removing')) {
                $request->session()->put('session_removing', 1);
            } else {
                $request->session()->put('session_removing', session()->get('session_removing') + 1);
            }
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        return back()->withErrors(['code' => 'Invalid verification code']);
    }
}
