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
            $open_dropping = false;
            $dropping =["cari_d","lihat_tt_d","masuk_tt_d","setuju_tt_d","lihat_p_d","masuk_p_d","setuju_p_d",
                    "setuju_p2_d","notif_setuju_tt_d","notif_setuju_p_d","notif_setuju_p2_d",
                    "notif_ubah_tt_d","notif_ubah_p_d"] ;
            for($i =0;$i< count($dropping);$i++){
                if(Gate::check($dropping[$i])){
                    $open_dropping =true;
                    break;
                }
            }
            if($open_dropping)
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
