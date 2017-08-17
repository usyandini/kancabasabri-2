<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiStatus extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'transaksi_status';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
    	'batch_id', 
    	'stat',
    	'submitted_by'
    ];

    public function submitter()
    {
    	return $this->belongsTo('App\User', 'submitted_by', 'id');
    }

    public function status()
    {
        $stat = $this->stat;
        switch ($stat) {
            case 0:
                return "Belum submit";
            case 1:
                return "Menunggu verifikasi";
            default:
                break;
        }
        return null;
    }

    public function isUpdatable()
    {
        $last = $this->where('batch_id', $this->batch_id)->orderBy('id', 'desc')->first();
        switch ($last['stat']) {
            case 0:
                return true;
            case 1:
                return false;
            case 2:
                return true;
        }
        return null;
    }
}
