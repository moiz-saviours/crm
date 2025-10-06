<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The verified user.
     *
     * @var MustVerifyEmail
     */
    public MustVerifyEmail $user;

    /**
     * Create a new event instance.
     *
     * @param MustVerifyEmail $user
     * @return void
     */
    public function __construct(MustVerifyEmail $user)
    {
        $this->user = $user;
    }
}
