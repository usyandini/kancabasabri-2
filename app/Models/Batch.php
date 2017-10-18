<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//  ----------- BATCH STAT / HISTORY DESC -------------
//          0 = Inserted 
//          1 = Updated
//          2 = Posted / Submitted to Kakancab
//          3 = Rejected for revision
//          4 = Verified by Kakancab (lvl 1) / Submitted to Akuntansi 
//          5 = Rejected for revision
//          6 = Verified by Akuntansi (lvl 2)
//  -----------------------------------------

class Batch extends Model
{
	protected $connection = 'sqlsrv';

	protected $table = 'batches';
    // protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['dob'];

	protected $fillable = ['divisi','cabang','seq_number','created_by'];    

	public function creator()
	{
		return $this->belongsTo('App\User', 'created_by', 'id');
	}

	public function transaksi()
	{
		return $this->hasMany('App\Models\Transaksi', 'batch_id', 'id');
	}

    public function staged()
    {
        return $this->hasMany('App\Models\StagingTransaksi', 'PIL_KCJOURNALNUM', 'id')->count();
    }

    public function posted()
    {
        return $this->hasMany('App\Models\StagingTransaksi', 'PIL_KCJOURNALNUM', 'id')->where('PIL_POSTED', 1)->count();
    }

    public function isPosted() {
        return $this->posted() > 0 ? true : false;
    }

    public function batchNo()
    {
        return date('ymd', strtotime($this->created_at)).'-'.$this->cabang.'/'.$this->divisi.'-'.$this->seq_number;
    }

    public function divisi()
    {
        return $this->hasOne('App\Models\Divisi', 'VALUE', 'divisi')->first();
    }

    public function kantorCabang()
    {
        return $this->hasOne('App\Models\KantorCabang', 'VALUE', 'cabang')->first();
    }

	public function latestStat()
	{
		return $this->hasOne('App\Models\BatchStatus', 'batch_id', 'id')->orderBy('updated_at', 'desc')->first();
	}

    public function latestUpdate()
    {
        return $this->hasOne('App\Models\BatchStatus', 'batch_id', 'id')->where('stat', 1)->first();
    }

    public function isAccessibleByUnitKerja()
    {
        $divisi = 'unit_00'.$this->divisi;
        $cabang = 'unit_'.$this->cabang.'00';

        if ($this->cabang == '00') {
            return \Auth::user()->hasAccess($cabang) && \Auth::user()->hasAccess($divisi);    
        }

        return \Auth::user()->hasAccess($cabang);
    }

    public function canReported()
    {
        return $this->hasOne('App\Models\BatchStatus', 'batch_id', 'id')->where('stat', 6);
    }

	public function isUpdatable()
    {
        if (!$this->latestStat()) {
            return null;
        }
        
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

    public function lvl1Verifiable()
    {
    	switch ($this->latestStat()->stat) {
            case 2:
                return true;
            default:
            	return false;
        }
    }

    public function lvl2Verifiable()
    {
        switch ($this->latestStat()->stat) {
            case 4:
                return true;
            default:
                return false;
        }
    }
}
