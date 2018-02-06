<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StagingSetorTunai extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_KCSETORTUNAI';

    public $timestamps = false;

    protected $fillable = [
        'DATAAREAID',
    	'RECID',
        'PIL_TRANSDATE',
        'PIL_TXT',
        'PIL_JOURNALNUM',
        'PIL_AMOUNT',
        'PIL_BANK',
        'PIL_ACCOUNT',
        'PIL_PROGRAM',
        'PIL_KPKC',
        'PIL_DIVISI',
        'PIL_SUBPOS',
        'PIL_MATAANGGARAN',
    ];
}
