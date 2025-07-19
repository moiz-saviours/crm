<?php

namespace App\Http\Middleware;

use App\Models\VerificationCode;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
    /**
     * Handle an incoming request.
     *
     * @param Request $request The incoming HTTP request
     * @param Closure $next The next middleware in the pipeline
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = $this->detectGuard($request);
        $user = Auth::guard($guard)->user();
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
            session([$guard . '_2fa_verified' => true]);
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
        return Cache::remember("{$guard}_2fa_verified:{$user->id}", 300, function () use ($user) {
            return VerificationCode::where('morph_id', $user->id)
                ->where('morph_type', get_class($user))
                ->whereNotNull('verified_at')
                ->where('verified_at', '>', now()->subHours(2))
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
        $routeName = $request->route()?->getName();
        $guards = ['admin', 'developer', 'web'];
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && str_starts_with($routeName ?? '', $guard)) {
                return $guard;
            }
        }
        return Auth::getDefaultDriver();
    }
}
