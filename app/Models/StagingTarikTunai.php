<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StagingTarikTunai extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_KCTARIKTUNAI';

    public $timestamps = false;

    protected $fillable = [
    	'RECID',
        'PIL_TRANSDATE',
        'PIL_TXT',
        'PIL_JOURNALNUM',
        'PIL_AMOUNT',
        'PIL_BANK',
        'PIL_ACCOUNT',
        'PIL_VOUCHER'
    ];
}
