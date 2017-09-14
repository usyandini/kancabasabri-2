<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasTransaksi extends Model
{
 	protected $connection = 'sqlsrv';

    protected $table = 'berkas_transaksi';

    protected $dateFormat;
    protected $dates =['dob'];

    protected $fillable = [
    	'batch_id',
    	'file_name',
    	'file'
    ];   

    public function __construct()
    {
        if (\App::environment('local-ilyas')) {
            $this->dateFormat = 'Y-m-d H:i:s';
        }
    }
}
