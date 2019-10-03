<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
           'status_message' => 'required|max:20',
        ]);

        auth()->user()->update([
            'status_message' => $request->input('status_message'),
        ]);

        return response([],200);
    }
}
