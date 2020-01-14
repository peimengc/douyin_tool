<?php

namespace App\Http\Controllers;

use App\AwemeUser;
use App\FollowTask;
use App\Http\Requests\FollowTaskRequest;
use App\Jobs\AwemeAddFansPodcast;
use App\Services\AwemeUserService;
use App\Services\FollowTaskService;
use Illuminate\Http\Request;

class FollowTaskController extends Controller
{
    protected $followTaskService;
    protected $awemeUserService;

    public function __construct(
        FollowTaskService $followTaskService,
        AwemeUserService $awemeUserService)
    {
        $this->followTaskService = $followTaskService;
        $this->awemeUserService = $awemeUserService;
        $this->middleware('can:addFollowTask,'.AwemeUser::class)->only(['store']);
        $this->middleware('can:viewAny,' . FollowTask::class)->only(['index']);
    }

    public function index()
    {
        $followTasks = $this->followTaskService->paginate();

        return view('followTask.index', compact('followTasks'));
    }

    public function store($awemeUserId, FollowTaskRequest $request)
    {
        $awemeUser = $this->awemeUserService->findAndNotTask($awemeUserId);

        $this->followTaskService->add($awemeUser, $request->all());

        return back()->with([
            'alert' => [
                'type' => 'success',
                'content' => "\"{$awemeUser->nick}\" 已加入增粉任务列表",
            ]
        ]);
    }

    public function addFans(FollowTask $followTask)
    {
        $followTask->load('awemeUser.followeds');

        AwemeAddFansPodcast::dispatch($followTask);

        return back()->with([
            'alert' => [
                'content' => '正在增粉。。。'
            ]
        ]);
    }
}
