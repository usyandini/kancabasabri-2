<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTag extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'DIMENSIONFINANCIALTAG';
}
