<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;
use App\Services\FileUpload;
use App\Services\NotificationSystem;
use PDF;

// table -> tl_tanggal :
// status = 1 -> dalam proses
// status = 2 -> selesai
// kirim = 1 -> belum dikirim ke unitkerja
// kirim = 2 -> sudah dikirim oleh SPI ke unitkerja
// kirim = 3 -> sudah dikirim oleh unit kerja ke SPI
// internal = 1 -> untuk tindak lanjut internal
// internal = 2 -> untuk tindak lanjut eksternal

class TindaklanjutController extends Controller
{

    public function index() 
    {
    	$a =DB::table('tl_tanggal')
        ->orderBy('id1','DESC')
        ->where('internal','1')
        ->paginate(10);
        return view('tindaklanjut.unitkerja', compact('a'));
	}

	public function unitkerjainternal($id) 
    {

     // $a =DB::table('tl_tanggal')
     //    ->orderBy('id1','DESC')
     //    ->where('internal','1')
     //    ->where('id1',$id)
     //    ->paginate(10);

        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('kirim', '<>', '1')
        	 ->where('internal', '1')
        	 ->where('id1', $id)
        	 ->orderBy('id2','DESC')->get();
        return view('tindaklanjut.tindaklanjutin', compact('a'));
	}

	public function cari_unitkerjainternal(Request $request) 
    {

    	$unitkerja = $request->unitkerja;
        $tgl_mulai = $request->tgl_mulai;
        $a = DB::table('tl_tanggal')
        	 ->where('kirim', '<>', '1')
        	 ->where('internal', '1')
        	 ->where('unitkerja', $unitkerja)
        	 ->where('tgl_mulai', $tgl_mulai)->first();

       	$id = $a->id1;
       	return redirect('tindaklanjutinternal/'.$id);


	}

	public function unitkerjaex() 
    {
    	$a =DB::table('tl_tanggal')
        ->orderBy('id1','DESC')
        ->where('internal','2')
        ->paginate(10);
        return view('tindaklanjut.unitkerjaex', compact('a'));
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
         $tgl_input = date('Y-m-d');
         $internal = '1';
         $kirim = '1';
         $data = [
             'unitkerja' => $a,
             'tgl_mulai' => $b,
             'durasi' => $durasi,
             'tgl_selesai' => $tgl_selesai,
             'tgl_input' => $tgl_input,
             'internal' => $internal,
             'kirim' => $kirim
         ];
        
         $store = DB::table('tl_tanggal')->insert($data);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

    public function store_unitkerjaex(Request $request)
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
         $tgl_input = date('Y-m-d');
         $internal = '2';
         $kirim = '1';
         $data = [
             'unitkerja' => $a,
             'tgl_mulai' => $b,
             'durasi' => $durasi,
             'tgl_selesai' => $tgl_selesai,
             'tgl_input' => $tgl_input,
             'internal' => $internal,
             'kirim' => $kirim
         ];
        
         $store = DB::table('tl_tanggal')->insert($data);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

     public function store_temuan(Request $request)
    {   
    	$id1=$request->id1;
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
         $kirim='1';
         $data2 = [
             'kirim' => $kirim
         ];
         DB::table('tl_tanggal')->where('id1', $id1)->update($data2);
         $store = DB::table('tl_temuan')->insert($data);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

    public function store_rekomendasi(Request $request)
    {   
        $id2=$request->id2;
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
         $kirim='1';
         $data2 = [
             'kirim' => $kirim
             
         ];
         $temuan = DB::table('tl_temuan')->where('id2', $id2)->first();
         $id1 = $temuan->id_unitkerja;
 		 DB::table('tl_tanggal')->where('id1', $id1)->update($data2);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

    public function store_tindaklanjut(Request $request)
    {   
        $id3=$request->id3;
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
         $kirim='1';
         $data2 = [
             'kirim' => $kirim
             
         ];
 		 DB::table('tl_tanggal')->where('id1', $id1)->update($data2);
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
 		 $kirim='1';
         $data2 = [
             'kirim' => $kirim
             
         ];
         $temuan = DB::table('tl_temuan')->where('id2', $id2)->first();
         $id1 = $temuan->id_unitkerja;
 		 DB::table('tl_tanggal')->where('id1', $id1)->update($data2);
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


     public function kirim_tindaklanjut(Request $request, $id1)
     {
         $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil dikirim ke unit kerja internal.'
         ];
         $a = '2';
         $data = [
             'kirim' => $a
         ];
 
         $update = DB::table('tl_tanggal')->where('id1', $id1)->update($data);
         NotificationSystem::send($id1, 38);
         return redirect()->back()->with('after_update', $after_update);
         
         
     }  

     public function kirim_tindaklanjut2(Request $request, $id1)
     {
         $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil dikirim ke SPI.'
         ];
         $a = '3';
         $data = [
             'kirim' => $a
         ];
 
         $update = DB::table('tl_tanggal')->where('id1', $id1)->update($data);

         NotificationSystem::send($id1, 39);
         return redirect()->back()->with('after_update', $after_update);
         
         
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
 		 $kirim='1';
         $data2 = [
             'kirim' => $kirim
             
         ];
         $rekomendasi = DB::table('tl_rekomendasi')->where('id3', $id3)->first();
         $id2 = $rekomendasi->id_temuan;
         $temuan = DB::table('tl_temuan')->where('id2', $id2)->first();
         $id1 = $temuan->id_unitkerja;
 		 DB::table('tl_tanggal')->where('id1', $id1)->update($data2);
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
            header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60*60))); // 1 hour
            header('Cache-Control: must-revalidate');
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
        	 ->orderBy('id2','DESC')
        	 ->get();
       
        return view('tindaklanjut.tindaklanjut', compact('a'));
	}

	public function tindaklanjutext(Request $request, $id1)
    {
        
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('id1', $id1)
        	 ->orderBy('id2','DESC')->get();
       
        return view('tindaklanjut.tindaklanjutext', compact('a'));
	}

	

	public function tindaklanjutinternal(Request $request)
    {
        $unitkerja = $request->get('unitkerja');
        $tgl_mulai = $request->get('tgl_mulai');
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('kirim', '<>', '1')
        	 ->where('internal', '1')
        	 ->where('unitkerja', $unitkerja)
        	 ->where('tgl_mulai', $tgl_mulai)
        	 ->orderBy('id2','DESC')->get();

        return view('tindaklanjut.tindaklanjutin', compact('unitkerja', 'tgl_mulai', 'a'));
	}

	public function tindaklanjutmaster(Request $request)
    {
        $unitkerja = $request->get('unitkerja');
        $tgl_mulai = $request->get('tgl_mulai');
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('unitkerja', $unitkerja)
        	 ->where('tgl_mulai', $tgl_mulai)
        	 ->get();
        
        return view('tindaklanjut.tindaklanjut', compact('unitkerja', 'tgl_mulai', 'a'));
		 
	}

	public function tindaklanjuteksternal(Request $request)
    {
        $unitkerja = $request->get('unitkerja');
        $tgl_mulai = $request->get('tgl_mulai');
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('unitkerja', $unitkerja)
        	 ->where('tgl_mulai', $tgl_mulai)
        	 ->get();
        
        return view('tindaklanjut.tindaklanjutext', compact('unitkerja', 'tgl_mulai', 'a'));
		 
	}

	public function print_tindaklanjut(Request $request, $id1)
    {
        
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('id1', $id1)
        	 ->orderBy('id2','DESC')->get();
       
        return view('tindaklanjut.cetak', compact('a'));
	}

	public function export_tindaklanjut(Request $request, $id1, $type)
    {
        $a = DB::table('tl_tanggal')
        	 ->leftjoin('tl_temuan', 'tl_tanggal.id1','=','tl_temuan.id_unitkerja')
        	 ->leftjoin('tl_rekomendasi', 'tl_temuan.id2','=','tl_rekomendasi.id_temuan')
        	 ->leftjoin('tl_tindaklanjut', 'tl_rekomendasi.id3','=','tl_tindaklanjut.id_rekomendasi')
        	 ->where('id1', $id1)
        	 ->orderBy('id2','DESC')->get();
        $excel = false;
        $data = ['a' => $a, 'excel' => $excel];
        //export ke pdf
        switch($type){
            case 'pdf':
                $pdf = PDF::loadView('tindaklanjut.export', $data);
                return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('tindak-lanjut-temuan-'.date("dmY").'.pdf');
                break;
            case 'excel':
                $excel = true;
                return view('tindaklanjut.export', compact('a', 'excel'));
                break;
        }
	}

	public function myformAjax($unitkerja)
    {
    	$dec_unit_kerja=urldecode($unitkerja);
        $tgl_mulai = DB::table('tl_tanggal')
                    ->where('unitkerja',$dec_unit_kerja)
                    ->where('internal','1')
                    ->where('kirim','<>','1')
                    ->lists('tgl_mulai');
        return json_encode($tgl_mulai);
    }

    public function myformAjaxunitkerja($unitkerja)
    {
    	$dec_unit_kerja=urldecode($unitkerja);
        $tgl_mulai = DB::table('tl_tanggal')
                    ->where('unitkerja',$dec_unit_kerja)
                    ->where('internal','1')
                    ->lists('tgl_mulai');
        return json_encode($tgl_mulai);
    }

    public function myformAjaxtindaklanjut($unitkerja)
    {
    	$dec_unit_kerja=urldecode($unitkerja);
        $tgl_mulai = DB::table('tl_tanggal')
                    ->where('unitkerja',$dec_unit_kerja)
                    ->where('internal','2')
                    ->lists('tgl_mulai');
        return json_encode($tgl_mulai);
    }
}