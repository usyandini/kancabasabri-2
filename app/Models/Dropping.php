<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dropping extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'dropping';

    protected $fillable = [
    	'RECID', 
    	'JOURNALNAME', 
    	'JOURNALNUM', 
    	'TRANSDATE', 
    	'BANK_DROPPING', 
    	'REKENING_DROPPING', 
    	'AKUN_DROPPING', 
    	'CABANG_DROPPING',
    	'TXT',
        'DEBIT',
        'KREDIT'
    ];

    public function tarikTunai()
    {
        return $this->hasOne('App\Models\TarikTunai', 'id_dropping', 'RECID');
    }

}
