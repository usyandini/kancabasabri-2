<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetControl extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = 'PIL_BUDGETCONTROLSTATISTICVIEW';
}
