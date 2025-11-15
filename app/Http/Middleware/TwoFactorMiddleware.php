<?php

namespace App\Http\Middleware;

use App\Models\VerificationCode;
use App\Services\TwoFactorService;
use App\Traits\ForceLogoutTrait;
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
    use ForceLogoutTrait;

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
        if (!$user) {
            $currentPath = request()->path();
            if (str_starts_with($currentPath, 'admin')) {
                return redirect()->route('admin.login');
            }
            if (str_starts_with($currentPath, 'developer')) {
                return redirect()->route('developer.login');
            }
            return redirect()->route('login');
        }
        if ($user && $this->shouldForceLogout($user, $guard)) {
            $this->forceLogout($user, $guard, $request);
            return redirect()->route($guard === 'web' ? 'login' : $guard . '.login')
                ->with('error', 'Your session has been terminated due to account changes.');
        }
        if ($user->status !== 1) {
            $this->forceLogout($user, $guard, $request);
            return redirect()->route($guard === 'web' ? 'login' : $guard . '.login')
                ->with('error', 'Your account has been deactivated.');
        }
//        if ($user && in_array($user->email, ['moiz@saviours.co', 'waqas@saviours.co'])) {
//            return $next($request);
//        }
        if ($this->isTwoFactorRoute($request, $guard)) {
            return $this->handleTwoFactorRoute($request, $guard, $user, $next);
        }
        if (session($guard . "_2fa_verified:{$user->id}") && !$this->isTwoFactorRoute($request, $guard)) {
            return $next($request);
        }
        if ($this->hasRecentVerification($user, $guard, $request->ip())) {
            return $next($request);
        }
        if (str_contains($request->route()?->getName(), '2fa')) {
            return $next($request);
        }
        return $this->redirectToTwoFactor($guard);
    }

    /**
     * Check if user should be force logged out due to admin changes
     *
     * @param mixed $user
     * @param string $guard
     * @return bool
     */
    protected function shouldForceLogout(mixed $user, string $guard): bool
    {
        $userSignatureKey = "{$guard}_user_signature:{$user->id}";
        $currentSignature = $this->generateUserSignature($user);
        $storedSignature = Cache::get($userSignatureKey);
        if (!$storedSignature) {
            Cache::put($userSignatureKey, $currentSignature, 86400); // 24 hours
            return false;
        }
        return $storedSignature !== $currentSignature;
    }

    /**
     * Force logout user and clear all sessions
     *
     * @param mixed $user
     * @param string $guard
     * @param Request $request
     * @return void
     */
    protected function forceLogout(mixed $user, string $guard, Request $request): void
    {
        $this->clearUserSessions($user, $guard);
        $userSignatureKey = "{$guard}_user_signature:{$user->id}";
        Cache::forget($userSignatureKey);
        Auth::guard($guard)->logout();
        $request->session()->regenerateToken();
        Log::info('User force logged out due to account changes', [
            'user_id' => $user->id,
            'guard' => $guard,
            'ip' => $request->ip()
        ]);
    }

    /**
     * Handle requests to two-factor authentication routes
     *
     * @param Request $request
     * @param string $guard
     * @param mixed $user
     * @param Closure $next
     * @return Response
     */
    protected function handleTwoFactorRoute(Request $request, string $guard, mixed $user, Closure $next): Response
    {
        if (session($guard . "_2fa_verified:{$user->id}")) {
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
     * @param string $currentIp
     * @return bool
     */
    protected function hasRecentVerification(mixed $user, string $guard, string $currentIp): bool
    {
        $sessionKey = "{$guard}_device_fingerprint";
        if (!session()->has($sessionKey)) {
            $deviceId = $this->twoFactorService->generateDeviceFingerprint();
            session([$sessionKey => $deviceId]);
        }
        $deviceId = session($sessionKey);
        $hasRecentVerification = VerificationCode::forUser($user)
            ->whereNotNull('verified_at')
            ->where('device_id', $deviceId)
            ->where('verified_at', '>', now()->subDay())
            ->exists();
        if (!$hasRecentVerification) {
            return false;
        }
        return $this->handleIpTracking($user, $guard, $deviceId, $currentIp);
    }

    /**
     * Handle IP tracking - allow max 3 IPs per device (separate from verification records)
     *
     * @param mixed $user
     * @param string $guard
     * @param string $deviceId
     * @param string $currentIp
     * @return bool
     */
    protected function handleIpTracking(mixed $user, string $guard, string $deviceId, string $currentIp): bool
    {
        $ipCacheKey = "{$guard}_device_ips:{$user->id}:{$deviceId}";
        $storedIps = Cache::get($ipCacheKey, []);
        if (in_array($currentIp, $storedIps)) {
            Cache::put($ipCacheKey, $storedIps, 86400);
            return true;
        }
        if (count($storedIps) < 3) {
            $storedIps[] = $currentIp;
            Cache::put($ipCacheKey, $storedIps, 86400);
            Log::info("New IP added for device", ['user_id' => $user->id, 'device_id' => $deviceId, 'new_ip' => $currentIp, 'stored_ips' => $storedIps]);
            return true;
        }
        Log::info("IP limit exceeded, requiring re-verification", ['user_id' => $user->id, 'device_id' => $deviceId, 'current_ip' => $currentIp, 'stored_ips' => $storedIps]);
        $this->clearVerificationForDevice($user, $guard, $deviceId);
        return false;
    }

    /**
     * Clear verification for a specific device when IP limit is exceeded
     *
     * @param mixed $user
     * @param string $guard
     * @param string $deviceId
     * @return void
     */
    protected function clearVerificationForDevice(mixed $user, string $guard, string $deviceId): void
    {
        VerificationCode::forUser($user)->where('device_id', $deviceId)->delete();
        $ipCacheKey = "{$guard}_device_ips:{$user->id}:{$deviceId}";
        Cache::forget($ipCacheKey);
        session()->forget($guard . "_2fa_verified:{$user->id}");
        Log::info("Cleared verification for device due to IP limit", ['user_id' => $user->id, 'device_id' => $deviceId, 'guard' => $guard]);
    }

    /**
     * Clear all user sessions and cache
     *
     * @param mixed $user
     * @param string $guard
     * @return void
     */
    protected function clearUserSessions(mixed $user, string $guard): void
    {
        session()->forget($guard . "_2fa_verified:{$user->id}");
        session()->forget($guard . "_verified_device:{$user->id}");
        session()->forget($guard . "_device_fingerprint");
        Cache::forget("{$guard}_2fa_verified:{$user->id}");
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
