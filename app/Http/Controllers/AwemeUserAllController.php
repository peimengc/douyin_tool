<?php

namespace App\Http\Controllers;

use App\AwemeUser;
use App\Services\AwemeUserService;
use App\Services\FollowTaskService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AwemeUserAllController extends Controller
{
    protected $awemeUserService;
    protected $userService;

    public function __construct(
        AwemeUserService $awemeUserService,
        UserService $userService
    )
    {
        $this->awemeUserService = $awemeUserService;
        $this->userService = $userService;
        $this->middleware('can:viewAny,'.AwemeUser::class)->only('index');
    }

    public function index()
    {
        $awemeUsers = $this->awemeUserService->paginate();

        $users = $this->userService->all(['id','name']);

        return view('awemeUserFollow.index', compact('awemeUsers','users'));
    }

}
