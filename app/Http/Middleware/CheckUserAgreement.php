<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserAgreement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user has accepted the user agreement
            if (!Auth::user()->user_agreement_accepted) {
                // If not, redirect to the user agreement page
                return redirect()->route('user-agreement');
            }
        }

        // If the user is authenticated and has accepted the agreement, proceed with the request
        return $next($request);
    }
}
