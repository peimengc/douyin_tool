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

class AwemeUserFollowSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $followedAwemeUser;
    public $followAwemeUser;
    public $followResponse;

    /**
     * AwemeUserFollowError constructor.
     * @param AwemeUser $followedAwemeUser
     * @param AwemeUser $followAwemeUser
     * @param $followResponse
     */
    public function __construct(
        AwemeUser $followedAwemeUser,
        AwemeUser $followAwemeUser,
        $followResponse)
    {
        $this->followedAwemeUser = $followedAwemeUser;
        $this->followAwemeUser = $followAwemeUser;
        $this->followResponse = $followResponse;
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
