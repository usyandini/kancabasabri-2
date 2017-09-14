<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPenyesuaian extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'berkas_penyesuaian';

    protected $dateFormat;
    protected $dates =['dob'];

    protected $fillable = [
    	'name',
    	'size',
    	'type',
    	'data'
    ];

    public function __construct()
    {
        if (\App::environment('local-ilyas')) {
            $this->dateFormat = 'Y-m-d H:i:s';
        }
    }
}
