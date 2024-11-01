<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; // Correct import for Auth
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBannedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and banned
        if (Auth::check() && Auth::user()->ban) {
            Auth::logout(); // Log out the banned user
            return redirect()->route('home')->with('message', 'Your account has been banned.');
        }
        return $next($request);
    }
}
