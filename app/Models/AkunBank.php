<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunBank extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_BANK_VIEW';
}
