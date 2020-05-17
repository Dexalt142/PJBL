<?php

namespace App\Http\Middleware;

use Closure;

class Siswa {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(auth()->check() && auth()->user()->user_type == "siswa") {
            return $next($request);
        }

        abort(404);
    }
}
