<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class User extends Authenticatable
{
    use SoftDeletes;

    protected $connection = 'sqlsrv';

    protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['dob'];
    
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'username', 
        'is_admin', 
        'created_by', 
        'updated_by', 
        'divisi', 
        'cabang', 
        'perizinan_dropping', 
        'perizinan_transaksi', 
        'perizinan_anggaran'
    ];

    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function divisi()
    {
        return $this->hasOne('App\Models\Divisi', 'VALUE', 'divisi');
    }

    public function kantorCabang()
    {
        return $this->hasOne('App\Models\KantorCabang', 'VALUE', 'cabang');
    }

    public function perizinan($perizinan)
    {
        switch ($perizinan) {
            case 'anggaran':
                $perizinan = $this->perizinan_anggaran;
                break;
            case 'dropping':
                $perizinan = $this->perizinan_dropping;
                break;
            default:
                $perizinan = $this->perizinan_transaksi;
                break;
        }

        $result = $perizinan;
        switch ($perizinan) {
            case '3':
                $result = [1, 2];
                break;
            case '5':
                $result = [1, 4];
                break;
            case '6':
                $result = [2, 4];
                break;
            case '7':
                $result = [1, 2, 4];
                break;
        }

        return $result;
    }
}
