<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectPenyesuaian extends Model
{
     protected $connection = 'sqlsrv';

    protected $table = 'reject_penyesuaian';

    protected $fillable = ['id_penyesuaian', 'reject_reason'];

    public function reason()
    {
    	return $this->hasOne('App\Models\RejectReason', 'id', 'reject_reason');
    }

    public function penyesuaianStatus()
    {
    	return $this->belongsTo('App\Models\PenyesuaianDropping', 'id', 'id_penyesuaian');
    }
}
