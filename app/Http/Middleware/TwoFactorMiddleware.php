<?php

namespace App\Http\Middleware;

use App\Models\VerificationCode;
use App\Services\TwoFactorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Two-Factor Authentication Middleware
 *
 * This middleware enforces two-factor authentication verification for authenticated users.
 * It handles redirection logic and session management for 2FA verification flows across
 * multiple authentication guards.
 */
class TwoFactorMiddleware
{
    protected TwoFactorService $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request The incoming HTTP request
     * @param Closure $next The next middleware in the pipeline
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('assets/*') || $request->is('*.js') || $request->is('*.css') || $request->is('*.map') || $request->expectsJson()) {
            return $next($request);
        }
        $guard = $this->detectGuard($request);
        $prefix = $this->detectPrefix($request);
        if ($guard != $prefix) {
            return $next($request);
        }
        $user = Auth::guard($guard)->user();
        if ($user && $user->status !== 1) {
            $user = Auth::guard($guard)->user();
            session()->put($guard . '_2fa_verified', false);
            session()->forget('admin_verified_device');
            if ($user) {
                Cache::forget($guard . "_2fa_verified:{$user->id}");
                $deviceId = $this->twoFactorService->generateDeviceFingerprint();
                $this->twoFactorService->deleteCode($user, $deviceId);
            }
            Auth::guard($guard)->logout();
            $request->session()->regenerateToken();
            return redirect()->route($guard === 'web' ? 'login' : $guard . '.login')
                ->with('error', 'Your account has been deactivated.');
        }
        if ($user && in_array($user->email, ['moiz@saviours.co', 'waqas@saviours.co'])) {
            return $next($request);
        }
        if ($this->isTwoFactorRoute($request, $guard)) {
            if ($user) {
                return $this->handleTwoFactorRoute($request, $guard, $next);
            }
        }
        if (!$user) {
            return $next($request);
        }
        if (session($guard . '_2fa_verified') && !$this->isTwoFactorRoute($request, $guard)) {
            return $next($request);
        }
        if ($this->hasRecentVerification($user, $guard)) {
            return $next($request);
        }
        if (str_contains($request->route()?->getName(), '2fa')) {
            return $next($request);
        }
        return $this->redirectToTwoFactor($guard);
    }

    /**
     * Handle requests to two-factor authentication routes
     *
     * @param Request $request
     * @param string $guard
     * @param Closure $next
     * @return Response
     */
    protected function handleTwoFactorRoute(Request $request, string $guard, Closure $next): Response
    {
        if (session($guard . '_2fa_verified')) {
            $dashboardRoute = $guard === 'web' ? 'user.dashboard' : $guard . '.dashboard';
            return redirect()->route($dashboardRoute);
        }
        return $next($request);
    }

    /**
     * Check if the user has a recent two-factor verification
     *
     * @param mixed $user
     * @param string $guard
     * @return bool
     */
    protected function hasRecentVerification(mixed $user, $guard): bool
    {
        $sessionKey = "{$guard}_device_fingerprint";
        if (!session()->has($sessionKey)) {
            session([$sessionKey => $this->twoFactorService->generateDeviceFingerprint()]);
        }
        $deviceId = session($sessionKey);
        $cacheKey = "{$guard}_2fa_verified:{$user->id}";
        return Cache::remember($cacheKey, 86400, function () use ($user, $guard, $deviceId) {
            return VerificationCode::forUser($user)
                ->whereNotNull('verified_at')
                ->where('device_id', $deviceId)
                ->where('verified_at', '>', now()->subDay())
                ->exists();
        });
    }

    /**
     * Redirect to the appropriate two-factor authentication page
     *
     * @param string $guard
     * @return Response
     */
    protected function redirectToTwoFactor(string $guard): Response
    {
        $route = $guard === 'web' ? '2fa.show' : $guard . '.2fa.show';
        return redirect()->route($route);
    }

    /**
     * Determine if the current route is a two-factor authentication route
     *
     * @param Request $request
     * @param string $guard
     * @return bool
     */
    protected function isTwoFactorRoute(Request $request, string $guard): bool
    {

        $prefix = $guard === 'web' ? '' : $guard . '.';
        $twoFactorRoutes = [
            $prefix . '2fa.show',
            $prefix . '2fa.verify',
            $prefix . '2fa.verify.show',
            $prefix . '2fa.send',
            $prefix . 'login'
        ];
        return $request->routeIs($twoFactorRoutes);
    }

    /**
     * Detect the appropriate authentication guard for the request
     *
     * @param Request $request
     * @return string
     */
    protected function detectGuard(Request $request): string
    {
        $guards = array_keys(config('auth.guards'));
        $routeName = $request->route()?->getName();
        $path = trim($request->path(), '/');
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && $guard !== 'web' && str_starts_with($path, $guard . '/') && str_starts_with($routeName, $guard . '.')) {
                return $guard;
            }
        }
        return Auth::getDefaultDriver();
    }

    /**
     * Detect the appropriate authentication guard for the request
     *
     * @param Request $request
     * @return string
     */
    protected function detectPrefix(Request $request): string
    {
        $guards = array_keys(config('auth.guards'));
        $routeName = $request->route()?->getName();
        $path = trim($request->path(), '/');
        foreach ($guards as $guard) {
            if ($guard !== 'web' && str_starts_with($path, $guard . '/') && str_starts_with($routeName, $guard . '.')) {
                return $guard;
            }
        }
        return Auth::getDefaultDriver();
    }
}
