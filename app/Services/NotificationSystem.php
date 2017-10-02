<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Batch;
use App\User;

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
class NotificationSystem
{
	public static function send($id, $type)
	{
		switch ($type) {
			case 1:
            case 4:
				$receiver_id = null;
				break;
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
		$array_type = array();
        $user = \Auth::user();
        if(isset($user->perizinan['notif_setuju_tt_d'])){
            array_push($array_type,7);
        }
        if(isset($user->perizinan['notif_ubah_tt_d'])){
            array_push($array_type,8,9);
        }
        if(isset($user->perizinan['notif_setuju_p_d'])){
            array_push($array_type,10);
        }
        if(isset($user->perizinan['notif_setuju_p2_d'])){
            array_push($array_type,12);
        }
        if(isset($user->perizinan['notif_ubah_p_d'])){
            array_push($array_type,11,13,14);
            if (!in_array(12, $array_type)) {
                array_push($array_type,12);
            }
        }
        if(isset($user->perizinan['notif_setuju_t'])){
            array_push($array_type,1);
        }
        if(isset($user->perizinan['notif_setuju2_t'])){
            array_push($array_type,4);
        }
        if(isset($user->perizinan['notif_ubah_t'])){
            array_push($array_type,2,3,5,6);
            if (!in_array(4, $array_type)) {
                array_push($array_type,4);
            }
        }

        if(isset($user->perizinan['notif_setuju_ia'])){
            array_push($array_type,15);
        }
        if(isset($user->perizinan['notif_setuju_iia'])){
            array_push($array_type,17);
        }
        if(isset($user->perizinan['notif_setuju_iiia'])){
            array_push($array_type,19);
        }
        if(isset($user->perizinan['notif_setuju_iva'])){
            array_push($array_type,21);
        }
        if(isset($user->perizinan['notif_setuju_va'])){
            array_push($array_type,23);
        }
        if(isset($user->perizinan['notif_setuju_via'])){
            array_push($array_type,25);
        }
        if(isset($user->perizinan['notif_setuju_viia'])){
            array_push($array_type,27);
        }
        if(isset($user->perizinan['notif_setuju_viiia'])){
            array_push($array_type,29);
        }
        if(isset($user->perizinan['notif_ubah_a'])){
            
            array_push($array_type,16);
            if (!in_array(17, $array_type)) {
                array_push($array_type,17);
            }
            array_push($array_type,18);
            if (!in_array(19, $array_type)) {
                array_push($array_type,19);
            }
            array_push($array_type,20);
            if (!in_array(21, $array_type)) {
                array_push($array_type,21);
            }
            array_push($array_type,22);
            if (!in_array(23, $array_type)) {
                array_push($array_type,23);
            }
            array_push($array_type,24);
            if (!in_array(25, $array_type)) {
                array_push($array_type,25);
            }
            array_push($array_type,26);
            if (!in_array(27, $array_type)) {
                array_push($array_type,27);
            }
            array_push($array_type,28);
            if (!in_array(29, $array_type)) {
                array_push($array_type,29);
            }
            array_push($array_type,30);
            array_push($array_type,31);
        }

        if(count($array_type) == 0){
            return null;
        }

        // $notifications = Notification::where('type', $array_type[0]);
        // if(count($array_type) > 1 ){
        //     for($i=1;$i<count($array_type);$i++){
        //         $notifications=$notifications->orWhere('type', $array_type[$i]);
        //     }
        // }

		if ($receiver_id) {
			return Notification::where([['receiver_id', $receiver_id]])->orderBy('id', 'desc')->get();
		}

		return Notification::whereIn('type',$array_type)->orderBy('id', 'desc')->get();
	}

	public static function markAsRead($id)
	{
		Notification::where('id', $id)->update(['is_read' => 1]);
	}

	public static function getUnreads($receiver_id = null)
	{
		$array_type = array();
        $user = \Auth::user();
        if(isset($user->perizinan['notif_setuju_tt_d'])){
            array_push($array_type,7);
        }
        if(isset($user->perizinan['notif_ubah_tt_d'])){
            array_push($array_type,8,9);
        }
        if(isset($user->perizinan['notif_setuju_p_d'])){
            array_push($array_type,10);
        }
        if(isset($user->perizinan['notif_setuju_p2_d'])){
            array_push($array_type,12);
        }
        if(isset($user->perizinan['notif_ubah_p_d'])){
            array_push($array_type,11,13,14);
            if (!in_array(12, $array_type)) {
                array_push($array_type,12);
            }
        }
        if(isset($user->perizinan['notif_setuju_t'])){
            array_push($array_type,1);
        }
        if(isset($user->perizinan['notif_setuju2_t'])){
            array_push($array_type,4);
        }
        if(isset($user->perizinan['notif_ubah_t'])){
            array_push($array_type,2,3,5,6);
            if (!in_array(4, $array_type)) {
                array_push($array_type,4);
            }
        }
        if(isset($user->perizinan['notif_setuju_ia'])){
            array_push($array_type,15);
        }
        if(isset($user->perizinan['notif_setuju_iia'])){
            array_push($array_type,17);
        }
        if(isset($user->perizinan['notif_setuju_iiia'])){
            array_push($array_type,19);
        }
        if(isset($user->perizinan['notif_setuju_iva'])){
            array_push($array_type,21);
        }
        if(isset($user->perizinan['notif_setuju_va'])){
            array_push($array_type,23);
        }
        if(isset($user->perizinan['notif_setuju_via'])){
            array_push($array_type,25);
        }
        if(isset($user->perizinan['notif_setuju_viia'])){
            array_push($array_type,27);
        }
        if(isset($user->perizinan['notif_setuju_viiia'])){
            array_push($array_type,29);
        }
        if(isset($user->perizinan['notif_ubah_a'])){
            array_push($array_type,16);
            if (!in_array(17, $array_type)) {
                array_push($array_type,17);
            }
            array_push($array_type,18);
            if (!in_array(17, $array_type)) {
                array_push($array_type,17);
            }
            array_push($array_type,20);
            if (!in_array(19, $array_type)) {
                array_push($array_type,19);
            }
            array_push($array_type,22);
            if (!in_array(21, $array_type)) {
                array_push($array_type,21);
            }
            array_push($array_type,24);
            if (!in_array(23, $array_type)) {
                array_push($array_type,23);
            }
            array_push($array_type,26);
            if (!in_array(25, $array_type)) {
                array_push($array_type,25);
            }
            array_push($array_type,28);
            if (!in_array(27, $array_type)) {
                array_push($array_type,27);
            }
            array_push($array_type,30);
            if (!in_array(29, $array_type)) {
                array_push($array_type,29);
            }
            array_push($array_type,31);
        }
        if(count($array_type) == 0){
            return null;
        }
        
        // $notifications = Notification::where('type', $array_type[0]);
        // $notifications = 
        // 	Notification::where(function ($query,) {
        // 					$query->where('type', $this->$array_type[0]);
        // 					if(count($this->$array_type) > 1 ){
					   //          for($i=1;$i<count($this->$array_type);$i++){
					   //              $query=$query->orWhere('type', $this->$array_type[$i]);
					   //          }
					   //      }
        // 	});
        
        $notifications = Notification::where('is_read',0)->whereIn('type',$array_type);
		if ($receiver_id) {
			return Notification::where([['receiver_id', $receiver_id]])->orderBy('id', 'desc')->get();
		}

		return $notifications->orderBy('id', 'desc')->get();
	}
}