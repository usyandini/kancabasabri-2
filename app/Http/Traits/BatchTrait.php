<?php 

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Batch;
use App\Models\BatchStatus;
use App\Models\RejectHistory;

//  ----------- BATCH STAT / HISTORY DESC -------------
//          0 = Inserted 
//          1 = Updated
//          2 = Posted / Submitted to Kakancab
//          3 = Rejected for revision
//          4 = Verified by Kakancab (lvl 1) / Submitted to Akuntansi 
//          5 = Rejected for revision
//          6 = Verified by Akuntansi (lvl 2)
//  -----------------------------------------

trait BatchTrait
{
	public function defineCurrentBatch()
    {
        $current_batch = Batch::orderBy('id','desc')
            ->where([['divisi', \Auth::user()->divisi], ['cabang', \Auth::user()->cabang]])
            ->first();  
        return $current_batch ? $current_batch : null;
    }

    public function defineNewBatch()
    {
    	$input = array(
            'created_by' => \Auth::User()->id, 
            'divisi' => \Auth::user()->divisi, 
            'cabang' => \Auth::user()->cabang, 
            'seq_number' => $this->defineCurentSequenceNo());
    	$create = Batch::create($input);
        $this->updateBatchStat($create->id, 0);
        return $create;
    }

    public function defineCurentSequenceNo()
    {
        $batch = Batch::orderBy('id','desc')
            ->where([['divisi', \Auth::user()->divisi], ['cabang', \Auth::user()->cabang]])
            ->whereYear('created_at', '=', date('Y'))
            ->first();   
        
        $result = $batch ? $batch['seq_number'] : 0;
        return sprintf('%04d', ++$result);
    }

    public function getBatchNos()
    {
        $result = Batch::orderBy('id','desc')
            ->where([['divisi', \Auth::user()->divisi], ['cabang', \Auth::user()->cabang]])
            ->get();
        return $result;
    }

    public function getBatchHistory($id)
    {
        return BatchStatus::select('stat', \DB::raw('count(*) as total'), \DB::raw('max(updated_at) as tgl'))
            ->where('batch_id', $id)
            ->groupBy('stat')
            ->orderBy('tgl', 'desc')
            ->get();
    }

	public function updateBatchStat($batch_id, $stat)
    {
        $stat_input = array('batch_id' => $batch_id, 'stat' => $stat, 'submitted_by' => \Auth::User()->id);
        $find_stat = BatchStatus::where([['batch_id', $batch_id], ['stat', $stat]])->first();
        if ($find_stat) {
            BatchStatus::where('id', $find_stat['id'])->update($stat_input);
            Batch::where('id', $find_stat['batch_id'])->update(array());
        } else {
            BatchStatus::create($stat_input);
        }

        return $batch_id;
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