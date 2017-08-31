<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\Models\PaymentJournalDropping;

use App\Models\Dropping;
use App\Models\TarikTunai;
use App\Models\PenyesuaianDropping;
use App\Models\BerkasTarikTunai;
use App\Models\BerkasPenyesuaian;

use App\Models\AkunBank;
use App\Models\KantorCabang;
use App\Models\Program;
use App\Models\Divisi;
use App\Models\SubPos;
use App\Models\Kegiatan;

use Validator;
use App\Services\FileUpload;
use App\Services\NotificationSystem;

//  ----------- DROPPING STAT DESC --------------
//          0 = Belum melakukan aksi dropping
//          1 = Submitted tarik tunai to Akuntansi
//          2 = Rejected for re-input Tarik Tunai
//          3 = Verified Tarik Tunai by Akuntansi
//          4 = Submited penyesuaian to Akuntansi 
//          5 = Rejected for re-input Penyesuaian
//          6 = Verified Penyesuaian by Akuntansi 
//  ----------------------------------------------


class DroppingController extends Controller
{

    protected $jDroppingModel;
    protected $kanCabModel;
    protected $kantorCabangs;
    protected $akunBankModel;
    protected $tarikTunaiModel;
    protected $droppingModel;
    protected $penyesuaianModel;
    protected $berkasTTModel;

    public function __construct(
        PaymentJournalDropping $jDropping, 
        KantorCabang $kanCab, 
        AkunBank $bankAkun,
        TarikTunai $tarikTunai,
        Dropping $droppingTable,
        PenyesuaianDropping $kesesuaianDropping,
        BerkasTarikTunai $berkasTT)
    {
        $this->jDroppingModel = $jDropping;
        $this->kanCabModel = $kanCab;
        $this->kantorCabangs = $this->kanCabModel->orderby('DESCRIPTION', 'asc')->where([['DESCRIPTION', '!=', ''],['DESCRIPTION', '!=', null] ])->get();
        $this->akunBankModel = $bankAkun;
        $this->tarikTunaiModel = $tarikTunai;
        $this->droppingModel = $droppingTable;
        $this->penyesuaianModel = $kesesuaianDropping;
        $this->berkasTTModel = $berkasTT;
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
                'debit'         => 'IDR '. number_format($dropping->DEBIT),
                'credit'        => 'IDR '. number_format($dropping->KREDIT),
                'banknum'       => $dropping->REKENING_DROPPING,
                'company'       => $dropping->CABANG_DROPPING,
                'sisa'          => 'IDR '. number_format($dropping->tarikTunai['sisa_dropping'])
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
                'debit'         => 'IDR '. number_format($dropping->DEBIT),
                'credit'        => 'IDR '. number_format($dropping->KREDIT),
                'banknum'       => $dropping->REKENING_DROPPING,
                'company'       => $dropping->CABANG_DROPPING,
                'sisa'          => 'IDR '. number_format($dropping->tarikTunai['sisa_dropping'])
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
        $tariktunai = TarikTunai::where([['id_dropping', $id_drop], ['nominal_tarik', '>', 0], ['stat', 3]])->orderby('sisa_dropping', 'asc')->get();
        $berkas = [];
        if($tariktunai){
            foreach($tariktunai as $value){
                //$berkas = BerkasTarikTunai::where('id_tariktunai', $this->tarikTunaiModel['id'])->get();   
                $berkas = BerkasTarikTunai::where('id_tariktunai', $value['id'])->get();      
            }
        }

        return view('dropping.tariktunai', ['tariktunai' => $tariktunai, 'dropping' => $dropping, 'berkas' => $berkas]);
    }

    public function tarik_tunai_process($id_drop, Request $request)
    {
        $temp_sisa = TarikTunai::where('id_dropping', $id_drop)->orderby('created_at', 'desc')->first();

        $inputsTT = $request->except('_method', '_token', 'nominal');

        $bank = AkunBank::where('BANK', $request->akun_bank)->first();
        $program = Program::where('DESCRIPTION', 'Tabungan Hari Tua')->first();
        $kpkc = KantorCabang::where('DESCRIPTION', $request->cabang)->first();
        $divisi = Divisi::where('DESCRIPTION', '')->first();
        $subpos = SubPos::where('DESCRIPTION', 'None')->first();
        $kegiatan = Kegiatan::where('DESCRIPTION', 'None')->first();

        $validatorTT = Validator::make($inputsTT,
            [
                'berkas' => 'required',
                'nominal_tarik' => 'not_in:0|required|regex:/^\d+([\,]\d+)*([\.]\d+)?$/'
                //'nominal_tarik' => 'not_in:0|required|regex:/^[1-8](,[1-8])*$/'
            ], 
            [
                'nominal_tarik.not_in'  => 'Nominal tarik tunai tidak boleh dikosongkan !',
                'nominal_tarik.required'  => 'Nominal tarik tunai harus diisi !',
                'nominal_tarik.regex'  => 'Nominal tarik tunai hanya bisa diisi oleh angka !',
                'berkas.required'  => 'Attachment bukti tarik tunai tidak boleh dikosongkan !'
            ]);

        //----- Fungsi tarik tunai, jika tidak ada record maka tariktunai berasal dari nominal awal - nominal tarik -----//
        //----- jika ada record maka tariktunai berasal dari (nominal = sisa dropping sebelumnya) - nominal tarik  -----//

        $string_tarik = $request->nominal_tarik;
        $tarik = floatval(str_replace('.', ',', str_replace(',', '', $string_tarik)));

        if($validatorTT->passes() && $temp_sisa['stat'] !=1){
            if($temp_sisa){
                $inputsTT['nominal'] = $temp_sisa['sisa_dropping'];
            }else{
                $inputsTT['nominal'] = $request->nominal;
                $temp_sisa['sisa_dropping'] = $request->nominal;
            }
            if($temp_sisa['sisa_dropping'] != 0 && $tarik <= $temp_sisa['sisa_dropping']){
                $inputsTT['sisa_dropping'] = ($temp_sisa['sisa_dropping'] - $tarik);

                $inputsTT['created_by'] = \Auth::id();
                $inputsTT['id_dropping'] = $id_drop;
                $inputsTT['nominal_tarik'] = $tarik;

                $seg1 = $inputsTT['SEGMEN_1'] = $bank->ACCOUNT;
                $seg2 = $inputsTT['SEGMEN_2'] = $program->VALUE;
                $seg3 = $inputsTT['SEGMEN_3'] = $kpkc->VALUE;
                $seg4 = $inputsTT['SEGMEN_4'] = $divisi->VALUE;
                $seg5 = $inputsTT['SEGMEN_5'] = $subpos->VALUE;
                $seg6 = $inputsTT['SEGMEN_6'] = $kegiatan->VALUE;
                $inputsTT['ACCOUNT'] = $seg1.'-'.$seg2.'-'.$seg3.'-'.$seg4.'-'.$seg5.'-'.$seg6;


                // $attach = $this->storeBerkas($request->berkas, 'tariktunai');
                // $inputsTT['berkas_tariktunai'] = $attach['id'];
                $inputsTT['stat'] = 1;

                //dd($inputsTT);
                
                $TT = TarikTunai::create($inputsTT);

                $this->storeBerkas($request->berkas, 'tariktunai', $TT->id);
                NotificationSystem::send($TT->id, 7);

                session()->flash('success', true);
            } else {
                session()->flash('offset', true);
            }   
        }elseif($temp_sisa['stat'] == 1){
            session()->flash('confirm', true);
        }
        else{
            //dd($request->all());
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

        $validatorPD = Validator::make($request->all(),
            [
                'p_akun_bank'       => 'not_in:0|required',
                'p_cabang'          => 'not_in:0|required',
                'p_nominal'         => 'not_in:0|required|regex:/^\d+([\,]\d+)*([\.]\d+)?$/',
                'p_rek_bank'        => 'not_in:0|required',
                'berkas'            => 'required'
            ],
            [
                'p_nominal.not_in'    => 'Nominal transaksi penyesuaian dropping tidak boleh dikosongkan !',
                'p_nominal.required'  => 'Nominal transaksi penyesuaian dropping harus diisi!',
                'p_nominal.regex'     => 'Nominal transaksi penyesuaian dropping hanya bisa diisi oleh angka !',
                'p_cabang.not_in'     => 'Pilihan kantor cabang tidak boleh dikosongkan !',
                'p_cabang.required'   => 'Pilihan kantor cabang tidak boleh dikosongkan !',
                'p_akun_bank.not_in'  => 'Pilihan nama bank tidak boleh dikosongkan !',
                'p_akun_bank.required'=> 'Pilihan nama bank tidak boleh dikosongkan !',
                'p_rek_bank.not_in'   => 'Pilihan nomor rekening tidak boleh dikosongkan !',
                'p_rek_bank.required' => 'Pilihan nomor rekening tidak boleh dikosongkan !',
                'berkas.required'     => 'Attachment bukti penyesuaian tidak boleh dikosongkan !'
            ]);

        $findstat = PenyesuaianDropping::where('id_dropping', $id_drop)->first();
        $string_penyesuaian = $request->p_nominal;
        $penyesuaian = floatval(str_replace('.', ',', str_replace(',', '', $string_penyesuaian)));

        if($findstat){
            session()->flash('fail', true);
        }else{
            if($validatorPD->passes())
            {   
                $bank = AkunBank::where('BANK', $request->akun_bank)->first();
                $program = Program::where('DESCRIPTION', 'Tabungan Hari Tua')->first();
                $kpkc = KantorCabang::where('DESCRIPTION', $request->cabang)->first();
                $divisi = Divisi::where('DESCRIPTION', '')->first();
                $subpos = SubPos::where('DESCRIPTION', 'None')->first();
                $kegiatan = Kegiatan::where('DESCRIPTION', 'None')->first();

                $inputsPD = array(
                    'akun_bank'         => $request->p_akun_bank, 
                    'cabang'            => $request->p_cabang,
                    'is_pengembalian'   => $request->p_is_pengembalian == "1" ? false : true,
                    'nominal'           => $penyesuaian,
                    'rek_bank'          => $request->p_rek_bank,
                    'tgl_dropping'      => $request->p_tgl_dropping,
                    'SEGMEN_1'          => $bank->ACCOUNT,
                    'SEGMEN_2'          => $program->VALUE,
                    'SEGMEN_3'          => $kpkc->VALUE,
                    'SEGMEN_4'          => $divisi->VALUE,
                    'SEGMEN_5'          => $subpos->VALUE,
                    'SEGMEN_6'          => $kegiatan->VALUE,
                    'ACCOUNT'           => $bank->ACCOUNT.' - '.$program->VALUE.' - '.$kpkc->VALUE.' - '.$divisi->VALUE.' - '.$subpos->VALUE.' - '.$kegiatan->VALUE
                );

                $inputsPD['created_by'] = \Auth::id();
                $inputsPD['id_dropping'] = $id_drop;
                $inputsPD['nominal_dropping']  = $request->nominal_dropping;
                $attach = $this->storeBerkas($request->berkas, 'penyesuaian');
                $inputsPD['berkas_penyesuaian'] = $attach['id'];
                
                dd($inputsPD);
                PenyesuaianDropping::create($inputsPD);   
                session()->flash('success', true);

            }else{
                return redirect()->back()->withErrors($validatorPD)->withInput();
            }
        }
        return redirect('/dropping/penyesuaian/'.$id_drop);
    }

    public function storeBerkas($inputs, $route, $id)
    {
        if ($inputs[0] != null) {
            $fileUpload = new FileUpload();
            $store = $fileUpload->base64Uploads($inputs);
            
            foreach($store as $key => $value){
                switch($route){
                    case 'tariktunai':
                        $value['id_tariktunai'] = $id;
                        return BerkasTarikTunai::insert($value);
                        break;
                    case 'penyesuaian':
                       return BerkasPenyesuaian::create($value);
                       break;
                }   
            }
        }
    }

    public function downloadBerkas($routes, $berkas_id)
    {
        switch($routes){
            case 'tariktunai':
               $berkas = BerkasTariktunai::where('id', $berkas_id)->first();
               break;
            case 'penyesuaian':
               $berkas = BerkasPenyesuaian::where('id', $berkas_id)->first();
               break;
        }
        $decoded = base64_decode($berkas->data);
        $file = $berkas->name;
        file_put_contents($file, $decoded);
        $data = bin2hex($decoded);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$berkas->type);
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            //header('Pragma: public');
            header('Content-Length: '.$berkas->size);
            readfile($file);
            exit($data);
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
                        $return .= "<option value='$temp->BANK'>".$temp->BANK_NAME."</option>";
                } 
            case 'rekening':
                $rekening = $this->akunBankModel->where('BANK', $request->input('id'))->get();
                if (count($rekening) > 0) {
                    $return = '<option value="0">Pilih Rekening</option>';
                    foreach($rekening as $temp) 
                        $return .= "<option value='$temp->REKENING'>".$temp->REKENING."</option>";
                }
                break;
        }
        return $return;
    }

    public function verifikasi($id){
        $dataTT = TarikTunai::where('id', $id)->first();
        $berkas = [] ;

        if($dataTT){
            $berkas= BerkasTarikTunai::where('id_tariktunai', $id)->get();
            $bank = AkunBank::where('ACCOUNT', $dataTT->SEGMEN_1)->first();
            $program = Program::where('VALUE', $dataTT->SEGMEN_2)->first();
            $kpkc = KantorCabang::where('VALUE', $dataTT->SEGMEN_3)->first();
            $divisi = Divisi::where('VALUE', $dataTT->SEGMEN_4)->first();
            $subpos = SubPos::where('VALUE', $dataTT->SEGMEN_5)->first();
            $kegiatan = Kegiatan::where('VALUE', $dataTT->SEGMEN_6)->first();
        }

        return view('dropping.verifikasi', [
            'tariktunai' => $dataTT,
            'berkas' => $berkas,
            'bank' => $bank,
            'program' => $program,
            'kpkc' => $kpkc,
            'divisi' => $divisi,
            'subpos' => $subpos,
            'kegiatan' => $kegiatan
            ]);
    }

    public function submitVerification($reaction, $id_tarik, Request $request)
    {
        $verification = TarikTunai::where([['id', $id_tarik], ['stat', 1]])->first();

        if($verification)
        {
            switch($reaction){
                case 'verified':
                    TarikTunai::where('id', $id_tarik)->update(array('stat' => 3));
                    session()->flash('success', true);
                    NotificationSystem::send($id_tarik, 9);
                    break;
                    //update dengan data tarik tunai sebelumnya // url rejected belum bisa
                case 'rejected':
                    TarikTunai::where('id', $id_tarik)
                    ->update(array(
                        'nominal' => $verification->nominal,
                        'nominal_tarik' => 0,
                        'sisa_dropping' => $verification->nominal,
                        'stat' => 2));
                    //BerkasTarikTunai::where('id', $verification->berkas_tariktunai)->delete();
                    NotificationSystem::send($id_tarik, 8);
                    session()->flash('reject', true);
                    break;
            }
        }
        session()->flash('done', true);
        return redirect()->back();
    }

    public function redirect($url, $statusCode = 303)
    {
       header('Location: ' . $url, true, $statusCode);
       die();
    }
}
