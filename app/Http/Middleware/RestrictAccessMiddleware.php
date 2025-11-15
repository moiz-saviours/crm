<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $restrictedIps = [
            '154.47.22.85',
            '193.56.253.50',
            '185.213.193.146',
        ];
        $bypassIps = [
            '127.0.0.1', /** LocalHost */
            '202.47.32.131', /** Stellers */
            '116.0.40.78',
            '103.164.49.42',
            '203.130.30.50', /** Trefid */
            '202.63.199.170',
            '101.53.224.227',
            '202.47.34.92', /** Genx */
            '116.0.40.86',
            '103.164.49.42',/** Saviours */
        ];
        $userIp = $request->ip();
        foreach ($restrictedIps as $restrictedPrefix) {
            if (str_starts_with($userIp, $restrictedPrefix)) {
                abort(403, 'Access denied.');
            }
        }
        if (in_array($userIp, $bypassIps)) {
            return $next($request);
        }
        return $next($request);
        abort(403, 'Access denied.');
    }
}
