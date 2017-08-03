<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AkunBank;
use App\Models\Item;
use App\Models\Kegiatan;
use App\Models\SubPos;
use App\Models\Transaksi;

use Validator;

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
    	dd($request->all());
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
                $return->splice(0,0,[["MAINACCOUNTID" => 0, "NAME" => "Silahkan pilih nama item"]]);
                break;
            case 'bank':
                $return = $this->bankModel->get();
                $return->splice(0,0,[["BANK" => 0, "BANK_NAME" => "Silahkan pilih bank"]]);
                break;       
            case 'subpos':
                $return = $this->subPosModel->get();
                $return->splice(0,0,[["VALUE" => 0, "DESCRIPTION" => "Silahkan pilih subpos"]]);
                break;
            case 'kegiatan':
                $return = $this->kegiatanModel->get();
                $return->splice(0,0,[["VALUE" => 0, "DESCRIPTION" => "Silahkan pilih kegiatan"]]);
                break;
        }

        return $return;
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
