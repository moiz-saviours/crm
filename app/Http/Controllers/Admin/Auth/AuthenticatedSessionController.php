<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest as AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(AdminLoginRequest $request): RedirectResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $request->authenticate();

        $request->session()->regenerate();
        $channels = [
            'https://payusinginvoice.com',
            'https://paymentbyinvoice.com',
            'https://paymentviainvoice.com',
            'https://paythroughinvoice.com',
            'https://payviainvoice.com',
        ];

        $loginResults = [];
        $prefix = app()->environment('development') ? '/crm-development' : '';
        foreach ($channels as $url) {
            try {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                ])->timeout(5)->post("$url{$prefix}/api/channel-login", [
                    'email' => $email,
                    'password' => $password, // Must send original password
                ]);

                $loginResults[$url] = $response->json();
            } catch (\Exception $e) {
                $loginResults[$url] = [
                    'status' => 'failed',
                    'error' => $e->getMessage()
                ];
            }
        }
        Log::info('Cross-channel login results', $loginResults);
        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        /** It will destroy every user session */
//        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
