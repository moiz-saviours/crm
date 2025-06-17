<?php

namespace App\Http\Middleware;

use App\Models\VerificationCode;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::getDefaultDriver();
        if ($this->isTwoFactorRoute($request, $guard)) {
            return $next($request);
        }
        $user = Auth::guard($guard)->user();
        if (!$user) {
            return $next($request);
        }
        if (session($guard . '_2fa_verified')) {
            return $next($request);
        }
        $verified = VerificationCode::where('morph_id', $user->id)
            ->where('morph_type', get_class($user))
            ->whereNotNull('verified_at')
            ->where('verified_at', '>', now()->subHours(2))
            ->exists();
        if ($verified) {
            session([$guard . '_2fa_verified' => true]);
            return $next($request);
        }
        if (!session()->has($guard . '_login_credentials')) {
            session()->put($guard . '_reauth_user_id', $user->id);
            Auth::guard($guard)->logout();
            return redirect()->route(($guard == "web" ? "" : $guard . ".") . 'login')
                ->with('message', 'Please complete 2FA verification to continue');
        }
        $route = $guard == 'web' ? '2fa.show' : $guard . '.2fa.show';
        return redirect()->route($route);
    }

    protected function isTwoFactorRoute(Request $request, string $guard): bool
    {
        $prefix = $guard === 'web' ? '' : $guard . '.';
        $twoFactorRoutes = [
            $prefix . '2fa.show',
            $prefix . '2fa.verify',
            $prefix . '2fa.send',
            $prefix . 'login'
        ];
        return $request->routeIs($twoFactorRoutes);
    }
}
