<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class VerifyCrossDomainToken
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !$request->has('access_token')) {
            return $next($request);
        }
        if (!$request->has('access_token')) {
            /** It will automatically redirect to log-in if not logged in */
            return $next($request);
        }
        try {
            $key = base64_decode('AxS9/+trvgrFBcvBwuYl0kjVocGf8t+eiol6LtErpck=');
            $encrypter = new Encrypter($key, 'AES-256-CBC');
            $decrypted = $encrypter->decrypt($request->access_token);
            if (now()->gt($decrypted['expires_at'])) {
                abort(403, 'Token expired');
            }
            if ($decrypted['ip_address'] !== $request->ip()) {
                abort(403, 'IP address mismatch');
            }
            $userModel = $this->getUserModelForTable($decrypted['table']);
            if (!$userModel) {
                abort(403, 'Invalid user table');
            }
            $user = $userModel::where('email', $decrypted['email'])
                ->where('status', 1)
                ->first();
            if (!$user) {
                abort(403, 'User not found or inactive');
            }
            $guard = $request->route()?->middleware()
                ? collect($request->route()->middleware())->first(fn($m) => str_starts_with($m, 'auth:'))
                : null;
            $guard = $guard ? explode(':', $guard)[1] : 'web';

            Auth::guard($guard)->login($user);
            return Redirect::to($request->url());

        } catch (\Exception $e) {
            abort(403, 'Invalid access token: ' . $e->getMessage());
        }
    }
    protected function getUserModelForTable(string $table): ?string
    {
        $models = [
            'users' => \App\Models\User::class,
            'admins' => \App\Models\Admin::class,
        ];

        return $models[$table] ?? null;
    }
}
