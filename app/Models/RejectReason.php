<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectReason extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'reject_reasons';

	protected $fillable = ['content', 'type'];
}
