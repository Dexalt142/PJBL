<?php

namespace App\Http\Middleware;

use Closure;
use App\Guru;
use App\Siswa;

class UserValidated {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(auth()->check()) {
            if(Guru::where(['user_id' => auth()->user()->id])->first()) {
                return $next($request);
            } else if(Siswa::where(['user_id' => auth()->user()->id])->first()) {
                return $next($request);
            } else {
                return redirect()->route('profile-setup');
            }
        } 
        return $next($request);
    }
}
