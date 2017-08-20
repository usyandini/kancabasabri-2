<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//  ----------- BATCH STAT DESC -------------
//          0 = Inserted 
//          1 = Updated
//          2 = Posted / Submitted to Kasmin
//          3 = Rejected for revision
//          4 = Verified by Kasmin (lvl 1) / Submitted to Akuntansi 
//          5 = Rejected for revision
//          6 = Verified by Akuntansi (lvl 2)
//  -----------------------------------------

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
		return $this->hasOne('App\Models\BatchStatus', 'batch_id', 'id')->orderBy('updated_at', 'desc')->first();
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
            case 3:
            	return true;
        	case 4:
        		return false;
    		case 5:
    			return true;
			case 6:
				return false;
        }
    }

    public function verifiable()
    {
    	switch ($this->latestStat()->stat) {
            case 2:
                return true;
            default:
            	return false;
        }
    }
}
