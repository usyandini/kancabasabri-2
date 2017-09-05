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
        $displayRembang = 'none';
        $displayManajemen = 'block';
        $reject = false;
        if($status == '1'){
            $displayRembang = 'block';
            $displayManajemen = 'none';
        }else if($status == '3'||$status == '4'){
            $displayRembang = 'block';
            $displayManajemen = 'none';
            $editable = true;
            if($status == '4'){
                $reject = true;
            }

        }



        return view('anggaran.persetujuan2', [
            'title' => 'Persetujuan Kegiatan dan Anggaran',
            'userCabang' =>$this->userCabang,
            'userDivisi' =>$this->userDivisi,
            'reject' => $reject,
            'editable' => $editable , 
            'filters' => array('nd_surat' => $nd_surat),
            'display' => array('rembang' => $displayRembang,
                    'manajemen' => $displayManajemen)]);
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
        $status = $request->stat_anggaran;
        $setuju = $request->persetujuan;
        if($request->setuju =='Kirim'){
            $status = "Transfer";
            if($setuju == ""){
                $setuju = $request->setuju;
            }else if($setuju == "Kirim"){
                $setuju = "Persetujuan Kanit Kerja";
            }else if($setuju == "Persetujuan Kanit Kerja"){
                $status = "Draft";
                $setuju = "Persetujuan Renbang";
            }else if($setuju == "Persetujuan Renbang"){
                $setuju = "Persetujuan Direksi";
            }else if($setuju == "Persetujuan Direksi"){
                $setuju = "Persetujuan Dekom";
            }else if($setuju == "Persetujuan Dekom"){
                $setuju = "Persetujuan Ratek";
            }else if($setuju == "Persetujuan Ratek"){
                $setuju = "Persetujuan RUPS";
            }else if($setuju == "Persetujuan RUPS"){
                $setuju = "Persetujuan FinRUPS";
            }else if($setuju == "Persetujuan FinRUPS"){
                $setuju = "Persetujuan Risalah RUPS";
            }else if($setuju == "Persetujuan Risalah RUPS"){
                $status = "Complete";
                $setuju = "Disetujui dan Ditandatangani";
            }
        }else if($request->setuju =='Simpan'){
            $status = "Draft";

        }else if($request->setuju =='Tolak'){
            $status = "Draft";
            if($setuju == "Persetujuan Kanit Kerja"||$setuju == "Kirim"||$setuju == "Persetujuan Renbang"){
                $setuju="";
            }else if($setuju != "Persetujuan Renbang"){
                $setuju="Persetujuan Renbang";
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

            // unset($store_list_values['id']);
            // $LAnggaran = ListAnggaran::create($anggaran_insert_list);
            // echo $LAnggaran->id;
            if($request->status == 'tambah'){
                $index2 = 1;
                foreach ($value->files as $values){
                   // echo $values->name."<br />"; 
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
        if($setuju == "Kirim"){
            $status_view = redirect('anggaran/persetujuan/'.$request->nd_surat.'/1');
        }else if($setuju == ""){
            $status_view = redirect('anggaran/edit/'.$request->nd_surat.'/0');
        }else{
            $status_view = redirect('anggaran/persetujuan/'.$request->nd_surat.'/2');
        }
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
