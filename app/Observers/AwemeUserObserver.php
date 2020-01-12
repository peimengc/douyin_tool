<?php

namespace App\Observers;

use App\AwemeUser;

class AwemeUserObserver
{
    public function creating(AwemeUser $awemeUser){
        $awemeUser->init_follow = $awemeUser->follow;
        $awemeUser->init_fans =  $awemeUser->fans;
    }
}
