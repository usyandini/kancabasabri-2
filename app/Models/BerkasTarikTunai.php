<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasTarikTunai extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'berkas_tariktunai';

    protected $dateFormat;
    protected $dates =['dob'];

    protected $fillable = [
        'id_tariktunai',
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
