<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\PaymentJournalDropping;

class DroppingController extends Controller
{

    protected $JDroppingModel;

    public function __construct(PaymentJournalDropping $JDropping)
    {
        $this->JDroppingModel = $JDropping;
    }

    public function index() 
    {
        return view('dropping.index');
    }

    public function table()
    {
    	return view('table');
    }

    public function getAll()
    {
        $droppings = $this->JDroppingModel->get();
        $result = [];
        foreach ($droppings as $dropping) {
            $result[] = [
                'id_drop'       => $dropping->RECID,
                'journalnum'    => $dropping->JOURNALNUM,
                'namabank'      => $dropping->BANK_DROPPING,
                'rekbank'       => $dropping->REKENING_DROPPING,
                'transdate'     => $dropping->TRANSDATE, 
                'debit'         => 'IDR '. number_format($dropping->DEBIT, 2),
                'credit'        => 'IDR '. number_format($dropping->CREDIT, 2),
                'cabang'        => $dropping->CABANG_DROPPING
            ];
        }
        return response()->json($result);
    }

    public function formatData($dropping)
    {
        
    }

    public function tarik_tunai($journalnum)
    {
        $dropping = $this->JDroppingModel->where('RECID', $journalnum)->firstOrFail();
    	return view('dropping.tariktunai', ['dropping' => $dropping]);
    }

    public function tarik_tunai_process($journalnum, Request $request)
    {
        dd($request->all());
    }

    public function pengembalian()
    {
    	return view ('pengembalian');
    }

    public function penambahan()
    {
    	return view ('penambahan');
    }

    public function redirect($url, $statusCode = 303)
    {
       header('Location: ' . $url, true, $statusCode);
       die();
    }
}
