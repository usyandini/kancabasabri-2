<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Models\PaymentJournalDropping;
use App\Models\KantorCabang;
use App\Models\AkunBank;
use App\Models\TarikTunai;
use App\Models\PenyesuaianDropping;

use Validator;

class DroppingController extends Controller
{

    protected $jDroppingModel;
    protected $kanCabModel;
    protected $kantorCabangs;
    protected $akunBankModel;
    protected $tarikTunaiModel;

    public function __construct(
        PaymentJournalDropping $jDropping, 
        KantorCabang $kanCab, 
        AkunBank $bankAkun,
        TarikTunai $tarikTunai)
    {
        $this->jDroppingModel = $jDropping;
        $this->kanCabModel = $kanCab;
        $this->kantorCabangs = $this->kanCabModel->orderby('DESCRIPTION', 'asc')->where([['DESCRIPTION', '!=', ''],['DESCRIPTION', '!=', null] ])->get();
        $this->akunBankModel = $bankAkun;
        $this->tarikTunaiModel = $tarikTunai;
    }

    public function index() 
    {
        return view('dropping.index', ['kcabangs' => $this->kantorCabangs, 'filters' => null]);
    }

    public function getAll()
    {
        $droppings = $this->jDroppingModel->where('DEBIT', '>', 0)->get();
        $result = [];
        foreach ($droppings as $dropping) {
            $result[] = [
                'id_dropping'   => $dropping->RECID,
                'bank'          => $dropping->BANK_DROPPING, 
                'journalnum'    => $dropping->JOURNALNUM, 
                'transdate'     => date("d-m-Y", strtotime($dropping->TRANSDATE)), 
                'debit'         => 'IDR '. number_format($dropping->DEBIT, 2),
                'credit'        => 'IDR '. number_format($dropping->KREDIT, 2),
                'banknum'       => $dropping->REKENING_DROPPING,
                'company'       => $dropping->CABANG_DROPPING,
                'stat'          => $dropping->tarikTunai['is_sesuai']
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
        $droppings = $this->jDroppingModel->where('DEBIT', '>', 0);
        
        if ($transyear != '0') {
            $droppings = $droppings->whereYear('TRANSDATE', '=', $transyear);
        }

        if ($periode != '0') {
            switch($periode){
                case '1':
                    $droppings = $droppings->whereMonth('TRANSDATE', '>=', '1')->whereMonth('TRANSDATE', '<=', '3');break;
                case '2':
                    $droppings = $droppings->whereMonth('TRANSDATE', '>=', '4')->whereMonth('TRANSDATE', '<=', '6');break;
                case '3':
                    $droppings = $droppings->whereMonth('TRANSDATE', '>=', '7')->whereMonth('TRANSDATE', '<=', '9');break;
                case '4':
                    $droppings = $droppings->whereMonth('TRANSDATE', '>=', '10')->whereMonth('TRANSDATE', '<=', '12');break;
            }
        }
    
        if ($kcabang != '0') {
            $droppings = $droppings->where('CABANG_DROPPING', $kcabang);
        }   
             
        $result = [];
        foreach ($droppings->get() as $dropping) {
            $result[] = [
                'id_dropping'   => $dropping->RECID,
                'bank'          => $dropping->BANK_DROPPING, 
                'journalnum'    => $dropping->JOURNALNUM, 
                'transdate'     => date("d-m-Y", strtotime($dropping->TRANSDATE)), 
                'debit'         => 'IDR '. number_format($dropping->DEBIT, 2),
                'banknum'       => $dropping->REKENING_DROPPING,
                'company'       => $dropping->CABANG_DROPPING
            ];
        }
        return response()->json($result);
    }

    public function tarik_tunai($id_drop)
    {
        $dropping = $this->jDroppingModel->where([['RECID', $id_drop], ['DEBIT', '>', 0]])->firstOrFail();
        $akunBank = $this->akunBankModel->get();
    	return view('dropping.tariktunai', ['dropping' => $dropping], ['kcabangs' => $this->kantorCabangs]);
    }

    public function tarik_tunai_process($id_drop, Request $request)
    {
        if ($request->is_sesuai == "1") {
            $inputsTT = $request->except('_method', '_token');
        } else {
            $inputsTT = $request->except('_method', '_token', 'p_akun_bank', 'p_cabang', 'is_pengembalian', 'p_nominal', 'p_rek_bank', 'p_tgl_dropping');
            $inputsPD = array(
                'akun_bank'         => $request->p_akun_bank, 
                'cabang'            => $request->p_cabang,
                'is_pengembalian'   => $request->p_is_pengembalian == "1" ? false : true,
                'nominal'           => $request->p_nominal,
                'rek_bank'          => $request->p_rek_bank,
                'tgl_dropping'      => $request->p_tgl_dropping
            );
            
            $penyesuaian = PenyesuaianDropping::create($inputsPD);
            $inputsTT['id_penyesuaian'] = $penyesuaian->id;
        }
        
        $inputsTT['created_by'] = \Auth::id();
        $inputsTT['id_dropping'] = $id_drop;
        
        TarikTunai::create($inputsTT);
        
        session()->flash('success', true);
        return redirect('/dropping');
    }

    public function pengembalian()
    {
    	return view ('pengembalian');
    }

    public function penambahan()
    {
    	return view ('penambahan');
    }

    public function getChainedBank(Request $request)
    {
        $return = 0;
        switch ($request->input('type')) {
            case 'bank':
                $banks = $this->akunBankModel->where('NAMA_CABANG', $request->input('id'))->get();
                if (count($banks) > 0) {
                    $return = '<option value="0">Pilih Bank</option>';
                    foreach($banks as $temp) 
                        $return .= "<option value='$temp->BANK_NAME'>".$temp->BANK_NAME."</option>";
                } 
            case 'rekening':
                $rekening = $this->akunBankModel->where('BANK_NAME', $request->input('id'))->get();
                if (count($rekening) > 0) {
                    $return = '<option value="0">Pilih Rekening</option>';
                    foreach($rekening as $temp) 
                        $return .= "<option value='$temp->REKENING'>".$temp->REKENING."</option>";
                }
                break;
        }
        return $return;
    }

    public function redirect($url, $statusCode = 303)
    {
       header('Location: ' . $url, true, $statusCode);
       die();
    }
}
