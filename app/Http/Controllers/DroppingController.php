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
    protected $kantorCabangs;

    public function __construct(PaymentJournalDropping $jDropping, FinancialTag $financialT)
    {
        $this->jDroppingModel = $jDropping;
        $this->financialTModel = $financialT;
        $this->kantorCabangs = $this->financialTModel->where([['DESCRIPTION', '!=', ''],['DESCRIPTION', '!=', null] ])->get();
    }

    public function index() 
    {
        return view('dropping.index', ['kcabangs' => $this->kantorCabangs, 'filters' => null]);
    }

    public function table()
    {
    	return view('table');
    }

    public function getAll()
    {
        $droppings = $this->jDroppingModel->where('KREDIT', '>', 0)->get();
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
        return redirect('dropping/filter/'.$request->transyear.'/'.$request->periode.'/'.$request->kcabang);
    }

    public function filter($transyear, $periode, $kcabang)
    {
        return view('dropping.index', ['kcabangs' => $this->kantorCabangs, 'filters' => array('transyear' => $transyear, 'periode' => $periode, 'kcabang' => $kcabang)]);
    }

    public function getFiltered($transyear, $periode, $kcabang)
    {
        $droppings = $this->jDroppingModel->where('KREDIT', '>', 0);
        
        if ($transyear != '0') {
            $droppings = $droppings->whereYear('TRANSDATE', '=', $transyear);
        }

        if ($periode != '0') {

        }
    
        if ($kcabang != '0') {
            $droppings = $droppings->where('CABANG_DROPPING', $kcabang);
        }   
             
        $result = [];
        foreach ($droppings->get() as $dropping) {
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
