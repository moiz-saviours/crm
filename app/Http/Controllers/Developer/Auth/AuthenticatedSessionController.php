<?php

namespace App\Http\Controllers\Developer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Developer\LoginRequest as DeveloperLoginRequest;
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
        return view('developer.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(DeveloperLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route('developer.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('developer')->logout();

        /** It will destroy every user session */
//        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('developer.login'));
    }
}
