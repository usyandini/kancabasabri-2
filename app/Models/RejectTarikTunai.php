<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectTarikTunai extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'reject_tariktunai';

    protected $fillable = ['id_tariktunai', 'reject_reason'];

    public function reason()
    {
    	return $this->hasOne('App\Models\RejectReason', 'id', 'reject_reason');
    }

    public function tarikTunaiStatus()
    {
    	return $this->belongsTo('App\Models\TarikTunai', 'id', 'id_tariktunai');
    }
}
