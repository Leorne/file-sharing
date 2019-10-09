<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UserAvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
//        $request->validate([
//           'avatar' => ['required', 'image']
//        ]);

        if (auth()->user()->avatar_path) {
            @unlink('storage/' . auth()->user()->avatar_path);
        }

        if (\request()->expectsJson()) {
            $path = $path = $request->input('avatar')->store('/avatars', 'public');
        } else {
            $path = $path = $request->file('avatar')->store('/avatars', 'public');
        }
        auth()->user()->update([
            'avatar_path' => $path,
        ]);

        return response([], 200);
    }
}
