<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StagingAnggaran extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_KCANGGARAN';

    public $timestamps = false;

    protected $fillable = [
        'DATAAREAID',
        // 'RECVERSION',
        // 'PARTITION',
        'RECID',
        'PIL_ACCOUNT',
        'PIL_DIVISI',
        'PIL_KPKC',
        'PIL_MATAANGGARAN',
        'PIL_PROGRAM',
        'PIL_SUBPOS',
        'PIL_TRANSDATE',
        'PIL_TXT',
        'PIL_AMOUNT'];
        // 'PIL_BUDGETTYPE'
    
}
