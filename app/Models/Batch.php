<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
	protected $connection = 'sqlsrv';

	protected $table = 'batches';

	protected $dateFormat = 'Y-m-d H:i:s';

	protected $fillable = ['created_by'];    

	public function creator()
	{
		return $this->belongsTo('App\User', 'created_by', 'id');
	}

	public function transaksi()
	{
		return $this->hasMany('App\Models\Transaksi', 'batch_id', 'id');
	}

	public function latestStat()
	{
		return $this->hasOne('App\Models\BatchStatus', 'batch_id', 'id')->orderBy('id', 'desc')->first();
	}

	public function isUpdatable()
    {
        switch ($this->latestStat()->stat) {
            case 0:
                return true;
            case 1:
                return true;
            case 2:
                return false;
        }
        return null;
    }
}
