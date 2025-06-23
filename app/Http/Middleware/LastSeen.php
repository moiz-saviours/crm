<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        }
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
        }
        if (isset($user)) {
            if (!$user->last_seen) {
                session()->put('show_tour', true);
            }
            $user->last_seen = now();
            $user->saveQuietly();
        }
        return $next($request);
    }
}
