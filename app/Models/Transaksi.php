<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'transaksi';
}
