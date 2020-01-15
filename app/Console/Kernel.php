<?php

namespace App\Console;

use App\Jobs\AwemeUserTodayFollowZeroPodcast;
use App\Jobs\UpdateUserInfoPodcast;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //队列信息监控
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        //账号今日关注数每日00：00 归零
        $schedule->job(new AwemeUserTodayFollowZeroPodcast())->dailyAt('00:00');

        //每五分钟更新userinfo，有未执行完的任务时不会重复添加任务
        $schedule->job(new UpdateUserInfoPodcast())->everyFiveMinutes()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
