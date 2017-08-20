<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Services\NotificationSystem;

// ---------------- Types -------------
// 1 = Submit verifikasi lvl 1 | Receiver : null (All Kasmin)
// 2 = Submit verifikasi lvl 1 rejected | Reveiver : id batch submitter
// 3 = Submit verifikasi lvl 1 approved | Receiver : id batch submitter
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
    	foreach ($notifications as $value) {
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
    	switch ($notifDetail->type) {
    		case 1:
    			return redirect('transaksi/persetujuan/'.$notifDetail->batch_id);
            case 3:
                return redirect('transaksi/verifikasi/'.$notifDetail->batch_id);
			default:
				return redirect('transaksi/');
    	}
    }
}
