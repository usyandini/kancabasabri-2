<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch->created_at)).' </b> anda ditolak dengan perbaikan oleh Kasmin.';
            case 3:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch->created_at)).' </b> anda telah diverifikasi oleh Kasmin. Silahkan Menunggu verifikasi dari user Akutansi.';
        }
    }
}
