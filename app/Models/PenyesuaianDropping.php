<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyesuaianDropping extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'penyesuaian_dropping';

    protected $fillable = [
    	'id_dropping', 
    	'nominal', 
    	'akun_bank', 
    	'rek_bank', 
    	'cabang', 
    	'is_pengembalian',  
    	'tgl_dropping',
        'id_dropping',
        'created_by',
        'nominal_dropping',
        'berkas_penyesuaian',

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

    public function filePenyesuaian()
    {
        return $this->hasOne('App\Models\BerkasPenyesuaian', 'id', 'berkas_penyesuaian');
    }
}
