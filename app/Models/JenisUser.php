<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisUser extends Model
{
    use SoftDeletes;
    
    protected $connection = 'sqlsrv';

	protected $dateFormat;
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
        'jenis_user'
    ];

    public function __construct()
    {
        if (\App::environment('local-ilyas')) {
            $this->dateFormat = 'Y-m-d H:i:s';
        }
    }
}
