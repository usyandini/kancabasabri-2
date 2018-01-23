<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pil_kcanggaranlines extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_KCANGGARANLINES';

    public $timestamps = false;

    protected $fillable = [
        'DATAAREAID',
        'RECID',
        'PIL_ACCOUNT',
        'PIL_DIVISI',
        'PIL_KPKC',
        'PIL_TRANSDATE',
        'PIL_MATAANGGARAN',
        'PIL_PROGRAM',
        'PIL_SUBPOS',
        'PIL_TRANSDATE',
        'PIL_TXT',
        'PIL_AMOUNT',
        'PIL_TRANSID'
    ];
        // 'PIL_BUDGETTYPE'
    
}
