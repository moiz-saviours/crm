<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilterAssetRequests
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        session(['FilterAssetRequests' => session('FilterAssetRequests') + 1, 'FilterAssetRequestsNow'=>[now()->format('Y-m-d H:i:s.v')]]);
        if ($this->isAsset($request)) {
            return $next($request);
        }
        return $next($request);
    }

    protected function isAsset(Request $request): bool
    {
        return $request->is([
            '*.css',
            '*.js',
            '*.png',
            '*.jpg',
            '*.jpeg',
            '*.gif',
            '*.ico',
            '*.svg',
            '*.woff',
            '*.woff2',
            '*.ttf',
            '*.map'
        ]);
    }
}
