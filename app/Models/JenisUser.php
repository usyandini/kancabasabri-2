<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisUser extends Model
{
    use SoftDeletes;
    
    protected $connection = 'sqlsrv';
    protected $table = 'jenis_user';

	// protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['dob'];

    protected $casts = ['perizinan' => 'array'];
    
    protected $fillable = ['nama', 'perizinan', 'desc', 'created_by', 'updated_by'];

    public function creator()
    {
        return $this->belongsTo('App\User', 'id', 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'id', 'updated_by');
    }

    public function countUsers()
    {
        return \App\User::where('jenis_user', $this->id)->count();
    }
}
