<?php

namespace App\Http\Middleware;

use Closure;

class Guru {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(auth()->check() && auth()->user()->user_type == "guru") {
            return $next($request);
        }

        abort(404);
    }
}
