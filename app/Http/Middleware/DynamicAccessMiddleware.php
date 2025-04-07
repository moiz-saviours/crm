<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class DynamicAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return $this->unauthorizedResponse($request, 'Please log in to access this resource.');
        }
        if (!$user->department) {
            return $this->unauthorizedResponse($request, 'You do not have any department assigned.');
        }
        $accessRules = config('access_rules');
        $routeName = $request->route()->getName();
        $department = strtolower($user->department->name);
        if (array_key_exists($department, $accessRules)) {
            $departmentRules = $accessRules[$department];
            if (isset($departmentRules['routes']) && in_array($routeName, $departmentRules['routes'])) {
                return $next($request);
            }
            if (isset($departmentRules['roles'])) {
                $roleRules = $departmentRules['roles'][$user->role->name] ?? [];
                if (isset($roleRules['routes']) && in_array($routeName, $roleRules['routes'])) {
                    return $next($request);
                }
                if (isset($roleRules['restrictions']) && in_array($routeName, $roleRules['restrictions'])) {
                    return $this->handleUnauthorizedAccess($request, $departmentRules, $roleRules);
                }
            }
        }
        return $this->handleUnauthorizedAccess($request, $departmentRules);
    }

    /**
     * Handle unauthorized access.
     *
     * @param Request $request
     * @param array $departmentRules
     * @param array|null $roleRules
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleUnauthorizedAccess(Request $request, array $departmentRules, ?array $roleRules = null): Response
    {
        $previousUrl = $request->headers->get('referer');
        if ($previousUrl && str_contains($previousUrl, 'login')) {
            return $this->redirectToDashboard($request, $departmentRules, $roleRules);
        }
        return $this->unauthorizedResponse($request, "You don't have permission to perform this action.");
    }

    /**
     * Redirect the user to a dashboard route if available.
     *
     * @param array $departmentRules
     * @param array|null $roleRules
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToDashboard(Request $request, array $departmentRules, ?array $roleRules = null): Response
    {
        if (isset($departmentRules['routes'])) {
            foreach ($departmentRules['routes'] as $route) {
                if (str_contains($route, 'dashboard')) {
                    if (Route::has($route)) {
                        return $this->redirectResponse($request, $route, "You don't have permission to perform this action.");
                    }
                }
            }
        }
        if ($roleRules && isset($roleRules['routes'])) {
            foreach ($roleRules['routes'] as $route) {
                if (str_contains($route, 'dashboard')) {
                    if (Route::has($route)) {
                        return $this->redirectResponse($request, $route, "You don't have permission to perform this action.");
                    }
                }
            }
        }
        return $this->unauthorizedResponse($request, 'Dashboard not found. Please contact support.');
    }

    /**
     * Handle unauthorized responses for both API and web routes.
     *
     * @param Request $request
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    private function unauthorizedResponse(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $message], 403);
        }
        Auth::logout();
        return redirect()->route('login')->with('error', $message);
    }

    /**
     * Handle redirect responses for both API and web routes.
     *
     * @param Request $request
     * @param string $route
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    private function redirectResponse(Request $request, string $route, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $message], 403);
        }
        return redirect()->route($route)->with('error', $message);
    }
}
