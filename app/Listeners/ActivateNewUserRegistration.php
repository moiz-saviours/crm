<?php

namespace App\Listeners;

use App\Events\UserVerified;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivateNewUserRegistration
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event when a user's email has been verified, activating
     * an account by updating the active column
     *
     * @param UserVerified $event An instance of the event holding data about the user
     * @return  void
     */
    public function handle(UserVerified $event): void
    {
        $user = User::find($event->user->id);
        $user->update([
//            'active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
