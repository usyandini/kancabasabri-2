<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiStatus extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'transaksi_status';

    protected $fillable = [
    	'batch_id', 
    	'stat',
    	'submitted_by'
    ];

    public function submitter()
    {
    	return $this->belongsTo('App\User', 'submitted_by', 'id');
    }
}
