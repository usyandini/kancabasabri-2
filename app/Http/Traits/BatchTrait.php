<?php 

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Batch;
use App\Models\BatchStatus;
use App\Models\RejectHistory;

//  ----------- BATCH STAT DESC -------------
//          0 = Inserted 
//          1 = Updated
//          2 = Posted / Submitted to Kasmin
//          3 = Rejected for revision
//          4 = Verified by Kasmin (lvl 1) / Submitted to Akuntansi 
//          5 = Rejected for revision
//          6 = Verified by Akuntansi (lvl 2)
//  -----------------------------------------

trait BatchTrait
{
	public function defineCurrentBatch()
    {
        $current_batch = Batch::orderBy('id','desc')->first();
        return $current_batch ? $current_batch : null;
    }

    public function defineNewBatch()
    {
    	$input = array('created_by' => \Auth::User()->id);
    	return Batch::create($input);
    }

	public function updateBatchStat($batch, $stat)
    {
        $stat_input = array('batch_id' => $batch->id, 'stat' => $stat, 'submitted_by' => \Auth::User()->id);
        $find_stat = BatchStatus::where([['batch_id', $batch->id], ['stat', $stat]])->first();
        if ($find_stat) {
            BatchStatus::where('id', $find_stat['id'])->update($stat_input);
            Batch::where('id', $find_stat['batch_id'])->update(array());
        } else {
            BatchStatus::create($stat_input);
        }

        return $batch->id;
    }

    public function approveOrReject($type, $batch, $input)
    {
        $data = ['batch_id' => $batch, 'submitted_by' => \Auth::User()->id];
        if ($type == 1) {
            $data['stat'] = $input['is_approved'] ? 4 : 3;
        } else {
            $data['stat'] = $input['is_approved'] ? 6 : 5;
        }
        $store = BatchStatus::create($data);

        if (!$input['is_approved']) {
            $reject_reason = ['batch_status_id' => $store->id, 'reject_reason' => $input['reason']];
            RejectHistory::create($reject_reason);
        }
    }
}