<?php

namespace App\Http\Controllers;

use App\AwemeUser;
use App\Services\AwemeUserService;
use App\Services\FollowTaskService;
use Illuminate\Http\Request;

class AwemeUserAllController extends Controller
{
    protected $awemeUserService;

    public function __construct(AwemeUserService $awemeUserService)
    {
        $this->awemeUserService = $awemeUserService;
        $this->middleware('can:viewAny,'.AwemeUser::class)->only('index');
    }

    public function index()
    {
        $awemeUsers = $this->awemeUserService->getPaginateAll();

        return view('awemeUserFollow.index', compact('awemeUsers'));
    }

}
