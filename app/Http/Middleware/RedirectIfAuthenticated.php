<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * The callback that should be used to generate the authentication redirect path.
     *
     * @var callable|null
     */
    protected static $redirectToCallback;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (!$this->isPathForGuard($request->path(), $guard) || $this->isGuestRoute($request, $guard)) {
                    return redirect($this->redirectTo($request));
                }
            }
        }
        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (Auth::guard('admin')->check() && Auth::guard('developer')->check()) {
            if (str_contains($request->path(), 'admin')) {
                return route('admin.dashboard');
            } elseif (str_contains($request->path(), 'developer')) {
                return route('developer.dashboard');
            }
        } elseif (Auth::guard('admin')->check()) {
            return route('admin.dashboard');
        } elseif (Auth::guard('developer')->check()) {
            return route('developer.dashboard');
        }
        return static::$redirectToCallback
            ? call_user_func(static::$redirectToCallback, $request)
            : $this->defaultRedirectUri();
    }

    /**
     * Determine if the current request path matches the guard's allowed prefix.
     */
    protected function isPathForGuard(string $path, string $guard): bool
    {
        $guardPrefixes = [
            'admin' => 'admin',
            'developer' => 'developer',
            'web' => '', // No prefix for normal users
        ];
        return isset($guardPrefixes[$guard]) && str_starts_with($path, $guardPrefixes[$guard]);
    }

    /**
     * Determine if the current request path is the login page for a specific guard.
     */
    protected function isLoginPath(Request $request, string $guard): bool
    {
        $guardPrefixes = [
            'admin' => 'admin',
            'developer' => 'developer',
            'web' => '', // No prefix for normal users
        ];
        $loginPrefix = $guardPrefixes[$guard] ?? '';
        return $request->is("{$loginPrefix}/login");
    }

    protected function isGuestRoute(Request $request, string $guard): bool
    {
        $guardPrefixes = [
            'admin' => 'admin',
            'developer' => 'developer',
            'web' => '', // No prefix for normal users
        ];
        $prefix = $guardPrefixes[$guard] ?? '';
        $prefix = $prefix ? "$prefix/" : '';
        $guestRoutes = ['login', 'register', 'forgot-password', 'reset-password', '2fa/show', '2fa/verify', '2fa/send'];
        foreach ($guestRoutes as $route) {
            if ($request->is("{$prefix}{$route}*")) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the default URI the user should be redirected to when they are authenticated.
     */
    protected function defaultRedirectUri(): string
    {
        foreach (['dashboard', 'home'] as $uri) {
            if (Route::has($uri)) {
                return route($uri);
            }
        }
        $routes = Route::getRoutes()->get('GET');
        foreach (['dashboard', 'home'] as $uri) {
            if (isset($routes[$uri])) {
                return '/' . $uri;
            }
        }
        return '/';
    }

    /**
     * Specify the callback that should be used to generate the redirect path.
     *
     * @param callable $redirectToCallback
     * @return void
     */
    public static function redirectUsing(callable $redirectToCallback)
    {
        static::$redirectToCallback = $redirectToCallback;
    }
}
