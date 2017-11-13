<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests;

use App\Models\TarikTunai;
use App\Models\PenyesuaianDropping;
use App\Models\Anggaran;
use App\Models\Notification;
use App\Models\KantorCabang;
use App\Models\Divisi;
use App\Models\FormMasterPelaporan;
use App\Models\TlTanggal;
use App\Models\PengajuanDropping;
use App\Models\BatasAnggaran;

use App\Services\NotificationSystem;

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

class NotificationController extends Controller
{
    public function get()
    {   $count_unread = 0;
        $notifications = NotificationSystem::getUnreads();
    	$result = [
    		'total'	=> $notifications->count(),
    		'totalUnread' => $count_unread,
    		'notifications' => []];
        $count_unread = 0 ;
    	foreach (NotificationSystem::getUnreads() as $value) {
            $unit_kerja = "";
            $notif = false;
            if($value->type < 7){

                $divisi = $value->batch['divisi'];
                $cabang = $value->batch['cabang'];
                if($cabang == "00"){
                    $unit_kerja = "00".$divisi;
                }else{
                    $unit_kerja = $cabang."00";
                }
                if(Gate::check('unit_'.$unit_kerja)){
                    $notif = true;
                }
            }else if($value->type < 15){
                if($value->type < 10){
                    $unit_kerja = $value->idTarikTunai['cabang'];
                }else{
                    $unit_kerja = $value->idPenyesuaian['cabang'];
                }
                if(Gate::check('unit_'.$this->check($unit_kerja))){
                    $notif = true;
                }
            }else if($value->type <32){
                $unit_kerja = $value->idAnggaran['unit_kerja'];
                if(Gate::check('unit_'.$this->check($unit_kerja))){
                    $notif = true;
                }
            }else if($value->type <38){
                $unit_kerja = $value->formMaster['unit_kerja'];
                if(Gate::check('unit_'.$this->check($unit_kerja))){
                    $notif = true;
                }
            }else if($value->type <40){
                $unit_kerja = $value->tindakLanjut['unitkerja'];
                if(Gate::check('unit_'.$this->check($unit_kerja))){
                    $notif = true;
                }
            }else if($value->type <47){
                $unit_kerja = $value->pengajuanDropping['kantor_cabang'];
                if(Gate::check('unit_'.$this->check($unit_kerja))){
                    $notif = true;
                }
            }else if($value->type <48){
                $unit_kerja = $value->pengajuanAnggaran['unit_kerja'];
                if($unit_kerja=="Semua Unit Kerja"){
                    $notif = true;
                }
                else{
                if(Gate::check('unit_'.$this->check($unit_kerja))){
                    $notif = true;
                    }
                }
            }

            if($notif){
        		$result['notifications'][] = [
        			'id' 		=> $value->id,
                    'type'      => $value->type,
        			'wording' 	=> $value->wording(),
        			'is_read'	=> $value->is_read,
        			'time_dif' 	=> \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans(),
        			'time'		=> date('d F Y, H:m', strtotime($value->created_at))
        		];
                $result['totalUnread'] = ++$count_unread;
            }
    	}

    	return response()->json($result);
    }

    public function redirect($id)
    {
        $read = true;
        $notifDetail = NotificationSystem::get($id);

        $value_cabang = \Auth::user()->cabang;
        $value_divisi = \Auth::user()->divisi;

        $form_master = FormMasterPelaporan::where('id', $notifDetail->batch_id)->first();
        $tindakLanjut = TlTanggal::where('id1', $notifDetail->batch_id)->first();
        $pengajuan = PengajuanDropping::where('id', $notifDetail->batch_id)->first();
        $pengajuan_anggaran = BatasAnggaran::where('id', $notifDetail->batch_id)->first();
        $unit_kerja = "";
        if($value_cabang == "00"){
            $unit_kerja = \Auth::user()->divisi()['DESCRIPTION'];
        }else{
            $unit_kerja = \Auth::user()->kantorCabang()['DESCRIPTION'];
        }

        if($notifDetail->type >=32 && $notifDetail->type<=47){
            $unit = "";
            if($notifDetail->type <= 36){
                $unit = $form_master->unit_kerja;
            }else if($notifDetail->type <= 38){
                $unit = $tindakLanjut->unitkerja;
            }else if($notifDetail->type <= 39){
                $unit = $tindakLanjut->unitkerja;    
            }else if($notifDetail->type <= 42){
                $unit = $pengajuan->kantor_cabang;
            }else if($notifDetail->type <= 47){
                $unit = $pengajuan_anggaran->unit_kerja;
            }

            if($notifDetail->type == 32){
                if(!Gate::check('tambah_pelaporan_anggaran')&&$unit_kerja!=$unit){
                    $read = false;
                }
            }
            if($notifDetail->type == 34){
                if(!Gate::check('tambah_pelaporan_a_RUPS')&&$unit_kerja!=$unit){
                    $read = false;
                }
            }
            if($notifDetail->type == 36){
                if(!Gate::check('tambah_pelaporan_usulan_p_p')&&$unit_kerja!=$unit){
                    $read = false;
                }
            }

            if($notifDetail->type == 38){
                if(!Gate::check('t_l_internal')&&$unit_kerja!=$unit){
                    $read = false;
                }
            }

            if($notifDetail->type == 41||$notifDetail->type == 43||$notifDetail->type == 45||$notifDetail->type == 46){
                if(!Gate::check('informasi_a_d')&&$unit_kerja!=$unit){
                    $read = false;
                }
            }
            if($notifDetail->type == 40){
                if(!Gate::check('setuju_a_d')||Gate::check('notif_setuju_a_d')){
                    if($unit_kerja!="Akuntansi"){
                        $read = false;
                    }
                }
            }

            if($notifDetail->type == 42){
                if(!Gate::check('setuju_a_d_2')||Gate::check('notif_setuju_a_d_2')){
                    if($unit_kerja!="Akuntansi"){
                        $read = false;
                    }
                }
            }



            if($notifDetail->type == 44){
                if(!Gate::check('setuju_a_d_3')||Gate::check('notif_setuju_a_d_3')){
                    if($unit_kerja!="Akuntansi"){
                        $read = false;
                    }
                }
            }

            if($notifDetail->type == 47){
                if(!Gate::check('notif_pengajuan_anggaran')&&$unit_kerja!=$unit){
                    $read = false;
                }
            }
        }
       
            
	   if($read)
            NotificationSystem::markAsRead($id); 
        
        $tariktunai = TarikTunai::where('id', $notifDetail->batch_id)->first();
        $penyesuaian = PenyesuaianDropping::where('id', $notifDetail->batch_id)->first();
        $anggaran = Anggaran::where('id', $notifDetail->batch_id)->first();
    	switch ($notifDetail->type) {
    		case 1:
    			return redirect('transaksi/persetujuan/'.$notifDetail->batch_id);
            case 2:
            case 3:
            case 5:
            case 6:
                return redirect('transaksi/'.$notifDetail->batch_id);
            case 4:
                return redirect('transaksi/verifikasi/'.$notifDetail->batch_id);
            case 7:
                return redirect('dropping/verifikasi/tariktunai/'.$notifDetail->batch_id);
            case 8:
                return redirect('dropping/tariktunai/'.$tariktunai->id_dropping);
            case 9:
                return redirect('dropping/tariktunai/'.$tariktunai->id_dropping);
            case 10:
                return redirect('dropping/verifikasi/penyesuaian/'.$notifDetail->batch_id);
            case 11:
                return redirect('dropping/penyesuaian/'.$penyesuaian->id_dropping);
            case 12:
                return redirect('dropping/verifikasi/penyesuaian/final/'.$notifDetail->batch_id);
            case 13:
                return redirect('dropping/penyesuaian/'.$penyesuaian->id_dropping);
            case 14:
                return redirect('dropping/penyesuaian/'.$penyesuaian->id_dropping);
            case 15:
                return redirect('anggaran/persetujuan/'.$anggaran->nd_surat."/1");
            case 16:
                return redirect('anggaran/edit/'.$anggaran->nd_surat);
            case 17:
                return redirect('anggaran/persetujuan/'.$anggaran->nd_surat."/1");
            case 18:
                return redirect('anggaran/edit/'.$anggaran->nd_surat);
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:
            case 25:
            case 26:
            case 27:
            case 28:
            case 29:
            case 30:
            case 31:
                return redirect('anggaran/persetujuan/'.$anggaran->nd_surat."/1");
            case 32:
                if(Gate::check('tambah_pelaporan_anggaran'))
                    return redirect('pelaporan/tambah/item/laporan_anggaran/'.$form_master->id);
                else
                    return redirect('pelaporan/edit/master/laporan_anggaran/'.$form_master->id);
            case 33:
                return redirect('pelaporan/edit/item/laporan_anggaran/'.$form_master->id);
            case 34:
                if(Gate::check('tambah_pelaporan_a_RUPS'))
                    return redirect('pelaporan/tambah/item/arahan_rups/'.$form_master->id);
                else
                    return redirect('pelaporan/edit/master/arahan_rups/'.$form_master->id);
            case 35:
                return redirect('pelaporan/edit/item/arahan_rups/'.$form_master->id);
            case 36:
                if(Gate::check('tambah_pelaporan_usulan_p_p'))
                    return redirect('pelaporan/tambah_usulan_program/'.$form_master->id);
                else
                    return redirect('pelaporan/edit/master/usulan_program/'.$form_master->id);
            case 37:
                return redirect('pelaporan/edit_usulan_program/'.$form_master->id);
            case 38:
                return redirect('tindaklanjutinternal/'.$notifDetail->batch_id);
            case 39:
                return redirect('unitkerja/tindaklanjut/'.$notifDetail->batch_id);
            case 40:
                return redirect('acc_pengajuan_dropping/verifikasi/'.$notifDetail->batch_id);
            case 41:
                return redirect('pengajuan_dropping/lihat/'.$notifDetail->batch_id);
            case 42:
                return redirect('acc_pengajuan_dropping2/verifikasi/'.$notifDetail->batch_id);
            case 43:
                return redirect('pengajuan_dropping/lihat/'.$notifDetail->batch_id);
            case 44:
                return redirect('acc_pengajuan_dropping3/verifikasi/'.$notifDetail->batch_id);
            case 45:
                return redirect('pengajuan_dropping/lihat/'.$notifDetail->batch_id);
            case 46:
                return redirect('pengajuan_dropping/lihat/'.$notifDetail->batch_id);
            case 47:
                return redirect('anggaran/tambah');
			default:
				return redirect('transaksi/');
    	}
    }

    public function read_all(){

        $notification_all = [];
        if(NotificationSystem::getAll()!=null)
            foreach (NotificationSystem::getAll() as $value) {
                $unit_kerja = "";
                $notif = false;
                if($value->type < 7){

                    $divisi = $value->batch['divisi'];
                    $cabang = $value->batch['cabang'];
                    if($cabang == "00"){
                        $unit_kerja = "00".$divisi;
                    }else{
                        $unit_kerja = $cabang."00";
                    }
                    if(Gate::check('unit_'.$unit_kerja)){
                        $notif = true;
                    }
                }else if($value->type < 15){
                    if($value->type < 10){
                        $unit_kerja = $value->idTarikTunai['cabang'];
                    }else{
                        $unit_kerja = $value->idPenyesuaian['cabang'];
                    }
                    if(Gate::check('unit_'.$this->check($unit_kerja))){
                        $notif = true;
                    }
                }else if($value->type <32){
                    $unit_kerja = $value->idAnggaran['unit_kerja'];
                    if(Gate::check('unit_'.$this->check($unit_kerja))){
                        $notif = true;
                    }
                }else if($value->type <38){
                    $unit_kerja = $value->formMaster['unit_kerja'];
                    if(Gate::check('unit_'.$this->check($unit_kerja))){
                        $notif = true;
                    }
                }else if($value->type <40){
                    $unit_kerja = $value->tindakLanjut['unitkerja'];
                    if(Gate::check('unit_'.$this->check($unit_kerja))){
                        $notif = true;
                    }
                }else if($value->type <47){
                    $unit_kerja = $value->pengajuanDropping['kantor_cabang'];
                    if(Gate::check('unit_'.$this->check($unit_kerja))){
                        $notif = true;
                    }
                }else if($value->type <48){
                    $unit_kerja = $value->pengajuanAnggaran['unit_kerja'];
                    if(Gate::check('unit_'.$this->check($unit_kerja))){
                        $notif = true;
                    }
                }
                    
                    
                if($notif){
                    $notification_all[] = [
                        'id'        => $value->id,
                        'type'      => $value->type,
                        'wording'   => $value->wording(),
                        'is_read'   => $value->is_read,
                        'time_dif'  => \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans(),
                        'time'      => date('d F Y, H:m', strtotime($value->created_at))
                    ];
                }
            }
        // $notification_all = null;
        // if(count($notification_all)){
        //     $notification_all = null;
        // }
        return view('notification.index', compact('notification_all'));
    }

    public function check($unit_kerja){
        $val_unit="";
        if(count(explode("Cabang",$unit_kerja))>1){
            $val_unit = KantorCabang::where('DESCRIPTION',$unit_kerja)->first();
            $val_unit = $val_unit['VALUE']."00";
        }else{  
            $val_unit = DIVISI::where('DESCRIPTION',$unit_kerja)->first();
            $val_unit = "00".$val_unit['VALUE'];
        }
        return $val_unit;
    } 

    public function markAllAsRead()
    {
        NotificationSystem::markAllAsRead();
        return redirect()->back();
    }

    public function deleteAll()
    {
        NotificationSystem::deleteAll();
        return redirect()->back();   
    }
}
