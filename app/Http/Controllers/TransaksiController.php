<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\AkunBank;
use App\Models\Item;
use App\Models\RejectReason;
use App\Models\Kegiatan;
use App\Models\SubPos;
use App\Models\Transaksi;
use App\Models\Batch;
use App\Models\BatchStatus;
use App\Models\BerkasTransaksi;

use Validator;

use App\Services\FileUpload;
use App\Services\NotificationSystem;
use App\Http\Traits\BatchTrait;

//  ----------- BATCH STAT DESC -------------
//          0 = Inserted 
//          1 = Updated
//          2 = Posted / Submitted to Kasmin
//          3 = Rejected for revision
//          4 = Verified by Kasmin (lvl 1) / Submitted to Akuntansi 
//          5 = Rejected for revision
//          6 = Verified by Akuntansi (lvl 2)
//  -----------------------------------------

class TransaksiController extends Controller
{
    use BatchTrait;    

    protected $bankModel;
    protected $itemModel;
    protected $subPosModel;
    protected $kegiatanModel;
    protected $transaksiModel;

    protected $current_batch;
    protected $batches_dates;

    public function __construct(AkunBank $bank, Item $item, SubPos $subPos, Kegiatan $kegiatan, Transaksi $transaksi)
    {
        $this->bankModel = $bank;
        $this->itemModel = $item;
        $this->subPosModel = $subPos;
        $this->kegiatanModel = $kegiatan;
        $this->transaksiModel = $transaksi;
        $this->current_batch = $this->defineCurrentBatch();
        $this->batches_dates = Batch::get();
    }

    public function index()
    {
        $jsGrid_url = 'transaksi';
        $berkas = $history = [];
        $empty_batch = $editable = true;
        
        if ($this->current_batch) {
            $editable = $this->current_batch->isUpdatable();
            $berkas = BerkasTransaksi::where('batch_id', $this->current_batch['id'])->get();
            $history = BatchStatus::where('batch_id', $this->current_batch['id'])->orderBy('updated_at', 'desc')->get();
            $jsGrid_url = 'transaksi/get/batch/'.$this->current_batch['id'];
            $empty_batch = false;
        }

        return view('transaksi.input', [
            'batches_dates' => $this->batches_dates,
            'filters'       => null,
            'active_batch'  => $this->current_batch,
            'editable'      => $editable,
            'empty_batch'   => $empty_batch,
            'berkas'        => $berkas,
            'batch_history' => $history,
            'jsGrid_url'    => $jsGrid_url]);
    }

    public function filter_handle(Request $request) 
    {
        $request->batch_no = $request->batch_no ? $request->batch_no : '0';
        if ($request->batch_no && $request->date != '0') {
            session()->flash('failed_filter', 'Filter dengan <b>dua field</b> tidak diperbolehkan.');
            return redirect('transaksi');
        } elseif (!$request->batch_no && $request->date == '0') {
            session()->flash('failed_filter', '<b>Silahkan input</b> salah satu field untuk melakukan filter.');
            return redirect('transaksi');
        } 
        session()->flash('success_filtering', true);
        return redirect('transaksi/filter/result/'.$request->date.'/'.$request->batch_no);
    }

    public function filter_result($batch_id, $batch_no)
    {
        $empty_batch = null;
        $berkas = $history = [];
        $jsGrid_url = 'transaksi';
        $active_batch = Batch::where('id', $batch_id)->first();
        
        if ($active_batch) {
            $editable = $active_batch->isUpdatable();
            $berkas = BerkasTransaksi::where('batch_id', $active_batch['id'])->get();
            $history = BatchStatus::where('batch_id', $active_batch['id'])->get();
            $jsGrid_url = 'transaksi/get/batch/'.$active_batch['id'];
        } else {
            $empty_batch = $editable = true;
        }

        return view('transaksi.input', [
            'batches_dates' => $this->batches_dates,
            'filters'       => [$batch_id, $batch_no],
            'active_batch'  => $active_batch,
            'editable'      => $editable,
            'empty_batch'   => $empty_batch,
            'berkas'        => $berkas,
            'batch_history' => $history,
            'jsGrid_url'    => $jsGrid_url]);   
    }

    public function getAll()
    {
        $transaksi = $this->transaksiModel->get();
        
        $result = array();
        foreach ($transaksi as $value) {
            array_push($result, [
                'id'            => $value->id,
                'tgl'           => $value->tgl,
                'item'          => $value->item,
                'qty_item'      => $value->qty_item,
                'desc'          => $value->desc,
                'sub_pos'       => $value->sub_pos,
                'mata_anggaran' => $value->mata_anggaran,
                'bank'          => $value->akun_bank,
                'account'       => $value->account,
                'anggaran'      => $value->anggaran,
                'total'         => $value->total
                ]);
        }
        return response()->json($result);
    }

    public function getByBatch($batch_id)
    {
        $transaksi = $this->transaksiModel->where('batch_id', $batch_id)->get();
        
        $result = array();
        foreach ($transaksi as $value) {
            array_push($result, [
                'id'            => $value->id,
                'tgl'           => $value->tgl,
                'item'          => $value->item,
                'qty_item'      => $value->qty_item,
                'desc'          => $value->desc,
                'sub_pos'       => $value->sub_pos,
                'mata_anggaran' => $value->mata_anggaran,
                'bank'          => $value->akun_bank,
                'account'       => $value->account,
                'anggaran'      => $value->anggaran,
                'total'         => $value->total
                ]);
        }
        return response()->json($result);
    }

    public function getAttributes($type)
    {
        $return = null;
        switch ($type) {
            case 'item':
                $return = $this->itemModel->get();
                break;
            case 'bank':
                $return = $this->bankModel->get();
                break;       
            case 'subpos':
                $return = $this->subPosModel->get();
                break;
            case 'kegiatan':
                $return = $this->kegiatanModel->get();
                break;
        }
        return response()->json($return);
    }

    public function store(Request $request)
    {
        $batch_insert = $batch_update = [];
        if (!$this->current_batch) {
            $this->current_batch = $this->defineNewBatch();
            $this->updateBatchStat($this->current_batch, 0);
        } else {
            $this->updateBatchStat($this->current_batch, 1);
        }

        foreach (json_decode($request->batch_values) as $value) {
            $store_values = [
                    'id'            => $value->id,
                    'tgl'           => date("Y-m-d",strtotime($value->tgl)),
                    'item'          => $value->item,
                    'qty_item'      => (int)$value->qty_item,
                    'desc'          => $value->desc,
                    'sub_pos'       => $value->sub_pos,
                    'mata_anggaran' => $value->mata_anggaran,
                    'akun_bank'     => $value->bank,
                    'account'       => $value->account,
                    'anggaran'      => (int)$value->anggaran,
                    'total'         => (int)$value->total,
                    'created_by'    => \Auth::user()->id,
                    'batch_id'      => (int)$this->current_batch['id'],
                    'created_at'    => \Carbon\Carbon::now(),
                    'updated_at'    => \Carbon\Carbon::now()];

            if (isset($value->isNew)) {
                unset($store_values['id']);
                array_push($batch_insert, $store_values);
            } else {
                array_push($batch_update, $store_values);
            }
        }

        $this->doInsert($batch_insert);
        $this->doUpdate($batch_update);
        $this->storeBerkas($request->berkas, $this->current_batch['id']);
        
        $batch_counter = array(count($batch_insert), count($batch_update), $request->berkas[0] ? count($request->berkas) : 0);

        session()->flash('success', $batch_counter);
        return redirect('transaksi');
    }

    public function submit(Request $request)
    {
        $update = $this->updateBatchStat($this->current_batch, 2);

        NotificationSystem::send($this->current_batch['id'], 1);

        session()->flash('success_submit', $this->current_batch['created_at']);
        return redirect('transaksi');
    }

    public function doInsert($batch_insert)
    {
        if (count($batch_insert) > 0) {
            Transaksi::insert($batch_insert);
        }
    }

    public function doUpdate($batch_update)
    {
        if (count($batch_update) > 0) {
            foreach ($batch_update as $value) {
                $id = $value['id'];
                unset($value['id']);
                unset($value['created_at']);
                Transaksi::where('id', $id)->update($value);
            }
        }
    }

    public function storeBerkas($inputs, $current_batch)
    {
        if ($inputs[0] != null) {
            // phpinfo();
            $file = $inputs[0];
            // dd($file);            
            $contents = base64_encode(file_get_contents($inputs[0]));
            // dd($contents);
            // $contents = base64_encode(file_get_contents($file->getRealPath()));
            $store = ['file_name' => 'tes', 'file' => $contents,'batch_id' => $current_batch, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()];

            // dd($inputs[0]);
            // $fileUpload = new FileUpload();
            // $newNames = $fileUpload->multipleUpload($inputs, 'transaksi');

            // $store = array();
            // foreach (explode('||', $newNames) as $value) {
            //     array_push($store, ['file_name' => $value, 'batch_id' => $current_batch, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
            // }

            BerkasTransaksi::insert($store);

        }
    }

    public function downloadBerkas($berkas_id)
    {
        $berkas = BerkasTransaksi::where('id', $berkas_id)->first();
        $decoded = base64_decode($berkas->file);
        $file = 'test.pdf';
        file_put_contents($file, $decoded);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    public function removeBerkas(Request $request)
    {
        $file_path = public_path('file/transaksi/'.$request->file_name);
        if (\File::exists($file_path)) {
            unlink($file_path);
        }

        BerkasTransaksi::where('id', $request->file_id)->delete();

        session()->flash('success_deletion', $request->file_name);
        return redirect()->back();
    }

    // lvl 1
    public function persetujuan($batch)
    {
        $berkas      = $history = [];
        $jsGrid_url  = 'transaksi';
        $empty_batch = $editable = false;
        $valid_batch = Batch::where('id', $batch)->first();

        if ($valid_batch) {
            $verifiable = $valid_batch->lvl1Verifiable();
            $berkas     = BerkasTransaksi::where('batch_id', $valid_batch['id'])->get();
            $history    = BatchStatus::where('batch_id', $valid_batch['id'])->orderBy('updated_at', 'desc')->get();
            $jsGrid_url = 'transaksi/get/batch/'.$valid_batch['id'];
        } 

        return view('transaksi.persetujuan', [
            'editable'      => false,
            'verifiable'    => $verifiable,
            'active_batch'  => $valid_batch,
            'empty_batch'   => $empty_batch,
            'berkas'        => $berkas,
            'batch_history' => $history,
            'jsGrid_url'    => $jsGrid_url,
            'reject_reasons'    => RejectReason::where('type', 1)->get()]);
    }   

    // lvl 2
    public function verifikasi($batch)
    {
        $berkas         = $history = [];
        $jsGrid_url     = 'transaksi';
        $empty_batch    = $editable = false;
        $valid_batch    = Batch::where('id', $batch)->first();

        if ($valid_batch) {
            $verifiable = $valid_batch->lvl2Verifiable();
            $berkas     = BerkasTransaksi::where('batch_id', $valid_batch['id'])->get();
            $history    = BatchStatus::where('batch_id', $valid_batch['id'])->orderBy('updated_at', 'desc')->get();
            $jsGrid_url = 'transaksi/get/batch/'.$valid_batch['id'];
        } 

        return view('transaksi.verifikasi', [ 
            'editable'      => false,
            'verifiable'    => $verifiable,
            'active_batch'  => $valid_batch,
            'empty_batch'   => $empty_batch,
            'berkas'        => $berkas,
            'batch_history' => $history,
            'jsGrid_url'    => $jsGrid_url,
            'reject_reasons'    => RejectReason::where('type', 2)->get()]);
    }

    public function submitVerification($type, $batch_id, Request $request)
    {
        $input = $request->only('is_approved', 'reason');
        $this->approveOrReject($type, $batch_id, $input);

        NotificationSystem::send($this->current_batch['id'], $type == 1 ? ($request->is_approved ? 3 : 2) : ($request->is_approved ? 6 : 5));

        session()->flash('success', true);
        return redirect()->back();   
    }      
}
