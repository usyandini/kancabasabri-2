<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarikTunai extends Model
{
	protected $connection = 'sqlsrv';

    protected $table = 'tarik_tunai';

    protected $fillable = [
    	'id_dropping', 
    	'nominal', 
    	'akun_bank', 
    	'rek_bank', 
    	'cabang',
    	'created_by',
    	'tgl_dropping',
        'nominal_tarik',
        'sisa_dropping',
        'berkas_tariktunai',

        'SEGMEN#1',
        'SEGMEN#2',
        'SEGMEN#3',
        'SEGMEN#4',
        'SEGMEN#5',
        'SEGMEN#6',
        'ACCOUNT'
    ];

    public function creator()
    {
    	return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function fileTarikTunai()
    {
        return $this->hasOne('App\Models\BerkasTarikTunai', 'id', 'berkas_tariktunai');
    }
}
