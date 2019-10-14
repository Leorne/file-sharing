<?php

namespace App\Http\Middleware;

use Closure;

class EmailShouldBeConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! $request->user()->email_verified_at){
            if(\request()->expectsJson()){
                return response()->json(['error' => 'You should confirm email to upload files.'],401);
            }
            return redirect('/')->with('flash','You should confirm email to upload files.');
        }

        return $next($request);
    }
}
