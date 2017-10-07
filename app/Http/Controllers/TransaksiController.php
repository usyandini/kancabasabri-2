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
use App\Models\BudgetControl;
use App\Models\StagingTransaksi;

use Validator;
use Carbon;
use Response;

use App\Services\FileUpload;
use App\Services\NotificationSystem;
use App\Http\Traits\BatchTrait;
use App\Http\Traits\BudgetControlTrait;

//  ----------- BATCH STAT / HISTORY DESC -------------
//          0 = Inserted 
//          1 = Updated
//          2 = Posted / Submitted to Kakancab
//          3 = Rejected for revision
//          4 = Verified by Kakancab (lvl 1) / Submitted to Akuntansi 
//          5 = Rejected for revision
//          6 = Verified by Akuntansi (lvl 2)
//  -----------------------------------------

class TransaksiController extends Controller
{
    use BatchTrait;
    use BudgetControlTrait;    

    protected $bankModel;
    protected $itemModel;
    protected $subPosModel;
    protected $kegiatanModel;
    protected $transaksiModel;

    protected $current_batch;
    protected $batch_nos;

    public function __construct(AkunBank $bank, Item $item, SubPos $subPos, Kegiatan $kegiatan, Transaksi $transaksi)
    {
        $this->bankModel = $bank;
        $this->itemModel = $item;
        $this->subPosModel = $subPos;
        $this->kegiatanModel = $kegiatan;
        $this->transaksiModel = $transaksi;
        $this->current_batch = $this->defineCurrentBatch();
        $this->batch_nos = $this->getBatchNos();

        $this->middleware('can:info_t', ['only' => 'index']);
        // $this->middleware('can:tambahBatch_t', ['only' => 'store']);
        $this->middleware('can:setuju_t', ['only' => 'persetujuan']);
        $this->middleware('can:setuju2_t', ['only' => 'verifikasi']);
        $this->middleware('can:cari_t', ['only' => 'filter_handle', 'filter_result']);
    }

    public function index($batch_id = null)
    {
        $jsGrid_url = 'transaksi';
        $berkas = $history = [];
        $no_batch = null;
        $empty_batch = $editable = true;
        
        $this->current_batch = ($batch_id == null) ? $this->current_batch : Batch::where('id', $batch_id)->first();
        if ($this->current_batch) {
            $editable = $this->current_batch->isUpdatable();
            $berkas = BerkasTransaksi::where('batch_id', $this->current_batch['id'])->get();
            $history = $this->getBatchHistory($this->current_batch['id']);
            $empty_batch = false;
            $jsGrid_url = 'transaksi/get/batch/'.$this->current_batch['id'];
        }

        return view('transaksi.input', [
            'batch_nos'     => $this->batch_nos,
            'filters'       => null,
            'active_batch'  => $this->current_batch,
            'editable'      => $editable,
            'empty_batch'   => $empty_batch,
            'berkas'        => $berkas,
            'batch_history' => $history,
            'jsGrid_url'    => $jsGrid_url]);
    }

    public function create()
    {
        return view('transaksi.new', [
            'cabang'    => \Auth::user()->kantorCabang()->DESCRIPTION,
            'divisi'    => \Auth::user()->cabang == '00' ? \Auth::user()->divisi()->DESCRIPTION : 'Non-Divisi',
            'no_batch'  => date('ymd').'-'.\Auth::user()->cabang.'/'.\Auth::user()->divisi.'-'.$this->defineCurentSequenceNo()]);
    }

    public function createProcess(Request $request)
    {
        $newBatch = $this->defineNewBatch();
        session()->flash('success_newBatch', true);
        return redirect('transaksi/'.$newBatch->id);
    }

    public function filter_handle(Request $request) 
    {
        return redirect('transaksi/filter/result/'.$request->batch);
    }

    public function filter_result($batch_id)
    {
        $empty_batch = null;
        $berkas = $history = [];
        $jsGrid_url = 'transaksi';
        $active_batch = Batch::where('id', $batch_id)->first();
        
        if ($active_batch) {
            $editable = $active_batch->isUpdatable();
            $berkas = BerkasTransaksi::where('batch_id', $active_batch['id'])->get();
            $history = $this->getBatchHistory($active_batch['id']);
            $jsGrid_url = 'transaksi/get/batch/'.$active_batch['id'];
        } else {
            $empty_batch = $editable = true;
        }

        return view('transaksi.input', [
            'batch_nos'     => $this->batch_nos,
            'filters'       => [$batch_id],
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
                'actual_anggaran' => $value->actual_anggaran,
                'total'         => $value->total,
                'is_anggaran_safe' => $value->is_anggaran_safe
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
                'actual_anggaran' => $value->actual_anggaran,
                'total'         => $value->total,
                'is_anggaran_safe' => $value->is_anggaran_safe
                ]);
        }
        return response()->json($result);
    }

    public function getAttributes($type)
    {
        $return = null;
        switch ($type) {
            case 'item':
                $header = ['MAINACCOUNTID' => '-1', 'NAME' => 'Silahkan Pilih'];
                $return = $this->itemModel->get(['MAINACCOUNTID', 'NAME'])->filter(function($item) {
                            return $item->kombinasiAvailable(\Auth::user()->cabang, \Auth::user()->divisi);
                        });
                $return->prepend($header);
                break;
            case 'bank':
                $return = $this->bankModel->get();
                break;       
            case 'subpos':
                $header = ['VALUE' => '-1', 'DESCRIPTION' => 'Auto Generate dari Account'];
                $return = $this->subPosModel->get(['VALUE', 'DESCRIPTION']);
                $return->prepend($header);
                break;
            case 'kegiatan':
                $header = ['VALUE' => '-1', 'DESCRIPTION' => 'Auto Generate dari Account'];
                $return = $this->kegiatanModel->get(['VALUE', 'DESCRIPTION']);
                $return->prepend($header);
                break;
        }
        return response()->json($return);
    }

    public function store(Request $request)
    {
        $batch_insert = $batch_update = $batch_delete = [];
        $batch_id = $calibrate = null;
        if (!isset($request->batch_id)) {
            $this->current_batch = $this->defineNewBatch();
            $batch_id = $this->current_batch['id'];
        } else {
            $batch_id = $request->batch_id;
            $this->updateBatchStat($batch_id, 1);
        }

        foreach (json_decode($request->batch_values) as $value) {
            $value->total = str_replace(',', '', $value->total);
            if (!isset($value->toBeDeleted)) {
                $calibrate = $this->calibrateAnggaran($value, true);
            }
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
                    'anggaran'      => isset($value->toBeDeleted) ? 0 : (int)$calibrate['anggaran'],
                    'actual_anggaran' => isset($value->toBeDeleted) ? 0 : (int)$calibrate['actual_anggaran'],
                    'total'         => (int)$value->total,
                    'created_by'    => \Auth::user()->id,
                    'batch_id'      => (int)$batch_id,
                    'is_anggaran_safe' => $calibrate['is_anggaran_safe'],
                    'created_at'    => \Carbon\Carbon::now(),
                    'updated_at'    => \Carbon\Carbon::now()];

            if (isset($value->isNew)) {
                unset($store_values['id']);
                array_push($batch_insert, $store_values);
            } elseif (isset($value->toBeDeleted)) {
                array_push($batch_delete, $value->id);
            } else {
                array_push($batch_update, $store_values);
            }
        }
        
        $accounts = \DB::select("SELECT 
                DATEPART(YEAR, tgl) as year, DATEPART(MONTH, tgl) as month, account FROM dbo.transaksi 
                    WHERE batch_id = ". $batch_id.
                " GROUP BY DATEPART(YEAR, tgl), DATEPART(MONTH, tgl), account");

        $this->doInsert($batch_insert);
        $this->doUpdate($batch_update);
        $this->doDelete($batch_delete);
        $this->storeBerkas($request->berkas, $batch_id);

        $batch_counter = array(
            count($batch_insert), // inserted items count
            count($batch_update), // updated items count
            count($batch_delete), // deleted items count
            $request->berkas[0] ? count($request->berkas) : 0 // berkas uploaded
        );

        $this->doRefreshAnggaran($batch_id);

        if (count($batch_delete) > 0 || count($batch_update) > 0) {
            $this->resetCalibrateBecauseDeleteOrUpdate($accounts);
        }

        session()->flash('success', $batch_counter);
        return redirect('transaksi/'.$batch_id);
    }

    public function isAllAnggaranSafe($batch_id)
    {
        return Transaksi::where([['batch_id', $batch_id], ['is_anggaran_safe', 0]])->first() ? false : true;
    }

    public function refreshAnggaran($batch_id)
    {
        $this->doRefreshAnggaran($batch_id);
        return redirect()->back();
    }

    public function doRefreshAnggaran($batch_id)
    {
        $accounts = \DB::select("SELECT 
                DATEPART(YEAR, tgl) as year, DATEPART(MONTH, tgl) as month, account FROM dbo.transaksi 
                    WHERE batch_id = ". $batch_id.
                " GROUP BY DATEPART(YEAR, tgl), DATEPART(MONTH, tgl), account");

        foreach ($accounts as $account) {
            if($this->calibrateSavePointAndActual($account)) {
                $transaksis = Transaksi::where('account', $account->account)->get();
                
                foreach ($transaksis as $transaksi) {
                    $calibrate = $this->calibrateAnggaran($transaksi, false);
                    if (count($calibrate) > 0) {
                        Transaksi::where('id', $transaksi->id)->update($calibrate);
                    }
                }
            }
        }
    }

    public function submit(Request $request, $batch_id)
    {
        $update = $this->updateBatchStat($batch_id, 2);

        NotificationSystem::send($batch_id, 1);
        $batch = Batch::where('id', $batch_id)->first();

        session()->flash('success_submit', $batch->batchNo());
        return redirect('transaksi/'.$batch_id);
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
                Transaksi::where('id', $value['id'])->delete();
                unset($value['id']);
                Transaksi::create($value);
            }
        }        
    }

    public function doDelete($batch_delete)
    {
        Transaksi::whereIn('id', $batch_delete)->delete();
    }

    public function storeBerkas($inputs, $current_batch)
    {
        if ($inputs[0] != null) {
            $fileUpload = new FileUpload();
            $store = $fileUpload->multipleBase64Upload($inputs);
            foreach ($store as $key => $value) {
                $value['batch_id'] = $current_batch;
                BerkasTransaksi::insert($value);
            }
        }
    }

    public function downloadBerkas($berkas_id)
    {
        $berkas = BerkasTransaksi::where('id', $berkas_id)->first();
        $decoded = base64_decode($berkas->file);
        $mime_type = explode('/', finfo_buffer(finfo_open(), $decoded, FILEINFO_MIME_TYPE)) ;
        $file = $berkas->file_name.'.'.$mime_type[1];
        file_put_contents($file, $decoded);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            // header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    public function removeBerkas(Request $request)
    {
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
            $history    = $this->getBatchHistory($valid_batch['id']);
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
            $history    = $this->getBatchHistory($valid_batch['id']);
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
        $this->doRefreshAnggaran($batch_id);
        if (!$this->isAllAnggaranSafe($batch_id) && $request->is_approved) {
            session()->flash('failed_safe', true);
            return redirect()->back();
        }

        $input = $request->only('is_approved', 'reason');
        $this->approveOrReject($type, $batch_id, $input);

        NotificationSystem::send($batch_id, $type == 1 ? ($request->is_approved ? 3 : 2) : ($request->is_approved ? 6 : 5));

        session()->flash('success', true);
        return redirect()->back();   
    }      

    public function insertStaging($batch_id)
    {
        $transaksi = Transaksi::where('batch_id', $batch_id)->get();

        foreach ($transaksi as $trans) {
            $input = [
                'PIL_ACCOUNT'   => $trans->item,
                'PIL_AMOUNT'    => $trans->total,
                'PIL_BANK'      => $trans->akun_bank,
                'PIL_DIVISI'    => $trans['batch']['divisi'],
                // 'PIL_JOURNALNUM',
                'PIL_KPKC'      => $trans['batch']['cabang'],
                'PIL_MATAANGGARAN'  => $trans->mata_anggaran,
                // 'PIL_PROGRAM',
                'PIL_SUBPOS'    => $trans->sub_pos,
                'PIL_TRANSDATE' => $trans->tgl,
                'PIL_TXT'       => $trans->desc,
                // 'PIL_VOUCHER',
                // 'DATAAREADID',
                // 'RECVERSION',
                // 'PARTITION',
                'RECID'         => $trans->id,
                // 'PIL_TRANSACTIONID'
            ];

            StagingTransaksi::create($input);
        }
    }
}
