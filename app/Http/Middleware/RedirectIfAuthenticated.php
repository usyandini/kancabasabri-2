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
        $staff_arr = [1,3,5,7];
        $approver_arr = [2,3,6,7];
        $su_arr = [4,5,6,7];
        $all_arr = [1,2,3,4,5,6,7];

        $user = Auth::user();
        if (Auth::guard($guard)->check()) {
            if (collect($all_arr)->contains($user->perizinan_dropping)) { 
                if (collect($staff_arr)->contains($user->perizinan_dropping)) {
                    return redirect('/dropping'); 
                } elseif (collect($approver_arr)->contains($user->perizinan_dropping)) {
                    return abort(404); // BELUM FIX
                } elseif (collect($su_arr)->contains($user->perizinan_dropping)) {
                    return abort(404); // BELUM FIX
                }
            } elseif (collect($all_arr)->contains($user->perizinan_transaksi)) { 
                if (collect($staff_arr)->contains($user->perizinan_transaksi)) {
                    return redirect('/transaksi'); 
                } elseif (collect($approver_arr)->contains($user->perizinan_transaksi)) {
                    return abort(404); // BELUM FIX
                } elseif (collect($su_arr)->contains($user->perizinan_transaksi)) {
                    return abort(404); // BELUM FIX
                }
            } elseif (collect($all_arr)->contains($user->perizinan_anggaran)) { 
                if (collect($staff_arr)->contains($user->perizinan_anggaran)) {
                    return redirect('/anggaran'); 
                } elseif (collect($approver_arr)->contains($user->perizinan_anggaran)) {
                    return abort(404); // BELUM FIX
                } elseif (collect($su_arr)->contains($user->perizinan_anggaran)) {
                    return abort(404); // BELUM FIX
                } 
            } else { abort(404); }
        }

        return $next($request);
    }
}
