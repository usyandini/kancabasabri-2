<?php

namespace App\Http\Middleware;

use Closure;

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

class PrevilegeManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $perizinan_type, ...$perizinan_value)
    {
        $user = \Auth::user();
        switch ($perizinan_type) {
            case 'dropping':
                if (collect($perizinan_value)->contains($user->perizinan_dropping)) { return $next($request); }
            case 'transaksi':
                if (collect($perizinan_value)->contains($user->perizinan_transaksi)) { return $next($request); }
            case 'anggaran':
                if (collect($perizinan_value)->contains($user->perizinan_anggaran)) { return $next($request); }
        }

        return redirect('/');
    }
}