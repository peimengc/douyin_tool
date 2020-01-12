<?php

namespace App\Listeners;

use App\Events\AwemeUserFollowSuccess as Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwemeUserFollowSuccess
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $event->followedAwemeUser->followed();
        $event->followAwemeUser->follow();
        //增粉任务修改
        $event->followedAwemeUser->followTask->followed();
    }
}
