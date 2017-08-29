<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_VIEW_PROGRAM';
}
