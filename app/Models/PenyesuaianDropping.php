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
    	'tgl_dropping'
    ];
}
