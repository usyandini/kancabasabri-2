<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Notification;
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
use App\Models\StagingTransaksiReverse;
use App\Models\KantorCabang;
use App\Models\ItemMaster;

use Validator;
use Carbon;
use Response;
use PDF;
use DB;

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

    protected $months = array(
        '1'     => 'Januari',
        '2'     => 'Februari',
        '3'     => 'Maret',
        '4'     => 'April',
        '5'     => 'Mei',
        '6'     => 'Juni',
        '7'     => 'Juli',
        '8'     => 'Agustus',
        '9'     => 'September',
        '10'    => 'Oktober',
        '11'    => 'November',
        '12'    => 'Desember');

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
        
        if ($batch_id != null) {
            $getByBatch = Batch::where('id', $batch_id)->get()->filter(function($batch) { 
                return $batch->isAccessibleByUnitKerja();
            });
            
            $getByBatch = isset($getByBatch[0]) ? $getByBatch[0] : null;
            if ($getByBatch == null) {
                // session()->flash('batch_notvalid', true);
                return redirect('transaksi');
            }
        }

        $this->current_batch = ($batch_id == null) ? $this->current_batch : $getByBatch;
        if ($this->current_batch) {
            $editable = $this->current_batch->isUpdatable();
            $berkas = BerkasTransaksi::where('batch_id', $this->current_batch['id'])->get();
            $history = $this->getBatchHistory($this->current_batch['id']);
            $empty_batch = false;
            $jsGrid_url = 'transaksi/get/batch/'.$this->current_batch['id'];
        }
        // $this->getAttributes('item', $this->current_batch);
        return view('transaksi.input', [
            'batch_nos'     => $this->batch_nos,
            'filters'       => null,
            'active_batch'  => $this->current_batch,
            'editable'      => $editable,
            'empty_batch'   => $empty_batch,
            'berkas'        => $berkas,
            'batch_history' => $history,
            'item'          => $this->getAttributes('item', $this->current_batch),
            'bank'          => $this->getAttributes('bank'),
            'kegiatan'      => $this->getAttributes('kegiatan'),
            'subpos'        => $this->getAttributes('subpos'),
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
            'item'          => $this->getAttributes('item', $active_batch),
            'bank'          => $this->getAttributes('bank'),
            'kegiatan'      => $this->getAttributes('kegiatan'),
            'subpos'        => $this->getAttributes('subpos'),
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
                'item'          => $this->getItemValue($value),
                'qty_item'      => $value->qty_item,
                'desc'          => $value->desc,
                'sub_pos'       => $value->sub_pos,
                'mata_anggaran' => $value->mata_anggaran,
                'bank'          => $value->akun_bank,
                'account'       => $value->account,
                'anggaran'      => (int)$value->anggaran,
                'actual_anggaran' => (int)$value->actual_anggaran,
                'total'         => (int)$value->total,
                'is_anggaran_safe' => $value->is_anggaran_safe,
                'is_rejected'   => $value->currently_rejected
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
                'item'          => $this->getItemValue($value),
                'qty_item'      => $value->qty_item,
                'desc'          => $value->desc,
                'sub_pos'       => $value->sub_pos,
                'mata_anggaran' => $value->mata_anggaran,
                'bank'          => $value->akun_bank,
                'account'       => $value->account,
                'anggaran'      => (int)$value->anggaran,
                'actual_anggaran' => (int)$value->actual_anggaran,
                'total'         => (int)$value->total,
                'is_anggaran_safe' => $value->is_anggaran_safe,
                'is_rejected'   => $value->currently_rejected
            ]);
        }
        return response()->json($result);
    }

    public function getItemValue($transaksi)
    {
        $splitted_account = explode("-", $transaksi->account);
        $SEGMEN_3 = $splitted_account[2];
        $SEGMEN_4 = $splitted_account[3];
        $SEGMEN_5 = $splitted_account[4];
        $SEGMEN_6 = $splitted_account[5];

        return (String) ItemMaster::where([['SEGMEN_1', $transaksi->item], ['SEGMEN_3', $SEGMEN_3], ['SEGMEN_4', $SEGMEN_4], ['SEGMEN_5', $SEGMEN_5], ['SEGMEN_6', $SEGMEN_6]])->first()['id'];
    }

    public function getAttributes($type, $batch = null)
    {
        $return = null;
        switch ($type) {
            case 'item':
                // $cabang = \Auth::user()->cabang;
                $header = ['VALUE' => '-1', 'nama_item' => 'Silahkan Pilih Barang/Jasa'];
                $return = ItemMaster::orderBy('nama_item','ASC')->get(['id', 'SEGMEN_1', 'nama_item', 'SEGMEN_3', 'is_displayed'])->filter(function($item) use($batch) {
                    return $item->isDisplayed($batch['cabang']);
                    //return $item->isDisplayed($cabang);
                });
                
                foreach ($return as $key => $value) {
                    $value->VALUE = (String) $return[$key]->id;
                }
                $return->prepend($header);
                break;
            case 'bank':
                $header = ['BANK' => '-1', 'BANK_NAME' => 'Silahkan Pilih Bank', 'accessible' => true];
                // $KAS = ['BANK' => 'KAS-KC', 'BANK_NAME' => 'KAS KC/KCP', 'accessible' => true];
                // $return = $this->bankModel->where('BANK_NAME', 'not like', '%kas%')->get(['BANK','BANK_NAME','ID_CABANG']);
                $return = $this->bankModel->get(['BANK','BANK_NAME','ID_CABANG']);
                foreach ($return as $key => $value) {
                    $value->accessible = $value->isAccessibleByCabang();
                    //unset jika tidak memiliki perizinan unit kerja
                    $val = $value->isAccessibleByCabang();
                    if(!$val){
                        unset($return[$key]);
                    }
                }
                // $return->prepend($KAS);
                $return->prepend($header);
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
        return $return;
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
            $value->anggaran = str_replace('.', '', $value->anggaran);
            $value->actual_anggaran = str_replace('.', '', $value->actual_anggaran);
            $value->total = str_replace('.', '', $value->total);
            $value->item = ItemMaster::where('id', $value->item)->first()['SEGMEN_1'];

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
                'currently_rejected' => 0,
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
        // dd($batch_update);
        
        $accounts = $this->getAccountsPerBatch($batch_id);

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

    public function getAccountsPerBatch($batch_id)
    {
        return \DB::select("SELECT 
            DATEPART(YEAR, tgl) as year, DATEPART(MONTH, tgl) as month, account FROM dbo.transaksi 
            WHERE batch_id = ". $batch_id.
            " GROUP BY DATEPART(YEAR, tgl), DATEPART(MONTH, tgl), account");        
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
        $accounts = $this->getAccountsPerBatch($batch_id);

        foreach ($accounts as $account) {
            if($this->calibrateSavePointAndActual($account)) {
                $transaksis = Transaksi::where('account', $account->account)
                            ->get()->filter(function($transaksi) {
                                return !$transaksi->batch->isPosted();
                            });
                
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
        // $file = $berkas->file_name.'.'.$mime_type[1];
        $file = $berkas->file_name;
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
            unlink($file);
            exit($data);
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
            'item'          => $this->getAttributes('item', $valid_batch),
            'bank'          => $this->getAttributes('bank'),
            'kegiatan'      => $this->getAttributes('kegiatan'),
            'subpos'        => $this->getAttributes('subpos'),
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
            $reverse    = $valid_batch->reverse();
            $berkas     = BerkasTransaksi::where('batch_id', $valid_batch['id'])->get();
            $history    = $this->getBatchHistory($valid_batch['id']);
            $jsGrid_url = 'transaksi/get/batch/'.$valid_batch['id'];
        } 

        return view('transaksi.verifikasi', [ 
            'editable'      => false,
            'reverse'       => $reverse,
            'verifiable'    => $verifiable,
            'active_batch'  => $valid_batch,
            'empty_batch'   => $empty_batch,
            'berkas'        => $berkas,
            'batch_history' => $history,
            'item'          => $this->getAttributes('item',  $valid_batch),
            'bank'          => $this->getAttributes('bank'),
            'kegiatan'      => $this->getAttributes('kegiatan'),
            'subpos'        => $this->getAttributes('subpos'),
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

        if (!$request->is_approved) {
            $accounts = $this->getAccountsPerBatch($batch_id);
            $this->resetCalibrateBecauseDeleteOrUpdate($accounts, true);            
        }

        NotificationSystem::send($batch_id, $type == 1 ? ($request->is_approved ? 3 : 2) : ($request->is_approved ? 6 : 5));

        if ($type == 2 && $request->is_approved) { $this->insertStaging($batch_id); }

        session()->flash('success', true);
        return redirect()->back();   
    }

    public function submitReverse($type, $batch_id, Request $request)
    {
        $lists=StagingTransaksi::where('PIL_KCJOURNALNUM',$batch_id)->get();
        foreach ($lists as $list) {
            // $rec=date('dmYHis');
            $rec=StagingTransaksiReverse::orderBy('RECID','DESC')->first();
            if ($rec){
                $idreverse=$rec->RECID+1;
            }
            else {
                $idreverse=1;
            }
            $input = [
                'PIL_ACCOUNT'           => $list->PIL_ACCOUNT,
                'PIL_AMOUNT'            => $list->PIL_AMOUNT,
                'PIL_BANK'              => $list->PIL_BANK,
                'PIL_DIVISI'            => $list->PIL_DIVISI,
                'PIL_GENERATED'         => 0,
                'PIL_JOURNALNUMREVERSE' => $list->PIL_JOURNALNUM,
                'PIL_KPKC'              => $list->PIL_KPKC,
                'PIL_MATAANGGARAN'      => $list->PIL_MATAANGGARAN,
                'PIL_POSTED'            => $list->PIL_POSTED,
                'PIL_PROGRAM'           => $list->PIL_PROGRAM,
                'PIL_SUBPOS'            => $list->PIL_SUBPOS,
                'PIL_TRANSDATE'         => $list->PIL_TRANSDATE,
                'PIL_TXT'               => $list->PIL_TXT.'(REVERSE)',
                'PIL_VOUCHER'           => $list->PIL_VOUCHER,
                'PIL_KCJOURNALNUM'      => $list->PIL_KCJOURNALNUM,
                'DATAAREAID'            => $list->DATAAREAID,
                'RECVERSION'            => $list->RECVERSION,
                'PARTITION'             => $list->PARTITION,
                'PIL_TRANSACTIONID'     => $list->RECID,
                'RECID'                 => $idreverse
            ];
                
            StagingTransaksiReverse::create($input);
        }
        StagingTransaksi::where('PIL_KCJOURNALNUM',$batch_id)->delete();
        $this->doRefreshAnggaran($batch_id);
        if (!$this->isAllAnggaranSafe($batch_id) && $request->is_approved) {
            session()->flash('failed_safe', true);
            return redirect()->back();
        }

        $input = $request->only('is_approved', 'reason');
        $this->approveOrReject($type, $batch_id, $input);

        if (!$request->is_approved) {
            $accounts = $this->getAccountsPerBatch($batch_id);
            $this->resetCalibrateBecauseDeleteOrUpdate($accounts, true);            
        }

        NotificationSystem::send($batch_id, $type == 1 ? ($request->is_approved ? 3 : 2) : ($request->is_approved ? 6 : 5));
        // BatchStatus::where('batch_id',$batch_id)->where('stat',6)->delete();
        if ($type == 2 && $request->is_approved) { $this->insertStaging($batch_id); }

        session()->flash('success', true);
        return redirect()->back();   
    }      

    public function insertStaging($batch_id)
    {   

        $transaksi = Transaksi::where('batch_id', $batch_id)->get();
        foreach ($transaksi as $trans) {
            $splitted_account = explode("-", $trans->account);
            $input = [
                'DATAAREAID'   => 'asbr',
                'PIL_ACCOUNT'   => $trans->item,
                'PIL_AMOUNT'    => $trans->total,
                'PIL_BANK'      => $trans->akun_bank,
                'PIL_DIVISI'    => $splitted_account[3],
                'PIL_KPKC'      => $splitted_account[2],
                'PIL_MATAANGGARAN'  => $trans->mata_anggaran,
                'PIL_KCJOURNALNUM'  => $batch_id,
                'PIL_PROGRAM'   => 'THT',
                'PIL_SUBPOS'    => $trans->sub_pos,
                'PIL_TRANSDATE' => new Carbon(str_replace(':AM', ' AM', $trans->tgl)),
                'PIL_TXT'       => $trans->desc,
                'PIL_TRANSACTIONID' => '',
                'RECID' => $trans->id];
                
            StagingTransaksi::create($input);
            Notification::where('type',4)->where('batch_id',$batch_id)->delete();
        }
    }

    // Report ralisasi anggaran
    public function realisasi()
    {
        $cabang = KantorCabang::where('VALUE','<>','00')->get();

        return view('transaksi.realisasi', [
            'cabang'    => $cabang,
            'months'    => $this->months,
            'filters'   => null]);
    }

    // Report ralisasi transaksi
    public function realisasi_transaksi()
    {
        $cabang = KantorCabang::where('VALUE','<>','00')->get();

        return view('transaksi.realisasi_transaksi', [
            'cabang'    => $cabang,
            'months'    => $this->months,
            'filters'   => null]);
    }

    public function cetakRealisasi($cabang, $awal, $akhir, $transyear, $type)
    {           
        $transaksi = $this->reportQuery($cabang, $awal, $akhir, $transyear);
        $start = $this->months[$awal];
        $end = $this->months[$akhir];
        $excel = $type == 'excel' ? true : false;

        $data = [
            'cabangs'   => KantorCabang::get(),
            'filters'   => array('cabang' => $cabang, 'start' => $start, 'end' => $end,  'year' => $transyear),
            'transaksi' => $transaksi,
            'excel'     => $excel,
            'awal'       => $awal,
            'akhir'      => $akhir,
            'transyear'  => $transyear];

        switch($type){
            case 'print' :
                return view('transaksi.cetak-realisasi', $data);
                break;
            case 'export' :
                $pdf = PDF::loadView('transaksi.export-realisasi', $data);
                return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('Realisasi Anggaran-'.date("dmY").'.pdf');
                // return $pdf->stream('Realisasi Anggaran-'.date("dmY").'.pdf'); // hanya untuk view pdf
                break;
            case 'excel' :
                return view('transaksi.export-realisasi', $data);
                break;
        }
      }
      
      public function cetakRealisasi_transaksi($cabang, $awal, $akhir, $transyear, $type)
    {           
        $transaksi = $this->reportQuery_transaksi($cabang, $awal, $akhir, $transyear);
        $start = $this->months[$awal];
        $end = $this->months[$akhir];
        $excel = $type == 'excel' ? true : false;
        $sebelum="";
        $data_count= [];
        foreach ($transaksi as $trans) {
            if($trans->account != $sebelum){
                $sebelum = $trans->account;
                $data_count[$trans->account] = 1;
            }else{
                $data_count[$trans->account]++;
            }
        }

        $data = [
            'cabangs'   => KantorCabang::get(),
            'filters'   => array('cabang' => $cabang, 'start' => $start, 'end' => $end,  'year' => $transyear),
            'transaksi'  => $transaksi,
            'data_count' => $data_count,
            'excel'      => $excel,
            'awal'       => $awal,
            'akhir'      => $akhir,
            'transyear'  => $transyear];

        switch($type){
            case 'print' :
                return view('transaksi.cetak-realisasi_transaksi', $data);
                break;
            case 'export' :
                $pdf = PDF::loadView('transaksi.export-realisasi_transaksi', $data);
                return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('Realisasi Transaksi-'.date("dmY").'.pdf');
                // return $pdf->stream('Realisasi Anggaran-'.date("dmY").'.pdf'); // hanya untuk view pdf
                break;
            case 'excel' :
                return view('transaksi.export-realisasi_transaksi', $data);
                break;
        }
      }

      public function filter_handle_realisasi(Request $request)
      {
        $validatorRR = Validator::make($request->all(),
            [
                'cabang'    => 'required',
                'awal'      => 'required',
                'akhir'     => 'required',
                'transyear' => 'required'
            ], 
            [
                'cabang.required'  => 'Kantor cabang harus dipilih.',
                'awal.required'  => 'Periode awal harus dipilih.',
                'akhir.required'  => 'Periode akhir harus dipilih.',
                'transyear.required'  => 'Tahun periode harus dipilih.'
            ]);

        if($validatorRR->passes()){
            return redirect('transaksi/filter/realisasi/'.$request->cabang.'/'.$request->awal.'/'.$request->akhir.'/'.$request->transyear);    
        }else{
            return redirect()->back()->withErrors($validatorRR)->withInput();
        }
    }

    public function filter_handle_realisasi_transaksi(Request $request)
      {
        $validatorRR = Validator::make($request->all(),
            [
                'cabang'    => 'required',
                'awal'      => 'required',
                'akhir'     => 'required',
                'transyear' => 'required'
            ], 
            [
                'cabang.required'  => 'Kantor cabang harus dipilih.',
                'awal.required'  => 'Periode awal harus dipilih.',
                'akhir.required'  => 'Periode akhir harus dipilih.',
                'transyear.required'  => 'Tahun periode harus dipilih.'
            ]);

        if($validatorRR->passes()){
            return redirect('transaksi/filter/realisasi_transaksi/'.$request->cabang.'/'.$request->awal.'/'.$request->akhir.'/'.$request->transyear);    
        }else{
            return redirect()->back()->withErrors($validatorRR)->withInput();
        }
    }

    public function reportQuery($cabang, $awal, $akhir, $transyear)
    {
        // return \DB::select("SELECT 
        //             T2.ITEM AS ITEM,
        //             MT.nama_item AS DESCRIPTION,
        //             SUM(T2.ANGGARAN_AWAL) AS ANGGARAN_AWAL,
        //             SUM(T2.REALISASI_ANGGARAN) AS REALISASI_ANGGARAN,
        //             SUM(T2.SISA_ANGGARAN) AS SISA_ANGGARAN 
        //                 FROM (SELECT 
        //             DATEPART(MONTH, T.tgl) AS MONTH, 
        //             DATEPART(YEAR, T.tgl) AS YEAR, 
        //             T.item AS ITEM, 
        //             KC.PIL_KPKC AS CABANG,
        //             KC.PIL_DIVISI AS DIVISI,
        //             KC.PIL_SUBPOS AS SUBPOS,
        //             KC.PIL_MATAANGGARAN AS MATAANGGARAN, 
        //             MAX(T.anggaran) AS ANGGARAN_AWAL,
        //             SUM(T.total) AS REALISASI_ANGGARAN,
        //             MIN(T.actual_anggaran) AS SISA_ANGGARAN 
        //         FROM dbcabang.dbo.transaksi T
        //             LEFT JOIN dbcabang.dbo.batches B ON T.batch_id = B.id 
        //             RIGHT JOIN AX_DUMMY.dbo.PIL_KCTRANSAKSI KC ON T.id = KC.RECID
        //         WHERE
        //             KC.PIL_POSTED = 1 AND 
        //             B.cabang = ".$cabang." AND
        //             DATEPART(MONTH, T.tgl) >= ".$awal." AND 
        //             DATEPART(MONTH, T.tgl) <= ".$akhir." AND 
        //             DATEPART(YEAR, T.tgl) = ".$transyear."
        //         GROUP BY DATEPART(MONTH, T.tgl), DATEPART(YEAR, T.tgl), T.item, KC.PIL_KPKC, KC.PIL_DIVISI, KC.PIL_SUBPOS, KC.PIL_MATAANGGARAN) T2
        //         LEFT JOIN dbcabang.dbo.item_master_transaksi MT ON 
        //                 T2.ITEM = MT.SEGMEN_1 AND 
        //                 T2.SUBPOS = MT.SEGMEN_5 AND 
        //                 T2.MATAANGGARAN = MT.SEGMEN_6
        //         GROUP BY T2.ITEM, T2.CABANG, T2.DIVISI, T2.SUBPOS, T2.MATAANGGARAN, MT.nama_item");

        //             T2.CABANG = MT.SEGMEN_3 AND 
        //             T2.DIVISI = MT.SEGMEN_4 AND 
        return \DB::select("SELECT 
          mata_anggaran, min(tgl) as tanggal, max(anggaran) as anggaran, sum(total) as realisasi, min(actual_anggaran) as sisa_anggaran
          FROM [DBCabang].[dbo].[transaksi] as a join [DBCabang].[dbo].[batches] as c on a.batch_id=c.id
          join [AX_DUMMY].[dbo].[PIL_KCTRANSAKSI] as b on a.id=b.RECID
          where 
          cabang = ".$cabang." AND
                    DATEPART(MONTH, tgl) >= ".$awal." AND 
                    DATEPART(MONTH, tgl) <= ".$akhir." AND 
                    DATEPART(YEAR, tgl) = ".$transyear."
          and pil_posted=1 group by mata_anggaran order by mata_anggaran");
    }

    public function reportQuery_transaksi($cabang, $awal, $akhir, $transyear)
    {
        return \DB::select("SELECT 
                  a.id as id, mata_anggaran, account, tgl, [desc], anggaran, total as realisasi, actual_anggaran as sisa_anggaran
                  FROM [DBCabang].[dbo].[transaksi] as a join [DBCabang].[dbo].[batches] as c on a.batch_id=c.id
                  
                  where
                    cabang = ".$cabang." AND
                    DATEPART(MONTH, tgl) >= ".$awal." AND 
                    DATEPART(MONTH, tgl) <= ".$akhir." AND 
                    DATEPART(YEAR, tgl) = ".$transyear."
                    and currently_rejected=0 order by account, a.id");

    }

    public function reportQuery_kasbank($cabang, $awal, $akhir, $transyear)
    {
        return \DB::select("SELECT
    ledgerjournaltable.JOURNALNAME as JournalName,
    ledgerjournaltrans.PIL_BK as Nomor_BK,
    ledgerjournaltrans.JournalNum as PIL_JournalNum,
    dimensionAttributeValueSetItem.DISPLAYVALUE as displayvalue,
    ledgerjournaltrans.VOUCHER as voucher,
    bankaccaounttable.ACCOUNTID as bankid,
    ledgerjournaltrans.TRANSDATE as tanggal,
    ledgerjournaltrans.AMOUNTCURDEBIT as debit,
    ledgerjournaltrans.AMOUNTCURCREDIT as credit,
    ledgerjournaltrans.TXT as Description
    

    FROM [AX_DUMMY].[dbo].[LEDGERJOURNALTABLE] AS ledgerjournaltable
    
    join [AX_DUMMY].[dbo].[LedgerJournalTrans] as ledgerjournaltrans
    on ledgerjournaltrans.JournalNum = ledgerjournaltable.JournalNum

    join [AX_DUMMY].[dbo].[DIMENSIONATTRIBUTEVALUECOMBINATION] as dimensionAttributeValueCombination
    on dimensionAttributeValueCombination.RECID = ledgerjournaltrans.LEDGERDIMENSION

    join [AX_DUMMY].[dbo].[BANKACCOUNTTABLE] as bankaccaounttable
    on bankaccaounttable.ACCOUNTID = dimensionAttributeValueCombination.DISPLAYVALUE
     
    join [AX_DUMMY].[dbo].[DimensionAttributeValueSet] as dimensionAttributeValueSet
    on dimensionAttributeValueSet.RecId = bankaccaounttable.DEFAULTDIMENSION 
    
    join [AX_DUMMY].[dbo].[DimensionAttributeValueSetItem] as dimensionAttributeValueSetItem
    on dimensionAttributeValueSetItem.DimensionAttributeValueSet = dimensionAttributeValueSet.RecId

    join [AX_DUMMY].[dbo].[DimensionAttributeValue] as dimensionAttributeValue
    on dimensionAttributeValue.RecId = dimensionAttributeValueSetItem.DimensionAttributeValue

    join [AX_DUMMY].[dbo].[DimensionAttribute] as DimensionAttribute
    on DimensionAttribute.RecId = dimensionAttributeValue.DimensionAttribute
    and DimensionAttribute.Name = 'KPKC'

  WHERE dimensionAttributeValueSetItem.DISPLAYVALUE = '".$cabang."'
  and DATEPART(MONTH, ledgerjournaltrans.TRANSDATE) >= ".$awal." 
  and DATEPART(MONTH, ledgerjournaltrans.TRANSDATE) <= ".$akhir."
  and DATEPART(YEAR, ledgerjournaltrans.TRANSDATE) = ".$transyear."
  and ledgerjournaltable.POSTED=1
  order by ledgerjournaltrans.TRANSDATE asc");
//         return \DB::select("SELECT distinct
    
//     _ledgerjournaltable.JournalNum as PIL_JournalNum,
//     _ledgerjournaltable.RECID as PIL_RECID,
//     _ledgerjournaltrans.PIL_BK as PIL_BK,
//     _ledgerjournaltrans.TXT as PIL_Description,
//     _generaljournalentry.AccountingDate as PIL_TransDate,
//     _ledgerjournaltrans.LEDGERDIMENSION as PIL_LEDGERDIMENSION,
//     bankaccaounttable.ACCOUNTID as PIL_ACCOUNTID,
//     bankaccaounttable.NAME as PIL_NAME,
//     pil_kc_transaksi.RECID as REC_TRANS,
//     _ledgerjournaltrans.AmountCurCredit as PIL_AmountCurCredit,
//     _ledgerjournaltrans.AmountCurDebit as PIL_AmountCurDebit,
//     (select SUM(AmountCur)+SUM(AmountCorrect) as SALDO FROM [AX_DUMMY].[dbo].[BANKACCOUNTTRANS]
//     where CREATEDDATETIME <= (select ba.CREATEDDATETIME from [AX_DUMMY].[dbo].[BANKACCOUNTTRANS] ba 
//     where ba.VOUCHER = _ledgerjournaltrans.Voucher AND ba.ACCOUNTID = bankaccaounttable.ACCOUNTID)
//     AND ACCOUNTID = bankaccaounttable.ACCOUNTID
//     GROUP BY ACCOUNTID) as SALDO,
//     _ledgerjournaltrans.PIL_BK as PIL_BK,
//     _ledgerjournaltrans.Invoice as PIL_Invoice,
//     _ledgerjournaltrans.Voucher as PIL_Voucher,
//     _ledgerjournaltrans.TXT as PIL_Description,
//     _generaljournalaccountentry.PostingType,
//     dimensionFinancialTag.VALUE as idcabang,
//     dimensionFinancialTag.DESCRIPTION as cabang
//     --_generaljournalaccountentry.LedgerAccount
// FROM 
//     [AX_DUMMY].[dbo].[LedgerJournalTable] as _ledgerjournaltable
//         join [AX_DUMMY].[dbo].[LedgerJournalTrans] as _ledgerjournaltrans
//             on _ledgerjournaltrans.JournalNum = _ledgerjournaltable.JournalNum 
//         join [AX_DUMMY].[dbo].[DimensionAttributeValueSet] as dimensionAttributeValueSet
//             on dimensionAttributeValueSet.RecId = _ledgerjournaltrans.DefaultDimension
//         join [AX_DUMMY].[dbo].[DimensionAttributeValueSetItem] as dimensionAttributeValueSetItem
//             on dimensionAttributeValueSetItem.DimensionAttributeValueSet = dimensionAttributeValueSet.RecId
//         join [AX_DUMMY].[dbo].[DIMENSIONATTRIBUTEVALUECOMBINATION] as dimensionAttributeValueCombination
//             on dimensionAttributeValueCombination.RECID = _ledgerjournaltrans.LEDGERDIMENSION
//         join [AX_DUMMY].[dbo].[BANKACCOUNTTABLE] as bankaccaounttable
//             on bankaccaounttable.ACCOUNTID = dimensionAttributeValueCombination.DISPLAYVALUE
//         join [AX_DUMMY].[dbo].[DimensionAttributeValue] as dimensionAttributeValue
//             on dimensionAttributeValue.RecId = dimensionAttributeValueSetItem.DimensionAttributeValue
//         join [AX_DUMMY].[dbo].[DimensionAttribute] as _DimensionAttribute
//             on _DimensionAttribute.RecId = dimensionAttributeValue.DimensionAttribute
//                and _DimensionAttribute.Name = 'KPKC'
//         join [AX_DUMMY].[dbo].[DimensionFinancialTag] as dimensionFinancialTag
//             on dimensionFinancialTag.RecId = dimensionAttributeValue.EntityInstance
//         left join [AX_DUMMY].[dbo].[PIL_KCTRANSAKSI] as pil_kc_transaksi
//             on pil_kc_transaksi.PIL_VOUCHER = _ledgerjournaltrans.Voucher AND  pil_kc_transaksi.PIL_JOURNALNUM = _ledgerjournaltrans.JOURNALNUM
       
//     join [AX_DUMMY].[dbo].[GeneralJournalEntry] as _generaljournalentry
//             on _ledgerjournaltrans.Voucher = _generaljournalentry.SubledgerVoucher
//         join [AX_DUMMY].[dbo].[GeneralJournalAccountEntry] as _generaljournalaccountentry
//             on _generaljournalentry.RecId = _generaljournalaccountentry.GeneralJournalEntry
//        where 
// --_generaljournalentry.RecId = _generaljournalaccountentry.GeneralJournalEntry
// --and _generaljournalaccountentry.PostingType = '20'
// --_generaljournalaccountentry.LedgerAccount like '%-THT-%' and
// DATEPART(MONTH, _generaljournalentry.AccountingDate) >= ".$awal." 
// and DATEPART(MONTH, _generaljournalentry.AccountingDate) <= ".$akhir."
// and DATEPART(YEAR, _generaljournalentry.AccountingDate) >= ".$transyear."
// and 
// dimensionFinancialTag.VALUE = '".$cabang."' AND 
// --_ledgerjournaltable.JournalNum = 'JB17100830' AND 
// --and 
// --_ledgerjournaltrans.VOUCHER = 'PAY-1707-0041'

// --AND
// bankaccaounttable.ACCOUNTID ='KAS-KC'
// and 
// ISNUMERIC(_ledgerjournaltable.JournalNum) = '' 
// and 
// isnumeric(bankaccaounttable.ACCOUNTID) = ''
// ORDER BY PIL_JOURNALNUM ASC");
//     return \DB::select("SELECT 
//     _ledgerjournaltable.JournalNum as PIL_JournalNum,
//     _generaljournalentry.AccountingDate as PIL_TransDate,
//     _ledgerjournaltrans.LEDGERDIMENSION as PIL_LEDGERDIMENSION,
//     bankaccaounttable.ACCOUNTID as PIL_ACCOUNTID,
//     bankaccaounttable.NAME as PIL_NAME,
//     _ledgerjournaltrans.AmountCurCredit as PIL_AmountCurCredit,
//     _ledgerjournaltrans.AmountCurDebit as PIL_AmountCurDebit,
//     (select TOP 1 SUM(AmountCur)+SUM(AmountCorrect) as SALDO FROM [AX_DUMMY].[dbo].[BANKACCOUNTTRANS]
//         where YEAR(TRANSDATE) = YEAR(_generaljournalentry.AccountingDate) AND
//                 MONTH(TRANSDATE) <=  (MONTH(_generaljournalentry.AccountingDate)-1) AND
//                 ACCOUNTID = bankaccaounttable.ACCOUNTID
//         GROUP BY ACCOUNTID,  YEAR(TRANSDATE)
//         ORDER BY YEAR(TRANSDATE) DESC) as SALDO,
//     _ledgerjournaltrans.PIL_BK as PIL_BK,
//     _ledgerjournaltrans.Invoice as PIL_Invoice,
//     _ledgerjournaltrans.Voucher as PIL_Voucher,
//     _generaljournalaccountentry.Text as PIL_Description,
//     _generaljournalaccountentry.LEDGERACCOUNT as PIL_Findim,
//     _generaljournalaccountentry.PostingType,
//     dimensionFinancialTag.VALUE as idcabang,
//     dimensionFinancialTag.DESCRIPTION as cabang,
//     _generaljournalaccountentry.LedgerAccount
// FROM 
//     [AX_DUMMY].[dbo].[LedgerJournalTable] as _ledgerjournaltable
//         join [AX_DUMMY].[dbo].[LedgerJournalTrans] as _ledgerjournaltrans
//             on _ledgerjournaltrans.JournalNum = _ledgerjournaltable.JournalNum
//         join [AX_DUMMY].[dbo].[DimensionAttributeValueSet] as dimensionAttributeValueSet
//             on dimensionAttributeValueSet.RecId = _ledgerjournaltrans.DefaultDimension
//         join [AX_DUMMY].[dbo].[DimensionAttributeValueSetItem] as dimensionAttributeValueSetItem
//             on dimensionAttributeValueSetItem.DimensionAttributeValueSet = dimensionAttributeValueSet.RecId
//         join [AX_DUMMY].[dbo].[DIMENSIONATTRIBUTEVALUECOMBINATION] as dimensionAttributeValueCombination
//             on dimensionAttributeValueCombination.RECID = _ledgerjournaltrans.LEDGERDIMENSION
//         join [AX_DUMMY].[dbo].[BANKACCOUNTTABLE] as bankaccaounttable
//             on bankaccaounttable.ACCOUNTID = dimensionAttributeValueCombination.DISPLAYVALUE
//         join [AX_DUMMY].[dbo].[DimensionAttributeValue] as dimensionAttributeValue
//             on dimensionAttributeValue.RecId = dimensionAttributeValueSetItem.DimensionAttributeValue
//         join [AX_DUMMY].[dbo].[DimensionAttribute] as _DimensionAttribute
//             on _DimensionAttribute.RecId = dimensionAttributeValue.DimensionAttribute
//                and _DimensionAttribute.Name = 'KPKC'
//         join [AX_DUMMY].[dbo].[DimensionFinancialTag] as dimensionFinancialTag
//             on dimensionFinancialTag.RecId = dimensionAttributeValue.EntityInstance
//         join [AX_DUMMY].[dbo].[GeneralJournalEntry] as _generaljournalentry
//             on _ledgerjournaltrans.Voucher = _generaljournalentry.SubledgerVoucher
//         join [AX_DUMMY].[dbo].[GeneralJournalAccountEntry] as _generaljournalaccountentry
//             on _generaljournalentry.RecId = _generaljournalaccountentry.GeneralJournalEntry
//         where _generaljournalentry.RecId = _generaljournalaccountentry.GeneralJournalEntry
//         and _generaljournalaccountentry.PostingType = '20'
//         and _generaljournalaccountentry.LedgerAccount like '%-THT-%'
//         and dimensionFinancialTag.VALUE = ".$cabang."
//         and DATEPART(MONTH, _generaljournalentry.AccountingDate) >= ".$awal." 
//         and DATEPART(MONTH, _generaljournalentry.AccountingDate) <= ".$akhir."
//         and DATEPART(YEAR, _generaljournalentry.AccountingDate) = ".$transyear."
//         ORDER BY PIL_TransDate asc");
        }
    
    public function filter_result_realisasi($cabang, $awal, $akhir, $transyear)
    {
        $cabangs = KantorCabang::get();
        $transaksi = $this->reportQuery($cabang, $awal, $akhir, $transyear);
        // dd($transaksi);
        $start = array_search($awal, $this->months);
        $end = array_search($akhir, $this->months);
    
        return view('transaksi.realisasi', [
            'cabang'    => $cabangs,
            'filters'   => array('cabang'=>$cabang, 'awal'=>$awal, 'akhir'=>$akhir, 'transyear' => $transyear),
            'transaksi' => $transaksi,
            'months'    => $this->months,
            'items'     => ItemMaster::get()]);
    }

    public function filter_result_realisasi_transaksi($cabang, $awal, $akhir, $transyear)
    {
        $cabangs = KantorCabang::get();
        $transaksi = $this->reportQuery_transaksi($cabang, $awal, $akhir, $transyear);
        // dd($transaksi);
        $start = array_search($awal, $this->months);
        $end = array_search($akhir, $this->months);
        $sebelum="";
        $data_count= [];
        foreach ($transaksi as $trans) {
            if($trans->account != $sebelum){
                $sebelum = $trans->account;
                $data_count[$trans->account] = 1;
            }else{
                $data_count[$trans->account]++;
            }
        }
        return view('transaksi.realisasi_transaksi', [
            'cabang'    => $cabangs,
            'filters'   => array('cabang'=>$cabang, 'awal'=>$awal, 'akhir'=>$akhir, 'transyear' => $transyear),
            'transaksi' => $transaksi,
            'data_count' => $data_count,
            'months'    => $this->months,
            'items'     => ItemMaster::get()]);
    }

    //Report kas/bank cabang
    public function kasbank()
    {
        $cabang = KantorCabang::where('VALUE','<>','00')->get();

        return view('transaksi.kasbank', [
            'cabang'    => $cabang,
            'months'    => $this->months,
            'filters'   => null]);
    }

    public function filter_handle_kasbank(Request $request)
      {
        $validatorRK = Validator::make($request->all(),
            [
                'cabang'    => 'required',
                'awal'      => 'required',
                'akhir'     => 'required',
                'transyear' => 'required'
            ], 
            [
                'cabang.required'  => 'Kantor cabang harus dipilih.',
                'awal.required'  => 'Periode awal harus dipilih.',
                'akhir.required'  => 'Periode akhir harus dipilih.',
                'transyear.required'  => 'Tahun periode harus dipilih.'
            ]
        );

        if($validatorRK->passes()){
            return redirect('transaksi/filter/kasbank/'.$request->cabang.'/'.$request->awal.'/'.$request->akhir.'/'.$request->transyear);    
        }else{
            return redirect()->back()->withErrors($validatorRK)->withInput();
        }
    }

    public function filter_result_kasbank($cabang, $awal, $akhir, $transyear)
    {
        $cabangs = KantorCabang::get();
        $transaksi = $this->reportQuery_kasbank($cabang, $awal, $akhir, $transyear);
        // $tgl1="".$transyear."-".$awal."-01";
        // $tgl1="2018-01-01";
        // $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl1))); 
        // $saldo=DB::select("SELECT 
        //                    accountid,
        //                    SUM(AmountCur)+SUM(AmountCorrect) as saldo
        //                         FROM [AX_DUMMY].[dbo].[BANKACCOUNTTRANS] as a
        //                         join [AX_DUMMY].[dbo].[PIL_BANK_VIEW] as b
        //                         on a.ACCOUNTID=b.BANK
        //                         where  b.ID_CABANG = '".$cabang."'
        //                         and a.TRANSDATE <= ".$tgl2."
        //                         and a.ACCOUNTID like '%KKC%'
        //                         group by a.ACCOUNTID");
                                        
        $start = array_search($awal, $this->months);
        $end = array_search($akhir, $this->months);
        return view('transaksi.kasbank', [
            'cabang'    => $cabangs,
            'months'    => $this->months,
            'transaksi' => $transaksi,
            // 'saldo'     => $saldo,
            'filters'   => array('cabang'=>$cabang, 'awal'=>$awal, 'akhir'=>$akhir, 'transyear' => $transyear)]
        );
    }

    public function cetakKasBank($cabang, $awal, $akhir, $transyear, $type)
    {   
        $transaksi = $this->reportQuery_kasbank($cabang, $awal, $akhir, $transyear);
        $start = $this->months[$awal];
        $end = $this->months[$akhir];
        $excel = false;

        if($type == 'excel'){
            $excel = true;
        }

        $data = [
            'cabangs'   => KantorCabang::get(),
            'filters'   => array('cabang' => $cabang, 'awal'=>$awal, 'akhir'=>$akhir,  'transyear' => $transyear),
            'transaksi' => $transaksi,
            'items'     => ItemMaster::get(),
            'start'     => $start,
            'end'       => $end,
            'months'    => $this->months,
            'year'      => $transyear,
            'excel'     => $excel];

            switch($type){
                case 'print' :
                    return view('transaksi.cetak-kasbank', $data);
                    break;
                case 'export' :
                $pdf = PDF::loadView('transaksi.pdf-kasbank', $data);
                return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('Report-kasbank-'.date("dmY").'.pdf');
                // return $pdf->stream('Realisasi Anggaran-'.date("dmY").'.pdf'); // hanya untuk view pdf
                break;
                case 'excel' :
                    return view('transaksi.export-kasbank', $data);
                    break;
            }

      }

    public function verifikasilevel1()
    {   
        $a = DB::select("SELECT 
        max(a.id) as id, batch_id, max(divisi) as divisi, 
        max(cabang) as cabang, max(seq_number) as seq_number, 
        max(b.created_at) as tanggal, max(stat) stat
        FROM [DBCabang].[dbo].[batches_status] as a join [DBCabang].[dbo].[batches] as b
        on a.batch_id=b.id
        where stat=2
        group by batch_id order by tanggal desc");
        return view('transaksi.verifikasilevel1', compact('a'));
    }

    public function verifikasilevel2()
    {   
        $a = DB::select("SELECT 
        max(a.id) as id, batch_id, max(divisi) as divisi, 
        max(cabang) as cabang, max(seq_number) as seq_number, 
        max(b.created_at) as tanggal, max(stat) stat
        FROM [DBCabang].[dbo].[batches_status] as a join [DBCabang].[dbo].[batches] as b
        on a.batch_id=b.id
        where stat=4
        group by batch_id order by tanggal desc");
        return view('transaksi.verifikasilevel2', compact('a'));
    }

    public function rejecthistory()
    {   
          $a = DB::select("SELECT batch_id, stat, submitted_by, batch_status_id, reject_reason, created_by, c.created_at as tanggal, divisi, cabang, seq_number
          FROM [DBCabang].[dbo].[batches_status] as a
          join [DBCabang].[dbo].[reject_history] as b
          on a.id=b.batch_status_id
          join [DBCabang].[dbo].[batches] as c
          on a.batch_id=c.id
          order by tanggal desc");
          return view('transaksi.rejecthistory', compact('a'));
    }
}