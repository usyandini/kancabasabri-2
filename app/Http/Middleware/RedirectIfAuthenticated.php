<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

// ------- PERIZINAN --------
//  0 = Not authorized
//  1 = Staff
//  2 = Approver
//  3 = Staff + Approver
//  4 = Superuser
//  5 = Staff + Superuser
//  6 = Approver + Superuser
//  7 = Staff + Approver + Superuser
// --------------------------

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/dropping');       
        }

        return $next($request);
    }
}
