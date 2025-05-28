<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authenticate implements AuthenticatesRequests
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * The callback that should be used to generate the authentication redirect path.
     *
     * @var callable
     */
    protected static $redirectToCallback;

    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Specify the guards for the middleware.
     *
     * @param string $guard
     * @param string $others
     * @return string
     */
    public static function using($guard, ...$others)
    {
        return static::class . ':' . implode(',', [$guard, ...$others]);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                $route = $request->path();
                if ($guard == 'admin' && (Route::is('developer.*') || str_contains($route, 'developer'))) {
                    $newRoute = str_replace('developer', 'admin', $route);
                    return redirect($newRoute);
                }

                if ($guard == null && ((Route::is('admin.*') || Route::is('developer.*')) || (str_contains($route, 'admin') || str_contains($route, 'developer')))) {
                    $newRoute = str_replace(['admin', 'developer'], '', $route);
                    return redirect($newRoute);
                }

                return $next($request);
            }
        }
        $this->unauthenticated($request, $guards);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }
        $this->unauthenticated($request, $guards);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            $request->expectsJson() ? null : $this->redirectTo($request),
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo(Request $request)
    {
        if (Route::is('developer.*') && !$this->auth->guard('developer')->check()) {
            return route('developer.login');
        }

        if (Route::is('admin.*') && !$this->auth->guard('admin')->check()) {
            return route('admin.login');
        }

        if (Route::is('.*') && !$this->auth->guard('web')->check()) {
            return route('login');
        }
        if (static::$redirectToCallback) {
            return call_user_func(static::$redirectToCallback, $request);
        }
        return route('login');
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
