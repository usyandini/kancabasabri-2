<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetControlHistory extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'budget_control_history';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['dob'];

    protected $fillable = ['month_period', 'year_period', 'account', 'savepoint_amount', 'actual_amount'];
}
