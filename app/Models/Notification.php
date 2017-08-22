<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ---------------- Types -------------
// 1 = Submit verifikasi lvl 1 | Receiver : null (All Kasmin)
// 2 = Submit verifikasi lvl 1 rejected | Reveiver : id batch submitter
// 3 = Submit verifikasi lvl 1 approved | Receiver : id batch submitter
// 4 = Submit verifikasi lvl 1 approved | Receiver : null (All Akutansi)
// 5 = Submit verifikasi lvl 2 rejected | Reveiver : id batch submitter
// 6 = Submit verifikasi lvl 2 approved | Receiver : id batch submitter
// ------------------------------------

class Notification extends Model
{
	protected $connection = 'sqlsrv';

    protected $table = 'notifications';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['receiver_id', 'type', 'batch_id', 'is_read'];

    public function receiver()
    {
    	return $this->belongsTo('App\User', 'receiver_id', 'id');
    }

    public function batch()
    {
    	return $this->belongsTo('App\Models\Batch', 'batch_id', 'id');
    }

    public function wording()
    {
        switch ($this->type) {
            case 1:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch->created_at)).' </b> butuh review anda untuk approval sebagai Kasmin.';
            case 2:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch->created_at)).' </b> anda ditolak dengan perbaikan oleh Kasmin. Silahkan lakukan perubahan dan submit kembali.';
            case 3:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch->created_at)).' </b> anda telah <b>disetujui oleh Kasmin</b>. Silahkan Menunggu verifikasi dari user Akutansi.';
            case 4:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch->created_at)).' </b> telah disetujui oleh user Kasmin. Mohon review untuk verifikasi akhir anda sebagai user Akutansi.';
            case 5:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch->created_at)).' </b> anda ditolak dengan perbaikan oleh user Akutansi. Silahkan lakukan perubahan dan submit kembali.';
            case 6: 
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch->created_at)).' </b> anda telah diverifikasi oleh user Akutansi. Harap menunggu konfirmasi dari Pusat.';
        }
    }
}
