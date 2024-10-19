<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated via the 'admin' guard
        if (!Auth::guard('admin')->check()) {
            return redirect('/login')->withErrors('Access denied. Please log in as an admin.');
        }

        return $next($request);
    }
}
