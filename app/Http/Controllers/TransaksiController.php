<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AkunBank;
use App\Models\Item;
use App\Models\Kegiatan;
use App\Models\SubPos;
use App\Models\Transaksi;
use App\Models\TransaksiStatus;
use App\Models\BerkasTransaksi;

use Validator;
use App\Services\FileUpload;

//  ----------- STAT DESC -------------
//          0 = Inserted 
//          1 = Posted / Submited      
//  -----------------------------------

class TransaksiController extends Controller
{

    protected $bankModel;
    protected $itemModel;
    protected $subPosModel;
    protected $kegiatanModel;
    protected $transaksiModel;

    protected $current_batch;

    public function __construct(
        AkunBank $bank,
        Item $item,
        SubPos $subPos,
        Kegiatan $kegiatan,
        Transaksi $transaksi)
    {
        $this->bankModel = $bank;
        $this->itemModel = $item;
        $this->subPosModel = $subPos;
        $this->kegiatanModel = $kegiatan;
        $this->transaksiModel = $transaksi;
        $this->current_batch = $this->defineBatch();
    }

    public function index() 
    {
        $berkas = BerkasTransaksi::where('batch_id', $this->current_batch)->get();

        return view('transaksi.input', ['filters' => null, 'berkas' => $berkas]);
    }

    public function defineBatch()
    {
        $result = 1;
        if ($this->transaksiModel->orderBy('id', 'desc')->first()) {
            $current_batch = $this->transaksiModel->orderBy('id', 'desc')->first();
            $result = $current_batch['batch_id'];

            if ($current_batch->latestStat() && (int)$current_batch->latestStat() > 0) {
                $result += 1;
            }
        } 

        return $result;
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
        // dd($result);
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
        // dd($return);
        return response()->json($return);
    }

    public function store(Request $request)
    {
        $batch_insert = $batch_update = array();
        
        // dd(count($request->berkas[0]));
        foreach (json_decode($request->batch_values) as $value) {
            $store_values = [
                    'id'            => $value->id,
                    'tgl'           => $value->tgl,
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
                    'batch_id'      => (int)$this->current_batch,
                    'created_at'    => \Carbon\Carbon::now(),
                    'updated_at'    => \Carbon\Carbon::now()];

            if (isset($value->isNew)) {
                unset($store_values['id']);
                array_push($batch_insert, $store_values);
            } else {
                array_push($batch_update, $store_values);
            }
        }
        
        // dd($batch_insert);

        $this->doInsert($batch_insert, $this->current_batch);
        $this->doUpdate($batch_update);
        $this->storeBerkas($request->berkas, $this->current_batch);
        $this->updateBatchStat($this->current_batch, 0);
        
        $batch_counter = array(count($batch_insert), count($batch_update), count($request->berkas[0]));

        session()->flash('success', $batch_counter);
        return redirect('transaksi');
    }

    public function doInsert($batch_insert, $current_batch)
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
            $fileUpload = new FileUpload();
            $newNames = $fileUpload->multipleUpload($inputs, 'transaksi');

            $store = array();
            foreach (explode('||', $newNames) as $value) {
                array_push($store, ['file_name' => $value, 'batch_id' => $current_batch, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
            }

            BerkasTransaksi::insert($store);
        }
    }

    public function removeBerkas($id)
    {
        BerkasTransaksi::where('id', $id)->delete();
    }

    public function updateBatchStat($current_batch, $stat)
    {
        $stat_inputs = [
                'batch_id'      => $current_batch, 
                'stat'          => $stat, 
                'submitted_by'  => \Auth::user()->id];
        $findStat = TransaksiStatus::where([['batch_id', $current_batch], ['stat', $stat]])->first();

        if ($findStat) {
            TransaksiStatus::where('id', $findStat['id'])->update($stat_inputs);
        } else {
            TransaksiStatus::create($stat_inputs);
        }
    }

    public function submit(Request $request)
    {

    }
    
    /*public function view_transaksi($batch)
    {
        $transaksi = $this->transaksiModel->where(['created_at', $batch])->get();
        return view('transaksi.viewtransaksi', ['transaksi' => $transaksi]);
    } */  

    public function view_transaksi()
    {
        return view('transaksi.viewtransaksi');
    }
    
    public function persetujuan_transaksi()
    {
        return view('transaksi.persetujuan');
    }   
    
    public function verifikasi_transaksi()
    {
        return view('transaksi.verifikasi');
    }      
}
