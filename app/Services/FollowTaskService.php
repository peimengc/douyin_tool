<?php


namespace App\Services;


use App\AwemeUser;
use App\FollowTask;

class FollowTaskService
{
    public function add(AwemeUser $awemeUser, $attr)
    {
        $followTask = new FollowTask($attr);
        $followTask->init_follow = $awemeUser->follow;
        $followTask->init_fans = $awemeUser->fans;
        $followTask->awemeUser()->associate($awemeUser)->save();

        return $followTask;
    }
}
