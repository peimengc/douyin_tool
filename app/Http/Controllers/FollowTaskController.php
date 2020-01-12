<?php

namespace App\Http\Controllers;

use App\AwemeUser;
use App\Services\FollowTaskService;
use Illuminate\Http\Request;

class FollowTaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:addFollowTask,'.AwemeUser::class)->only(['store']);
    }

    public function store(AwemeUser $awemeUser, Request $request, FollowTaskService $followTaskService)
    {
        $followTask = $followTaskService->add($awemeUser, $request->all());

        return [
            'status' => 1
        ];
    }
}
