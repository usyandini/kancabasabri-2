<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;
use App\Services\FileUpload;


class TindaklanjutController extends Controller
{

    public function index() 
    {
    	 
    	$a =DB::table('tl_tanggal')->simplePaginate(10);
        return view('tindaklanjut.unitkerja', compact('a'));
	}

    public function store_unitkerja(Request $request)
    {   
        $a=$request->unitkerja;
        $b=$request->tgl_mulai;
        $db = DB::table('tl_tanggal')->where('unitkerja', $a)->where('tgl_mulai', $b)->get();
        if($db){
            $after_save = [
             'alert' => 'danger',
             'title' => 'Data gagal ditambah, data sudah ada.'
             ];
             return redirect()->back()->with('after_save', $after_save);
         }
		else{
         
 
         $after_save = [
             'alert' => 'success',
             'title' => 'Data berhasil ditambah.'
             
         ];
         $durasi=$request->durasi;
         $tgl_selesai= date('Y-m-d', strtotime('+'. $durasi .'days', strtotime($b)));
         $data = [
             'unitkerja' => $a,
             'tgl_mulai' => $b,
             'durasi' => $durasi,
             'tgl_selesai' => $tgl_selesai
         ];
        
         $store = DB::table('tl_tanggal')->insert($data);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

     public function store_temuan(Request $request, $id1)
    {   
        $a=$request->temuan;
        $db = DB::table('tl_temuan')->where('temuan', $a)->where('id_unitkerja', $id1)->get();
        if($db){
            $after_save = [
             'alert' => 'danger',
             'title' => 'Data gagal ditambah, data sudah ada.'
             ];
             return redirect()->back()->with('after_save', $after_save);
         }
		else{
         
 
         $after_save = [
             'alert' => 'success',
             'title' => 'Data berhasil ditambah.'
             
         ];
         $data = [
         	 'id_unitkerja' => $id1,
             'temuan' => $a
         ];
        
         $store = DB::table('tl_temuan')->insert($data);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

    public function store_rekomendasi(Request $request, $id2)
    {   
        $a=$request->rekomendasi;
        $db = DB::table('tl_rekomendasi')->where('rekomendasi', $a)->where('id_temuan', $id2)->get();
        if($db){
            $after_save = [
             'alert' => 'danger',
             'title' => 'Data gagal ditambah, data sudah ada.'
             ];
             return redirect()->back()->with('after_save', $after_save);
         }
		else{
         
 
         $after_save = [
             'alert' => 'success',
             'title' => 'Data berhasil ditambah.'
             
         ];
         $data = [
         	 'id_temuan' => $id2,
             'rekomendasi' => $a
         ];
        
         $store = DB::table('tl_rekomendasi')->insert($data);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

    public function store_tindaklanjut(Request $request, $id3)
    {   
        $a=$request->tindaklanjut;
        $db = DB::table('tl_tindaklanjut')->where('tindaklanjut', $a)->where('id_rekomendasi', $id3)->get();
        
        if($db){
            $after_save = [
             'alert' => 'danger',
             'title' => 'Data gagal ditambah, data sudah ada.'
             ];
             return redirect()->back()->with('after_save', $after_save);
         }
         $berkas = $request->inputs;

         if (isset($berkas)) {
            $fileUpload = new FileUpload();
            $after_save = [
             'alert' => 'success',
             'title' => 'Data berhasil ditambah.'
            ];

	        $value['id_rekomendasi'] = $id3;
	        $value['tindaklanjut'] = $a;
	        $value['status'] = $request->status;
	        $value['keterangan'] = $request->keterangan;
			$value['name'] = $berkas->getClientOriginalName();
			$value['size'] = $berkas->getClientSize();
			$value['type'] = $berkas->getClientMimeType();
			$value['data'] = base64_encode(file_get_contents($berkas));
	        DB::table('tl_tindaklanjut')->insert($value);
            return redirect()->back()->with('after_save', $after_save);
        }else {
        	$after_save = [
             'alert' => 'success',
             'title' => 'Data berhasil ditambah.'
            ];
	         $data = [
	         	 'id_rekomendasi' => $id3,
	             'tindaklanjut' => $a,
	             'status' => $request->status,
	             'keterangan' => $request->keterangan
	         ];
	        
	         $store = DB::table('tl_tindaklanjut')->insert($data);
	       
	         return redirect()->back()->with('after_save', $after_save);

        }
	}

	public function update_tindaklanjut(Request $request, $id3)
     {
         
         $a=$request->tindaklanjut;
         $id4=$request->id4;

         $db = DB::table('tl_tindaklanjut')->where('tindaklanjut', $a)->where('id_rekomendasi', $id3)->where('id4','<>', $id4)->get();
         if($db){
            $after_update = [
             'alert' => 'danger',
             'title' => 'Data gagal diubah, data sudah ada.'
             ];
             return redirect()->back()->with('after_update', $after_update);
         }
         $berkas = $request->inputs;
         if (isset($berkas)) {
            $fileUpload = new FileUpload();
            $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil diubah.'
             ];

	        $value['id_rekomendasi'] = $id3;
	        $value['tindaklanjut'] = $a;
	        $value['status'] = $request->status;
	        $value['keterangan'] = $request->keterangan;
			$value['name'] = $berkas->getClientOriginalName();
			$value['size'] = $berkas->getClientSize();
			$value['type'] = $berkas->getClientMimeType();
			$value['data'] = base64_encode(file_get_contents($berkas));
	        DB::table('tl_tindaklanjut')->where('id4', $id4)->update($value);
            return redirect()->back()->with('after_update', $after_update);
        }
        else {
        	$after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil diubah.'
             ];
	         $data = [
	         	 'id_rekomendasi' => $id3,
	             'tindaklanjut' => $a,
	             'status' => $request->status,
	             'keterangan' => $request->keterangan
	         ];
 
         $update = DB::table('tl_tindaklanjut')->where('id4', $id4)->update($data);

         return redirect()->back()->with('after_update', $after_update);
         }
         
     }

	public function update_temuan(Request $request, $id1)
     {
         
         $a=$request->temuan;
         $id2=$request->id2;

         $db = DB::table('tl_temuan')->where('temuan', $a)->where('id_unitkerja', $id1)->where('id2','<>', $id2)->get();
         if($db){
            $after_update = [
             'alert' => 'danger',
             'title' => 'Data gagal diubah, data sudah ada.'
             ];
             return redirect()->back()->with('after_update', $after_update);
         }
         else{
 
         $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil diubah.'
         ];
 
         $data = [
             'temuan' => $a
             
         ];
 
         $update = DB::table('tl_temuan')->where('id2', $id2)->update($data);

         return redirect()->back()->with('after_update', $after_update);
         }
         
     }      

     public function update_rekomendasi(Request $request, $id2)
     {
         
         $a=$request->rekomendasi;
         $id3=$request->id3;

         $db = DB::table('tl_rekomendasi')->where('rekomendasi', $a)->where('id_temuan', $id2)->where('id3','<>', $id3)->get();
         if($db){
            $after_update = [
             'alert' => 'danger',
             'title' => 'Data gagal diubah, data sudah ada.'
             ];
             return redirect()->back()->with('after_update', $after_update);
         }
         else{
 
         $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil diubah.'
         ];
 
         $data = [
             'rekomendasi' => $a
             
         ];
 
         $update = DB::table('tl_rekomendasi')->where('id3', $id3)->update($data);

         return redirect()->back()->with('after_update', $after_update);
         }
         
     }      

     public function update_unitkerja(Request $request, $id1)
     {
         
         $a=$request->unitkerja;
         $b=$request->tgl_mulai;
         $db = DB::table('tl_tanggal')->where('unitkerja', $a)->where('tgl_mulai', $b)->where('id1','<>', $id1)->get();
         if($db){
            $after_update = [
             'alert' => 'danger',
             'title' => 'Data gagal diubah, data sudah ada.'
             ];
             return redirect()->back()->with('after_update', $after_update);
         }
         else{
 
         $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil diubah.'
         ];
 
         $durasi=$request->durasi;
         $tgl_selesai= date('Y-m-d', strtotime('+'. $durasi .'days', strtotime($b)));
         
         $data = [
             'unitkerja' => $a,
             'tgl_mulai' => $b,
             'tgl_selesai' => $tgl_selesai,
             'durasi' => $durasi
         ];
 
         $update = DB::table('tl_tanggal')->where('id1', $id1)->update($data);

         return redirect()->back()->with('after_update', $after_update);
         }
         
     }      

     
    public function delete_unitkerja(Request $request, $id1)
     {
         
 
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
         $update = \DB::table('tl_tanggal')->where('id1', $id1)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
      }

     public function delete_temuan(Request $request, $id2)
     {
         
 
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
         $update = \DB::table('tl_temuan')->where('id2', $id2)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
      }

     public function delete_rekomendasi(Request $request, $id3)
     {
         
 
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
         $update = \DB::table('tl_rekomendasi')->where('id3', $id3)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
      }
     
    public function delete_tindaklanjut(Request $request, $id4)
     {
         
 
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
         $update = \DB::table('tl_tindaklanjut')->where('id4', $id4)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
      }

    

    public function downloadberkas(Request $request, $id4)
    {
        $berkas = DB::table('tl_tindaklanjut')
        	 ->where('id4', $id4)
        	 ->first();
        $decoded = base64_decode($berkas->data);
        $file = $berkas->name;
        file_put_contents($file, $decoded);
        $data = bin2hex($decoded);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$berkas->type);
            header('Content-Disposition: inline; filename="'.basename($file).'"');
            //header('Expires: 0');
            header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60*60))); // 1 hour
            header('Cache-Control: must-revalidate');
            //header('Pragma: public');
            header('Content-Length: '.$berkas->size);
            readfile($file);
            exit($data);

        }
    }

    public function tindaklanjut(Request $request, $id1)
    {
        
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('id1', $id1)
        	 ->orderBy('temuan','rekomendasi','tindaklanjut')->get();
       
        return view('tindaklanjut.tindaklanjut', compact('a'));
	}

	public function print_tindaklanjut(Request $request, $id1)
    {
        
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('id1', $id1)
        	 ->orderBy('temuan','rekomendasi','tindaklanjut')->get();
       
        return view('tindaklanjut.cetak', compact('a'));
	}

	public function export_tindaklanjut(Request $request, $id1)
    {
        
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('id1', $id1)
        	 ->orderBy('temuan','rekomendasi','tindaklanjut')->get();
       
        return view('tindaklanjut.export', compact('a'));
	}
}