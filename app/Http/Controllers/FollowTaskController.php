<?php

namespace App\Http\Controllers;

use App\AwemeUser;
use App\FollowTask;
use App\Services\FollowTaskService;
use Illuminate\Http\Request;

class FollowTaskController extends Controller
{
    protected $followTaskService;

    public function __construct(FollowTaskService $followTaskService)
    {
        $this->followTaskService = $followTaskService;
        $this->middleware('can:addFollowTask,awemeUser')->only(['store']);
        $this->middleware('can:viewAny,'.FollowTask::class)->only(['index']);
    }

    public function index()
    {
        $followTasks = $this->followTaskService->paginate();

        return view('followTask.index',compact('followTasks'));
    }

    public function store(AwemeUser $awemeUser, Request $request)
    {
        $followTask = $this->followTaskService->add($awemeUser, $request->all());

        return [
            'status' => 1
        ];
    }
}
