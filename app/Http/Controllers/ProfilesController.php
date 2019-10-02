<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    //

    public function show(User $user){
        return view('profiles.show', [
            'profileUser' => $user,
            'files' => $user->files()->paginate(10),
            'activities' => $user->activity()->latest()
                ->with('subject')
                ->take(20)->get()
                ->groupBy(function($activity){
                    return $activity->created_at->format('Y-m-d');
            })
        ]);
    }
}
