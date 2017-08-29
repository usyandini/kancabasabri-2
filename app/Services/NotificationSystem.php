<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Batch;
use App\User;

// ---------------- Types -------------
// 1 = Submit verifikasi lvl 1 | Receiver : null (All Kasmin)
// 2 = Submit verifikasi lvl 1 rejected | Reveiver : id batch submitter
// 3 = Submit verifikasi lvl 1 approved | Receiver : id batch submitter
// 4 = Submit verifikasi lvl 1 approved | Receiver : null (All Akutansi)
// 5 = Submit verifikasi lvl 2 rejected | Reveiver : id batch submitter
// 6 = Submit verifikasi lvl 2 approved | Receiver : id batch submitter
// ------------------------------------
class NotificationSystem
{
	public static function send($id, $type)
	{
		switch ($type) {
			case 1:
				$receiver_id = null;
				break;
			case 7:
				$receiver_id = User::where('id', 5)->first();
			default:
				$receiver_id = Batch::where('id', $id)->first()['creator']['id'];
				break;
		}

		$data = array('batch_id' => $id, 'type' => $type, 'receiver_id' => $receiver_id);
		Notification::create($data);

		if ($type == 3 ) static::sendAlso($id, 4);
	}

	public static function sendAlso($id, $type)
	{
		$data = array('batch_id' => $id, 'type' => $type, 'receiver_id' => null);
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
			return Notification::where([['receiver_id', $receiver_id]])->orderBy('id', 'desc')->get();
		}

		return Notification::orderBy('id', 'desc')->get();
	}

	public static function markAsRead($id)
	{
		Notification::where('id', $id)->update(['is_read' => 1]);
	}

	public static function getUnreads($receiver_id = null)
	{
		if ($receiver_id) {
			return Notification::where([['receiver_id', $receiver_id], ['is_read', 0]])->orderBy('id', 'desc')->get();
		}

		return Notification::where('is_read', 0)->orderBy('id', 'desc')->get();
	}
}