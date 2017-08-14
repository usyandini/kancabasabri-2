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
use App\Models\Dropping;

use Validator;

class DroppingController extends Controller
{

    protected $jDroppingModel;
    protected $kanCabModel;
    protected $kantorCabangs;
    protected $akunBankModel;
    protected $tarikTunaiModel;
    protected $droppingModel;

    public function __construct(
        PaymentJournalDropping $jDropping, 
        KantorCabang $kanCab, 
        AkunBank $bankAkun,
        TarikTunai $tarikTunai,
        Dropping $droppingTable)
    {
        $this->jDroppingModel = $jDropping;
        $this->kanCabModel = $kanCab;
        $this->kantorCabangs = $this->kanCabModel->orderby('DESCRIPTION', 'asc')->where([['DESCRIPTION', '!=', ''],['DESCRIPTION', '!=', null] ])->get();
        $this->akunBankModel = $bankAkun;
        $this->tarikTunaiModel = $tarikTunai;
        $this->droppingModel = $droppingTable;
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
                'stat'          => $dropping->tarikTunai['is_sesuai'],
                'nominal_tarik' => $dropping->tarikTunai['nominal_tarik'],
                'sisa'          => 'IDR '. number_format($dropping->tarikTunai['sisa_dropping'], 2)
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
                'credit'        => 'IDR '. number_format($dropping->KREDIT, 2),
                'banknum'       => $dropping->REKENING_DROPPING,
                'company'       => $dropping->CABANG_DROPPING,
                'stat'          => $dropping->tarikTunai['is_sesuai'],
                'nominal_tarik' => $dropping->tarikTunai['nominal_tarik'],
                'sisa'          => 'IDR '. number_format($dropping->tarikTunai['sisa_dropping'], 2)
            ];
        }

        return response()->json($result);
    }

    public function inputDrop($id_drop)
    {
        $dropping = $this->jDroppingModel->where([['RECID', $id_drop], ['DEBIT', '>', 0]])->firstOrFail();
        //----- input view dropping axapta to table dropping dbcabang ketika klik lanjut -----//
        $inputDropping = [
                'RECID'         => $dropping->RECID,
                'JOURNALNAME'   => $dropping->JOURNALNAME,
                'JOURNALNUM'    => $dropping->JOURNALNUM,
                'TRANSDATE'     => $dropping->TRANSDATE,
                'DEBIT'         => $dropping->DEBIT,
                'BANK_DROPPING' => $dropping->BANK_DROPPING,
            'REKENING_DROPPING' => $dropping->REKENING_DROPPING,
            'CABANG_DROPPING'   => $dropping->CABANG_DROPPING,
            'AKUN_DROPPING'     => $dropping->AKUN_DROPPING,
                'TXT'           => $dropping->TXT,
                'KREDIT'        => $dropping->KREDIT];
        
        //----- update droping where recid = id_drop ------//
        $findDrop = Dropping::where([['RECID', $id_drop], ['DEBIT', '>', 0]])->first();

        if($findDrop){
            Dropping::where('RECID', $findDrop['RECID'])->update($inputDropping);
        }else{
            Dropping::create($inputDropping);
        }
    }

    public function tarik_tunai($id_drop, Request $request)
    {
        $this->inputDrop($id_drop); 

        $dropping = $this->droppingModel->where([['RECID', $id_drop], ['DEBIT', '>', 0]])->firstOrFail();
        $akunBank = $this->akunBankModel->get();
        $tariktunai = TarikTunai::where('id_dropping', $id_drop)->get();

        return view('dropping.tariktunai', ['tariktunai' => $tariktunai, 'dropping' => $dropping, 'kcabangs' => $this->kantorCabangs]);
    }

    public function tarik_tunai_process($id_drop, Request $request)
    {
        if ($request->is_sesuai == "1") {
            $inputsTT = $request->except('_method', '_token', 'nominal');
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

        //----- Fungsi tarik tunai, jika tidak ada record maka tariktunai berasal dari nominal awal - nominal tarik -----//
        //----- jika ada record maka tariktunai berasal dari (nominal = sisa dropping sebelumnya) - nominal tarik  -----//
        $temp_sisa = TarikTunai::where('id_dropping', $id_drop)->orderby('created_at', 'desc')->first();
        if($temp_sisa){
            $inputsTT['nominal'] = $temp_sisa['sisa_dropping'];
        }else{
            $inputsTT['nominal'] = $request->nominal;
            $temp_sisa['sisa_dropping'] = $request->nominal;
        }

        if($temp_sisa['sisa_dropping'] != 0 && $request->nominal_tarik <= $temp_sisa['sisa_dropping']){
            $inputsTT['sisa_dropping'] = ($temp_sisa['sisa_dropping'] - $request->nominal_tarik);

            $inputsTT['created_by'] = \Auth::id();
            $inputsTT['id_dropping'] = $id_drop;
            //$inputsTT['berkas_tariktunai'] = $this->storeBerkas($request->berkas_tariktunai);            
            
            TarikTunai::create($inputsTT);
           
            session()->flash('success', true);
        } else {
            session()->flash('failed', true);
        }
        return redirect('/dropping');
    }

    public function storeBerkas($inputs)
    {
        //---- belum terselesaikan ----//
        if ($inputs[0] != null) {
            $fileUpload = new FileUpload();
            $newNames = $fileUpload->multipleUpload($inputs, 'tariktunai');

            $store = array();
            foreach (explode('||', $newNames) as $value) {
                array_push($store, ['berkas_tariktunai' => $value]);
            }
            TarikTunai::insert($store);
        }
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
