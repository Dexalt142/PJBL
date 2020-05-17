<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        // if (Auth::guard($guard)->check()) {
        if (auth()->check() && auth()->user()->user_type == "guru") {
            return redirect('guru');
        } else if (auth()->check() && auth()->user()->user_type == "siswa") {
            return redirect('siswa');
        }

        return $next($request);
    }
}
