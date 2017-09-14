<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisUser extends Model
{
    use SoftDeletes;
    
    protected $connection = 'sqlsrv';
    protected $table = 'jenis_user';

	protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['dob'];

    protected $casts = ['perizinan' => 'array'];
    
    protected $fillable = ['nama', 'perizinan', 'desc', 'created_by', 'updated_by'];
}
