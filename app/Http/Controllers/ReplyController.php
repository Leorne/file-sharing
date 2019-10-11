<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;
use App\File;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(File $file){
        $file->fresh();
        $replies = $file->replies()->paginate(10);
        if(\request()->json()){
            return $replies;
        }
        return $replies;
    }

    public function store(File $file)
    {
        $this->validate(request(),
            [
                'body' => 'required'
            ]);
        $reply = Reply::create([
            'user_id' => auth()->id(),
            'file_id' => $file->id,
            'body' => request('body')
        ]);

        if(request()->expectsJson()){
            return $reply->load('owner');
        }
        return redirect($file->path())->with('flash', 'Your reply has been left');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();
        if(request()->expectsJson()){
            return response(['status' => 'Reply has been deleted']);
        }

        return back()->with('flash', 'Reply has been deleted.');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(['body' => \request('body')]);
    }
}
