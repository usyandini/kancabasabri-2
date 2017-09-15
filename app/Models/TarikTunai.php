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

        'SEGMEN_1',
        'SEGMEN_2',
        'SEGMEN_3',
        'SEGMEN_4',
        'SEGMEN_5',
        'SEGMEN_6',
        'ACCOUNT',

        'stat',
        'verified_by'
    ];

    public function creator()
    {
    	return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function dropping()
    {
        return $this->hasOne('App\Models\Dropping', 'RECID', 'id_dropping');
    }

    public function integrated()
    {
        return $this->hasOne('App\Models\StagingTarikTunai', 'RECID', 'id');
    }
}
