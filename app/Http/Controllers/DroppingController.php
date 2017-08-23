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
use App\Services\FileUpload;

class DroppingController extends Controller
{

    protected $jDroppingModel;
    protected $kanCabModel;
    protected $kantorCabangs;
    protected $akunBankModel;
    protected $tarikTunaiModel;
    protected $droppingModel;
    protected $penyesuaianModel;

    public function __construct(
        PaymentJournalDropping $jDropping, 
        KantorCabang $kanCab, 
        AkunBank $bankAkun,
        TarikTunai $tarikTunai,
        Dropping $droppingTable,
        PenyesuaianDropping $kesesuaianDropping)
    {
        $this->jDroppingModel = $jDropping;
        $this->kanCabModel = $kanCab;
        $this->kantorCabangs = $this->kanCabModel->orderby('DESCRIPTION', 'asc')->where([['DESCRIPTION', '!=', ''],['DESCRIPTION', '!=', null] ])->get();
        $this->akunBankModel = $bankAkun;
        $this->tarikTunaiModel = $tarikTunai;
        $this->droppingModel = $droppingTable;
        $this->penyesuaianModel = $kesesuaianDropping;
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
        $tariktunai = TarikTunai::where([['id_dropping', $id_drop], ['nominal_tarik', '>', 0]])->orderby('sisa_dropping', 'asc')->get(); 

        return view('dropping.tariktunai', ['tariktunai' => $tariktunai, 'dropping' => $dropping]);
    }

    public function tarik_tunai_process($id_drop, Request $request)
    {
        $temp_sisa = TarikTunai::where('id_dropping', $id_drop)->orderby('created_at', 'desc')->first();

        $inputsTT = $request->except('_method', '_token', 'nominal');

        $validatorTT = Validator::make($inputsTT,
            [
                'berkas' => 'required',
                'nominal_tarik' => 'not_in:0|required|numeric'
            ], 
            [
                'nominal_tarik.not_in'  => 'Nominal tarik tunai tidak boleh dikosongkan !',
                'nominal_tarik.required'  => 'Nominal tarik tunai tidak boleh dikosongkan !',
                'nominal_tarik.numeric'  => 'Nominal tarik tunai hanya bisa diisi oleh angka !',
                'berkas.required'  => 'Attachment bukti tarik tunai tidak boleh dikosongkan !'
            ]);

        //----- Fungsi tarik tunai, jika tidak ada record maka tariktunai berasal dari nominal awal - nominal tarik -----//
        //----- jika ada record maka tariktunai berasal dari (nominal = sisa dropping sebelumnya) - nominal tarik  -----//
        if($validatorTT->passes()){
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
                $inputsTT['berkas_tariktunai'] = $this->storeBerkas($request->berkas, 'tariktunai');      

                TarikTunai::create($inputsTT);
               
                session()->flash('success', true);
            } else {
                session()->flash('offset', true);
            }   
        }else{
            return redirect()->back()->withErrors($validatorTT)->withInput();
        }
        return redirect('/dropping/tariktunai/'.$id_drop);
    }

    public function penyesuaian($id_drop, Request $request)
    {
        $this->inputDrop($id_drop); 

        $dropping = $this->droppingModel->where([['RECID', $id_drop], ['DEBIT', '>', 0]])->firstOrFail();
        $akunBank = $this->akunBankModel->get();
        $kesesuaian = PenyesuaianDropping::where('id_dropping', $id_drop)->first();

        return view('dropping.penyesuaian', ['dropping' => $dropping, 'kesesuaian' => $kesesuaian, 'kcabangs' => $this->kantorCabangs]);
    }

    public function penyesuaian_process($id_drop, Request $request)
    {
        $inputsPD = $request->except('_method', '_token', 'p_akun_bank', 'p_cabang', 'is_pengembalian', 'p_nominal', 'p_rek_bank', 'p_tgl_dropping');
        $inputsPD = array(
            'akun_bank'         => $request->p_akun_bank, 
            'cabang'            => $request->p_cabang,
            'is_pengembalian'   => $request->p_is_pengembalian == "1" ? false : true,
            'nominal'           => $request->p_nominal,
            'rek_bank'          => $request->p_rek_bank,
            'tgl_dropping'      => $request->p_tgl_dropping
        );

        $validatorPD = Validator::make($request->all(),
            [
                //'is_sesuai'           => 'not_in:0',
                'p_akun_bank'       => 'not_in:0|required',
                'p_cabang'          => 'not_in:0|required',
                'p_nominal'         => 'not_in:0|required|numeric',
                'p_rek_bank'        => 'not_in:0|required',
                'berkas'            => 'required'
            ],
            [
                //'is_sesuai.not_in'    => 'Anda sudah melakukan penyesuaian dropping',
                'p_nominal.not_in'    => 'Nominal transaksi penyesuaian dropping tidak boleh dikosongkan !',
                'p_nominal.required'  => 'Nominal transaksi penyesuaian dropping tidak boleh dikosongkan !',
                'p_nominal.numeric'   => 'Nominal transaksi penyesuaian dropping hanya bisa diisi oleh angka !',
                'p_cabang.not_in'     => 'Pilihan kantor cabang tidak boleh dikosongkan !',
                'p_cabang.required'   => 'Pilihan kantor cabang tidak boleh dikosongkan !',
                'p_akun_bank.not_in'  => 'Pilihan nama bank tidak boleh dikosongkan !',
                'p_akun_bank.required'=> 'Pilihan nama bank tidak boleh dikosongkan !',
                'p_rek_bank.not_in'   => 'Pilihan nomor rekening tidak boleh dikosongkan !',
                'p_rek_bank.required' => 'Pilihan nomor rekening tidak boleh dikosongkan !',
                'berkas.required'     => 'Attachment bukti penyesuaian tidak boleh dikosongkan !'
            ]);

        $findstat = PenyesuaianDropping::where('id_dropping', $id_drop)->first();

        if($findstat){
            session()->flash('fail', true);
        }else{
            if($validatorPD->passes())
            {
                $inputsPD['created_by'] = \Auth::id();
                $inputsPD['id_dropping'] = $id_drop;
                $inputsPD['nominal_dropping']  = $request->nominal_dropping;
                $inputsPD['berkas_penyesuaian'] = $this->storeBerkas($request->berkas, 'penyesuaian');
                
                //dd($request->berkas);
                PenyesuaianDropping::create($inputsPD);   
                session()->flash('success', true);

            }else{
                return redirect()->back()->withErrors($validatorPD)->withInput();
            }
        }
        return redirect('/dropping/penyesuaian/'.$id_drop);
    }

    public function storeBerkas($inputs, $route)
    {
        if ($inputs != null) {
            $fileUpload = new FileUpload();
            $newNames = $fileUpload->upload($inputs, $route);
            return $newNames;
        }else{
            return null;
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
