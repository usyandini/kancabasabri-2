<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\PaymentJournalDropping;
use App\Models\FinancialTag;


class DroppingController extends Controller
{

    protected $jDroppingModel;
    protected $financialTModel;

    public function __construct(PaymentJournalDropping $jDropping, FinancialTag $financialT)
    {
        $this->jDroppingModel = $jDropping;
        $this->financialTModel = $financialT;
    }

    public function index() 
    {
        $kantorCabangs = $this->financialTModel->get();
        return view('dropping.index', ['kcabangs' => $kantorCabangs, 'filters' => null]);
    }

    public function table()
    {
    	return view('table');
    }

    public function getAll()
    {
        $droppings = $this->jDroppingModel->get();
        $result = [];
        foreach ($droppings as $dropping) {
            $result[] = [
                'bank'       => $dropping->BANK_DROPPING, 
                'journalnum'    => $dropping->JOURNALNUM, 
                'transdate'     => $dropping->TRANSDATE, 
                'credit'        => 'IDR '. number_format($dropping->KREDIT, 2),
                'banknum'   => $dropping->REKENING_DROPPING,
                'company'       => $dropping->CABANG_DROPPING
            ];
        }
        return response()->json($result);
    }

    public function filterHandle(Request $request)
    {
        
    }

    public function getFiltered($filters)
    {
        $droppings = $this->jDroppingModel;
        
        if ($filters['transyear'] != 0) {
            $droppings->whereYear('TRANSDATE', $filters['transyear']);
        }

        if ($filters['periode'] != 0) {

        }
    
        if ($filters['kcabang'] != 0) {
            $droppings->where('CABANG_DROPPING', $filters['kcabang']);
        }   

        $droppings->get();
             
        $result = [];
        foreach ($droppings as $dropping) {
            $result[] = [
                'bank'       => $dropping->BANK_DROPPING, 
                'journalnum'    => $dropping->JOURNALNUM, 
                'transdate'     => $dropping->TRANSDATE, 
                'credit'        => 'IDR '. number_format($dropping->KREDIT, 2),
                'banknum'   => $dropping->REKENING_DROPPING,
                'company'       => $dropping->CABANG_DROPPING
            ];
        }
        return response()->json($result);
    }

    public function tarik_tunai($journalnum)
    {
        $dropping = $this->jDroppingModel->where('JOURNALNUM', $journalnum)->firstOrFail();
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
