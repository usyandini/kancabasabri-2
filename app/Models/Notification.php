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

    // protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['dob'];

    protected $fillable = ['receiver_id', 'type', 'batch_id', 'is_read'];

    public function receiver()
    {
    	return $this->belongsTo('App\User', 'receiver_id', 'id');
    }

    public function batch()
    {
    	return $this->belongsTo('App\Models\Batch', 'batch_id', 'id');
    }

    public function idTarikTunai()
    {
        return $this->belongsTo('App\Models\TarikTunai', 'batch_id', 'id');
    }

    public function rejectTarikTunai()
    {
        return $this->belongsTo('App\Models\RejectTarikTunai', 'batch_id', 'id_tariktunai');
    }

    public function idPenyesuaian()
    {
        return $this->belongsTo('App\Models\PenyesuaianDropping', 'batch_id', 'id');
    }

    public function rejectPenyesuaian()
    {
        return $this->belongsTo('App\Models\RejectPenyesuaian', 'batch_id', 'id_penyesuaian');
    }

    public function wording()
    {
        switch ($this->type) {
            case 1:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch['created_at'])).' </b> butuh review anda untuk approval sebagai Kasimin.';
            case 2:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch['created_at'])).' </b> anda ditolak dengan perbaikan oleh Kasimin. Silahkan lakukan perubahan dan submit kembali.';
            case 3:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch['created_at'])).' </b> anda telah <b>disetujui oleh Kasimin</b>. Silahkan Menunggu verifikasi dari user Akutansi.';
            case 4:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch['created_at'])).' </b> telah disetujui oleh user Kasmin. Mohon review untuk verifikasi akhir anda sebagai user Akutansi.';
            case 5:
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch['created_at'])).' </b> anda ditolak dengan perbaikan oleh user Akutansi. Silahkan lakukan perubahan dan submit kembali.';
            case 6: 
                return 'Batch <b>'.date('d-m-Y', strtotime($this->batch['created_at'])).' </b> anda telah diverifikasi oleh user Akutansi. Harap menunggu konfirmasi dari Pusat.';
            case 7: 
                return 'Tarik Tunai dilakukan oleh <b>'.$this->idTarikTunai['cabang'].'</b>. Mohon review untuk verifikasi anda sebagai user Akuntansi.';
            case 8:
                return 'Tarik Tunai oleh <b>'.$this->idTarikTunai['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idTarikTunai['created_at'])).' ditolak oleh Divisi Akuntansi dengan alasan '.$this->rejectTarikTunai['reason']['content'].'. Silahkan melakukan Tarik Tunai kembali.';
            case 9:
                return 'Tarik Tunai oleh <b>'.$this->idTarikTunai['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idTarikTunai['created_at'])).' telah diverifikasi oleh Divisi Akuntansi.';
            case 10: 
                return 'Penyesuaian dropping dilakukan oleh <b>'.$this->idPenyesuaian['cabang'].'</b>. Mohon review untuk verifikasi anda sebagai user Bia.';
            case 11:
                return 'Penyesuaian dropping oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' ditolak oleh Bia dengan alasan '.$this->rejectPenyesuaian['reason']['content'].'. Silahkan melakukan Penyesuaian Dropping kembali.';
            case 12:
                return 'Penyesuaian dropping oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' telah diverifikasi oleh Bia. Mohon review untuk verifikasi anda sebagai user Akuntansi.';
            case 13:
                return 'Penyesuaian dropping oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' ditolak oleh Divisi Akuntansi dengan alasan '.$this->rejectPenyesuaian['reason']['content'].'. Silahkan melakukan Penyesuaian Dropping kembali.';
            case 14:
                return 'Penyesuaian dropping oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' telah diverifikasi oleh Divisi Akuntansi.';
            case 15:
                return 'Anggaran yang diajukan oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' telah diverifikasi oleh Divisi Akuntansi.';
        
        }
    }
}
