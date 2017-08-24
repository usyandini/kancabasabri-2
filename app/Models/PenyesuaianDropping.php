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
        'berkas_penyesuaian'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
