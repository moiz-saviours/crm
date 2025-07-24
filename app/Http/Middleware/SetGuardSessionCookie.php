<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetGuardSessionCookie
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin/*')) {
            config(['session.cookie' => 'admin_session']);
        } elseif ($request->is('developer/*')) {
            config(['session.cookie' => 'developer_session']);
        }
        return $next($request);
    }
}
