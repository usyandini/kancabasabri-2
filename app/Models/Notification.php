<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $connection = 'sqlsrv';

    protected $table = 'notifications';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['receiver_id', 'type', 'batch_id', 'is_read'];

    public function receiver()
    {
    	return $this->belongsTo('app\User', 'receiver_id', 'id');
    }

    public function batch()
    {
    	return $this->belongsTo('app\Models\BatchStatus', 'batch_id', 'id');
    }
}
