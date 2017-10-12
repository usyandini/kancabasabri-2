<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDropping extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'pengajuan_dropping_cabang';
}
