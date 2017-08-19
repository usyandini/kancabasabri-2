<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Services\NotificationSystem;

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
}
