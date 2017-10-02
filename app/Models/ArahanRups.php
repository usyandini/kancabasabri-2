<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ArahanRups extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'arahan_rups';

	protected $fillable = ['arahan_rups'];
}
