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

class BatchStatus extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'batches_status';

    //protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates =['dob'];

    protected $fillable = [
    	'batch_id', 
    	'stat',
    	'submitted_by'
    ];

    public function submitter()
    {
    	return $this->belongsTo('App\User', 'submitted_by', 'id');
    }

    public function rejectReason()
    {
        return $this->hasOne('App\Models\RejectHistory', 'batch_status_id', 'id');
    }

    public function status()
    {
        switch ($this->stat) {
            case 0:
                return "Pertama dibuat";
            case 1:
                return "Terakhir diupdate";
            case 2:
                return "Submit persetujuan ke Kasmin";
            case 3:
                return "Tidak disetujui Kasmin";
            case 4:
                return "Mendapat persetujuan dari Kasmin";
            case 5:
                return "Tidak diverifikasi Akutansi";
            case 6:
                return "Mendapat verifikasi dari Akutansi";
        }
    }
}
