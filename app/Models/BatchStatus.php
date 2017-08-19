<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchStatus extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'batches_status';

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
                return "Pertama dibuat";
            case 1:
                return "Terakhir diupdate";
            case 2:
                return "Submit verifikasi Kasmin";
            default:
                break;
        }
        return null;
    }
}
