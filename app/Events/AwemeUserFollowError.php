<?php

namespace App\Events;

use App\AwemeUser;
use App\FollowTask;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AwemeUserFollowError
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $followTask;
    public $followAwemeUser;
    public $followResponse;

    /**
     * AwemeUserFollowError constructor.
     * @param FollowTask $followTask
     * @param AwemeUser $followAwemeUser
     * @param $followResponse
     */
    public function __construct(
        FollowTask $followTask,
        AwemeUser $followAwemeUser,
        $followResponse)
    {
        $this->followTask = $followTask;
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
