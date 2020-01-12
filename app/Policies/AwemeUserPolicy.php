<?php

namespace App\Policies;

use App\User;

class AwemeUserPolicy extends BasePolicey
{
    public function viewAny(User $user)
    {
        return false;
    }

    public function addFollowTask(User $user)
    {
        return false;
    }
}
