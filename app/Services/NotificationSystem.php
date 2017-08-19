<?php

namespace App\Services;

use App\Models\Notification;

// ---------------- Types -------------
// 1 = Submit verifikasi lvl 1 | Receiver : null (All Kasmin)
// 2 = Submit verifikasi lvl 1 approved | Receiver : id batch submitter
// 3 = Submit verifikasi lvl 1 rejected | Reveiver : id batch submitter
// ------------------------------------
class NotificationSystem
{
	public static function send($id, $type)
	{
		$data = array('batch_id' => $id, 'type' => $type);
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

	public static function getAll($receiver_id = null)
	{
		if ($receiver_id) {
			return Notification::where(['receiver_id', $receiver_id])->get();
		}

		return Notification::get();

	}

	public function getUnreads()
	{

	}
}