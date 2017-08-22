<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasTransaksi extends Model
{
 	protected $connection = 'sqlsrv';

    protected $table = 'berkas_transaksi';

    //protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates =['dob'];


    protected $fillable = [
    	'batch_id',
    	'file_name'
    ];   
}
