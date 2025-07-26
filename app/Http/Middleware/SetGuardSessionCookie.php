<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $appName = Str::slug(config('app.name', 'laravel'), '_');
        $appEnv = Str::slug(config('app.env', 'local'), '_');
        if ($request->is('admin/*')) {
            config(['session.cookie' => "{$appName}_admin_{$appEnv}_session"]);
        } elseif ($request->is('developer/*')) {
            config(['session.cookie' => "{$appName}_developer_{$appEnv}_session"]);
        }
        return $next($request);
    }
}
