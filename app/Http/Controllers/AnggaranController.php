<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Http\Requests;
use App\Models\Anggaran;
use App\Models\ListAnggaran;
use App\Models\FileListAnggaran;
use App\Models\Kegiatan;
use App\Models\SubPos;
use App\Models\ItemMaster;
use App\Models\ItemMasterAnggaran;
use App\Models\NilaiMataAnggaran;
use App\Models\ItemAnggaranMaster;
use App\Models\BatasAnggaran;
use App\Models\Divisi;
use App\Models\KantorCabang;
use App\Models\StagingAnggaran;
use App\Models\pil_kcanggaranheader;
use App\Models\pil_kcanggaranlines;
use App\Models\Notification;
use App\Services\FileUpload;
use App\Services\NotificationSystem;
use Validator;
use PDF;
/**
*
*-------Status Data :----------
*1 = "Tambah"
*2 = "Edit"
*3 = "Kirim"
*4 = "Setuju"
*5 = "Tolak"
*
*-------Status Anggaran :----------
*1 = "Draft"
*2 = "Transfer"
*3 = "Complete"
*
*-------LVL Persetujuan :----------
*-1 = ""
*0 = "Kirim" -> Tidak Ada
*1 = "Persetujuan Ka Unit Kerja"  -> "Kirim"
*2 = "Persetujuan Kadiv Renbang"
*3 = "Persetujuan Direksi"
*4 = "Persetujuan Dekom"
*5 = "Persetujuan Ratek"
*6 = "Persetujuan RUPS"
*7 = "Persetujuan FinRUPS"
*8 = "Persetujuan Risalah RUPS"
*9 = "Disetujui dan Ditandatangani"
*
*/

class AnggaranController extends Controller
{
    protected $kegiatanModel;
    protected $divisiModel;
    protected $kanCabModel;
    protected $userCabang ;
    protected $userDivisi ;
    protected $anggaranModel ;
    protected $listAnggaranModel ;
    protected $fileListAnggaranModel ;


    public function __construct(
       Kegiatan $kegiatan, Divisi $divisi, 
       KantorCabang $kanCab, Anggaran $anggaran, 
       ListAnggaran $listAnggaran, FileListAnggaran $fileListAnggaran )
    {
        $this->kanCabModel = $kanCab;
        $this->divisiModel = $divisi;
        $this->kegiatanModel = $kegiatan;
        $this->anggaranModel = $anggaran;
        $this->listAnggaranModel = $listAnggaran;
        $this->fileListAnggaranModel = $fileListAnggaran;
        $this->userCabang = \Auth::user()->cabang;
        $this->userDivisi = \Auth::user()->divisi;
        

        $this->middleware('can:info_a', ['only' => 'index']);
        $this->middleware('can:batas_a', ['only' => 'batas']);
        $this->middleware('can:tambah_a', ['only' => 'tambah_anggaran']);
        $this->middleware('can:cari_a', ['only' => 'cari', 'getFilteredAnggaran']);
        $this->middleware('can:riwayat_a', ['only' => 'riwayat','getFilteredHistory']);
    }
    public function index() 
    {

        $filter = null;
        $query="SELECT * 
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_DIVISI] 
                    WHERE VALUE!='00') AS A 
                    UNION ALL 
                    SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  
                    WHERE VALUE!='00') AS B";
        $unit_kerja = \DB::select($query);
        return view('anggaran.informasi', [
            'title' => 'Informasi Kegiatan dan Anggaran',
            'unit_kerja' =>$unit_kerja,
            'nd_surat' => '',
            'filters' =>$filter]);
    }

    public function semua_anggaran()
    {
        
        $a = null;
       
        return view('anggaran.semualist', compact('a'));
    }

    public function cari_semua_anggaran(Request $request)
    {
        $persetujuan=$request->persetujuan;
        $tahun=$request->tahun;
        $query="SELECT * 
                FROM [DBCabang].[dbo].[anggaran] 
                where DATEPART(YEAR, tanggal) = ".$tahun."
                and persetujuan= ".$persetujuan."
                and active=1";

        $a = \DB::select($query);
       
        return view('anggaran.semualist', compact('a'));
    }
    public function verifikasi_semua_anggaran(Request $request)
    {   
        if(isset($request->terima)){
            $id=$request->id;
            $jumlah_id = count($id);
            for($x=0;$x<$jumlah_id;$x++){
                if($request->cek[$x]=='y'){
                    $tasks = Anggaran::find($request->id[$x]);
                    $newTask = $tasks->replicate();
                    $newTask->save();
                    $newID = $newTask->id;
                    $tasks->update(['active'=>'0']);
                    $ubahlist=ListAnggaran::where('id_list_anggaran',$tasks->id)->get();
                    foreach ($ubahlist as $list) {
                        $listbaru=$list->replicate();
                        $listbaru->save();
                        $idlistbaru=$listbaru->id;
                        $list->update(['active'=>'0']);
                        $datalistbaru=ListAnggaran::where('id',$listbaru->id)->first();
                        $datalistbaru->update(['id_list_anggaran'=>$newID]);
                        // $list->update(['id_list_anggaran'=>$newID]);
                    }
                    if($newTask->persetujuan == 2){
                        Anggaran::where('id',$newID)->update(['persetujuan'=>$newTask->persetujuan+1]);
                        NotificationSystem::send($newID, 19);
                    }
                    else if($newTask->persetujuan == 3){
                        Anggaran::where('id',$newID)->update(['persetujuan'=>$newTask->persetujuan+1]);
                        NotificationSystem::send($newID, 21);
                    }
                    else if($newTask->persetujuan == 4){
                        Anggaran::where('id',$newID)->update(['persetujuan'=>$newTask->persetujuan+1]);
                        NotificationSystem::send($newID, 23);
                    }
                    else if($newTask->persetujuan == 5){
                        Anggaran::where('id',$newID)->update(['persetujuan'=>$newTask->persetujuan+1]);
                        NotificationSystem::send($newID, 25);
                    }
                    else if($newTask->persetujuan == 6){
                        Anggaran::where('id',$newID)->update(['persetujuan'=>$newTask->persetujuan+1]);
                        NotificationSystem::send($newID, 27);
                    }
                    else if($newTask->persetujuan == 7){
                        Anggaran::where('id',$newID)->update(['persetujuan'=>$newTask->persetujuan+1]);
                        NotificationSystem::send($newID, 29);
                    }
                    else if($newTask->persetujuan == 8){
                        Anggaran::where('id',$newID)->update(['status_anggaran'=>3,'persetujuan'=>$newTask->persetujuan+1]);
                        NotificationSystem::send($newID, 31);
                        pil_kcanggaranheader::create(['RECID'=>$newID,'PIL_TRANSID'=>'AC-'.$newID,'PIL_TRANSDATE'=>$newTask->tanggal,'DATAAREAID'=>'asbr']);
                        $lines=ListAnggaran::where('id_list_anggaran',$newID)->get();
                            foreach ($lines as $line) {
                                $unit = explode(' Cabang ',$line->unit_kerja);
                                if(count($unit)>1){
                                    $cabang = KantorCabang::where('DESCRIPTION',$line->unit_kerja)->first()->VALUE;
                                    $divisi = '00';
                                }else{
                                    $divisi = Divisi::where('DESCRIPTION',$line->unit_kerja)->first()->VALUE;
                                    $cabang = '00';
                                }
                                $jenis = ItemAnggaranMaster::where('name',$line->jenis)
                                                            ->where('type','1')->first()->kode;
                                $kelompok = ItemAnggaranMaster::where('name',$line->kelompok)
                                                            ->where('type','2')->first()->kode;
                                $pos_anggaran = ItemAnggaranMaster::where('name',$line->pos_anggaran)
                                                            ->where('type','3')->first()->kode;
                                $sub_pos = SubPos::where('DESCRIPTION',$line->sub_pos)
                                                            ->first()->VALUE;
                                $mata_anggaran = Kegiatan::where('DESCRIPTION',$line->mata_anggaran)
                                                            ->first()->VALUE;
                                $account = ItemMasterAnggaran::where('jenis',$jenis)->where('kelompok',$kelompok)
                                                            ->where('pos_anggaran',$pos_anggaran)->where('sub_pos',$sub_pos)
                                                            ->where('mata_anggaran',$mata_anggaran)->first()->account;
                                if($line->TWI > 0){
                                $year = explode("-", $line->created_at);
                                $amount = $line->TWI;
                                $transdate = ((int)$year[0]+1).'-01-01';
                                $input = [
                                        'DATAAREAID'            => 'asbr',
                                        'RECID'                 => $line->id.'1',
                                        'PIL_ACCOUNT'           => $account,
                                        'PIL_PROGRAM'           => 'THT',
                                        'PIL_TRANSDATE'         => $transdate,
                                        'PIL_KPKC'              => $cabang,
                                        'PIL_DIVISI'            => $divisi,
                                        'PIL_SUBPOS'            => $sub_pos,
                                        'PIL_MATAANGGARAN'      => $mata_anggaran,
                                        'PIL_TXT'               => $line->mata_anggaran,
                                        'PIL_AMOUNT'            => $amount,
                                        'PIL_TRANSID'           => 'AC-'.$line->id_list_anggaran
                                        ];
                                pil_kcanggaranlines::create($input);
                                }
                                //2
                                if($line->TWII > 0){
                                $year = explode("-", $line->created_at);
                                $amount = $line->TWII;
                                $transdate = ((int)$year[0]+1).'-04-01';
                                $input = [
                                        'DATAAREAID'            => 'asbr',
                                        'RECID'                 => $line->id.'2',
                                        'PIL_ACCOUNT'           => $account,
                                        'PIL_PROGRAM'           => 'THT',
                                        'PIL_TRANSDATE'         => $transdate,
                                        'PIL_KPKC'              => $cabang,
                                        'PIL_DIVISI'            => $divisi,
                                        'PIL_SUBPOS'            => $sub_pos,
                                        'PIL_MATAANGGARAN'      => $mata_anggaran,
                                        'PIL_TXT'               => $line->mata_anggaran,
                                        'PIL_AMOUNT'            => $amount,
                                        'PIL_TRANSID'           => 'AC-'.$line->id_list_anggaran
                                        ];
                                pil_kcanggaranlines::create($input);
                                }
                                //3
                                if($line->TWIII > 0){
                                $year = explode("-", $line->created_at);
                                $amount = $line->TWIII;
                                $transdate = ((int)$year[0]+1).'-07-01';
                                $input = [
                                        'DATAAREAID'            => 'asbr',
                                        'RECID'                 => $line->id.'3',
                                        'PIL_ACCOUNT'           => $account,
                                        'PIL_PROGRAM'           => 'THT',
                                        'PIL_TRANSDATE'         => $transdate,
                                        'PIL_KPKC'              => $cabang,
                                        'PIL_DIVISI'            => $divisi,
                                        'PIL_SUBPOS'            => $sub_pos,
                                        'PIL_MATAANGGARAN'      => $mata_anggaran,
                                        'PIL_TXT'               => $line->mata_anggaran,
                                        'PIL_AMOUNT'            => $amount,
                                        'PIL_TRANSID'           => 'AC-'.$line->id_list_anggaran
                                        ];
                                pil_kcanggaranlines::create($input);
                                }
                                //4
                                if($line->TWIV > 0){
                                $year = explode("-", $line->created_at);
                                $amount = $line->TWIV;
                                $transdate = ((int)$year[0]+1).'-10-01';
                                $input = [
                                        'DATAAREAID'            => 'asbr',
                                        'RECID'                 => $line->id.'4',
                                        'PIL_ACCOUNT'           => $account,
                                        'PIL_PROGRAM'           => 'THT',
                                        'PIL_TRANSDATE'         => $transdate,
                                        'PIL_KPKC'              => $cabang,
                                        'PIL_DIVISI'            => $divisi,
                                        'PIL_SUBPOS'            => $sub_pos,
                                        'PIL_MATAANGGARAN'      => $mata_anggaran,
                                        'PIL_TXT'               => $line->mata_anggaran,
                                        'PIL_AMOUNT'            => $amount,
                                        'PIL_TRANSID'           => 'AC-'.$line->id_list_anggaran
                                        ];
                                pil_kcanggaranlines::create($input);
                                }
                            }
                    }
                }  
            }
            $after_save = [
             'alert' => 'success',
             'title' => 'Data berhasil diterima.'
            ];
            return redirect()->back()->with('after_save', $after_save);
        }
        else{
            $id=$request->id;
            $jumlah_id = count($id);
            for($x=0;$x<$jumlah_id;$x++){
                if($request->cek[$x]=='y'){
                    $tasks = Anggaran::where('id', $request->id[$x])->first();
                    // print_r($tasks);
                    // $newTask = $tasks->replicate();
                    // $newTask->save();
                    // $newID = $newTask->id;
                    // $tasks->update(['active'=>'0']);
                    // print_r($tasks);
                    if($tasks->persetujuan == 2){
                        Anggaran::where('id',$tasks->id)->update(['persetujuan'=>'1']);
                        NotificationSystem::send($tasks->id, 18);
                    }
                    else if($tasks->persetujuan == 3){
                        Anggaran::where('id',$tasks->id)->update(['persetujuan'=>2]);
                        NotificationSystem::send($tasks->id, 20);
                    }
                    else if($tasks->persetujuan == 4){
                        Anggaran::where('id',$tasks->id)->update(['persetujuan'=>2]);
                        NotificationSystem::send($tasks->id, 22);
                    }
                    else if($tasks->persetujuan == 5){
                        Anggaran::where('id',$tasks->id)->update(['persetujuan'=>2]);
                        NotificationSystem::send($tasks->id, 24);
                    }
                    else if($tasks->persetujuan == 6){
                        Anggaran::where('id',$tasks->id)->update(['persetujuan'=>2]);
                        NotificationSystem::send($tasks->id, 26);
                    }
                    else if($tasks->persetujuan == 7){
                        Anggaran::where('id',$tasks->id)->update(['persetujuan'=>2]);
                        NotificationSystem::send($tasks->id, 28);
                    }
                    else if($tasks->persetujuan == 8){
                        Anggaran::where('id',$tasks->id)->update(['persetujuan'=>2]);
                        NotificationSystem::send($tasks->id, 30);
                    }
                }  
            }
            $after_save = [
             'alert' => 'success',
             'title' => 'Data berhasil ditolak.'
            ];
            return redirect()->back()->with('after_save', $after_save);
        }
    }
    

    public function batas()
    {
        
        $query="SELECT * 
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_DIVISI] 
                    WHERE VALUE!='00') AS A 
                    UNION ALL 
                    SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  
                    WHERE VALUE!='00') AS B";
        $unit_kerja = \DB::select($query);

        $batas_anggaran = BatasAnggaran::get();

        foreach ($batas_anggaran as $batas) {
            $date_now = date("Y-m-d");
            $date = $batas ->tanggal_selesai;
            $diff = strtotime($date) - strtotime($date_now);
            if($diff <= 0){
                BatasAnggaran::where('id',$batas->id)->update(['active'=>'0']);
            }
        }

        return view('anggaran.batas',[
            'unit_kerja' => $unit_kerja,
            'reject_reasons'=>null, 
            'batas_anggaran'=>BatasAnggaran::get()
            ]);
    }

    public function add_pengajuan(Request $request){
        $date_now = date("Y-m-d");
        $input = $request->except('_method', '_token');
        $batas = BatasAnggaran::where('unit_kerja',$input['unit_kerja']);
        $count = 0;
        foreach ($batas->get() as $bts) {
            $count++;
        }
        $condition = false;
        if($count >= 1){
            $date = $batas->first()->tanggal_mulai;
            $condition = date('Y', strtotime($date)) != date('Y', strtotime($date_now));
            if($condition){
                unset($input['unit_kerja']);
            }
        }

        $validator = $this->validateBatas($input);

        if ($validator->passes()) {
            if($condition){
                $input['unit_kerja'] = $request->unit_kerja;
                BatasAnggaran::where('unit_kerja',$input['unit_kerja'])->update(['tanggal_mulai'=>$input['tanggal_mulai'],'tanggal_selesai'=>$input['tanggal_selesai'],'active'=>'1']);
            }else{
                $input['active']= '1';
                $z=BatasAnggaran::create($input);
                $id=$z->id;
                NotificationSystem::send($id, 47);
            }
            session()->flash('success', 'Waktu Pengajuan Anggaran dan Kegiatan Untuk '.$input['unit_kerja']." telah ditambah");
            return redirect()->back();
        }

        return redirect()->back()->withInput()->withErrors($validator);

    }

    public function change_pengajuan(Request $request, $id){
        $input = $request->except('_method', '_token');
        if(!isset($input['tanggal_mulai'])){
            unset($input['tanggal_mulai']);
        }
        $validator = $this->validateBatas($input);

        if ($validator->passes()) {
            $batas = BatasAnggaran::where('id',$id)->first();
            if(!isset($input['tanggal_mulai'])){
                BatasAnggaran::where('id',$id)->update(['tanggal_selesai'=>$input['tanggal_selesai'],'active'=>'1']);
            }else{
                BatasAnggaran::where('id',$id)->update(['tanggal_mulai'=>$input['tanggal_mulai'],'tanggal_selesai'=>$input['tanggal_selesai'],'active'=>'1']);
            }
            Notification::where('batch_id', $id)->update(['is_read'=>'0']);
            // BatasAnggaran::where('id',$id)->update(['tanggal_mulai'=>$input['tanggal_mulai'],'tanggal_selesai'=>$input['tanggal_selesai'],'active'=>'1']);
            session()->flash('success', 'Waktu Pengajuan Anggaran dan Kegiatan Untuk '.$batas->unit_kerja." telah diubah");

            return redirect()->back();
        }
        return redirect()->back()->withInput()->withErrors($validator);
    }

    public function validateBatas($input, $id = null)
    {
        return Validator::make($input, 
            [
                'tanggal_mulai'  => 'sometimes|required',
                'tanggal_selesai'  => 'required',
                'unit_kerja'    => 'unique:batas_anggaran,unit_kerja,'.$id
            ],[
                'tanggal_mulai.required' => 'Tanggal Mulai Harap Di isi.',
                'tanggal_selesai.required' => 'Tanggal Selesai Harap Di isi.',
                'unit_kerja.unique'   => 'Batas Pengajuan Unit Kerja Sudah terdapat di Database Sistem. Silahkan ubah pengajuan yang telah tersedia'
            ]);
    }

    public function cari(Request $request) 
    {

        $filter = null;
        if(isset($request->cari_nd_surat)){
            $filter = array('nd_surat' => $request->cari_nd_surat,
                    'status_anggaran' =>$request->cari_stat_anggaran,
                    'unit_kerja' =>$request->cari_unit_kerja
                );
        }
        $query="SELECT * 
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_DIVISI] 
                    WHERE VALUE!='00') AS A 
                    UNION ALL 
                    SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  
                    WHERE VALUE!='00') AS B";
        $unit_kerja = \DB::select($query);
        return view('anggaran.informasi', [
            'title' => 'Informasi Kegiatan dan Anggaran',
            'unit_kerja' =>$unit_kerja,
            'nd_surat' => '',
            'filters' =>$filter]);

        // echo $request->cari_stat_anggaran;
    }

    public function tambah_anggaran() 
    {
        $editable = true;
        $displayEdit = 'none';
        $displaySave = 'block';
        $displaySend = 'block';
        $batasAnggaran = BatasAnggaran::orderBy('id', 'ASC')->get();
        $userUnit = "";
        if($this->userCabang != "00"){
            $cabang = KantorCabang::where('VALUE',$this->userCabang)->get();
            foreach ($cabang as $cab ) {
                $userUnit =  $cab->DESCRIPTION;
            } 
        }else if($this->userDivisi != "00"){
            $divisi = Divisi::where('VALUE',$this->userDivisi)->get();
            foreach ($divisi as $div ) {
                $userUnit = $div->DESCRIPTION;
            } 
        }

        $date_now = date("Y-m-d");
        $date_selesai;
        $date_mulai;

        if(count ($batasAnggaran)==0){
            session()->flash('batas', 'Batas Pengajuan Anggaran dan Kegiatan Belum diisi oleh Renbang');
            return redirect()->back();
        }
        foreach ($batasAnggaran as $batas) {
            
            if($batas->unit_kerja == "Semua Unit Kerja"||$userUnit == $batas->unit_kerja){
                $date_mulai = $batas->tanggal_mulai;
                $date_selesai = $batas->tanggal_selesai;
            }


        }


        $diff1 = strtotime($date_now) - strtotime($date_mulai);
        $diff2 = strtotime($date_selesai) - strtotime($date_now);
        $mulai=false;
        $batas=$date_selesai;

        if($diff2 < 0){
            $beda = false;
        }else{
            // $beda = true;
            if($diff1 < 0){
                $mulai=true;
                $batas= $date_mulai;
                $beda = false;
            }else{
                $beda = true;
            }
        }

        // echo $date_mulai.":".$diff1;
        // echo $beda?1:0;

        return view('anggaran.index', [
            'title' => 'Tambah Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => '',
            'beda' => $beda ,
            'batas' =>$batas,
            'mulai' =>$mulai,
            'status' => 'tambah',
            'persetujuan'=>-1,
            'reject' => false,
            'filters' =>null,
            'display' => array('edit' => $displayEdit,
                    'save' => $displaySave,
                    'send' => $displaySend)]);
    }

    public function edit_anggaran($nd_surat) 
    {   
        $editable = false;
        $displayEdit = 'none';
        $displaySave = 'none';
        $displaySend = 'none';
        $userUnit = "";

        $batasAnggaran = BatasAnggaran::orderBy('id', 'ASC')->get();

        if($this->userCabang != "00"){
            $cabang = KantorCabang::where('VALUE',$this->userCabang)->get();
            foreach ($cabang as $cab ) {
                $userUnit =  $cab->DESCRIPTION;
            } 
        }else if($this->userDivisi != "00"){
            $divisi = Divisi::where('VALUE',$this->userDivisi)->get();
            foreach ($divisi as $div ) {
                $userUnit = $div->DESCRIPTION;
            } 
        }
        $anggaran = $this->anggaranModel->where('nd_surat', $nd_surat)->where('active', '1')->orderBy('id', 'DESC')->get();
        $unit = "";
        $persetujuan = "";
        foreach ($anggaran as $angg) {
            $unit = $angg->unit_kerja;
            $persetujuan = $angg->persetujuan;
        }
        $date_now = date("Y-m-d");
        $date_mulai;
        $date_selesai;
        foreach ($batasAnggaran as $batas) {
            
            if($batas->unit_kerja == "Semua Unit Kerja"||$unit == $batas->unit_kerja){
                $date_mulai = $batas->tanggal_mulai;
                $date_selesai = $batas->tanggal_selesai;
            }
        }

        $diff1 = strtotime($date_now) - strtotime($date_mulai);
        $diff2 = strtotime($date_selesai) - strtotime($date_now);
        $beda = false;
        $mulai= false;
        $batas=$date_selesai;
        if($userUnit == $unit||Gate::check('setuju_iia')){
            $beda = true;
            if($diff2 <= 0){
                $beda = false;
            }

            if($diff1 < 0){
                $mulai=true;
                $batas= $date_mulai;
                $beda = false;
            }
        }

        if($persetujuan != "-1"&&$persetujuan!='1'){
            $beda = false;
        }

        if(Gate::check('tambah_item_a')||Gate::check('ubah_item_a')||Gate::check('hapus_item_a')){
            $displayEdit = 'none';
            $displaySave = 'block';
        }

        if(Gate::check('kirim_a')){
            $displayEdit = 'none';
            $displaySend = 'block';
        }

        // echo $beda?1:0;
        return view('anggaran.index', [
            'title' => 'Ubah Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => $nd_surat,
            'beda' => $beda , 
            'batas' =>$batas,
            'mulai' =>$mulai,
            'status' => 'edit',
            'reject' => false,
            'persetujuan'=>$persetujuan,
            'filters' => array('nd_surat' => $nd_surat),
            'display' => array('edit' => $displayEdit,
                    'save' => $displaySave,
                    'send' => $displaySend)]);
    }

    public function persetujuan_anggaran($nd_surat,$status) 
    {
        $editable = false;
        $reject = false;
        if($status == '2'||$status == '3'){
            $editable = true;
            if($status == '3'){
                $reject = true;
            }

        }

        $userUnit = "";
        if($this->userCabang != "00"){
            $cabang = KantorCabang::where('VALUE',$this->userCabang)->get();
            foreach ($cabang as $cab ) {
                $userUnit =  $cab->DESCRIPTION;
            } 
        }else if($this->userDivisi != "00"){
            $divisi = Divisi::where('VALUE',$this->userDivisi)->get();
            foreach ($divisi as $div ) {
                $userUnit = $div->DESCRIPTION;
            } 
        }
        $anggaran = $this->anggaranModel->where('nd_surat', $nd_surat)->where('active', '1')->orderBy('id', 'DESC')->get();
        $unit = "";
        $persetujuan = "";
        foreach ($anggaran as $angg) {
            $unit = $angg->unit_kerja;
            $persetujuan = $angg->persetujuan;
        }

        $beda = false;

        //  *Hapus Persetujuan Kanit Kerja*
        // if($persetujuan == "0"){
        //     if(Gate::check('setuju_ia')&&($userUnit == $unit))
        //         $beda = true;
        // }else 
        if($persetujuan == "1"&&Gate::check('setuju_iia')){
            if($status == '2'||$status == '3'){
                $beda = true;
                if($status == '3'){
                    $reject = true;
                }

            }
        }else if($persetujuan == "2"&&Gate::check('setuju_iiia')){
                $beda = true;
        }else if($persetujuan == "3"&&Gate::check('setuju_iva')){
                $beda = true;
        }else if($persetujuan == "4"&&Gate::check('setuju_va')){
                $beda = true;
        }else if($persetujuan == "5"&&Gate::check('setuju_via')){
                $beda = true;
        }else if($persetujuan == "6"&&Gate::check('setuju_viia')){
                $beda = true;
        }else if($persetujuan == "7"&&Gate::check('setuju_viiia')){
                $beda = true;
        }else{

                // echo "renbang";
        }

        // echo $status;
        return view('anggaran.index', [
            'title' => 'Persetujuan Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => $nd_surat,
            'beda' => $beda , 
            'batas' =>null,
            'mulai' =>false,
            'status' => 'setuju',
            'reject' => $reject,
            'persetujuan'=>$persetujuan,
            'filters' => array('nd_surat' => $nd_surat),
            'display' => array('edit' => "none",
                    'save' => "none",
                    'send' => "none",)]);

    }
    public function riwayat(Request $request ) 
    {
        $query="SELECT * 
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_DIVISI] 
                    WHERE VALUE!='00') AS A 
                    UNION ALL 
                    SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  
                    WHERE VALUE!='00') AS B";
        $unit_kerja = \DB::select($query);
        $filter = null;
        $keyword = $request->cari_keyword;
        if($request->cari_keyword == ""){
            $keyword = "-";
        }
        if(isset($request->cari_tahun)){
            $filter = array('tahun' => $request->cari_tahun,
                    'unit_kerja' =>$request->cari_unit_kerja,
                    'nd_surat' =>$request->cari_nd_surat,
                    'kategori' =>$request->cari_kategori,
                    'keyword' =>$keyword,
                );
        }

        return view('anggaran.history', [
            'title' => 'Riwayat Kegiatan dan Anggaran',
            'userCabang'    =>$this->userCabang,
            'userDivisi'    =>$this->userDivisi,
            'unit_kerja'    => $unit_kerja,
            'filters'       => $filter]);
    }

    public function store(Request $request)
    {
        
             
        $anggaran_insert = $anggaran_update = [];
        $anggaran_insert_list = $anggaran_update_list = [];
        $anggaran_insert_file_list  = $anggaran_insert_file_list = [];
        $status = "";
        $setuju = "";
        // $setujuNext = "";
        $keterangan = $request->setuju;

        switch($request->persetujuan){
          case ""                               : $setuju="-1";break;
          // case "Kirim"                          : $setuju="0";break;*Hapus Kanit Kerja*
          // case "Persetujuan Ka Unit Kerja"      : $setuju="1";break;
          case "Persetujuan Ka Unit Kerja"      : $setuju="1";break;
          case "Persetujuan Kadiv Renbang"      : $setuju="2";break;
          case "Persetujuan Direksi"            : $setuju="3";break;
          case "Persetujuan Dekom"              : $setuju="4";break;
          case "Persetujuan Ratek"              : $setuju="5";break;
          case "Persetujuan RUPS"               : $setuju="6";break;
          case "Persetujuan FinRUPS"            : $setuju="7";break;
          case "Persetujuan Risalah RUPS"       : $setuju="8";break;
          case "Telah disetujui"                : $setuju="9";break;
        }

        switch($request->stat_anggaran){
          case "Draft"      : $status="1";break;
          case "Transfer"   : $status="2";break;
          case "Complete"   : $status="3";break;
        }

        if($request->setuju =='Kirim'||$request->setuju =='Setuju'){
            $status = "2";
            // *Seleksi KEtika -1(Unit Kerja) maka Kirim Ke Renbang*
            if($setuju == -1){
                $setuju = 1 ;
            }else{
                $setuju = (int)$setuju+1;
            }

            if($setuju == 2){
                $status = "1";
            }else if($setuju == 8){
                $status = "3";
            }
        }else if($request->setuju =='Simpan'){
            $status = "1";
        }else if($request->setuju =='Tolak'){
            $status = "1";
            if($setuju == "1"||$setuju == "0"){
                $setuju="-1";
            }else if($setuju != "3"||$setuju == "3"){
                $setuju="1";
            }

            if(isset($request->alasan_penolakan)){
                $keterangan = $request->alasan_penolakan;
            }
        }
        if($request->setuju != 'Simpan' || $request->status == 'tambah'){
            // $surat=$request->nd_surat;
            // $db = DB::table('anggaran')->where('nd_surat', $surat)->get();
            //     if($db){
            //         $after_save = [
            //          'alert' => 'danger',
            //          'title' => 'Data gagal ditambah, Nomor ND Surat sudah ada.'
            //          ];
            //          return redirect()->back()->with('after_save', $after_save);
            //      }
            
            $tambahtanggal=date("Y-m-d", strtotime($request->tanggal));
            $anggaran_insert = [
            'tanggal'           => $tambahtanggal,
            'nd_surat'          => $request->nd_surat,
            'unit_kerja'        => $request->unit_kerja,
            'tipe_anggaran'     => $request->tipe_anggaran,
            'status_anggaran'   => $status,
            'persetujuan'       => $setuju,
            'keterangan'        => $keterangan,
            'active'            => '1'];
            
        }
        
        $active = '0';
        if($request->setuju == 'Simpan'){
            $active = '1';
        }
        $ubahtanggal=date("Y-m-d", strtotime($request->tanggal));
        $anggaran_update = [
        'tanggal'           => $ubahtanggal,
        'tipe_anggaran'     => $request->tipe_anggaran,
        'status_anggaran'   => $status,
        'persetujuan'       => $setuju,
        'active'            => $active,
        'keterangan'        => $keterangan,
        'updated_at'        => \Carbon\Carbon::now()];
        $anggaranId;
        $AnggaranData;
        if($request->status == 'tambah'){
            $AnggaranData=Anggaran::create($anggaran_insert);
        }else if($request->setuju == 'Simpan'){
            Anggaran::where('nd_surat', $request->nd_surat)->where('active', '1')->update($anggaran_update);
        }else{
            Anggaran::where('nd_surat', $request->nd_surat)->where('active', '1')->update($anggaran_update);
            $AnggaranData=Anggaran::create($anggaran_insert);
        }
        Anggaran::where('nd_surat', $request->nd_surat)->where('active', '1')->where('persetujuan', 8)->update(['persetujuan'=>9]);
        $index = 0;
        //list_anggaran_download
        foreach (json_decode($request->list_anggaran_values) as $value) {
            $idBefore = '0';
            $anggaranId = $request->id_anggaran;

            if(($request->setuju == 'Kirim'||$request->setuju == 'Setuju')||$request->setuju == 'Tolak'){

                $anggaranId = $AnggaranData->id;
                if($value->id_first == '0'){
                    if($value->id != "-1"){
                        $idBefore = $value->id;
                    }
                }else{
                    $idBefore = $value->id_first;
                }
            }

            if($anggaranId == "" && $request->status == 'tambah'){
                $anggaranId = $AnggaranData->id;
            }
            if($request->setuju != 'Simpan' || ($request->setuju == 'Simpan' && $value->id == -1)){
                // echo "baru";
                $anggaran_insert_list = [
                // 'id'            => $value->id,
                'jenis'             => $value->jenis,
                'kelompok'          => $value->kelompok,
                'pos_anggaran'      => $value->pos_anggaran,
                'sub_pos'           => $value->sub_pos,
                'mata_anggaran'     => $value->mata_anggaran,
                'item'              => "",
                'kuantitas'         => (int)$value->kuantitas,
                'satuan'            => $value->satuan,
                'nilai_persatuan'   => (double)$value->nilai_persatuan,
                'terpusat'          => $value->terpusat,
                'unit_kerja'        => $value->unit_kerja,
                'TWI'               => (double)$value->tw_i,
                'TWII'              => (double)$value->tw_ii,
                'TWIII'             => (double)$value->tw_iii,
                'TWIV'              => (double)$value->tw_iv,
                'anggaran_setahun'  => (double)$value->anggarana_setahun,
                'id_first'          => $idBefore,
                'id_list_anggaran'  => $anggaranId,
                'active'            => '1'
                ];
            }

            $active_list = '0';
            if($request->setuju == 'Simpan'){
                $active_list = '1';
            }

            $anggaran_update_list = [
                'jenis'             => $value->jenis,
                'kelompok'          => $value->kelompok,
                'pos_anggaran'      => $value->pos_anggaran,
                'sub_pos'           => $value->sub_pos,
                'mata_anggaran'     => $value->mata_anggaran,
                'item'              => "",
                'kuantitas'         => (int)$value->kuantitas,
                'satuan'            => $value->satuan,
                'nilai_persatuan'   => (double)$value->nilai_persatuan,
                'terpusat'          => $value->terpusat,
                'unit_kerja'        => $value->unit_kerja,
                'TWI'               => (double)$value->tw_i,
                'TWII'              => (double)$value->tw_ii,
                'TWIII'             => (double)$value->tw_iii,
                'TWIV'              => (double)$value->tw_iv,
                'anggaran_setahun'  => (double)$value->anggarana_setahun,
                'active'            => $active_list,
                'updated_at'        => \Carbon\Carbon::now()
                ];

            $LAnggaranInsert;
            $LAnggaranUpdate;
            if($value->delete == "none"){
                if($request->status == 'tambah'){
                    // echo $active_list;
                    $LAnggaranInsert  = ListAnggaran::create($anggaran_insert_list);
                }else if($request->setuju == 'Simpan'){
                    // echo $active_list;
                    if($value->id == -1){
                        $LAnggaranInsert  = ListAnggaran::create($anggaran_insert_list);
                    }else{
                        $LAnggaranUpdate  = ListAnggaran::where('id', $value->id)->where('active', '1')->update($anggaran_update_list);
                    }
                }else{
                    // echo $active_list;
                    $LAnggaranInsert  = ListAnggaran::create($anggaran_insert_list);
                    $LAnggaranUpdate  = ListAnggaran::where('id', $value->id)->where('active', '1')->update($anggaran_update_list);
                }
            }else if($value->delete == "delete"){
                if($value->id != -1){
                    ListAnggaran::where('id', $value->id)->delete();
                    FileListAnggaran::where('id_list_anggaran', $value->id)->update(["active" =>'0']);
                }
            }

            if($request->status == 'tambah'||($request->setuju == 'Simpan')){
                $index2 = 0;
                $id_list_anggaran=0;
                if($request->setuju == 'Simpan'){ 

                    if($value->id_first== 0){
                        $id_list_anggaran = $value->id;

                        
                        if($value->id == -1){
                            $id_list_anggaran = $LAnggaranInsert->id;
                        }

                         
                    }else{
                        $id_list_anggaran = $value->id_first;
                         // echo $value->id_first;
                    }  
                }else if($request->status == 'tambah'){
                    $id_list_anggaran = $LAnggaranInsert->id;
                }

               

                if($value->delete == "none"){
                    if(isset($_POST['count_file_'.$index])){
                        for($i=0;$i<$_POST['count_file_'.$index];$i++){
                            $data = $_POST['file_'.$index."_".$index2];
                            if($data!="null"){
                                // echo $index."_".$index2."<br />";
                                $file_name = $_POST['file_name_'.$index."_".$index2];
                                $file_type = $_POST['file_type_'.$index."_".$index2];
                                $file_size = $_POST['file_size_'.$index."_".$index2];
                                $base64 = explode(";base64,", $data);
                                $store_file_list_values = [
                                    'id_list_anggaran' => $id_list_anggaran,
                                    'name'            => $file_name,
                                    'type'           => $file_type,
                                    'size'           => $file_size,
                                    'data'           => $base64[1],
                                    'active'         => '1',
                                    'created_at'    => \Carbon\Carbon::now(),
                                    'updated_at'    => \Carbon\Carbon::now()];

                                FileListAnggaran::insert($store_file_list_values);
                                $index2++;
                            }
                        }
                    }

                    if (is_array($value->file) || is_object($value->file)){
                        foreach ($value->file as $list_file) {
                            if($list_file->delete == "delete"){
                                $file_update = [
                                        'active'         => '0',
                                        'updated_at'    => \Carbon\Carbon::now()];
                                FileListAnggaran::where('id', $list_file->id)->update($file_update);
                            }
                        }
                    }
                    
                }
            }
            $index++;

        }

        $status_view = redirect('anggaran/edit/'.$request->nd_surat); 
        // echo $setuju;
        if($request->setuju=='Kirim'||$request->setuju=='Setuju'){
            // *Hapus Notifikasi Ke Kanit Kerja*
            // if($setuju == 0)
            //     NotificationSystem::send($anggaranId, 15);
            // else 
            if($setuju == 1)
                NotificationSystem::send($anggaranId, 17);
            else if($setuju == 2)
                NotificationSystem::send($anggaranId, 19);
            else if($setuju == 3)
                NotificationSystem::send($anggaranId, 21);
            else if($setuju == 4)
                NotificationSystem::send($anggaranId, 23);
            else if($setuju == 5)
                NotificationSystem::send($anggaranId, 25);
            else if($setuju == 6)
                NotificationSystem::send($anggaranId, 27);
            else if($setuju == 7)
                NotificationSystem::send($anggaranId, 29);
            else if($setuju == 8){
                NotificationSystem::send($anggaranId, 31);
                $this->insertStaging($request->nd_surat);
            }
        }else if($request->setuju=='Tolak'){
            if($setuju == "-1"){
                if($request->persetujuan == "Persetujuan Ka Unit Kerja")
                    NotificationSystem::send($anggaranId, 18);
                // *Hapus dan Ganti Ditolak Kanit dengan Di Tolak Rembang*
                //  if($request->persetujuan == "Kirim")
                //     NotificationSystem::send($anggaranId, 16);
                // else if($request->persetujuan == "Persetujuan Kanit Kerja")
                //     NotificationSystem::send($anggaranId, 18);
            }else if($setuju == "1"){
                if($request->persetujuan == "Persetujuan Kadiv Renbang")
                    NotificationSystem::send($anggaranId, 20);
                else if($request->persetujuan == "Persetujuan Direksi")
                    NotificationSystem::send($anggaranId, 22);
                else if($request->persetujuan == "Persetujuan Dekom")
                    NotificationSystem::send($anggaranId, 24);
                else if($request->persetujuan == "Persetujuan Ratek")
                    NotificationSystem::send($anggaranId, 26);
                else if($request->persetujuan == "Persetujuan RUPS")
                    NotificationSystem::send($anggaranId, 28);
                else if($request->persetujuan == "Persetujuan FinRUPS")
                    NotificationSystem::send($anggaranId, 30);
            }

        }
        
        // if($request->persetujuan != "Kirim"&&$request->setuju){
        //     $status_view = redirect('anggaran/persetujuan/'.$request->nd_surat.'/1');
        // }
        return $status_view;
    }

    public function insertTW($list_anggaran,$type,$unit_kerja){
        $amount;
        $transdate;
        $year = explode("-", $list_anggaran->created_at);
        switch ($type) {
            case 1 :$amount = $list_anggaran->TWI;
                    $transdate = ((int)$year[0]+1).'-01-01';
                    break;
            case 2 :$amount = $list_anggaran->TWII;
                    $transdate = ((int)$year[0]+1).'-04-01';
                    break;
            case 3 :$amount = $list_anggaran->TWIII;
                    $transdate = ((int)$year[0]+1).'-07-01';
                    break;
            case 4 :$amount = $list_anggaran->TWIV;
                    $transdate = ((int)$year[0]+1).'-10-01';
                    break;
        }
        $unit = explode(' Cabang ',$unit_kerja);
        $divisi;
        $cabang;
        if(count($unit)>1){
            $cabang = KantorCabang::where('DESCRIPTION',$unit_kerja)->first()->VALUE;
            $divisi = '00';
        }else{
            $divisi = Divisi::where('DESCRIPTION',$unit_kerja)->first()->VALUE;
            $cabang = '00';
        }
        $jenis = ItemAnggaranMaster::where('name',$list_anggaran->jenis)
                                    ->where('type','1')->first()->kode;
        $kelompok = ItemAnggaranMaster::where('name',$list_anggaran->kelompok)
                                    ->where('type','2')->first()->kode;
        $pos_anggaran = ItemAnggaranMaster::where('name',$list_anggaran->pos_anggaran)
                                    ->where('type','3')->first()->kode;
        $sub_pos = SubPos::where('DESCRIPTION',$list_anggaran->sub_pos)
                                    ->first()->VALUE;
        $mata_anggaran = Kegiatan::where('DESCRIPTION',$list_anggaran->mata_anggaran)
                                    ->first()->VALUE;

        $account = ItemMasterAnggaran::where('jenis',$jenis)->where('kelompok',$kelompok)
                                    ->where('pos_anggaran',$pos_anggaran)->where('sub_pos',$sub_pos)
                                    ->where('mata_anggaran',$mata_anggaran)->first()->account;
        $input = [
                'DATAAREAID'            => 'asbr',
                'RECID'                 => $list_anggaran->id.$type,
                'PIL_ACCOUNT'           => $account,
                'PIL_PROGRAM'           => 'THT',
                'PIL_KPKC'              => $cabang,
                'PIL_DIVISI'            => $divisi,
                'PIL_SUBPOS'            => $sub_pos,
                'PIL_MATAANGGARAN'      => $mata_anggaran,
                'PIL_TRANSDATE'         => $transdate,
                'PIL_TXT'               => $list_anggaran->mata_anggaran,
                'PIL_AMOUNT'            => $amount,
                'PIL_TRANSID'           => 'AC-'.$list_anggaran->id_list_anggaran
                ];
        // return $input;
        pil_kcanggaranlines::create($input);
        // StagingAnggaran::create($input);
    }

    public function insertStaging($nd_surat)
    {
        $anggaran = $this->anggaranModel->where('nd_surat', $nd_surat)->where('active', '1')->first();
        pil_kcanggaranheader::create(['RECID'=>$anggaran->id,'PIL_TRANSID'=>'AC-'.$anggaran->id,'PIL_TRANSDATE'=>$anggaran->tanggal,'DATAAREAID'=>'asbr']);
        // foreach ($anggaran as $angga) {
            $unit_kerja = $anggaran->unit_kerja;
            $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)
                                                    ->where('active', '1')->get();
            foreach ($listAnggaran as $list_anggaran) {
                //Ini Seleksi Jika Anggaran Tidak Terpusat Disimpan Kestaging
                if($list_anggaran->terpusat != "1"){
                    if($list_anggaran->TWI > 0){
                        $this->insertTW($list_anggaran,1,$unit_kerja);
                    }
                    if($list_anggaran->TWII > 0){
                        $this->insertTW($list_anggaran,2,$unit_kerja);
                    }
                    if($list_anggaran->TWIII > 0){
                        $this->insertTW($list_anggaran,3,$unit_kerja);
                    }
                    if($list_anggaran->TWIV > 0){
                        $this->insertTW($list_anggaran,4,$unit_kerja);
                    }
                }

            }
        // }
    }

    public function getFiltered($nd_surat,$type){
        $result = [];

        if($type == "anggaran"){
            $result = $this->anggaranModel->where('nd_surat', $nd_surat)->orderBy('id', 'DESC')->take(5)->get();
            // $result = $this->anggaranModel->where('nd_surat', $nd_surat)->where('active','1')->get();

        }else if($type == "list_anggaran"){

            $Anggaran = $this->anggaranModel->where('nd_surat', $nd_surat)->where('active', '1');
            foreach ($Anggaran->get() as $anggaran) {
                $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)->where('active', '1');

                
                $countIndex=0;
                foreach ($listAnggaran->get() as $list_anggaran) {
                    $id_list_anggaran;
                    if($list_anggaran->id_first == 0){
                        $id_list_anggaran = $list_anggaran->id;
                    }else{
                        $id_list_anggaran = $list_anggaran->id_first;
                    }
                    $fileListAnggaran = $this->fileListAnggaranModel->where('active','1');
                    $fileList = [];
                    foreach ($fileListAnggaran->get() as $file_list_anggaran) {
                        if($file_list_anggaran->id_list_anggaran == $id_list_anggaran){
                            $fileList[] = [
                                'id'   => $file_list_anggaran->id,
                                'count'=> $countIndex,
                                'name' => $file_list_anggaran->name,
                                'type' => $file_list_anggaran->type,
                                'size' => $file_list_anggaran->size
                            ];
                        }
                    }

                    $result[] = [
                        'id'                => $list_anggaran->id,
                        'jenis'             => $list_anggaran->jenis,
                        'kelompok'          => $list_anggaran->kelompok,
                        'pos_anggaran'      => $list_anggaran->pos_anggaran,
                        'sub_pos'           => $list_anggaran->sub_pos,
                        'mata_anggaran'     => $list_anggaran->mata_anggaran,
                        'item'              => $list_anggaran->item,
                        'kuantitas'         => $list_anggaran->kuantitas,
                        'satuan'            => $list_anggaran->satuan,
                        'nilai_persatuan'   => (int)$list_anggaran->nilai_persatuan,
                        'terpusat'          => $list_anggaran->terpusat,
                        'unit_kerja'        => $list_anggaran->unit_kerja,
                        'tw_i'              => (int)$list_anggaran->TWI,
                        'tw_ii'             => (int)$list_anggaran->TWII,
                        'tw_iii'            => (int)$list_anggaran->TWIII,
                        'tw_iv'             => (int)$list_anggaran->TWIV,
                        'id_first'          => $list_anggaran->id_first,
                        'anggarana_setahun' => (int)$list_anggaran->anggaran_setahun,
                        'file'              => $fileList
                        
                    ];
                    $countIndex++;
                }  
            }
            
        }

        
        return response()->json($result);
    }

    public function getFilteredHistory($tahun,$nd_surat,$kategori,$keyword){
        $decode_nd_surat = urldecode($nd_surat);
        $decode_keyword = urldecode($keyword);

        $result = [];

        $query;
        if($tahun == "0"){
            $query = $this->anggaranModel->where('nd_surat', $decode_nd_surat);
            
        }else{
            $query = $this->anggaranModel->where('nd_surat', $decode_nd_surat)
                                ->whereYear('updated_at','=', $tahun);
        }

        $Anggaran = $query->where('active', '1')->orderBy('updated_at','DESC');
        
        // $Anggaran = $this->anggaranModel->where('active', '1')->orderBy('updated_at','DESC')->get();
        
        $countIndex=-1;
        foreach($Anggaran->get() as $anggaran){
            $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)->where('active', '1');
            if($decode_keyword !="-"){
                if($kategori == "semua"){
                    $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)
                                    ->where(function($qry) use($decode_keyword){
                                        $qry->where('jenis','LIKE' ,'%'.$decode_keyword.'%')
                                            ->orWhere('kelompok','LIKE' ,'%'.$decode_keyword.'%')
                                            ->orWhere('pos_anggaran','LIKE' ,'%'.$decode_keyword.'%')
                                            ->orWhere('sub_pos','LIKE' ,'%'.$decode_keyword.'%')
                                            ->orWhere('mata_anggaran','LIKE' ,'%'.$decode_keyword.'%');
                                            // ->orWhere('item','LIKE' ,'%'.$decode_keyword.'%');
                                    })->where('active', '1');
                }else{
                    $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)
                                    ->where($kategori,'LIKE' ,'%'.$decode_keyword.'%')
                                    ->where('active', '1');
                }
            }else{
                $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)
                                    ->where('active', '1');
            }

            $fileListAnggaran = $this->fileListAnggaranModel->where('active','1');
            // echo "Terbaru<br/>";
            foreach ($listAnggaran->get() as $list_anggaran) {
                $fileList = [];
                $id_list_anggaran;
                if($list_anggaran->id_first == 0){
                    $id_list_anggaran = $list_anggaran->id;
                }else{
                    $id_list_anggaran = $list_anggaran->id_first;
                }
                $countIndex++;
                foreach ($fileListAnggaran->get() as $file_list_anggaran) {
                    if($file_list_anggaran->id_list_anggaran == $id_list_anggaran){
                        // echo $countIndex;
                        $fileList[] = [
                            'id'   => $file_list_anggaran->id,
                            'count' => $countIndex,
                            'name' => $file_list_anggaran->name,
                            'type' => $file_list_anggaran->type,
                            'size' => $file_list_anggaran->size
                        ];
                    }
                }
                // echo "<br />";

                $Value=array(
                            'input_anggaran'    =>0,
                            'clearing_house'    =>0,
                            'naskah_rkap'       =>0,
                            'dewan_komisaris'   =>0,
                            'rapat_teknis'      =>0,
                            'rups'              =>0,
                            'finalisasi_rups'   =>0,
                            'risalah_rups'      =>0
                            );

                
                $AnggaranValue = $this->anggaranModel->where('nd_surat', $anggaran->nd_surat)->orderBy('id', 'DESC');
                foreach ($AnggaranValue->get() as $anggaran_value) {

                    $listAnggaranValue = $this->listAnggaranModel->where('id_list_anggaran', $anggaran_value->id)->orderBy('id', 'DESC');
                    $setValue = $anggaran->persetujuan;

                    // echo $setValue;
                    foreach ($listAnggaranValue->get() as $list_anggaran_value) {
                        if((int)$anggaran_value->persetujuan <= (int)$setValue){
                        // echo $list_anggaran->id.":".$list_anggaran_value->anggaran_setahun."=".$list_anggaran_value->id.":".$list_anggaran_value->anggaran_setahun."<br/>";
                            if($list_anggaran->id_first == $list_anggaran_value->id_first||$list_anggaran->id_first == $list_anggaran_value->id){

                        // echo $list_anggaran->id."(".$anggaran->persetujuan."):".$list_anggaran_value->anggaran_setahun."=".$list_anggaran_value->id."(".$anggaran->persetujuan."):".$list_anggaran_value->anggaran_setahun."<br/>";

                                $persetujuan = $anggaran_value->persetujuan;
                                // echo $persetujuan.":".$list_anggaran_value->anggaran_setahun."<br />";
                                if($anggaran_value->keterangan == "Setuju"||$anggaran_value->keterangan == "Kirim"){
                                    if($persetujuan == "1"){
                                        $Value['input_anggaran'] = $list_anggaran_value->anggaran_setahun;
                                    }else if($persetujuan == "2"){
                                        $Value['clearing_house']= $list_anggaran_value->anggaran_setahun;
                                    }else if($persetujuan == "3"){
                                        $Value['naskah_rkap']= $list_anggaran_value->anggaran_setahun;
                                    }else if($persetujuan == "4"){
                                        $Value['dewan_komisaris']= $list_anggaran_value->anggaran_setahun;
                                    }else if($persetujuan == "5"){
                                        $Value['rapat_teknis']= $list_anggaran_value->anggaran_setahun;
                                    }else if($persetujuan == "6"){
                                        $Value['rups']= $list_anggaran_value->anggaran_setahun;
                                    }else if($persetujuan == "7"){
                                        $Value['finalisasi_rups']= $list_anggaran_value->anggaran_setahun;
                                    }else if($persetujuan == "8"){
                                        $Value['risalah_rups']= $list_anggaran_value->anggaran_setahun;
                                    } 
                                }
                                // echo $persetujuan."<br />";
                                // print_r($Value);
                                
                            }
                        }
                    }
                }
                $result[] = [
                    'id'                => $list_anggaran->id,
                    'active'            => $list_anggaran->active,
                    'jenis'             => $list_anggaran->jenis,
                    'kelompok'          => $list_anggaran->kelompok,
                    'pos_anggaran'      => $list_anggaran->pos_anggaran,
                    'sub_pos'           => $list_anggaran->sub_pos,
                    'mata_anggaran'     => $list_anggaran->mata_anggaran,
                    'input_anggaran'    =>$Value['input_anggaran'],
                    'clearing_house'    =>$Value['clearing_house'],
                    'naskah_rkap'       =>$Value['naskah_rkap'],
                    'dewan_komisaris'   =>$Value['dewan_komisaris'],
                    'rapat_teknis'      =>$Value['rapat_teknis'],
                    'rups'              =>$Value['rups'],
                    'finalisasi_rups'   =>$Value['finalisasi_rups'],
                    'risalah_rups'      =>$Value['risalah_rups'],
                    'file'              => $fileList
                ];
            }
        }

        
        return response()->json($result);
    }

    public function getFilteredAnggaran($nd_surat,$status,$unit){
        $decode_nd_surat = urldecode($nd_surat);
        $decode_unit = urldecode($unit);
        $result = [];

        $query =$this->anggaranModel;
        if($decode_nd_surat != ""){
            $query = $query->where('nd_surat', $decode_nd_surat);
            
        }

        if($status != "0"){
            $query = $query->where('status_anggaran', $status);
        }

        $result = $query->where('unit_kerja',$decode_unit)->where('active', '1')->orderBy('updated_at','DESC')->get();
        
        return response()->json($result);
    }

    public function getAttributes($type,$id)
    {
        $return = null;
        switch ($type) {
            case 'unitkerja':
                $second="SELECT * 
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_DIVISI] 
                    WHERE VALUE!='00') AS A 
                    UNION ALL 
                    SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DUMMY].[dbo].[PIL_VIEW_KPKC]  
                    WHERE VALUE!='00') AS B";
                $return = \DB::select($second);
                break;
            case 'divisi':
                $return = $this->divisiModel->select('DESCRIPTION', 'VALUE')->where("VALUE",$id)->get();
                break;       
            case 'cabang':
                $return = $this->kanCabModel->select('DESCRIPTION', 'VALUE')->where("VALUE",$id)->get();
                break;
            case 'nilaipersatuan':
                $value = explode("->",$id);
                $decode = urldecode($id);
                if(count($value)>1){
                    $val = $value[0];
                    for($i = 1;$i<count($val);$i++){
                        $val .= "/".$value[$i];
                    }
                    $decode = urldecode($val);
                }
                $mataanggaran= Kegiatan::where('DESCRIPTION',$decode)->first()->VALUE;
                // echo $mataanggaran;
                $return = NilaiMataAnggaran::select('nilai')->where('value',$mataanggaran)->orderBy('nilai','ASC')->get();
                break;
            case 'satuan':
                $return = ItemAnggaranMaster::select('name')->where('type',4)->orderBy('name','ASC')->get();
                break;
            case 'divisi2':
                $return = $this->divisiModel->select('DESCRIPTION')->where('VALUE','<>','00')->orderBy('DESCRIPTION','ASC')->get();
                break;
            case 'mataanggaran':
                $value = explode("->",$id);
                $decode = urldecode($id);
                if(count($value)>1){
                    $val = $value[0];
                    for($i = 1;$i<count($val);$i++){
                        $val .= "/".$value[$i];
                    }
                    $decode = urldecode($val);
                }
                // echo $decode;
                $kode= SubPos::where('DESCRIPTION',$decode)->first()->VALUE;
                
                $item = ItemMasterAnggaran::where('sub_pos',$kode)->get();
                $array = [];
                foreach ($item as $row) {
                    array_push($array,$row->mata_anggaran);
                }
                $return = Kegiatan::select('DESCRIPTION')->where('DESCRIPTION','<>','None')->whereIn('VALUE',$array)->orderBy('DESCRIPTION','ASC')->get();
                // $return = Kegiatan::select('DESCRIPTION')->where('DESCRIPTION','<>','None')->orderBy('DESCRIPTION','ASC')->get();
                break;
            case 'subpos':
                $value = explode("->",$id);
                $decode = urldecode($id);
                if(count($value)>1){
                    $val = $value[0];
                    for($i = 1;$i<count($value);$i++){
                        $val .=  "/".$value[$i];
                    }
                    $decode = urldecode($val);
                }
                // echo $decode;
                $kode= ItemAnggaranMaster::where('name',$decode)->where('type',3)->first()->kode;
                // echo $kode;
                $item = ItemMasterAnggaran::where('pos_anggaran',$kode)->get();
                $array = [];
                foreach ($item as $row) {
                    // echo $row->sub_pos;
                    array_push($array,$row->sub_pos);  
                }
                $return = SubPos::select('DESCRIPTION')->where('DESCRIPTION','<>','None')->whereIn('VALUE',$array)->orderBy('DESCRIPTION','ASC')->get(); 
                // $return = SubPos::select('DESCRIPTION')->where('DESCRIPTION','<>','None')->orderBy('DESCRIPTION','ASC')->get(); 
                break;
            case 'posanggaran':
                $value = explode("->",$id);
                $decode = urldecode($id);
                if(count($value)>1){
                    $val = $value[0];
                    for($i = 1;$i<count($val);$i++){
                        $val .= $value[$i];
                    }
                    $decode = urldecode($val);
                }
                $kode= ItemAnggaranMaster::where('name',$decode)->where('type',2)->first()->kode;
                $item = ItemMasterAnggaran::where('kelompok',$kode)->get();
                $array = [];
                foreach ($item as $row) {
                    array_push($array,$row->pos_anggaran);
                }
                $return = ItemAnggaranMaster::select('name')->where('type',3)->whereIn('kode',$array)->orderBy('name','ASC')->get(); 
                // $return = ItemAnggaranMaster::select('name')->where('type',3)->orderBy('name','ASC')->get(); 
                break;
            case 'kelompok':
                $value = explode("->",$id);
                $decode = urldecode($id);
                if(count($value)>1){
                    $val = $value[0];
                    for($i = 1;$i<count($val);$i++){
                        $val .= $value[$i];
                    }
                    $decode = urldecode($val);
                }
                $kode= ItemAnggaranMaster::where('name',$decode)->where('type',1)->first()->kode;
                // echo $kode;
                $item = ItemMasterAnggaran::where('jenis',$kode)->get();
                $array = [];
                foreach ($item as $row) {
                    array_push($array,$row->kelompok);
                }
                $return = ItemAnggaranMaster::select('name')->where('type',2)->whereIn('kode',$array)->orderBy('name','ASC')->get(); 
                // $return = ItemAnggaranMaster::select('name')->where('type',2)->orderBy('name','ASC')->get(); 
                break;
            case 'jenis':

                $return = ItemAnggaranMaster::select('name')->where('type',1)->orderBy('name','ASC')->get(); 
                break;
            case 'nd_surat':
                $return = $this->anggaranModel->select('nd_surat')->where('unit_kerja','LIKE',"%".urldecode($id)."%")->where('active','1')->orderBy('nd_surat','ASC')->get();
                break;
        }
        return response()->json($return);
    }

    public function getDivisi()
    {
        $return = null;
        $return = $this->divisiModel->select('DESCRIPTION', 'VALUE')->where('VALUE','<>','00')->get();
        return response()->json($return);
    }

    public function getNDSurat($unit,$stat)
    {
            
        $de_unit = urldecode($unit);
        $de_stat = urldecode($stat);
        $return = $this->anggaranModel->select('nd_surat')->where('active','1')
                        ->where('unit_kerja','LIKE',"%".urldecode($de_unit)."%");
        if($de_stat != "0"){
            $return = $return->where('status_anggaran',urldecode($de_stat));
        }

        $return = $return->orderBy('nd_surat','ASC')->get();
                
        
        return response()->json($return);
    }

    public function unduh_file($id){

        $berkas = FileListAnggaran::where('id', $id)->first();
         
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
            unlink($file); 
            exit($data);

        }
    }

    public function export_list_anggaran(Request $request)
    {
        $header_list = [];
        
        foreach(json_decode($request->header_anggaran_download) as $header){

            $header_list[] = [
                'tanggal'       => $header->tanggal,
                'nd_surat'      => $header->nd_surat,
                'unit_kerja'    => $header->unit_kerja,
                'tipe_anggaran' => $header->tipe_anggaran,
                'stat_anggaran' => $header->stat_anggaran,
                'persetujuan'   => $header->persetujuan
            ];
        }

        $anggaran_view_list = [];
        foreach (json_decode($request->list_anggaran_download) as $value) {
            $idBefore = '0';
            $anggaranId = $request->id_anggaran;

            $anggaran_view_list[] = [
                'jenis'             => $value->jenis,
                'kelompok'          => $value->kelompok,
                'pos_anggaran'      => $value->pos_anggaran,
                'sub_pos'           => $value->sub_pos,
                'mata_anggaran'     => $value->mata_anggaran,
                'item'              => $value->item,
                'kuantitas'         => (int)$value->kuantitas,
                'satuan'            => $value->satuan,
                'nilai_persatuan'   => (double)$value->nilai_persatuan,
                'terpusat'          => $value->terpusat,
                'unit_kerja'        => $value->unit_kerja,
                'TWI'               => (double)$value->tw_i,
                'TWII'              => (double)$value->tw_ii,
                'TWIII'             => (double)$value->tw_iii,
                'TWIV'              => (double)$value->tw_iv,
                'anggaran_setahun'  => (double)$value->anggarana_setahun
            ];
        }

        $data = [
            'list'      => $anggaran_view_list,
            'header'    => $header_list
        ];

        $pdf = PDF::loadView('anggaran.report.export-anggaran', $data);
        return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('Anggaran dan Kegiatan-'.date("dmY").'.pdf');
    }

    public function export_list_anggaran_excel(Request $request)
    {
        $header_list = [];
        
        foreach(json_decode($request->header_anggaran_export) as $header){

            $header_list[] = [
                'tanggal'       => $header->tanggal,
                'nd_surat'      => $header->nd_surat,
                'unit_kerja'    => $header->unit_kerja,
                'tipe_anggaran' => $header->tipe_anggaran,
                'stat_anggaran' => $header->stat_anggaran,
                'persetujuan'   => $header->persetujuan
            ];
        }

        $anggaran_view_list = [];
        foreach (json_decode($request->list_anggaran_export) as $value) {
            $idBefore = '0';
            $anggaranId = $request->id_anggaran;

            $anggaran_view_list[] = [
                'jenis'             => $value->jenis,
                'kelompok'          => $value->kelompok,
                'pos_anggaran'      => $value->pos_anggaran,
                'sub_pos'           => $value->sub_pos,
                'mata_anggaran'     => $value->mata_anggaran,
                'item'              => $value->item,
                'kuantitas'         => (int)$value->kuantitas,
                'satuan'            => $value->satuan,
                'nilai_persatuan'   => (double)$value->nilai_persatuan,
                'terpusat'          => $value->terpusat,
                'unit_kerja'        => $value->unit_kerja,
                'TWI'               => (double)$value->tw_i,
                'TWII'              => (double)$value->tw_ii,
                'TWIII'             => (double)$value->tw_iii,
                'TWIV'              => (double)$value->tw_iv,
                'anggaran_setahun'  => (double)$value->anggarana_setahun
            ];
        }

        $data = [
            'list'      => $anggaran_view_list,
            'header'    => $header_list
        ];

        return view('anggaran.report.export-anggaran-excel', $data);
    }

    public function export_riwayat(Request $request)
    {
        $header_list = [];  
        foreach(json_decode($request->header_riwayat_values) as $header){
            $header_list[] = [
                'tahun'       => $header->tahun,
                'unit_kerja'  => $header->unit_kerja
            ];
        }

        $riwayat_list = [];
        foreach(json_decode($request->list_riwayat_values) as $value){
            $riwayat_list[] = [
                'jenis'             => $value->jenis,
                'kelompok'          => $value->kelompok,
                'pos_anggaran'      => $value->pos_anggaran,
                'sub_pos'           => $value->sub_pos,
                'mata_anggaran'     => $value->mata_anggaran,
                'input_anggaran'    => $value->input_anggaran,
                'clearing_house'    => $value->clearing_house,
                'naskah_rkap'       => $value->naskah_rkap,
                'dewan_komisaris'   => $value->dewan_komisaris,
                'rapat_teknis'      => $value->rapat_teknis,
                'rups'              => $value->rups,
                'finalisasi_rups'   => $value->finalisasi_rups,
                'risalah_rups'      => $value->risalah_rups
            ];
        }

        $data = [
            'list'      => $riwayat_list,
            'header'    => $header_list
        ];
        $pdf = PDF::loadView('anggaran.report.export-history', $data);
        return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('Riwayat Anggaran-'.date("dmY").'.pdf');
    }

    
}
