<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasTarikTunai extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'berkas_tariktunai';

    //protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates =['dob'];


    protected $fillable = [
    	'name',
    	'size',
    	'type',
    	'data'
    ];

    // public function fileTarikTunai()
    // {
    //     return $this->hasOne('App\Models\TarikTunai', 'berkas_tariktunai', 'id');
    // }
}