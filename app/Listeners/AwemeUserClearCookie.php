<?php

namespace App\Listeners;

use App\Events\AwemeUserCookieInvalid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwemeUserClearCookie
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
     * @param  AwemeUserCookieInvalid  $event
     * @return void
     */
    public function handle(AwemeUserCookieInvalid $event)
    {
        $event->awemeUser->clearCookie();
    }
}
