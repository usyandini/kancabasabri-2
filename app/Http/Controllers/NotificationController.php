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

use App\Services\NotificationSystem;

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

class NotificationController extends Controller
{
    public function get()
    {

        $notifications = NotificationSystem::getAll();
    	$result = [
    		'total'	=> $notifications->count(),
    		'totalUnread' => NotificationSystem::getUnreads()->count(),
    		'notifications' => []];
        $count_unread = 0 ;
    	foreach (NotificationSystem::getUnreads() as $value) {
            $unit_kerja = "";
            if($value->type < 7){
                $unit_kerja = "transaksi";
            }else if($value->type < 15){
                if($value->type < 10){
                    $unit_kerja = $value->idTarikTunai['cabang'];
                }else{
                    $unit_kerja = $value->idPenyesuaian['cabang'];
                }
            }else {
                $unit_kerja = $value->idAnggaran['unit_kerja'];
            }
            $val_unit = "";
            if(count(explode("Cabang",$unit_kerja))>1){
                $val_unit = KantorCabang::where('DESCRIPTION',$unit_kerja)->first();
                $val_unit = $val_unit['VALUE']."00";
            }else{  
                $val_unit = DIVISI::where('DESCRIPTION',$unit_kerja)->first();
                $val_unit = "00".$val_unit['VALUE'];
                if($unit_kerja == 'transaksi'){
                    $val_unit = $unit_kerja;
                }
            }
            // if(Gate::check('unit_'.$val_unit)){
        		$result['notifications'][] = [
        			'id' 		=> $value->id,
                    'unit_kerja'=> $val_unit,
                    'type'      => $value->type,
        			'wording' 	=> $value->wording(),
        			'is_read'	=> $value->is_read,
        			'time_dif' 	=> \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans(),
        			'time'		=> date('d F Y, H:m', strtotime($value->created_at))
        		];
                $count_unread++;
            // }
    	}
        $result['totalUnread'] = $count_unread;

    	return response()->json($result);
    }

    public function redirect($id)
    {
    	NotificationSystem::markAsRead($id);
        
        $notifDetail = NotificationSystem::get($id);
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
			default:
				return redirect('transaksi/');
    	}
    }

    public function read_all(){

        $notification_all = [];
        if(NotificationSystem::getAll()!=null)
            foreach (NotificationSystem::getAll() as $value) {
                $unit_kerja = "";
                if($value->type < 7){
                    $unit_kerja = "transaksi";
                }else if($value->type < 15){
                    if($value->type < 10){
                        // $cabang = $value->idTarikTunai();
                        $unit_kerja = $value->idTarikTunai['cabang'];
                    }else{
                        $unit_kerja = $value->idPenyesuaian['cabang'];
                    }
                }else {
                    $unit_kerja = $value->idAnggaran['unit_kerja'];
                }
                $val_unit = "";
                if(count(explode("Cabang",$unit_kerja))>1){
                    $val_unit = KantorCabang::where('DESCRIPTION',$unit_kerja)->first();
                    $val_unit = $val_unit['VALUE']."00";
                }else{  
                    $val_unit = DIVISI::where('DESCRIPTION',$unit_kerja)->first();
                    $val_unit = "00".$val_unit['VALUE'];
                    if($unit_kerja == 'transaksi'){
                        $val_unit = $unit_kerja;
                    }
                }
                if(Gate::check('unit_'.$val_unit)){
                    $notification_all[] = [
                        'id'        => $value->id,
                        'unit_kerja'=> $val_unit,
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
}
