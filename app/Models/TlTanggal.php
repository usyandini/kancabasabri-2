<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TlTanggal extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'tl_tanggal';
}
