<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
//    /**
//     * The root template that's loaded on the first page visit.
//     *
//     * @see https://inertiajs.com/server-side-setup#root-template
//     *
//     * @var string
//     */
//    protected $rootView = 'app';
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @param Request $request
     * @return string
     */
    public function rootView(Request $request): string
    {
        if (Auth::guard('admin')->check()) {
            return 'admin.layouts.inertia';
        }
        if (Auth::guard('web')->check()) {
            return 'user.layouts.inertia';
        }
        if ($request->is('admin/*')) {
            return 'admin.layouts.inertia';
        }
        if ($request->is('user/*')) {
            return 'user.layouts.inertia';
        }
        return 'app';
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            //
        ];
    }
}
