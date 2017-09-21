<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
            if(Gate::check('info_d') || Gate::check('verifikasiTT_d') || Gate::check('verifikasiPD_d') || Gate::check('verifikasiPD2_d'))
                return redirect('/dropping');
            elseif(Gate::check('info_t'))
                return redirect('/transaksi');
            elseif(Gate::check('info_a'))
                return redirect('/anggaran'); 
            else
                return redirect('/dashboard');      
        }

        return $next($request);
    }
}
