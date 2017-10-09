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
            case 0:
			case 1:
            case 4:
				$receiver_id = null;
				break;
            case 7:
            case 39:
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

    public static function checkArrayTypes()
    {
        $user = \Auth::user();
        $array_type = [];
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
        if(isset($user->perizinan['notif_ajukan_p_a'])){
            array_push($array_type,33);
        }
        if(isset($user->perizinan['notif_ajukan_a_RUPS'])){
            array_push($array_type,35);
        }
        if(isset($user->perizinan['notif_ajukan_usulan_p_p'])){
            array_push($array_type,37);
        }

        if(isset($user->perizinan['notif_ajukan_master_p_a'])){
            array_push($array_type,32);
        }
        if(isset($user->perizinan['notif_ajukan_master_a_RUPS'])){
            array_push($array_type,34);
        }
        if(isset($user->perizinan['notif_ajukan_master_usulan_p_p'])){
            array_push($array_type,36);
        }

        if(isset($user->perizinan['notif_tindak_lanjut'])){
            array_push($array_type,38);
        }

        if(isset($user->perizinan['notif_tindak_lanjut2'])){
            array_push($array_type,39);
        }

        return $array_type;
    }

	public static function getAll($receiver_id = null)
	{	
        $array_type = static::checkArrayTypes();
        
        if(count($array_type) == 0) { return null; }
        return Notification::whereIn('type',$array_type)
                        ->orderBy('id', 'desc')
                        ->get()->filter(function($notif) {
                            return $notif->receiver_id == \Auth::user()->id || $notif->receiver_id == null; 
                        });
	}

	public static function markAsRead($id)
	{
		Notification::where('id', $id)->update(['is_read' => 1]);
	}

    public static function markAllAsRead()
    {
        $notif = static::getAll();
        foreach ($notif as $not) {
            static::markAsRead($not->id);
        }
    } 

    public static function deleteAll()
    {
        $notif = static::getAll();
        foreach ($notif as $not) {
            Notification::where('id', $not->id)->delete();
        }
    }

	public static function getUnreads($receiver_id = null)
	{
	    $array_type = static::checkArrayTypes();	
        if(count($array_type) == 0) { return null; }
        
        return Notification::where('receiver_id', \Auth::user()->id)
                        ->orWhereNull('receiver_id')
                        ->whereIn('type',$array_type)
                        ->orderBy('id', 'desc')
                        ->get()->filter(function($notif) {
                            $isread = $notif->is_read != 1 ? true : false;
                            $receiver = $notif->receiver_id == \Auth::user()->id || $notif->receiver_id == null;
                            return $isread && $receiver;
                        });
	}
}