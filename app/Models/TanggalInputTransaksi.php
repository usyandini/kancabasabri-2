<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//  ------------------------- REJECT REASON DESC ------------------------ //
//          1 = Reject transaksi by Kakancab (lv1)						  //
//          2 = Reject transaksi by akuntansi (lv2)						  //
//          3 = Reject tarik tunai by akuntansi (lv1)					  //	
//          4 = Reject penyesuaian dropping by bia (lv1)				  //
//          5 = Reject penyesuaian dropping by akuntansi (lv2)	
//						untuk pengajuan dropping						  //
//          6 = Reject pengajuan dropping oleh staff Akuntansi (lv1)	  //
//          7 = Reject pengajuan dropping oleh kabid Akuntansi (lv2)	  //
//          8 = Reject pengajuan dropping oleh kadiv Akuntansi (lv3)	  //
//  --------------------------------------------------------------------  //

class TanggalInputTransaksi extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'tanggal_transaksi';

	protected $fillable = ['tanggal'];
}
