<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StagingTransaksi extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_KCTRANSAKSI';

    public $timestamps = false;

    protected $fillable = [
    	'PIL_ACCOUNT',
    	'PIL_AMOUNT',
    	'PIL_BANK',
    	'PIL_DIVISI',
    	'PIL_JOURNALNUM',
    	'PIL_KPKC',
    	'PIL_MATAANGGARAN',
    	'PIL_POSTED',
    	'PIL_PROGRAM',
    	'PIL_SUBPOS',
    	'PIL_TRANSDATE',
    	'PIL_TXT',
    	'PIL_VOUCHER',
    	'DATAAREADID',
    	'RECVERSION',
    	'PARTITION',
    	'RECID',
    	'PIL_TRANSACTIONID'
    ];
}
