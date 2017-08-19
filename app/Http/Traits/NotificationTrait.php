<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Services\NotificationSystem;

trait NotificationTrait
{
	public function send($id, $type)
	{
		$notif_input = array('batch_id' => $id, 'type' => $type);
        NotificationSystem::store($notif_input);
	}

	public function getAll($receiver_id)
	{
		return notificationSystem::getAll($receiver_id);
	}
}