<?php

namespace App\Http\Controllers;

use App\AwemeUser;
use Illuminate\Http\Request;

class AwemeUserController extends Controller
{
    public function index(Request $request)
    {
        $awemeUsers = $request->user()->awemeUsers()
            ->paginate();

        return view('awemeUser.index',compact('awemeUsers'));
    }
}
