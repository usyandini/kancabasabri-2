<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AkunBank;
use App\Models\Item;
use App\Models\Kegiatan;
use App\Models\SubPos;
use App\Models\Transaksi;
use App\Models\BerkasTransaksi;

use Validator;
use App\Services\FileUpload;

class TransaksiController extends Controller
{

    protected $bankModel;
    protected $itemModel;
    protected $subPosModel;
    protected $kegiatanModel;
    protected $transaksiModel;

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
    }

    public function index() 
    {
        return view('transaksi.input', ['filters' => null]);
    }

    public function store(Request $request)
    {
        // dd($request->berkas);
        $current_batch = $this->transaksiModel->limit(1)->orderBy('id', 'desc')->first()['batch_id'] ? $this->transaksiModel->limit(1)->orderBy('id', 'desc')->first()['batch_id']+1 : 1;
        $batch_values = array();

        foreach (json_decode($request->batch_values) as $value) {
            array_push($batch_values, [
                    'tgl'       => $value->tgl,
                    'item'      => (int)$value->item,
                    'qty_item'  => (int)$value->qty_item,
                    'desc'      => $value->desc,
                    'sub_pos'   => (int)$value->sub_pos,
                    'mata_anggaran' => (int)$value->mata_anggaran,
                    'akun_bank'      => (int)$value->bank,
                    'account'   => $value->account,
                    'anggaran'  => (int)$value->anggaran,
                    'total'     => (int)$value->total,
                    'created_by'    => \Auth::user()->id,
                    'batch_id'      => $current_batch,
                    'created_at'    => \Carbon\Carbon::now(),
                    'updated_at'    => \Carbon\Carbon::now()
            ]);
        }
        
        Transaksi::insert($batch_values);

        if ($request->berkas != null) {
            $this->storeBerkas($request->berkas, $current_batch);
        }
    }

    public function storeBerkas($inputs, $current_batch)
    {
        $fileUpload = new FileUpload();
        $newNames = $fileUpload->multipleUpload($inputs, 'transaksi');

        $store = array();
        foreach (explode('||', $newNames) as $value) {
            array_push($store, ['file_name' => $value, 'batch_id' => $current_batch, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
        }

        BerkasTransaksi::insert($store);
    }

    public function getAll()
    {
        return response()->json($this->transaksiModel->get());
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
    
    public function transaksi_process($batch, Request $request)
    {
        $inputsTrans = $request->except('_method', '_token');
        
        $inputsTrans['created_by'] = \Auth::id();
        $inputsTrans['created_at'] = $batch;
        
        Transaksi::create($inputsTrans);
        
        session()->flash('success', true);
        return redirect('/transaksi/viewtransaksi/{created_at}');
    }
    
    public function view_transaksi($batch)
    {
        $transaksi = $this->transaksiModel->where(['created_at', $batch])->get();
        return view('transaksi.viewtransaksi', ['transaksi' => $transaksi]);
    }   
}
