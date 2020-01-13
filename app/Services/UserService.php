<?php


namespace App\Services;


use App\User;

class UserService
{
    public function all($columns = ['*'])
    {
        return User::query()->get($columns);
    }
}
