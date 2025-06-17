<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if ($reauthUserId = session('web_reauth_user_id')) {
            $user = Auth::guard('web')->getProvider()->retrieveById($reauthUserId);
            if ($user) {
                session()->put('web_login_credentials', [
                    'email' => $user->email,
                    'password' => 'placeholder', // Actual password not needed here
                    'remember' => false
                ]);
                session()->forget('web_reauth_user_id');
                return redirect()->route('2fa.show');
            }
        }
        if (!Auth::guard('web')->validate($request->only('email', 'password'))) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ]);
        }
        $request->session()->put('web_login_credentials', [
            'email' => $request->email,
            'password' => $request->password,
            'remember' => $request->filled('remember')
        ]);

        return redirect()->route('2fa.show');
//        $request->authenticate();
//
//        $request->session()->regenerate();
//
//        return redirect()->intended(route('user.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        /** It will destroy every user session */
//        $request->session()->invalidate();

        $request->session()->regenerateToken();
        session()->forget('web_2fa_verified');

        return redirect('/login');
    }
    protected function guard()
    {
        return Auth::guard('web');
    }
}
