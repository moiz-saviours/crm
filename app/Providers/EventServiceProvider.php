<?php

namespace App\Providers;

use App\Events\AdminVerified;
use App\Events\UserVerified;
use App\Listeners\ActivateNewAdminRegistration;
use App\Listeners\ActivateNewUserRegistration;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected array $listen = [
        UserVerified::class => [
            ActivateNewUserRegistration::class,
        ],
        AdminVerified::class => [
            ActivateNewAdminRegistration::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];
}
