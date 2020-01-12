<?php

namespace App\Http\Controllers;

use App\AwemeUser;
use Illuminate\Http\Request;

class AwemeUserController extends Controller
{
    public function index()
    {
        $awemeUsers = AwemeUser::query()
            ->paginate();

        return view('awemeUser.index',compact('awemeUsers'));
    }
}
