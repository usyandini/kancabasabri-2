<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPenyesuaian extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'berkas_penyesuaian';

    //protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['dob'];

    protected $fillable = [
    	'name',
    	'size',
    	'type',
    	'data'
    ];
}
