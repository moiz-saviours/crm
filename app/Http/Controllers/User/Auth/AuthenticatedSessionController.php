<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use function redirect;
use function route;
use function view;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('user.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(route('user.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId = Auth::guard('web')->id();
        Auth::guard('web')->logout();
        /** It will destroy every user session */
//        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->put('web_2fa_verified', false);
        if ($userId) {
            Cache::forget("web_2fa_verified:{$userId}");
        }
        return redirect('/login');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
