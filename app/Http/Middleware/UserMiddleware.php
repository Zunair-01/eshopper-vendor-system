<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'customer') {
            return $next($request); 
        }

        return redirect()->route('customer.login')->with('error', 'You do not have access to this page.');
    }
}
