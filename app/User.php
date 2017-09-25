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

    protected $casts = ['perizinan' => 'array'];
    
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'username', 
        'created_by', 
        'updated_by', 
        'divisi', 
        'cabang',
        'perizinan',
        'jenis_user',
        'as_ldap'
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

    public function hasAccess($permission)
    {
        if ($this->hasPermission($permission)) {
            return true;
        }
        return false;
    }

    public function hasPermission($permission)
    {
        return isset($this->perizinan[$permission]) ? true : false;
    }
}
