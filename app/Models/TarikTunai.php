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
    	'is_sesuai', 
    	'id_penyesuaian', 
    	'created_by',
    	'tgl_dropping',
        'nominal_tarik',
        'sisa_dropping',
        'berkas_tariktunai'
    ];

    public function creator()
    {
    	return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
