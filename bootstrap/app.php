<?php

use App\Http\Middleware\Cooldown;
use App\Http\Middleware\DynamicAccessMiddleware;
use App\Http\Middleware\FilterAssetRequests;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\LastSeen;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RestrictAccessMiddleware;
use App\Http\Middleware\RestrictDevAccess;
use App\Http\Middleware\SetGuardSessionCookie;
use App\Http\Middleware\TwoFactorMiddleware;
use App\Http\Middleware\VerifyCrossDomainToken;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

$helperPath = __DIR__ . '/../app/Helpers/Restrict';
if (is_dir($helperPath)) {
    foreach (glob($helperPath . '/*.php') as $file) {
        require_once $file;
    }
}
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('webhooks')->group(function () {
//                require __DIR__ . '/../routes/webhooks.php';
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [LastSeen::class, Cooldown::class,HandleInertiaRequests::class]);
        $middleware->web(prepend: [SetGuardSessionCookie::class, StartSession::class, VerifyCrossDomainToken::class, FilterAssetRequests::class,]);
        $middleware->alias([
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
            '2fa' => TwoFactorMiddleware::class,
            'restrict.dev' => RestrictDevAccess::class,
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
            'dynamic.access' => DynamicAccessMiddleware::class,
            'restricted.ips' => RestrictAccessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 419) {
                return back()->with([
                    'message' => 'Your session expired, please try again..',
                ]);
            }
            return $response;
        });
    })->withSchedule(function (Schedule $schedule) {
//        $schedule->command('sanctum:prune-expired --hours=24')->daily();
    })->create();
