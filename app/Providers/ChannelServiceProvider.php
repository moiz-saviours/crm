<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ChannelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $host = request()->getHost();
            $port = request()->getPort();
            $environment = app()->environment();
            if ($environment === 'local') {
                $mainDomain = "localhost:$port";
            } else {
                $host = preg_replace('/^www\./', '', $host);
                $parts = explode('.', $host);
                $mainDomain = count($parts) >= 2 ? $parts[count($parts) - 2] : $host;
            }
            $channelMap = config('channels');
            $currentChannel = $channelMap[$mainDomain] ?? 'Unknown Channel';
            $channelCheckRoute = null;
            if (Auth::guard('admin')->check()) $channelCheckRoute = route('admin.check.channels');
            elseif (Auth::guard('developer')->check()) $channelCheckRoute = route('developer.check.channels');
            elseif (Auth::guard('web')->check()) $channelCheckRoute = route('check.channels');
            $view->with([
                'currentChannel' => $currentChannel,
                'currentDomain' => $mainDomain,
                'channelMap' => $channelMap,
                'channelCheckRoute' => $channelCheckRoute,
            ]);
        });
    }
}
