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

// 7 = Submit verifikasi lvl 1 tarik tunai | Receiver : Akuntansi
// 8 = Submit verifikasi lvl 1 tarik tunai rejected | Receiver : id submitter
// 9 = Submit verifikasi lvl 1 tarik tunai approved | Receiver : id submitter

// 10 = Submit verifikasi lvl 1 penyesuaian dropping | Receiver : Bia
// 11 = Submit verifikasi lvl 1 penyesuaian dropping rejected | Receiver : id submitter
//    = Submit verifikasi lvl 1 penyesuaian dropping approved | Receiver : id submitter
// 12 = Submit verifikasi lvl 1 penyesuaian dropping approved | Receiver : Akuntansi
// 13 = Submit verifikasi lvl 2 penyesuaian dropping rejected | Receiver : id submitter
// 14 = Submit verifikasi lvl 2 penyesuaian dropping approved | Reveiver : id submitter

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

    public function idAnggaran()
    {
        return $this->belongsTo('App\Models\Anggaran', 'batch_id', 'id');
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
                return 'Penyesuaian dropping dilakukan oleh <b>'.$this->idPenyesuaian['cabang'].'</b>. Mohon review untuk verifikasi anda.';
            case 11:
                return 'Penyesuaian dropping oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' ditolak dengan alasan '.$this->rejectPenyesuaian['reason']['content'].'. Silahkan melakukan Penyesuaian Dropping kembali.';
            case 12:
                return 'Penyesuaian dropping oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' telah diverifikasi. Mohon review untuk verifikasi anda sebagai user Akuntansi.';
            case 13:
                return 'Penyesuaian dropping oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' ditolak oleh Divisi Akuntansi dengan alasan '.$this->rejectPenyesuaian['reason']['content'].'. Silahkan melakukan Penyesuaian Dropping kembali.';
            case 14:
                return 'Penyesuaian dropping oleh <b>'.$this->idPenyesuaian['cabang'].'</b> pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' telah diverifikasi oleh Divisi Akuntansi.';
            case 15:
                return 'Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b>. Mohon review untuk disetujui anda sebagai <b> Kanit Kerja '.$this->idAnggaran['unit_kerja'].'</b>.';
            case 16:
                return 'Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak oleh <b>Kanit Kerja</b> dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali.';
            case 17:
                return 'Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui oleh <b>Kanit Kerja</b>. Mohon review untuk disetujui anda sebagai <b>Divisi Renbang</b>.';
            case 18:
                return 'Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak oleh <b>Divisi Renbang</b> dengan alasan <i>'.$this->idAnggaran['keterangan'].'</i>. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali.';
            case 19:
                return 'Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui oleh <b>Divisi Renbang</b>. Mohon review untuk disetujui anda sebagai <b>Direksi</b>.';
            case 20:
                return 'Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak oleh <b>Direksi</b> dengan alasan <i>'.$this->idAnggaran['keterangan'].'</i>. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh <b>Divisi Renbang</b>';
            case 21:
                return 'Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui oleh <b>Direksi</b>. Mohon Naskah RKAP untuk disetujui anda sebagai <b>Dewan Komisaris</b>.';
            case 22:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak oleh <b>Dewan Komisaris</b> dengan alasan <i>'.$this->idAnggaran['keterangan'].'</i>. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh <b>Divisi Renbang</b>';
            case 23:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui oleh <b>Dewan Komisaris</b>. Mohon Naskah RKAP disetujui pada <b>Rapat Teknis</b>.';
            case 24:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak pada <b>Rapat Teknis</b> dengan alasan <i>'.$this->idAnggaran['keterangan'].'</i>. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh <b>Divisi Renbang</b>';
            case 25:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui pada <b>Rapat Teknis</b>. Mohon Naskah RKAP disetujui pada <b>Rapat Umum Pemegang Saham</b>';
            case 26:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak pada <b>Rapat Umum Pemegang Saham</b> dengan alasan <i>'.$this->idAnggaran['keterangan'].'</i>. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh <b>Divisi Renbang</b>';
            case 27:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui pada <b>Rapat Umum Pemegang Saham</b>. Mohon Naskah RKAP dilakukan <b>Finalisasi RUPS</b>';
            case 28:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak pada <b>Finalisasi RUPS</b> dengan alasan <i>'.$this->idAnggaran['keterangan'].'</i>. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh <b>Divisi Renbang</b>';
            case 29:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui pada <b>Finalisasi RUPS</b>. Mohon Naskah RKAP dilakukan <b>Pembuatan Risalah RUPS</b>';
            case 30:
                return 'Risalah RUPS Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak dengan alasan <i>'.$this->idAnggaran['keterangan'].'</i>. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh <b>Divisi Renbang</b>';
            case 31:
                return 'Risalah RUPS Anggaran dengan Nomer Dinas/Surat <b>'.$this->idAnggaran['nd_surat'].'</b> diajukan oleh <b>'.$this->idAnggaran['unit_kerja'].'</b> pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui dan ditandatangani';
        }
    }
}
