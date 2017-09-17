<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//  ----------- REJECT REASON DESC ------------- 
//          1 = Reject transaksi by kasimin (lv1)
//          2 = Reject transaksi by akuntansi (lv2)
//          3 = Reject tarik tunai by akuntansi (lv1)
//          4 = Reject penyesuaian dropping by bia (lv1)
//          5 = Reject penyesuaian dropping by akuntansi (lv2)
//  -----------------------------------------

class RejectReason extends Model
{
    protected $connection = 'sqlsrv';

	protected $table = 'reject_reasons';

	protected $fillable = ['content', 'type'];
}
