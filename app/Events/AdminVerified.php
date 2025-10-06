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

class AdminVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The verified admin.
     *
     * @var MustVerifyEmail
     */
    public MustVerifyEmail $admin;

    /**
     * Create a new event instance.
     *
     * @param MustVerifyEmail $admin
     * @return void
     */
    public function __construct(MustVerifyEmail $admin)
    {
        $this->admin = $admin;
    }
}
