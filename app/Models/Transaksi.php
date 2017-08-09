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

    public function stat()
    {
        return $this->hasMany('App\Models\TransaksiStatus', 'batch_id', 'batch_id');
    }

    public function latestStat()
    {
        $check = $this->hasOne('App\Models\TransaksiStatus', 'batch_id', 'batch_id')->limit(1)->orderBy('id', 'desc')->first();

        if ($check) return $check['stat'];
        else return false; 
    }
}
