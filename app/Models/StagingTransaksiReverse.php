<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StagingTransaksiReverse extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_KCTRANSAKSIREVERSE';

    public $timestamps = false;

    protected $fillable = [
        'RECID',
    	'PIL_ACCOUNT',
    	'PIL_AMOUNT',
    	'PIL_BANK',
    	'PIL_DIVISI',
        'PIL_GENERATED',
    	'PIL_JOURNALNUM',
    	'PIL_KPKC',
    	'PIL_MATAANGGARAN',
    	'PIL_POSTED',
    	'PIL_PROGRAM',
    	'PIL_SUBPOS',
    	'PIL_TRANSDATE',
    	'PIL_TXT',
    	'PIL_VOUCHER',
        'PIL_TRANSACTIONID',
        'PIL_KCJOURNALNUM',
    	'DATAAREAID',
    	'RECVERSION',
    	'PARTITION',
        'PIL_JOURNALNUMREVERSE'
    ];
}
