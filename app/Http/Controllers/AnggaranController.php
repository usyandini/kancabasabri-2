<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Anggaran;
use App\Models\ListAnggaran;
use App\Models\FileListAnggaran;
use App\Models\Kegiatan;
use App\Models\Divisi;
use App\Models\KantorCabang;

use App\Services\FileUpload;
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
*0 = "Kirim"
*1 = "Persetujuan Kanit Kerja"
*2 = "Persetujuan Renbang"
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
        $this->userCabang = '00';
        $this->userDivisi = '16';
        
    }

    public function index(Request $request) 
    {

        $filter = null;
        if(isset($request->cari_stat_anggaran)){
            $filter = array('nd_surat' => $request->cari_nd_surat,
                    'status_anggaran' =>$request->cari_stat_anggaran,
                    'unit_kerja' =>$request->cari_unit_kerja
                );
        }

        $editable = false;
        $displaySearch = 'block';
        return view('anggaran.informasi', [
            'title' => 'Informasi Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => '',
            'filters' =>$filter]);
    }

    public function tambah_anggaran() 
    {

        
        $editable = true;
        $displayEdit = 'none';
        $displaySave = 'block';
        $displaySend = 'block';
        return view('anggaran.index', [
            'title' => 'Tambah Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => '',
            'editable' => $editable , 
            'status' => 'tambah',
            'reject' => false,
            'filters' =>null,
            'display' => array('edit' => $displayEdit,
                    'save' => $displaySave,
                    'send' => $displaySend)]);
    }

    public function edit_anggaran($nd_surat,$status) 
    {   

        $editable = false;
        $displayEdit = 'block';
        $displaySave = 'none';
        $displaySend = 'none';
        if($status == "1"){
            $editable = true;
            $displayEdit = 'none';
            $displaySave = 'block';
            $displaySend = 'block';
        }
        return view('anggaran.index', [
            'title' => 'Ubah Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => $nd_surat,
            'editable' => $editable , 
            'status' => 'edit',
            'reject' => false,
            'filters' => array('nd_surat' => $nd_surat),
            'display' => array('edit' => $displayEdit,
                    'save' => $displaySave,
                    'send' => $displaySend)]);
    }

    public function persetujuan_anggaran($nd_surat,$status) 
    {

        // (checkActiveMenu('anggaran') == 'active' ? url('anggaran') : url('anggaran/get/filteredAnggaran/'.$filters['nd_surat'].'/'.$filters['status_anggaran'].'/'.urlencode(strtolower($filters['unit_kerja'])));
        $editable = false;
        $reject = false;
        if($status == '2'||$status == '3'){
            $editable = true;
            if($status == '3'){
                $reject = true;
            }

        }
        return view('anggaran.index', [
            'title' => 'Persetujuan Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => $nd_surat,
            'editable' => $editable , 
            'status' => 'setuju',
            'reject' => $reject,
            'filters' => array('nd_surat' => $nd_surat),
            'display' => array('edit' => "none",
                    'save' => "none",
                    'send' => "none",)]);

    }
    public function riwayat(Request $request ) 
    {
        $filter = null;
        if(isset($request->cari_tahun)){
            $filter = array('tahun' => $request->cari_tahun,
                    'unit_kerja' =>$request->cari_unit_kerja,
                    'kategori' =>$request->cari_kategori,
                    'keyword' =>$request->cari_keyword,
                );
        }

        return view('anggaran.history', [
            'title' => 'Riwayat Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function store(Request $request)
    {
        $anggaran_insert = $anggaran_update = [];
        $anggaran_insert_list = $anggaran_update_list = [];
        $anggaran_insert_file_list  = $anggaran_insert_file_list = [];
        $status = "";
        $setuju = "";
        $keterangan = $request->setuju;

        switch($request->persetujuan){
          case ""                               : $setuju="-1";break;
          case "Kirim"                          : $setuju="0";break;
          case "Persetujuan Kanit Kerja"        : $setuju="1";break;
          case "Persetujuan Renbang"            : $setuju="2";break;
          case "Persetujuan Direksi"            : $setuju="3";break;
          case "Persetujuan Dekom"              : $setuju="4";break;
          case "Persetujuan Ratek"              : $setuju="5";break;
          case "Persetujuan RUPS"               : $setuju="6";break;
          case "Persetujuan FinRUPS"            : $setuju="7";break;
          case "Persetujuan Risalah RUPS"       : $setuju="8";break;
          case "Disetujuai dan Ditandatangani"  : $setuju="9";break;
        }

        switch($request->stat_anggaran){
          case "Draft"      : $status="1";break;
          case "Transfer"   : $status="2";break;
          case "Complete"   : $status="3";break;
        }

        if($request->setuju =='Kirim'||$request->setuju =='Setuju'){
            $status = "2";
            $setuju = (int)$setuju+1;
            if($setuju == 2){
                $status = "1";
            }else if($setuju == 9){
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
            $anggaran_insert = [
            'tanggal'           => date("Y/m/d"),
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

        $anggaran_update = [
        'tanggal'           => date("Y/m/d"),
        'tipe_anggaran'     => $request->tipe_anggaran,
        'status_anggaran'   => $status,
        'persetujuan'       => $setuju,
        'active'            => $active,
        'updated_at'        => \Carbon\Carbon::now()];
        
        // echo $request->status;
        // echo $request->setuju;
        $AnggaranData;
        if($request->status == 'tambah'){
            $AnggaranData=Anggaran::create($anggaran_insert);
        }else if($request->status == 'edit' && $request->setuju == 'Simpan'){
            Anggaran::where('nd_surat', $request->nd_surat)->where('active', '1')->update($anggaran_update);
        }else{
            Anggaran::where('nd_surat', $request->nd_surat)->where('active', '1')->update($anggaran_update);
            $AnggaranData=Anggaran::create($anggaran_insert);
        }
            
        $index = 0;
        foreach (json_decode($request->list_anggaran_values) as $value) {
            $idBefore = '0';
            if(($request->setuju == 'Kirim'||$request->setuju == 'Setuju')||$request->setuju == 'Tolak'){
                if($value->id_first == '0'){
                    $idBefore = $value->id;
                }else{
                    $idBefore = $value->id_first;
                }
            }
            if($request->setuju != 'Simpan' || $request->status == 'tambah'){
                $anggaran_insert_list = [
                    // 'id'            => $value->id,
                    'jenis'           => $value->jenis,
                    'kelompok'          => $value->kelompok,
                    'pos_anggaran'      => $value->pos_anggaran,
                    'sub_pos'       => $value->sub_pos,
                    'mata_anggaran' => $value->mata_anggaran,
                    'kuantitas'     => (int)$value->kuantitas,
                    'satuan'     => $value->satuan,
                    'nilai_persatuan'       => (double)$value->nilai_persatuan,
                    'terpusat'      => $value->terpusat,
                    'unit_kerja'         => $value->unit_kerja,
                    'TWI'    => (double)$value->tw_i,
                    'TWII'    => (double)$value->tw_ii,
                    'TWIII'    => (double)$value->tw_iii,
                    'TWIV'    => (double)$value->tw_iv,
                    'anggaran_setahun'      => (double)$value->anggarana_setahun,
                    'id_first'      => $idBefore,
                    'id_list_anggaran'            => $AnggaranData->id,
                    'active'            => '1'
                    ];
            }

            $active_list = '0';
            if($request->setuju == 'Simpan'){
                $active_list = '1';
            }

            $anggaran_update_list = [
                'jenis'           => $value->jenis,
                'kelompok'          => $value->kelompok,
                'pos_anggaran'      => $value->pos_anggaran,
                'sub_pos'       => $value->sub_pos,
                'mata_anggaran' => $value->mata_anggaran,
                'kuantitas'     => (int)$value->kuantitas,
                'satuan'     => $value->satuan,
                'nilai_persatuan'       => (double)$value->nilai_persatuan,
                'terpusat'      => $value->terpusat,
                'unit_kerja'         => $value->unit_kerja,
                'TWI'    => (double)$value->tw_i,
                'TWII'    => (double)$value->tw_ii,
                'TWIII'    => (double)$value->tw_iii,
                'TWIV'    => (double)$value->tw_iv,
                'anggaran_setahun'      => (double)$value->anggarana_setahun,
                'active'            => $active_list,
                'updated_at'        => \Carbon\Carbon::now()
                ];

            $LAnggaranInsert;
            $LAnggaranUpdate;
            if($request->status == 'tambah'){
                $LAnggaranInsert  = ListAnggaran::create($anggaran_insert_list);
            }else if($request->status == 'edit'&& $request->setuju == 'Simpan'){
                $LAnggaranUpdate  = ListAnggaran::where('id', $value->id)->where('active', '1')->update($anggaran_update_list);
            }else{
                $LAnggaranInsert  = ListAnggaran::create($anggaran_insert_list);
                $LAnggaranUpdate  = ListAnggaran::where('id', $value->id)->where('active', '1')->update($anggaran_update_list);
            }

            if($request->status == 'tambah'||($request->status == 'edit')){
                $index2 = 0;
                $id_list_anggaran;
                if($request->status == 'edit'){
                    if($value->id_first== 0){
                        $id_list_anggaran = $value->id;
                    }else{
                        $id_list_anggaran = $value->id_first;
                    }  
                }else if($request->status == 'tambah'){
                    $id_list_anggaran = $LAnggaranInsert->id;
                }
                
                if(isset($_POST['count_file_'.$index])){
                    for($i=0;$i<$_POST['count_file_'.$index];$i++){
                        $data = $_POST['file_'.$index."_".$index2];
                        if($data!="null"){
                            // echo $index."_".$index2;
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
                                'created_at'    => \Carbon\Carbon::now(),
                                'updated_at'    => \Carbon\Carbon::now()];

                            FileListAnggaran::insert($store_file_list_values);
                            $index2++;
                        }
                    }
                }
            }
            $index++;

        }
        if($request->status == 'tambah'){
            session()->flash('tambah', true);
        }else if($request->setuju =='Tolak'){
            session()->flash('tolak', true);
        }else if($request->setuju =='Simpan'){
            session()->flash('simpan', true);
        }else if($request->setuju =='Kirim'){
            session()->flash('kirim', true);
        }else if($request->setuju =='Setuju'){
            session()->flash('setuju', true);
        }
        $status_view = redirect('anggaran/edit/'.$request->nd_surat.'/0'); 
        // echo $setuju;
        if($setuju != "-1"){
            $status_view = redirect('anggaran/persetujuan/'.$request->nd_surat.'/1');
        }
        return $status_view;
    }

    public function getFiltered($nd_surat,$type){
        $result = [];

        if($type == "anggaran"){
            $result = $this->anggaranModel->where('nd_surat', $nd_surat)->orderBy('id', 'DESC')->take(5)->get();

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
                    $fileListAnggaran = $this->fileListAnggaranModel;
                    $fileList = [];
                    foreach ($fileListAnggaran->get() as $file_list_anggaran) {
                        if($file_list_anggaran->id_list_anggaran == $id_list_anggaran){
                            $fileList[] = [
                                'id'   => $file_list_anggaran->id,
                                'count' => $countIndex,
                                'name' => $file_list_anggaran->name,
                                'type' => $file_list_anggaran->type,
                                'size' => $file_list_anggaran->size
                            ];
                        }
                    }

                    $result[] = [
                        'id'            => $list_anggaran->id,
                        'jenis'           => $list_anggaran->jenis,
                        'kelompok'          => $list_anggaran->kelompok,
                        'pos_anggaran'      => $list_anggaran->pos_anggaran,
                        'sub_pos'       => $list_anggaran->sub_pos,
                        'mata_anggaran' => $list_anggaran->mata_anggaran,
                        'kuantitas'     => $list_anggaran->kuantitas,
                        'satuan'     => $list_anggaran->satuan,
                        'nilai_persatuan'       => $list_anggaran->nilai_persatuan,
                        'terpusat'      => $list_anggaran->terpusat,
                        'unit_kerja'         => $list_anggaran->unit_kerja,
                        'tw_i'    => $list_anggaran->TWI,
                        'tw_ii'    => $list_anggaran->TWII,
                        'tw_iii'    => $list_anggaran->TWIII,
                        'tw_iv'    => $list_anggaran->TWIV,
                        'id_first'    => $list_anggaran->id_first,
                        'anggarana_setahun'      => $list_anggaran->anggaran_setahun,
                        'file'  => $fileList
                        
                    ];
                    $countIndex++;
                }  
            }
            
        }

        
        return response()->json($result);
    }

    public function getFilteredHistory($tahun,$unit,$kategori,$keyword){
        $decode_unit = urldecode($unit);
        $decode_keyword = urldecode($keyword);

        $result = [];

        $query;
        if($tahun == "0"){
            $query = $this->anggaranModel->where('unit_kerja', $decode_unit);
            
        }else{
            $query = $this->anggaranModel->where('unit_kerja', $decode_unit)
                                ->whereYear('updated_at','=', $tahun);
        }

        $Anggaran = $query->where('active', '1')->orderBy('updated_at','DESC');
        
        // $Anggaran = $this->anggaranModel->where('active', '1')->orderBy('updated_at','DESC')->get();
        foreach($Anggaran->get() as $anggaran){
            $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)->where('active', '1');
            
            if($kategori == "semua"){
                $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)
                                ->where('unit_kerja', $decode_unit)
                                ->where(function($qry) use($decode_keyword){
                                    $qry->where('jenis','LIKE' ,'%'.$decode_keyword.'%')
                                        ->orWhere('kelompok','LIKE' ,'%'.$decode_keyword.'%')
                                        ->orWhere('pos_anggaran','LIKE' ,'%'.$decode_keyword.'%')
                                        ->orWhere('sub_pos','LIKE' ,'%'.$decode_keyword.'%')
                                        ->orWhere('mata_anggaran','LIKE' ,'%'.$decode_keyword.'%');
                                })->where('active', '1');
            }else{
                $listAnggaran = $this->listAnggaranModel->where('id_list_anggaran', $anggaran->id)
                                ->where('unit_kerja', $decode_unit)
                                ->where($kategori,'LIKE' ,'%'.$decode_keyword.'%')
                                ->where('active', '1');
            }

            $fileListAnggaran = $this->fileListAnggaranModel;
            // echo "Terbaru<br/>";
            $countIndex=0;
            foreach ($listAnggaran->get() as $list_anggaran) {
                $fileList = [];
                $id_list_anggaran;
                if($list_anggaran->id_first == 0){
                    $id_list_anggaran = $list_anggaran->id;
                }else{
                    $id_list_anggaran = $list_anggaran->id_first;
                }
                foreach ($fileListAnggaran->get() as $file_list_anggaran) {
                    if($file_list_anggaran->id_list_anggaran == $id_list_anggaran){
                        $fileList[] = [
                            'id'   => $file_list_anggaran->id,
                            'count' => $countIndex,
                            'name' => $file_list_anggaran->name,
                            'type' => $file_list_anggaran->type,
                            'size' => $file_list_anggaran->size
                        ];
                    }
                }

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
                            if($list_anggaran->id_first == $list_anggaran_value->id_first){

                        // echo $list_anggaran->id."(".$anggaran->persetujuan."):".$list_anggaran_value->anggaran_setahun."=".$list_anggaran_value->id."(".$anggaran->persetujuan."):".$list_anggaran_value->anggaran_setahun."<br/>";

                                $persetujuan = $anggaran_value->persetujuan;
                                // if($persetujuan == "1"&&$Value['input_anggaran']==0){
                                //     $Value['input_anggaran'] = $list_anggaran_value->anggaran_setahun;
                                // }else if($persetujuan == "2"&&$Value['clearing_house']==0){
                                //     $Value['clearing_house']= $list_anggaran_value->anggaran_setahun;
                                // }else if($persetujuan == "3"&&$Value['naskah_rkap']==0){
                                //     $Value['naskah_rkap']= $list_anggaran_value->anggaran_setahun;
                                // }else if($persetujuan == "4"&&$Value['dewan_komisaris']==0){
                                //     $Value['dewan_komisaris']= $list_anggaran_value->anggaran_setahun;
                                // }else if($persetujuan == "5"&&$Value['rapat_teknis']==0){
                                //     $Value['rapat_teknis']= $list_anggaran_value->anggaran_setahun;
                                // }else if($persetujuan == "6"&&$Value['rups']==0){
                                //     $Value['rups']= $list_anggaran_value->anggaran_setahun;
                                // }else if($persetujuan == "7"&&$Value['finalisasi_rups']==0){
                                //     $Value['finalisasi_rups']= $list_anggaran_value->anggaran_setahun;
                                // }else if($persetujuan == "8"&&$Value['risalah_rups']==0){
                                //     $Value['risalah_rups']= $list_anggaran_value->anggaran_setahun;
                                // }
                                if($anggaran_value->keterangan == "Setuju"){
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
                                
                            }
                        }
                    }
                    $countIndex++;
                }
                $result[] = [
                    'id'             => $list_anggaran->id,
                    'active'             => $list_anggaran->active,
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
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_DIVISI] WHERE VALUE!='00') AS A UNION ALL SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_KPKC]  WHERE VALUE!='00') AS B";
                $return = \DB::select($second);
                break;
            case 'divisi':
                $return = $this->divisiModel->select('DESCRIPTION', 'VALUE')->where("VALUE",$id)->get();
                break;       
            case 'cabang':
                $return = $this->kanCabModel->select('DESCRIPTION', 'VALUE')->where("VALUE",$id)->get();
                break;
            case 'mataanggaran':
                $return = $this->kegiatanModel->get();
                break;
        }
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


    public function removeAnggaranAll(){

                \DB::table('anggaran')->delete();
                \DB::table('list_anggaran')->delete();
                \DB::table('file_list_anggaran')->delete();
    }

}
