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

    public function index() 
    {

        $editable = false;
        $displayEdit = 'none';
        $displaySave = 'none';
        $displaySend = 'none';
        $displaySearch = 'block';
        return view('anggaran.index', [
            'title' => 'Informasi Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => '',
            'editable' => $editable , 
            'status' => 'edit',
            'filters' =>null,
            'display' => array('edit' => $displayEdit,
                    'save' => $displaySave,
                    'send' => $displaySend,
                    'search' => $displaySearch)]);
    }

    public function tambah_anggaran() 
    {

        
        $editable = true;
        $displayEdit = 'none';
        $displaySave = 'block';
        $displaySend = 'block';
        $displaySearch = 'none';
        return view('anggaran.index', [
            'title' => 'Tambah Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'nd_surat' => '',
            'editable' => $editable , 
            'status' => 'tambah',
            'filters' =>null,
            'display' => array('edit' => $displayEdit,
                    'save' => $displaySave,
                    'send' => $displaySend,
                    'search' => $displaySearch)]);
    }

    public function edit_anggaran($nd_surat,$status) 
    {   

        $editable = false;
        $displayEdit = 'block';
        $displaySave = 'none';
        $displaySend = 'none';
        $displaySearch = 'block';
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
            'filters' => array('nd_surat' => $nd_surat),
            'display' => array('edit' => $displayEdit,
                    'save' => $displaySave,
                    'send' => $displaySend,
                    'search' => $displaySearch)]);
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
        return view('anggaran.persetujuan2', [
            'title' => 'Persetujuan Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'reject' => $reject,
            'editable' => $editable , 
            'filters' => array('nd_surat' => $nd_surat)]);
    }

    public function riwayat() 
    {
        return view('anggaran.history', [
            'title' => 'Riwayat Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'filters' => null]);
    }

    public function store(Request $request)
    {
        $anggaran_insert = $anggaran_update = [];
        $anggaran_insert_list = $anggaran_update_list = [];
        $anggaran_insert_file_list  = $anggaran_insert_file_list = [];
        $status = "";
        $setuju = "";

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


        if($request->setuju =='Kirim'){
            $status = "2";
            // if()
            $setuju = (int)$setuju+1;
            if($setuju == 2){
                $status = "1";
            }else if($setuju == 9){
                $status = "3";
            }

            // if($setuju == "-1"){
            //     $setuju = "0";
            // }else if($setuju == "0"){
            //     $setuju = "1";
            // }else if($setuju == "1"){
            //     $status = "1";
            //     $setuju = "2";
            // }else if($setuju == "2"){
            //     $setuju = "3";
            // }else if($setuju == "3"){
            //     $setuju = "4";
            // }else if($setuju == "4"){
            //     $setuju = "5";
            // }else if($setuju == "5"){
            //     $setuju = "6";
            // }else if($setuju == "6"){
            //     $setuju = "7";
            // }else if($setuju == "7"){
            //     $setuju = "8";
            // }else if($setuju == "8"){
            //     $status = "3";
            //     $setuju = "9";
            // }
        }else if($request->setuju =='Simpan'){
            $status = "1";

        }else if($request->setuju =='Tolak'){
            $status = "1";
            if($setuju == "1"||$setuju == "0"){
                $setuju="-1";
            }else if($setuju != "3"||$setuju == "3"){
                $setuju="1";
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
            'keterangan'        => '',
            'active'            => '1',
            'created_at'        => \Carbon\Carbon::now(),
            'updated_at'        => \Carbon\Carbon::now()];
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
        'keterangan'        => '',
        'active'            => $active,
        'updated_at'        => \Carbon\Carbon::now()];
        
        // echo $request->status;
        // echo $request->setuju;
       
        if($request->status == 'tambah'){
            Anggaran::insert($anggaran_insert);
        }else if($request->status == 'edit' && $request->setuju == 'Simpan'){
            Anggaran::where('nd_surat', $request->nd_surat)->where('active', '1')->update($anggaran_update);
        }else{
            Anggaran::where('nd_surat', $request->nd_surat)->where('active', '1')->update($anggaran_update);
            Anggaran::insert($anggaran_insert);
        }
            
        $index = 1;
        foreach (json_decode($request->list_anggaran_values) as $value) {
            $idBefore = '0';
            if($request->setuju == 'Kirim'||$request->setuju == 'Tolak'){
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
                    'nd_surat'            => $request->nd_surat,
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
                'nd_surat'            => $request->nd_surat,
                'active'            => $active_list
                ];

            $LAnggaranInsert;
            $LAnggaranUpdate;
            if($request->status == 'tambah'){
                $LAnggaranInsert  = ListAnggaran::create($anggaran_insert_list);
                // echo "tambah";
            }else if($request->status == 'edit'&& $request->setuju == 'Simpan'){
                $LAnggaranUpdate  = ListAnggaran::where('id', $value->id)->where('active', '1')->update($anggaran_update_list);
                
                // echo "edit simpan";  
            }else{

                // echo "lainnya";
                $LAnggaranInsert  = ListAnggaran::create($anggaran_insert_list);
                $LAnggaranUpdate  = ListAnggaran::where('id', $value->id)->where('active', '1')->update($anggaran_update_list);
            }

            if($request->status == 'tambah'){
                $index2 = 1;
                foreach ($value->files as $values){
                    $data = $_POST['file_'.$index."_".$index2];
                    $base64 = explode(";base64,", $data);
                    $store_file_list_values = [
                        'id_list_anggaran' => $LAnggaranInsert->id,
                        'name'            => $values->name,
                        'type'           => $values->type,
                        'size'           => $values->size,
                        'data'           => $base64[1],
                        'created_at'    => \Carbon\Carbon::now(),
                        'updated_at'    => \Carbon\Carbon::now()];

                    FileListAnggaran::insert($store_file_list_values);
                    $index2++;
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
            session()->flash('setuju', true);
        }
        $status_view = redirect('anggaran/edit/'.$request->nd_surat.'/0'); 
        // echo $setuju;
        if($setuju != "-1"){
            $status_view = redirect('anggaran/persetujuan/'.$request->nd_surat.'/1');
        }
        // else if($request->setuju =='Tolak'&&)
        // else if($setuju == ""){
        //     $status_view = redirect('anggaran/edit/'.$request->nd_surat.'/0');
        // }else{
        //     $status_view = redirect('anggaran/persetujuan/'.$request->nd_surat.'/2');
        // }
        return $status_view;
        // return redirect('anggaran/persetujuan/'.$request->nd_surat.'/1');
    }

    public function inactive($nd_surat){

    }

    public function getFiltered($nd_surat,$type){
        $result = [];

        if($type == "anggaran"){
            $result = $this->anggaranModel->where('nd_surat', $nd_surat)->where('active', '1')->get();

        }else if($type == "list_anggaran"){
            $listAnggaran = $this->listAnggaranModel->where('nd_surat', $nd_surat)->where('active', '1');
            $fileListAnggaran = $this->fileListAnggaranModel;
            
            foreach ($listAnggaran->get() as $list_anggaran) {

                $fileList = [];
                foreach ($fileListAnggaran->get() as $file_list_anggaran) {
                    if($file_list_anggaran->id_list_anggaran == $list_anggaran->id||$file_list_anggaran->id_list_anggaran == $list_anggaran->id_first){
                        $fileList[] = [
                            'id_list_anggaran'   => $file_list_anggaran->id_list_anggaran,
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
                    // 'file'  => 0
                    
                ];
            }
        }

        
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

                // $second = $this->divisiModel->select('DESCRIPTION', 'VALUE');
                // $return = $this->kanCabModel->select('DESCRIPTION', 'VALUE')->union($second)->get();
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

    public function unduh_file($id,$nd_surat){

        ignore_user_abort(true);

        $anggaran = $this->anggaranModel->where('nd_surat',$nd_surat);
        $tanggal = "";

        foreach ($anggaran->get() as $value) {

            $tanggal = $value->tanggal;
        }

        $listAnggaran = $this->listAnggaranModel->where('id',$id)->where('nd_surat',$nd_surat);
        $mata_anggaran = "";

        foreach ($listAnggaran->get() as $list_anggaran) {

            $mata_anggaran = $list_anggaran->mata_anggaran;
        }

        $fileListAnggaran = $this->fileListAnggaranModel->where('id_list_anggaran',$id);
        $files = array(); 
        foreach ($fileListAnggaran->get() as $file_list_anggaran) {

            $decoded = base64_decode($file_list_anggaran->data);
            $file = $file_list_anggaran->name;
            $files[] = $file;
            file_put_contents($file, $decoded);
        }

        $zipname = rand(1000,10000)."-".$tanggal."-".$nd_surat.'-'.$mata_anggaran."-".".zip";
        $zip = new \ZipArchive;
        // $count = 0;
        foreach ($files as $f) {
            // $count++;
            if($zip->open($zipname, \ZipArchive::CREATE) === TRUE) {
                // $new_filename = substr($f,strrpos($f,'/') + 1);
                // $zip->addFile($f,$new_filename);
                $zip->addFile($f);

                // unlink($f);
            } else {

            }
        }
        // echo $count;
        $zip->close(); 

        if (file_exists($zipname)) {
            $timeToCache = 60;
            header('Content-Description: File Transfer');
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename='.basename($zipname));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: max-age='.$timeToCache);
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zipname));
            ob_clean();
            flush();
            readfile($zipname);
            unlink($zipname);
            foreach ($files as $f) {
                unlink($f); 
            }
            exit;
        } else {
            exit("Could not find Zip file to download");
        }
    }


    public function removeAnggaranAll(){

                \DB::table('anggaran')->delete();
                \DB::table('list_anggaran')->delete();
                \DB::table('file_list_anggaran')->delete();
    }

}
