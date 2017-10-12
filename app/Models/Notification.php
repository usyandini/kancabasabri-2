<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ---------------- Types -------------
// 1 = Submit verifikasi lvl 1 | Receiver : null (All Kakancab)
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

    public function formMaster()
    {
        return $this->belongsTo('App\Models\FormMasterPelaporan', 'batch_id', 'id');
    }

    public function tindakLanjut()
    {
        return $this->belongsTo('App\Models\TlTanggal', 'batch_id', 'id1');
    }

    public function pengajuanDropping()
    {
        return $this->belongsTo('App\Models\PengajuanDropping', 'batch_id', 'id');
    }

    public function wording()
    {
        $batchNo = $this->batch ? $this->batch->batchNo() : '';
        $tw_dari="";
        $tw_ke="";
        $TW="";
        if($this->type >= 32&& $this->type <= 37){
            $tw_dari = $this->formMaster['tw_dari'];
            $tw_ke = $this->formMaster['tw_ke'];
            switch ($tw_dari) {
                case '1': $tw_dari = "I";break;
                case '2': $tw_dari = "II";break;
                case '3': $tw_dari = "III";break;
                case '4': $tw_dari = "IV";break;  
            }
            switch ($tw_ke) {
                case '1': $tw_ke = "I";break;
                case '2': $tw_ke = "II";break;
                case '3': $tw_ke = "III";break;
                case '4': $tw_ke = "IV";break;  
            }
            if($tw_dari == $tw_ke){
                $TW = "TW ".$tw_dari;
            }else{
                $TW = "TW ".$tw_dari." Sampai TW ".$tw_ke;
            }

        }else if($this->type >= 40&& $this->type <= 42){
            $periode = $this->pengajuanDropping['periode_realisasi'];
            switch ($periode) {
                case '1': $TW = "I";break;
                case '2': $TW = "II";break;
                case '3': $TW = "III";break;
                case '4': $TW = "IV";break;  
            }
        }
        

        switch ($this->type) {
            case 1:
                return 'Batch <b>'.$batchNo.'</b> butuh review anda untuk approval sebagai Kakancab.';
            case 2:
                return 'Batch <b>'.$batchNo.'</b> anda ditolak dengan perbaikan oleh Kakancab. Silahkan lakukan perubahan dan submit kembali.';
            case 3:
                return 'Batch <b>'.$batchNo.'</b> anda telah disetujui oleh Kakancab. Silahkan Menunggu verifikasi dari user Akutansi.';
            case 4:
                return 'Batch <b>'.$batchNo.'</b> telah disetujui oleh user Kakancab. Mohon review untuk verifikasi akhir anda sebagai user Akutansi.';
            case 5:
                return 'Batch <b>'.$batchNo.'</b> anda ditolak dengan perbaikan oleh user Akutansi. Silahkan lakukan perubahan dan submit kembali.';
            case 6: 
                return 'Batch <b>'.$batchNo.'</b> anda telah diverifikasi oleh user Akutansi. Harap menunggu konfirmasi dari Pusat.';
            case 7: 
                return 'Tarik Tunai dilakukan oleh '.$this->idTarikTunai['cabang'].'. Mohon review untuk verifikasi level 1.';
            case 8:
                return 'Tarik Tunai oleh '.$this->idTarikTunai['cabang'].' pada tanggal '.date('d F Y', strtotime($this->idTarikTunai['created_at'])).' ditolak oleh verifikator dengan alasan '.$this->rejectTarikTunai['reason']['content'].'. Silahkan melakukan Tarik Tunai kembali.';
            case 9:
                return 'Tarik Tunai oleh '.$this->idTarikTunai['cabang'].' pada tanggal '.date('d F Y', strtotime($this->idTarikTunai['created_at'])).' telah diverifikasi.';
            case 10: 
                return 'Penyesuaian dropping dilakukan oleh '.$this->idPenyesuaian['cabang'].'. Mohon review untuk verifikasi level 1.';
            case 11:
                return 'Penyesuaian dropping oleh '.$this->idPenyesuaian['cabang'].' pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' ditolak dengan alasan '.$this->rejectPenyesuaian['reason']['content'].'. Silahkan melakukan Penyesuaian Dropping kembali.';
            case 12:
                return 'Penyesuaian dropping oleh '.$this->idPenyesuaian['cabang'].' pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' telah diverifikasi level 1. Mohon review untuk verifikasi level 2.';
            case 13:
                return 'Penyesuaian dropping oleh '.$this->idPenyesuaian['cabang'].' pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' ditolak dengan alasan '.$this->rejectPenyesuaian['reason']['content'].'. Silahkan melakukan Penyesuaian Dropping kembali.';
            case 14:
                return 'Penyesuaian dropping oleh '.$this->idPenyesuaian['cabang'].' pada tanggal '.date('d F Y', strtotime($this->idPenyesuaian['created_at'])).' telah diverifikasi.';
            case 15:
                return 'Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].'. Mohon review untuk disetujui anda sebagai Kanit Kerja '.$this->idAnggaran['unit_kerja'].'.';
            case 16:
                return 'Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak oleh Kanit Kerja dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali.';
            case 17:
                return 'Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui oleh Kanit Kerja. Mohon review untuk disetujui anda sebagai Divisi Renbang.';
            case 18:
                return 'Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak oleh Divisi Renbang dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali.';
            case 19:
                return 'Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui oleh Divisi Renbang. Mohon review untuk disetujui anda sebagai Direksi.';
            case 20:
                return 'Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak oleh Direksi dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh Divisi Renbang';
            case 21:
                return 'Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui oleh Direksi. Mohon Naskah RKAP untuk disetujui anda sebagai Dewan Komisaris.';
            case 22:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak oleh Dewan Komisaris dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh Divisi Renbang';
            case 23:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui oleh Dewan Komisaris. Mohon Naskah RKAP disetujui pada Rapat Teknis.';
            case 24:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak pada Rapat Teknis dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh Divisi Renbang';
            case 25:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui pada Rapat Teknis. Mohon Naskah RKAP disetujui pada Rapat Umum Pemegang Saham';
            case 26:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak pada Rapat Umum Pemegang Saham dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh Divisi Renbang';
            case 27:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui pada Rapat Umum Pemegang Saham. Mohon Naskah RKAP dilakukan Finalisasi RUPS.';
            case 28:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak pada Finalisasi RUPS dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh Divisi Renbang.';
            case 29:
                return 'Naskah RKAP Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui pada Finalisasi RUPS. Mohon Naskah RKAP dilakukan Pembuatan Risalah RUPS.';
            case 30:
                return 'Risalah RUPS Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' ditolak dengan alasan '.$this->idAnggaran['keterangan'].'. Silahkan melakukan Perbaikan Anggaran dan Kegiatan kembali oleh Divisi Renbang';
            case 31:
                return 'Risalah RUPS Anggaran dengan Nomer Dinas/Surat '.$this->idAnggaran['nd_surat'].' diajukan oleh '.$this->idAnggaran['unit_kerja'].' pada tanggal '.date('d F Y', strtotime($this->idAnggaran['updated_at'])).
                ' telah disetujui dan ditandatangani';
            case 32:
                return 'Form Master untuk Pelaporan Anggaran dan kegiatan untuk '.$TW.'  unit kerja '.$this->formMaster['unit_kerja'].' telah dibuat dan dapat di isi mulai dari '.$this->formMaster['tanggal_mulai'].' sampai '.$this->formMaster['tanggal_selesai'];
            case 33:
                return 'Pelaporan Anggaran dan kegiatan telah diisi oleh '.$this->formMaster['unit_kerja'].' untuk '.$TW.'.';
            case 34:
                return 'Form Master untuk Arahan RUPS untuk '.$TW.' unit kerja '.$this->formMaster['unit_kerja'].' telah dibuat dan dapat di isi mulai dari '.$this->formMaster['tanggal_mulai'].' sampai '.$this->formMaster['tanggal_selesai'];
            case 35:
                return 'Arahan RUPS telah diisi oleh '.$this->formMaster['unit_kerja'].' untuk '.$TW.'.';
            case 36:
                return 'Form Master untuk Usulan Program Prioritas untuk '.$TW.'  unit kerja '.$this->formMaster['unit_kerja'].' telah dibuat dan dapat di isi mulai dari '.$this->formMaster['tanggal_mulai'].' sampai '.$this->formMaster['tanggal_selesai'];
            case 37:
                return 'Usulan Program Prioritas telah diisi oleh '.$this->formMaster['unit_kerja'].' untuk '.$TW.'.';
            case 38:
                return 'Temuan dan Rekomendasi telah dibuat dan akan dikirim ke unit kerja '.$this->tindakLanjut['unitkerja'].'.';
            case 39:
                return 'Tindak Lanjut telah diisi oleh unit kerja '.$this->tindakLanjut['unitkerja'].' dan akan dikirim ke SPI.';
            case 40:
                return 'Pengajuan Dropping telah di buat oleh '.$this->pengajuanDropping['kantor_cabang'].' untuk periode TW '.$TW.' dengan Nomor '.$this->pengajuanDropping['nomor'].'.';
            case 41:
                return 'Pengajuan Dropping '.$this->pengajuanDropping['kantor_cabang'].' periode TW '.$TW.' dengan Nomor '.$this->pengajuanDropping['nomor'].' telah ditolak oleh ????. Silahkan Kirim Pengajuan Kembali.';
            case 42:
                return 'Pengajuan Dropping '.$this->pengajuanDropping['kantor_cabang'].' periode TW '.$TW.' dengan Nomor '.$this->pengajuanDropping['nomor'].' telah diterima oleh ????.';
        }
    }
}
