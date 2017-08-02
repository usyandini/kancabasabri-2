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

    public function __construct(
        AkunBank $bank,
        Item $item,
        SubPos $subPos,
        Kegiatan $kegiatan)
    {
        $this->bankModel = $bank;
        $this->itemModel = $item;
        $this->subPosModel = $subPos;
        $this->kegiatanModel = $kegiatan;
    }

    public function index() 
    {
        return view('transaksi.input', ['filters' => null]);
    }

    public function view_transaksi()
    {
    	return view('transaksi.viewtransaksi');
    }

    public function store(Request $request)
    {
    	dd($request->all());
    }

    public function getAll()
    {
        return response()->json($this->bankModel->get());
    }

    public function getAttributes($type)
    {
        $return = null;
        switch ($type) {
            case 'item':
                $return = response()->json($this->itemModel->get());
                break;
            case 'bank':
                $return = response()->json($this->bankModel->get());
                break;       
            case 'subpos':
                $return = response()->json($this->subPosModel->get());
                break;
            case 'kegiatan':
                $return = response()->json($this->kegiatanModel->get());
                break;
        }

        return $return;
    }   
}
