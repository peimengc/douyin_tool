<?php


namespace App\Services;


use App\AwemeUser;
use App\FollowTask;

class FollowTaskService
{

    public function paginate($perPage = null, $columns = ['*'])
    {
        return FollowTask::query()
            ->with(['awemeUser'])
            ->orderByDesc('created_at')
            ->paginate($perPage,$columns);
    }

    public function add(AwemeUser $awemeUser, $attr)
    {
        $followTask = new FollowTask($attr);
        $followTask->init_follow = $awemeUser->follow;
        $followTask->init_fans = $awemeUser->fans;
        $followTask->awemeUser()->associate($awemeUser)->save();

        return $followTask;
    }
}
