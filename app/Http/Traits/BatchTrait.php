<?php 

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Batch;
use App\Models\BatchStatus;

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
}