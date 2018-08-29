<?php

namespace Modules\Users\Events;

use Illuminate\Queue\SerializesModels;

class NewUserRegistered
{
    use SerializesModels;

    /**
     * the registered user
     *
     * @var \App\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
