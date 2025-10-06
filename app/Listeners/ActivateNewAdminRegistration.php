<?php

namespace App\Listeners;

use App\Events\AdminVerified;
use App\Models\Admin;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivateNewAdminRegistration
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * @note    find the admin, via the $event, since now
     *          verified by clicking on the verification link in email
     *
     *          the email_verified_at column is updated once admin clicks on the
     *          verification link, and not before
     */
    public function handle(AdminVerified $event): void
    {
        $user = Admin::find($event->user->id);
        $user->update([
//            'active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
