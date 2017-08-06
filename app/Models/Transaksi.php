<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'transaksi';

    protected $fillable = [
    	'tgl',
    	'item',
    	'qty_item',
    	'desc',
    	'sub_pos',
    	'mata_anggaran',
    	'akun_bank',
    	'account',
    	'anggaran',
    	'total',
    	'created_by',
        'batch_id'
    ];
}
