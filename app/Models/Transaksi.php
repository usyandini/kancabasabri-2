<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'transaksi';

    // protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['dob'];

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
        'actual_anggaran',
    	'total',
    	'created_by',
        'batch_id',
        'is_anggaran_safe'
    ];

    public function stat()
    {
        return $this->hasMany('App\Models\BatchStatus', 'batch_id', 'batch_id');
    }

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch', 'batch_id', 'id');
    }

    public function latestStat()
    {
        $check = $this->hasOne('App\Models\BatchStatus', 'batch_id', 'batch_id')->limit(1)->orderBy('id', 'desc')->first();

        if ($check) return $check['stat'];
        else return false; 
    }
}
