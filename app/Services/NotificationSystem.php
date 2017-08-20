<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Batch;

// ---------------- Types -------------
// 1 = Submit verifikasi lvl 1 | Receiver : null (All Kasmin)
// 2 = Submit verifikasi lvl 1 rejected | Reveiver : id batch submitter
// 3 = Submit verifikasi lvl 1 approved | Receiver : id batch submitter
// ------------------------------------
class NotificationSystem
{
	public static function send($id, $type)
	{
		switch ($type) {
			case 1:
				$receiver_id = null;
				break;
			case 2:
				$receiver_id = Batch::where('id', $id)->first()['creator']['id'];
				break;
			case 3:
				$receiver_id = Batch::where('id', $id)->first()['creator']['id'];
				break;
		}

		$data = array('batch_id' => $id, 'type' => $type, 'receiver_id' => $receiver_id);
		Notification::create($data);
	}

	public static function update($data, $id)
	{
		Notification::where('id', $id)->update($data);
	}

	public static function delete($id)
	{
		Notification::where('id',$id)->delete();
	}

	public static function get($idNotif)
	{
		return Notification::where('id',$idNotif)->first();
	}

	public static function getAll($receiver_id = null)
	{
		if ($receiver_id) {
			return Notification::where([['receiver_id', $receiver_id]])->get();
		}

		return Notification::get();
	}

	public static function markAsRead($id)
	{
		Notification::where('id', $id)->update(['is_read' => 1]);
	}

	public static function getUnreads($receiver_id = null)
	{
		if ($receiver_id) {
			return Notification::where([['receiver_id', $receiver_id], ['is_read', 0]])->get();
		}

		return Notification::where('is_read', 0)->get();
	}
}