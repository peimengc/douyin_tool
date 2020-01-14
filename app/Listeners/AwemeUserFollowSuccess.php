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
        //被关注号数据更改
        $event->followTask->awemeUser->followed();
        //关注号数据更改
        $event->followAwemeUser->follow();
        //增加增粉日志 （谁关注了谁）
        $event->followTask->awemeUser->followeds()->attach($event->followAwemeUser);
        //增粉任务修改
        $event->followTask->followed();
    }
}
