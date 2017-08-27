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
    
    protected $fillable = [
        'name', 'email', 'password', 'username', 'is_admin', 'created_by', 'updated_by'
    ];

    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
