<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\FormMaster;
use App\Models\ListLaporanAnggaran;
use App\Models\FileFormMaster;


class PelaporanController extends Controller
{
    protected $FormMasterModel;
    protected $ListLaporanAnggaranModel;
    protected $FileFormMasterModel;


    public function __construct(
       FormMaster $FormMaster, 
       ListLaporanAnggaran $ListLaporanAnggaran, 
       FileFormMaster $FileFormMaster )
    {
        $this->FormMasterModel = $FormMaster;
        $this->ListLaporanAnggaranModel = $ListLaporanAnggaran;
        $this->FileFormMasterModel = $FileFormMaster;
        $this->userCabang = '00';
        $this->userDivisi = '16';
        
    }

    public function index(Request $request) 
    {

        $filter = null;
        $editable = true;
        $setting = array('editable' => true,
                    'berkas'=>true,
                    'master'=>true,
                    'status'=>"Tambah",
                    'jenis_berkas'=>"download",
                    'kategori'=>'laporan anggaran'

            );

        if(isset($request->cari_tahun)){
            $filter = array('tahun' => $request->cari_tahun,
                    'unit_kerja' =>$request->cari_unit_kerja,
                    'kategori' =>$request->cari_kategori,
                    'keyword' =>$request->cari_keyword,
                );
        }

        return view('anggaran.master.pelaporan', [
            'title' => 'Form Master',
            'sub_title' => 'Pelaporan Anggaran dan Kegiatan',
            'setting' => $setting , 
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function form_master($kategori,$id,$type) 
    {

        $filter =  array(
                'id'        => $id,
                'kategori'  => $kategori

            );
        $setting = array('editable' => false,
                    'berkas'        =>true,
                    'edit'          =>false,
                    'insert'          =>false,
                    'status'        =>"View",
                    'jenis_berkas'  =>"upload",
                    'kategori'      =>$kategori,
                    'id_form_master'=>$id,
                    'table'         => true

            );

        $sub_title = "";
        if($kategori == "laporan_anggaran"){
            if($type == "1"){
                $setting['edit'] = true;
                $setting['jenis_berkas'] = "download";
            }
            $setting['table'] = true;
            $setting['kategori'] = "laporan anggaran";
            $sub_title = "Pelaporan Anggaran dan Kegiatan";
        }else if($kategori == "arahan_rups"){
            if($type == "1"){
                $setting['edit'] = true;
                $setting['berkas'] = false;
            }
            $setting['table'] = true;
            $setting['kategori'] = "arahan rups";
            $sub_title = "Arahan RUPS";
        }else if($kategori == "usulan_program"){
            $setting['table'] = false;
            $setting['kategori'] = "usulan program";
            $sub_title = "Usulan Program Prioritas";
        }
        

        return view('anggaran.master.pelaporan', [
            'title' => 'Form Master',
            'sub_title' => $sub_title,
            'setting' => $setting , 
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

     public function pelaporan($kategori) 
    {

        $filter = null;
        $setting = array('editable' => false,
                    'berkas'        =>true,
                    'edit'          =>false,
                    'insert'          =>false,
                    'status'        =>"Cari",
                    'jenis_berkas'  =>"upload",
                    'kategori'      =>$kategori,
                    'id_form_master'=>-1,
                    'table'         => true

            );
        $sub_title = "";
        if($kategori == "laporan_anggaran"){
            $setting['table'] = true;
            $sub_title = "Pelaporan Anggaran dan Kegiatan";
        }else if($kategori == "arahan_rups"){
            $setting['table'] = true;
            $sub_title = "Arahan RUPS";
        }else if($kategori == "3"){
            $setting['table'] = false;
            $sub_title = "Usulan Program Prioritas";
        }
        

        return view('anggaran.master.pelaporan', [
            'title' => 'Form Master',
            'sub_title' => $sub_title,
            'setting' => $setting , 
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function tambah($kategori) 
    {

        $filter = null;
        $setting = array('editable' => false,
                    'berkas'        =>true,
                    'edit'          =>true,
                    'insert'          =>true,
                    'status'        =>"Tambah",
                    'jenis_berkas'  =>"upload",
                    'kategori'      =>$kategori,
                    'id_form_master'=>-1,
                    'table'         => true

            );
        $sub_title = "";
        if($kategori == "laporan_anggaran"){
            $setting['table'] = true;
            $sub_title = "Pelaporan Anggaran dan Kegiatan";
        }else if($kategori == "arahan_rups"){
            $setting['table'] = true;
            $setting['berkas'] = false;
            $sub_title = "Arahan RUPS";
        }else if($kategori == "usulan_program"){
            $setting['table'] = false;
            $sub_title = "Usulan Program Prioritas";
        }
        

        return view('anggaran.master.pelaporan', [
            'title' => 'Form Master',
            'sub_title' => $sub_title,
            'setting' => $setting , 
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => $filter]);
    }

    public function store(Request $request){
        $form_master_insert ;
        $form_master_insert_list = $form_master_update_list = [];
        $form_master_insert_file_list  = $form_master_update_file_list = [];
        $kategori =$request->kategori;

        if($request->status == 'Tambah'){
            $anggaran_insert = [
                'tanggal_mulai'    => $request->tanggal_mulai, 
                'tanggal_selesai'  => $request->tanggal_selesai,
                'tw_dari'           => $request->tw_dari, 
                'tw_ke'             => $request->tw_ke, 
                'kategori'          => $kategori,
                'active'            => '1'];
        }


        $id_form_master;
        if($request->status == 'Tambah'){
            $formMaster=FormMaster::create($anggaran_insert);
            $id_form_master = $formMaster->id;
        }else{
            $id_form_master = $request->id_form_master;
        }

        $index = 0;
        // echo $kategori == "laporan anggaran";
        foreach (json_decode($request->list_laporan_anggaran) as $value) {
            $idBefore = '0';
            if($request->status != 'Tambah'){
                if($value->id_before == '0'){
                    $idBefore = $value->id;
                }else{
                    $idBefore = $value->id_before;
                }
            }
            if($request->status == 'Tambah'){
                // echo "baru";
                if($kategori == "laporan_anggaran"){
                    $form_master_insert_list = [
                    'program_prioritas' => $value->program_prioritas,
                    'sasaran_dicapai'   => $value->sasaran_dicapai,
                    'uraian_progress'   => $value->uraian_progress,
                    'id_before'         => $idBefore,
                    'id_form_master'    => $id_form_master,
                    'active'            => '1'
                    ];
                }else if($kategori == "arahan_rups"){
                    $form_master_insert_list = [
                    'jenis_arahan'          => $value->jenis_arahan,
                    'arahan'                => $value->arahan,
                    'progres_tindak_lanjut' => $value->progres_tindak_lanjut,
                    'id_before'             => $idBefore,
                    'id_form_master'        => $id_form_master,
                    'active'                => '1'
                    ];
                }

            }

            // echo json_encode($form_master_insert_list);

            $active_list = '0';
            if($request->setuju == 'Simpan'){
                $active_list = '1';
            }

            if($kategori == "laporan anggaran"){
                $form_master_update_list = [
                'uraian_progress'   => $value->uraian_progress,
                'active'            => $active_list,
                'updated_at'        => \Carbon\Carbon::now()
                ];
            }else if($kategori == "arahan rups"){
                $form_master_update_list = [
                'progres_tindak_lanjut' => $value->progres_tindak_lanjut,
                'active'                => $active_list,
                'updated_at'            => \Carbon\Carbon::now()
                ];
            }

            $LFormMasterInsert;
            $LFormMasterUpdate;
            if($request->status == 'Tambah'){
                $LFormMasterInsert  = ListLaporanAnggaran::create($form_master_insert_list);
            }else if($request->status == 'Simpan'){
                $LFormMasterUpdate  = ListLaporanAnggaran::where('id', $value->id)->where('active', '1')->update($form_master_update_list);
            }else{
                $LFormMasterInsert  = ListLaporanAnggaran::create($form_master_insert_list);
                $LFormMasterUpdate  = ListLaporanAnggaran::where('id', $value->id)->where('active', '1')->update($form_master_update_list);
            }

            
            $index2 = 0;
            $id_list_form_master;
            if($request->status == 'Simpan'){
                if($value->id_before== 0){
                    $id_list_form_master = $value->id;
                }else{
                    $id_list_form_master = $value->id_before;
                }  
            }else if($request->status == 'Tambah'){
                $id_list_form_master = $LFormMasterInsert->id;
            }


            // if($value->delete == "none"){
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
                                'id_list_form_master'   => $id_list_form_master,
                                'name'                  => $file_name,
                                'type'                  => $file_type,
                                'size'                  => $file_size,
                                'data'                  => $base64[1],
                                'jenis'                 => $request->jenis_berkas,
                                'kategori'              => $kategori,
                                'active'                => '1',
                                'created_at'            => \Carbon\Carbon::now(),
                                'updated_at'            => \Carbon\Carbon::now()];

                            FileFormMaster::insert($store_file_list_values);
                            $index2++;
                        }
                    }
                }
            // }
            
            $index++;

        }
        // if($request->kategori == "laporan_anggaran")
        return redirect('anggaran/pelaporan/'.$kategori."/".urlencode($id_form_master)."/0");
    }   

    public function getFiltered($id,$kategori){
        $result = [];

        if($kategori == "form_master"){
            // $result = $this->anggaranModel->where('nd_surat', $nd_surat)->orderBy('id', 'DESC')->take(5)->get();
            $result = $this->FormMasterModel->where('id', $id)->where('active','1')->get();

        }else if($kategori == "laporan_anggaran"){

            $FormMaster = $this->FormMasterModel->where('id', $id)->where('active', '1');
            foreach ($FormMaster->get() as $form_master) {
                $listLaporanAnggaran = $this->ListLaporanAnggaranModel
                    ->where('id_form_master', $form_master->id)->where('active', '1');

                
                $countIndex=0;
                foreach ($listLaporanAnggaran->get() as $list_laporan_anggaran) {
                    $id_list_Laporan_anggaran;
                    if($list_laporan_anggaran->id_before == 0){
                        $id_list_Laporan_anggaran = $list_laporan_anggaran->id;
                    }else{
                        $id_list_Laporan_anggaran = $list_laporan_anggaran->id_before;
                    }
                    $fileFormMaster = $this->FileFormMasterModel;
                    $fileList = [];
                    foreach ($fileFormMaster->get() as $file_form_master) {
                        if($file_form_master->id_list_form_master == $id_list_Laporan_anggaran){
                            $fileList[] = [
                                'id'   => $file_form_master->id,
                                'count' => $countIndex,
                                'name' => $file_form_master->name,
                                'type' => $file_form_master->type,
                                'size' => $file_form_master->size
                            ];
                        }
                    }

                    $result[] = [
                        'id'                        => $list_laporan_anggaran->id,
                        'program_prioritas'         => $list_laporan_anggaran->program_prioritas,
                        'sasaran_dicapai'           => $list_laporan_anggaran->sasaran_dicapai,
                        'uraian_progress'           => $list_laporan_anggaran->uraian_progress,
                        'id_before'                 => $list_laporan_anggaran->id_first,
                        'file'  => $fileList
                        
                    ];
                    $countIndex++;
                }  
            }
            
        }

        
        return response()->json($result);
    }

    public function removeFormMasterAll(){

                \DB::table('form_master')->delete();
                \DB::table('list_laporan_anggaran')->delete();
                \DB::table('file_form_master')->delete();
    }

}
