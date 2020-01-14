<?php

namespace App\Jobs;

use App\FollowTask;
use App\Helpers\DouYin\FollowUserHelper;
use App\Services\AwemeUserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AwemeAddFansPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $awemeUserService;
    protected $followUserHelper;
    protected $followTask;

    /**
     * AwemeAddFansPodcast constructor.
     * @param FollowTask $followTask
     */
    public function __construct(FollowTask $followTask)
    {
        $this->awemeUserService = new AwemeUserService();
        $this->followUserHelper = new FollowUserHelper();
        $this->followTask = $followTask;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->followUserHelper->followUser($this->followTask, $this->awemeUserService->getFollowAwemeUser($this->followTask));
    }
}
