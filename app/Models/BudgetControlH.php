<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetControlH extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'budget_control';

    // protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['dob'];

    protected $fillable = ['year_period', 'account', 'savepoint_amount', 'actual_amount'];
}
