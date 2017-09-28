<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\TarikTunai;
use App\Models\PenyesuaianDropping;
use App\Models\Anggaran;
use App\Models\Notification;

use App\Services\NotificationSystem;

// ---------------- Types -------------
// 1 = Submit verifikasi lvl 1 | Receiver : null (All Kasmin)
// 2 = Submit verifikasi lvl 1 rejected | Reveiver : id batch submitter
// 3 = Submit verifikasi lvl 1 approved | Receiver : id batch submitter
// 4 = Submit verifikasi lvl 1 approved | Receiver : null (All Akutansi)
// 5 = Submit verifikasi lvl 2 rejected | Reveiver : id batch submitter
// 6 = Submit verifikasi lvl 2 approved | Receiver : id batch submitter
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
    	foreach (NotificationSystem::getUnreads() as $value) {
    		$result['notifications'][] = [
    			'id' 		=> $value->id,
    			'wording' 	=> $value->wording(),
    			'is_read'	=> $value->is_read,
    			'time_dif' 	=> \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans(),
    			'time'		=> date('d F Y, H:m', strtotime($value->created_at))
    		];
    	}

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
                $notification_all[] = [
                    'id'        => $value->id,
                    'wording'   => $value->wording(),
                    'is_read'   => $value->is_read,
                    'time_dif'  => \Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans(),
                    'time'      => date('d F Y, H:m', strtotime($value->created_at))
                ];
            }
        // $notification_all = null;
        // if(count($notification_all)){
        //     $notification_all = null;
        // }
        return view('notification.index', compact('notification_all'));
    }
}
