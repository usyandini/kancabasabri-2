<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
