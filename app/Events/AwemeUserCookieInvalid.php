<?php

namespace App\Events;

use App\AwemeUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AwemeUserCookieInvalid
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $awemeUser;

    /**
     * AwemeUserCookieInvalid constructor.
     * @param AwemeUser $awemeUser
     */
    public function __construct(AwemeUser $awemeUser)
    {
        $this->awemeUser = $awemeUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
