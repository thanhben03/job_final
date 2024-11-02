<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CompanyAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('company')->user()) {
            return redirect()->route('company.login');
        }
        if (Auth::guard('company')->check() && !Auth::guard('company')->user()->is_active) {
            return redirect()->route('company.account-not-active');
        }
        return $next($request);
    }
}
