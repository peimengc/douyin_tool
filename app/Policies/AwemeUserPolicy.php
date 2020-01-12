<?php

namespace App\Policies;

use App\AwemeUser;
use App\User;

class AwemeUserPolicy extends BasePolicey
{
    public function viewAny(User $user)
    {
        return false;
    }

    public function addFollowTask(User $user,AwemeUser $awemeUser)
    {
        return false;
    }
}
