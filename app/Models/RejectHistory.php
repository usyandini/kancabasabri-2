<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectHistory extends Model
{
	protected $connection = 'sqlsrv';

    protected $table = 'reject_history';

    protected $fillable = ['batch_status_id', 'reject_reason'];

    public $timestamps = false;

    public function reason()
    {
    	return $this->hasOne('App\Models\RejectReason', 'id', 'reject_reason');
    }

    public function batchStatus()
    {
    	return $this->belongsTo('App\Models\BatchStatus', 'id', 'batch_status_id');
    }
}
