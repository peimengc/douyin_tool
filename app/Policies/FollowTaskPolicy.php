<?php

namespace App\Policies;

use App\User;

class FollowTaskPolicy extends BasePolicey
{
    public function viewAny(User $user)
    {
        return false;
    }

}
