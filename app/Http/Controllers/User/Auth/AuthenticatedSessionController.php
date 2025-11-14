<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\TwoFactorService;
use App\Traits\ForceLogoutTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use function redirect;
use function route;
use function view;

class AuthenticatedSessionController extends Controller
{
    use ForceLogoutTrait;
    protected TwoFactorService $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        session(['AuthenticatedSessionController' => session('AuthenticatedSessionController') + 1, 'AuthenticatedSessionControllerNow' => [now()->format('Y-m-d H:i:s.v')]]);
        return view('user.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        Log::info('User authenticated with guard', ["intended_url" => session("url.intended"), 'sessions' => session()->all()]);
        return redirect()->route('user.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::guard('web')->user();
        session()->put("web_2fa_verified:{$user->id}", false);
        if ($user) {
            Cache::forget("web_2fa_verified:{$user->id}");
            $deviceId = $this->twoFactorService->generateDeviceFingerprint();
            $this->twoFactorService->deleteCode($user, $deviceId);
        }
        $this->forceLogoutUser($user);
        Auth::guard('web')->logout();
        /** It will destroy every user session */
//        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
