<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasTransaksi extends Model
{
 	protected $connection = 'sqlsrv';

    protected $table = 'berkas_transaksi';

    protected $fillable = [
    	'batch_id',
    	'file_name'
    ];   
}
