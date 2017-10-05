<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\Http\Requests;
use App\Models\FormMasterPelaporan;
use App\Models\KantorCabang;
use App\Models\Divisi;
use App\Models\MasterItemPelaporanAnggaran;
use App\Models\MasterItemArahanRUPS;
use App\Models\BerkasFormItemMaster;
use App\Models\ProgramPrioritas;
use App\Models\ArahanRups;


class PelaporanController extends Controller
{
    protected $FormMasterPelaporanModel;
    protected $MasterItemPelaporanAnggaranModel;
    protected $MasterItemArahanRUPSModel;
    protected $BerkasFormItemMasterModel;


    public function __construct(
       FormMasterPelaporan $FormMasterPelaporan, 
       MasterItemPelaporanAnggaran $MasterItemPelaporanAnggaran, 
       MasterItemArahanRUPS $MasterItemArahanRUPS,
       BerkasFormItemMaster $BerkasFormItemMaster )
    {
        $this->FormMasterPelaporanModel = $FormMasterPelaporan;
        $this->MasterItemPelaporanAnggaranModel = $MasterItemPelaporanAnggaran;
        $this->MasterItemArahanRUPSModel = $MasterItemArahanRUPS;
        $this->BerkasFormItemMasterModel = $BerkasFormItemMaster;
        $this->userCabang = \Auth::user()->cabang;
        $this->userDivisi = \Auth::user()->divisi;
        
    }

    public function index(Request $request) 
    {

    }

    public function cari(Request $request,$kategori,$type) 
    {

        $filter = null;
        // if(isset($request->cari_stat_anggaran)){
        $filter = array('cari_tahun' => $request->cari_tahun,
                'unit_kerja' =>$request->cari_unit_kerja,
                'cari_tw_dari' =>$request->cari_tw_dari,
                'cari_tw_ke' =>$request->cari_tw_ke
            );
        // }
        $query="SELECT * 
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_DIVISI] 
                    WHERE VALUE!='00') AS A 
                    UNION ALL 
                    SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_KPKC]  
                    WHERE VALUE!='00') AS B";
        $unit_kerja = \DB::select($query);
        $sub_title = "";
        if($kategori == "laporan_anggaran"){
            $sub_title = "Pelaporan Anggaran dan Kegiatan";
        }else if($kategori == "arahan_rups"){
            $sub_title = "Arahan RUPS";
        }else if($kategori == "usulan_program"){
            $sub_title = "Usulan Program Prioritas";
        }
        

        return view('pelaporan.informasi', [
            'title' => $sub_title,
            'sub_title' => '',
            'kategori'=>$kategori,
            'unit_kerja'=>$unit_kerja,
            'type' => $type,
            'filters'=>$filter,
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function pelaporan($type,$kategori) 
    {

        $filter = null;
        
        $sub_title = "";
        if($kategori == "laporan_anggaran"){
            $sub_title = "Pelaporan Anggaran dan Kegiatan";
        }else if($kategori == "arahan_rups"){
            $sub_title = "Arahan RUPS";
        }else if($kategori == "usulan_program"){
            $sub_title = "Usulan Program Prioritas";
        }

        $query="SELECT * 
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_DIVISI] 
                    WHERE VALUE!='00') AS A 
                    UNION ALL 
                    SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_KPKC]  
                    WHERE VALUE!='00') AS B";
        

        $unit_kerja = \DB::select($query);
        return view('pelaporan.informasi', [
            'title' => $sub_title,
            'sub_title' => '',
            'kategori'=>$kategori,
            'unit_kerja'=>$unit_kerja,
            'type' => $type,
            'filters'=>$filter,
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function edit($type,$kategori,$id) 
    {

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

        $beda = false;

        $pelaporan = FormMasterPelaporan::where('id', $id)->get();
        
        $item;
        foreach ($pelaporan as $row) {
            if($kategori == 'laporan_anggaran')
                $item = MasterItemPelaporanAnggaran::where('id_form_master',$row->id)->where('unit_kerja',$userUnit);
            else if($kategori == 'arahan_rups')
                $item = MasterItemArahanRUPS::where('id_form_master',$row->id)->where('unit_kerja',$userUnit);
            
        }

        if(count($item->get())>0){
            $beda = true;
        }

        $filter =  array(
                'id'        => $id);
        $setting = array('editable' => false,
                    'berkas'        =>true,
                    'edit'          =>true,
                    'insert'          =>true,
                    'status'        =>"Edit",
                    'jenis_berkas'  =>"1",
                    'kategori'      =>$kategori,
                    'id_form_master'=>-1,
                    'table'         => true

            );

        $sub_title = "";
        if($kategori == "laporan_anggaran"){
            if($type=='item'){
                $setting['insert']=false;
                $setting['jenis_berkas']="0";
            }
            $setting['table'] = true;
            $sub_title = "Pelaporan Anggaran dan Kegiatan";
        }else if($kategori == "arahan_rups"){
            $setting['table'] = true;
            if($type=='item'){
                $setting['insert']=false;
                $setting['jenis_berkas']="0";
            }
            if($type == "master"){
                $setting['berkas'] = false;
            }
            $sub_title = "Arahan RUPS";
        }else if($kategori == "usulan_program"){
            $setting['table'] = false;
            $sub_title = "Usulan Program Prioritas";
        }
        
        return view('pelaporan.edit', [
            'title' => 'Form Master',
            'sub_title' => $sub_title,
            'setting' => $setting , 
            'type' => $type,
            'beda' => $beda,
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function usulan_program_prioritas() 
    {

        $filter = null;
        $setting = array('editable' => false,
                    'edit'          =>false,
                    'insert'          =>false,
                    'status'        =>"Info",
                    'kategori'      =>'usulan_program',
                    'id_form_master'=>-1,
                    'table'         => true

            );
        
        $sub_title = "Usulan Program Prioritas";
        
        

        return view('pelaporan.usulan_program_prioritas', [
            'title' => $sub_title,
            'sub_title' => '',
            'setting' => $setting ,
            'type' => 'item',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function tambah_usulan_program_prioritas() 
    {

        $filter = null;
        $setting = array('editable' => false,
                    'edit'          =>true,
                    'insert'          =>true,
                    'status'        =>"Tambah",
                    'kategori'      =>'usulan_program',
                    'id_form_master'=>-1,
                    'table'         => true

            );
        
        $sub_title = "Usulan Program Prioritas";
        
        

        return view('pelaporan.usulan_program_prioritas', [
            'title' => $sub_title,
            'sub_title' => '',
            'setting' => $setting ,
            'type' => 'item',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function tambah($type,$kategori) 
    {

        $filter = null;
        $setting = array('editable' => false,
                    'berkas'        =>true,
                    'edit'          =>true,
                    'insert'          =>true,
                    'status'        =>"Tambah",
                    'jenis_berkas'  =>"1",
                    'kategori'      =>$kategori,
                    'id_form_master'=>-1,
                    'table'         => true

            );
        $sub_title = "";
        if($kategori == "laporan_anggaran"){
            if($type=='item'){
                $setting['insert']=false;
                $setting['jenis_berkas']="0";
            }
            $setting['table'] = true;
            $sub_title = "Pelaporan Anggaran dan Kegiatan";
        }else if($kategori == "arahan_rups"){
            $setting['table'] = true;
            if($type=='item'){
                $setting['insert']=false;
                $setting['jenis_berkas']="0";
            }
            if($type == "master"){
                $setting['berkas'] = false;
            }
            $sub_title = "Arahan RUPS";
        }else if($kategori == "usulan_program"){
            $setting['table'] = false;
            $sub_title = "Usulan Program Prioritas";
        }


        if($type == 'item'){
            if($this->check_tambah($kategori)){
                session()->flash('back', 'Unit Kerja Anda Telah mengisi '.$sub_title.'. Silahkan Melakukan pencarian jika ingin merubah sebelum waktu pengajuan berakhir');
                session()->flash('title', $sub_title);
                return redirect('pelaporan/informasi/item/'.$kategori);
            }  
        }

        return view('pelaporan.input', [
            'title' => 'Form Master',
            'sub_title' => $sub_title,
            'setting' => $setting , 
            'type' => $type,
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);


    }

    public function store(Request $request){
        $form_master_insert ;
        $form_master_insert_item = $form_master_update_item = [];
        $form_master_insert_file_item  = $form_master_update_file_item = [];
        $kategori =$request->kategori;

        if($request->status == 'Tambah'){
            if($request->jenis_berkas == '1'){
                $form_master_insert = [
                    'tanggal_mulai'    => $request->tanggal_mulai, 
                    'tanggal_selesai'  => $request->tanggal_selesai,
                    'tw_dari'           => $request->tw_dari, 
                    'tw_ke'             => $request->tw_ke, 
                    'kategori'          => $kategori,
                    'is_template'       => $request->jenis_berkas,
                    'active'            => '1'];
            }else if($request->jenis_berkas == '0'){
                $FormMaster = FormMasterPelaporan::where('id',$request->id_form_master)->first();
                $form_master_insert = [
                    'tanggal_mulai'    => $FormMaster->tanggal_mulai, 
                    'tanggal_selesai'  => $FormMaster->tanggal_selesai,
                    'tw_dari'           => $FormMaster->tw_dari, 
                    'tw_ke'             => $FormMaster->tw_ke, 
                    'kategori'          => $kategori,
                    'is_template'       => $request->jenis_berkas,
                    'active'            => '1'];

            }
        }


        $id_form_master;
        if($request->status == 'Tambah'){
            $formMaster=FormMasterPelaporan::create($form_master_insert);
            $id_form_master = $formMaster->id;
        }else{
            $id_form_master = $request->id_form_master;
        }
        if($kategori != "usulan_program"){
            $index = 0;
            foreach (json_decode($request->item_form_master) as $value) {
                if($request->status == 'Tambah'){
                    if($kategori == "laporan_anggaran"){
                        $uraian_progress="";
                        $id_list_master=0;
                        if($request->jenis_berkas == '0'){
                            $uraian_progress = $value->uraian_progress;
                            $id_list_master = $value->id;
                        }
                        $form_master_insert_item = [
                        'unit_kerja' => $value->unit_kerja,
                        'program_prioritas' => $value->program_prioritas,
                        'sasaran_dicapai'   => $value->sasaran_dicapai,
                        'id_form_master'    => $id_form_master,
                        'uraian_progress'   => $uraian_progress,
                        'is_template'       => $request->jenis_berkas,
                        'id_list_master'    => $id_list_master,
                        'active'            => '1'
                        ];
                    }else if($kategori == "arahan_rups"){
                        $progress_tindak_lanjut="";
                        if($request->jenis_berkas == '0'){
                            $progress_tindak_lanjut = $value->progress_tindak_lanjut;
                        }
                        $form_master_insert_item = [
                        'unit_kerja' => $value->unit_kerja,
                        'jenis_arahan'              => $value->jenis_arahan,
                        'arahan'                    => $value->arahan,
                        'id_form_master'            => $id_form_master,
                        'progress_tindak_lanjut'    => $progress_tindak_lanjut,
                        'is_template'               => $request->jenis_berkas,
                        'active'                    => '1'
                        ];
                    }

                }else if($request->status == 'Edit'){
                    if($kategori == "laporan_anggaran"){
                        $uraian_progress="";
                        if($request->jenis_berkas == '0'){
                            $uraian_progress = $value->uraian_progress;
                        }
                        $form_master_insert_item = [
                        'unit_kerja' => $value->unit_kerja,
                        'program_prioritas' => $value->program_prioritas,
                        'sasaran_dicapai'   => $value->sasaran_dicapai,
                        'uraian_progress'   => $uraian_progress
                        ];
                    }else if($kategori == "arahan_rups"){
                        $progress_tindak_lanjut="";
                        if($request->jenis_berkas == '0'){
                            $progress_tindak_lanjut = $value->progress_tindak_lanjut;
                        }
                        $form_master_insert_item = [
                        'unit_kerja' => $value->unit_kerja,
                        'jenis_arahan'              => $value->jenis_arahan,
                        'arahan'                    => $value->arahan,
                        'progress_tindak_lanjut'    => $progress_tindak_lanjut
                        ];
                    }

                }

                $LFormMasterInsert;
                $LFormMasterUpdate;
                if($request->status == 'Tambah'){
                    if($kategori == "laporan_anggaran"){
                        $LFormMasterInsert  = MasterItemPelaporanAnggaran::create($form_master_insert_item);
                    }else if($kategori == "arahan_rups"){
                        $LFormMasterInsert  = MasterItemArahanRUPS::create($form_master_insert_item);
                    }
                }else if($request->status == 'Edit'){
                    if($kategori == "laporan_anggaran"){
                        $LFormMasterUpdate  = MasterItemPelaporanAnggaran::where('id',$value->id)->update($form_master_insert_item);
                    }else if($kategori == "arahan_rups"){
                        $LFormMasterUpdate  = MasterItemArahanRUPS::where('id',$value->id)->update($form_master_insert_item);
                    }
                }

                
                $index2 = 0;
                $id_list_form_master;
                if($request->status == 'Tambah'){
                    $id_list_form_master = $LFormMasterInsert->id;
                }else if($request->status == 'Edit'){
                    $id_list_form_master = $value->id;
                }

                    if(isset($_POST['count_file_'.$index])){
                        for($i=0;$i<$_POST['count_file_'.$index];$i++){
                            $data = $_POST['file_'.$index."_".$index2];
                            if($data!="null"){
                                $file_name = $_POST['file_name_'.$index."_".$index2];
                                $file_type = $_POST['file_type_'.$index."_".$index2];
                                $file_size = $_POST['file_size_'.$index."_".$index2];
                                $base64 = explode(";base64,", $data);
                                
                                $store_file_list_values = [
                                    'id_item_master'   => $id_list_form_master,
                                    'name'                  => $file_name,
                                    'type'                  => $file_type,
                                    'size'                  => $file_size,
                                    'data'                  => $base64[1],
                                    'kategori'              => $kategori,
                                    'active'                => '1',
                                    'is_template'           => $request->jenis_berkas,
                                    'created_at'            => \Carbon\Carbon::now(),
                                    'updated_at'            => \Carbon\Carbon::now()];

                                BerkasFormItemMaster::insert($store_file_list_values);
                                $index2++;
                            }
                        }
                    }
                // }
                
                $index++;

            }
        }
        $type = "master";
        if($request->jenis_berkas == '0'){
            $type = 'item';
        }
        return redirect('pelaporan/edit/'.$type."/".$kategori."/".$id_form_master);
    }   

    public function getFilteredPelaporan($type,$kategori,$tahun,$tw_dari,$tw_ke,$unit_kerja){
        $decode_unit = urldecode($unit_kerja);
        $result = [];

        $query =$this->FormMasterPelaporanModel;
        if($tahun != "0"){
            $query = $query->whereYear('created_at', '=', $tahun);
            
        }
        $query = $query->where('tw_dari','<=',$tw_dari)->orWhere('tw_ke','<=',$tw_ke);
        $is_template = 1;
        if($type == "item"){
            $is_template = 0;
        }
        $query = $query->where('kategori',$kategori)->where('is_template', $is_template)->orderBy('updated_at','DESC');
        // echo count($query->get()); 
        if($decode_unit !="0"){
            foreach ($query->get() as $row) {
                $hasil;
                if($kategori == 'laporan_anggaran'){
                    // echo 'laporan_anggaran';
                    $hasil = $this->MasterItemPelaporanAnggaranModel
                        ->where('id_form_master', $row->id)->where('unit_kerja', $decode_unit)->get();
                }else if($kategori == 'arahan_rups'){

                    // echo 'arahan';
                    $hasil = $this->MasterItemArahanRUPSModel
                        ->where('id_form_master', $row->id)->where('unit_kerja', $decode_unit)->get();
                }
                if(count($hasil)>0){
                    foreach ($hasil as $itm) {
                        $result[] = [
                            'id'                => $row->id,
                            'created_at'        => $row->created_at,
                            'tw_dari'           => $row->tw_dari,
                            'tw_ke'             => $row->tw_ke,
                            'unit_kerja'        => $itm['unit_kerja']
                            
                        ];
                    }
                }
            }
        }else{
            $unit = array();
            $cabang = KantorCabang::get();
            $divisi = Divisi::get();
            foreach($cabang as $cab){
                if(Gate::check('unit_'.$cab->VALUE."00")){
                    array_push($unit, $cab->DESCRIPTION);
                }
            }  
            foreach($divisi as $div){
                if(Gate::check('unit_00'.$div->VALUE)){
                    array_push($unit, $div->DESCRIPTION);
                }
            } 
            foreach ($query->get() as $row) {
                $hasil;
                if($kategori == 'laporan_anggaran'){
                    $hasil = $this->MasterItemPelaporanAnggaranModel
                        ->where('id_form_master', $row->id)->whereIn('unit_kerja', $unit)->get();
                }else if($kategori == 'arahan_rups'){
                    $hasil = $this->MasterItemArahanRUPSModel
                        ->where('id_form_master', $row->id)->whereIn('unit_kerja', $unit)->get();
                }
                // if($hasil['unit_kerja']!=null)
                //     $item[]=['unit_kerja'=>$hasil['unit_kerja']];

                if(count($hasil)>0){
                    foreach ($hasil as $itm) {
                        $result[] = [
                            'id'                => $row->id,
                            'created_at'        => $row->created_at,
                            'tw_dari'           => $row->tw_dari,
                            'tw_ke'             => $row->tw_ke,
                            'unit_kerja'        => $itm['unit_kerja']
                            
                        ];
                    }
                }
            }
            
        }

        return response()->json($result);
    }

    public function getDataFormMaster($kategori,$type){
        $tw = 0;
        if(date('n')>=1&&date('n')<=3){
            $tw = 1;
        }else if(date('n')>=4&&date('n')<=6){
            $tw = 2;
        }else if(date('n')>=7&&date('n')<=9){
            $tw = 3;
        }else if(date('n')>=10&&date('n')<=12){
            $tw = 4;
        }

        $result = [];
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

        // echo $kategori;
        if($type == "0"){
            $FormMaster = $this->FormMasterPelaporanModel->where('tw_dari', $tw)->where('kategori',$kategori)->where('active','1')->where('is_template','1');
            $ItemPelaporanAnggaran;
            foreach ($FormMaster->get() as $form_master) {
                $Item = $this->MasterItemPelaporanAnggaranModel
                    ->where('id_form_master', $form_master->id)->where('unit_kerja', $userUnit)
                    ->where('active', '1');
                if(count($Item)>0){
                    $ItemPelaporanAnggaran = $Item;
                }

            }
            $result = null;
            if(count($ItemPelaporanAnggaran)>0||$kategori == 'usulan_program'){
                $result = $FormMaster->get();
            }

        }else if($kategori == "laporan_anggaran"&&$type=="1"){
            $FormMaster = $this->FormMasterPelaporanModel->where('tw_dari', $tw)->where('kategori',$kategori)->where('is_template','1');
            foreach ($FormMaster->get() as $form_master) {

                $ItemPelaporanAnggaran = $this->MasterItemPelaporanAnggaranModel
                    ->where('id_form_master', $form_master->id)->where('unit_kerja', $userUnit)
                    ->where('active', '1');

                
                $countIndex=0;
                foreach ($ItemPelaporanAnggaran->get() as $item_pelaporan_anggaran) {
                    $id_item_pelaporan_anggaran = $item_pelaporan_anggaran->id;
                    $BerkasFormItem = $this->BerkasFormItemMasterModel
                            ->where('id_item_master', $id_item_pelaporan_anggaran)
                            ->where('kategori', $kategori)
                            ->where('active', '1');
                    $fileList = [];
                    foreach ($BerkasFormItem->get() as $berkas_form_item) {
                        $fileList[] = [
                            'id'   => $berkas_form_item->id,
                            'count' => $countIndex,
                            'is_template' => $berkas_form_item->is_template,
                            'name' => $berkas_form_item->name,
                            'type' => $berkas_form_item->type,
                            'size' => $berkas_form_item->size
                        ];
                    }

                    $result[] = [
                        'id'                        => $item_pelaporan_anggaran->id,
                        'tempId'                    => $countIndex,
                        'unit_kerja'         => $item_pelaporan_anggaran->unit_kerja,
                        'program_prioritas'         => $item_pelaporan_anggaran->program_prioritas,
                        'sasaran_dicapai'           => $item_pelaporan_anggaran->sasaran_dicapai,
                        'file'  => $fileList
                        
                    ];
                    $countIndex++;
                }  
            }
        }else if($kategori == "arahan_rups" && $type=="1"){
            $FormMaster = $this->FormMasterPelaporanModel->where('tw_dari', $tw)->where('kategori',$kategori)->where('is_template','1');
            foreach ($FormMaster->get() as $form_master) {

                $ItemArahaRUPS = $this->MasterItemArahanRUPSModel
                    ->where('id_form_master', $form_master->id)->where('unit_kerja', $userUnit)
                    ->where('active', '1');

                
                $countIndex=0;
                foreach ($ItemArahaRUPS->get() as $item_arahan_rups) {
                    $id_item_arahan_rups = $item_arahan_rups->id;
                    $BerkasFormItem = $this->BerkasFormItemMasterModel
                            ->where('id_item_master', $id_item_arahan_rups)
                            ->where('kategori', $kategori)
                            ->where('active', '1');
                    $fileList = [];
                    foreach ($BerkasFormItem->get() as $berkas_form_item) {
                        $fileList[] = [
                            'id'   => $berkas_form_item->id,
                            'count' => $countIndex,
                            'is_template' => $berkas_form_item->is_template,
                            'name' => $berkas_form_item->name,
                            'type' => $berkas_form_item->type,
                            'size' => $berkas_form_item->size
                        ];
                    }

                    $result[] = [
                        'id'                        => $item_arahan_rups->id,
                        'unit_kerja'         => $item_arahan_rups->unit_kerja,
                        'jenis_arahan'         => $item_arahan_rups->jenis_arahan,
                        'arahan'           => $item_arahan_rups->arahan,
                        'file'  => $fileList
                        
                    ];
                    $countIndex++;
                }  
            }
        }

        return response()->json($result);

    }

    public function getFiltered($type,$id,$kategori){
        $result = [];

        if($kategori == "form_master"){
            $result = [];

            $query =$this->FormMasterPelaporanModel->where('id',$id)->where('active', '1');
            $is_template = 1;
            if($type == "item"){
                $is_template = 0;
            }

            $result = $query->get();

        }else if($kategori == "laporan_anggaran"){

            $FormMaster = $this->FormMasterPelaporanModel->where('id', $id)->where('active', '1');
            foreach ($FormMaster->get() as $form_master) {

                $ItemPelaporanAnggaran = $this->MasterItemPelaporanAnggaranModel
                    ->where('id_form_master', $form_master->id)->where('active', '1');

                
                $countIndex=0;
                foreach ($ItemPelaporanAnggaran->get() as $item_pelaporan_anggaran) {
                    $id_item_pelaporan_anggaran = $item_pelaporan_anggaran->id;
                    $BerkasFormItem = $this->BerkasFormItemMasterModel
                            ->where('id_item_master', $id_item_pelaporan_anggaran)
                            ->orWhere('id_item_master',$item_pelaporan_anggaran->id_list_master)
                            ->where('kategori', $kategori)
                            ->where('active', '1');
                    $fileList = [];
                    foreach ($BerkasFormItem->get() as $berkas_form_item) {
                        $fileList[] = [
                            'id'   => $berkas_form_item->id,
                            'count' => $countIndex,
                            'is_template' => $berkas_form_item->is_template,
                            'name' => $berkas_form_item->name,
                            'type' => $berkas_form_item->type,
                            'size' => $berkas_form_item->size
                        ];
                    }

                    $result[] = [
                        'id'                        => $item_pelaporan_anggaran->id,
                        'unit_kerja'         => $item_pelaporan_anggaran->unit_kerja,
                        'program_prioritas'         => $item_pelaporan_anggaran->program_prioritas,
                        'sasaran_dicapai'           => $item_pelaporan_anggaran->sasaran_dicapai,
                        'uraian_progress'           => $item_pelaporan_anggaran->uraian_progress,
                        'file'  => $fileList
                        
                    ];
                    $countIndex++;
                }  
            }
            
        }else if($kategori == "arahan_rups"){

            $FormMaster = $this->FormMasterPelaporanModel->where('id', $id)->where('active', '1');
            foreach ($FormMaster->get() as $form_master) {

                $ItemArahanRUPS = $this->MasterItemArahanRUPSModel
                    ->where('id_form_master', $form_master->id)->where('active', '1');

                
                $countIndex=0;
                foreach ($ItemArahanRUPS->get() as $item_arahan_RUPS) {
                    $id_item_arahan_RUPS = $item_arahan_RUPS->id;
                    $BerkasFormItem = $this->BerkasFormItemMasterModel
                            ->where('id_item_master', $id_item_arahan_RUPS)
                            ->orWhere('id_item_master',$item_arahan_RUPS->id_list_master)
                            ->where('kategori', $kategori)
                            ->where('active', '1');
                    $fileList = [];
                    foreach ($BerkasFormItem->get() as $berkas_form_item) {
                        $fileList[] = [
                            'id'   => $berkas_form_item->id,
                            'count' => $countIndex,
                            'is_template' => $berkas_form_item->is_template,
                            'name' => $berkas_form_item->name,
                            'type' => $berkas_form_item->type,
                            'size' => $berkas_form_item->size
                        ];
                    }

                    $result[] = [
                        'id'                        => $item_arahan_RUPS->id,
                        'unit_kerja'                => $item_arahan_RUPS->unit_kerja,
                        'jenis_arahan'              => $item_arahan_RUPS->jenis_arahan,
                        'arahan'                    => $item_arahan_RUPS->arahan,
                        'progress_tindak_lanjut'    => $item_arahan_RUPS->progress_tindak_lanjut,
                        'file'                      => $fileList
                        
                    ];
                    $countIndex++;
                }  
            }
            
        }

        
        return response()->json($result);
    }

    public function getAttributes($type,$id)
    {
        $return = null;
        switch ($type) {
            case 'unitkerja':
                

                $query = array();
                $query2 = array();
                $cabang = KantorCabang::get();
                $divisi = Divisi::get();
                foreach($cabang as $cab){
                    if(Gate::check('unit_'.$cab->VALUE."00")){
                        array_push($query, $cab->VALUE);
                    }
                }  
                foreach($divisi as $div){
                    if(Gate::check('unit_00'.$div->VALUE)){
                        array_push($query2, $div->VALUE);
                    }
                } 
                $string1 = "";
                $count1=0;
                foreach ($query as $row) {
                    if($count1 == 0)
                        $string1.="VALUE = '".$row."'";
                    else
                        $string1.=" OR VALUE = '".$row."'";
                    $count1++;
                }
                $string2 = "";
                $count2=0;
                foreach ($query2 as $row) {
                    if($count2 == 0)
                        $string2.="VALUE = '".$row."'";
                    else
                        $string2.=" OR VALUE = '".$row."'";

                    $count2++;
                }

                // echo $string1;
                $second="SELECT * 
                    FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_DIVISI] 
                    WHERE VALUE!='00' AND (".$string2.")) AS A 
                    UNION ALL 
                    SELECT * FROM (SELECT DESCRIPTION, VALUE FROM [AX_DEV].[dbo].[PIL_VIEW_KPKC]  
                    WHERE VALUE!='00' AND (".$string1.")) AS B";
                $return = \DB::select($second);
                break;
            case 'programprioritas':
                $return = ProgramPrioritas::select('program_prioritas')->get();
                break;
            case 'arahanrups':
                $return = ArahanRups::select('arahan_rups')->get();
                break;
        }
        return response()->json($return);
    }

    public function unduh_file($id){

        $berkas = BerkasFormItemMaster::where('id', $id)->first();
         
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


    public function check_tambah($kategori){
        $tw = 0;
        if(date('n')>=1&&date('n')<=3){
            $tw = 1;
        }else if(date('n')>=4&&date('n')<=6){
            $tw = 2;
        }else if(date('n')>=7&&date('n')<=9){
            $tw = 3;
        }else if(date('n')>=10&&date('n')<=12){
            $tw = 4;
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

        $FormMaster = $this->FormMasterPelaporanModel->where('tw_dari', $tw)->where('kategori',$kategori)->where('active','1')->where('is_template','0');
        $ItemPelaporanAnggaran;

        $result = null;
        // echo count($FormMaster->get());
        if(count($FormMaster->get())>0){
            $ItemPelaporanAnggaran = null;
            foreach ($FormMaster->get() as $form_master) {
                $Item = $this->MasterItemPelaporanAnggaranModel
                    ->where('id_form_master', $form_master->id)->where('unit_kerja', $userUnit)
                    ->where('active', '1')->where('is_template','0')->get();
                if(count($Item)>0){
                    $ItemPelaporanAnggaran = $Item;
                }
                // echo count($Item);
            }
            if(count($ItemPelaporanAnggaran)>0||$kategori == 'usulan_program'){
                $result = $FormMaster->get();
                // $result = $ItemPelaporanAnggaran;
            }else{
                $result = null;
            }
        }
        if($result == null){
            return false;
        }else{
            return true;
        }
        // return response()->json($result);
        
    }

    public function removeFormMasterAll(){

                \DB::table('form_master_pelaporan')->delete();
                \DB::table('master_item_arahan_rups')->delete();
                \DB::table('master_item_pelaporan_anggaran')->delete();
                \DB::table('berkas_form_item_master')->delete();
    }

}
