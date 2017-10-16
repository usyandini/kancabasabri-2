<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;
use App\Services\FileUpload;
use App\Services\NotificationSystem;


class PengajuanDroppingController extends Controller
{

    public function index() 
    {
    	$a =DB::table('pengajuan_dropping_cabang')
        ->orderBy('id','DESC')->where('kirim','<>','3')
        ->get();
        return view('pengajuan_dropping.pengajuan', compact('a'));
	}

    public function myformAjax($cabang)
    {
        $dec_cabang=urldecode($cabang);
        $a =DB::table('pengajuan_dropping_cabang')
        ->where('kantor_cabang',$dec_cabang)
        ->where('kirim','<>','3')
        ->lists('tanggal');
        return json_encode($a);
    }

    public function carimyformAjax(Request $request)
    {
        $kantor_cabang = $request->get('cabang');
        $tanggal = $request->get('tanggal');
        $a = DB::table('pengajuan_dropping_cabang')
             ->where('kantor_cabang', $kantor_cabang)
             ->where('tanggal', $tanggal)
             ->get();
        
        return view('pengajuan_dropping.pengajuan', compact('kantor_cabang', 'tanggal', 'a'));
         
    }

	public function acc() 
    {
    	$a =DB::table('pengajuan_dropping_cabang')
    	->where('kirim','<>','1')->where('kirim','<>','4')
        ->orderBy('id','DESC')
        ->get();
        return view('pengajuan_dropping.approval', compact('a'));
	}

    public function myformAjax1($cabang)
    {
        $dec_cabang=urldecode($cabang);
        $a =DB::table('pengajuan_dropping_cabang')
        ->where('kirim','<>','1')->where('kirim','<>','4')
        ->where('kantor_cabang',$dec_cabang)
        ->lists('tanggal');
        return json_encode($a);
    }

    public function carimyformAjax1(Request $request)
    {
        $kantor_cabang = $request->get('cabang');
        $tanggal = $request->get('tanggal');
        $a = DB::table('pengajuan_dropping_cabang')
             ->where('kantor_cabang', $kantor_cabang)
             ->where('tanggal', $tanggal)
             ->get();
        
        return view('pengajuan_dropping.approval', compact('kantor_cabang', 'tanggal', 'a'));
    }

    public function acc2() 
    {
        $a =DB::table('pengajuan_dropping_cabang')
        ->where('kirim','<>','1')->where('kirim','<>','2')
        ->orderBy('id','DESC')
        ->get();
        return view('pengajuan_dropping.approval2', compact('a'));
    }

    public function myformAjax2($cabang)
    {
        $dec_cabang=urldecode($cabang);
        $a =DB::table('pengajuan_dropping_cabang')
        ->where('kirim','<>','1')->where('kirim','<>','2')
        ->where('kantor_cabang',$dec_cabang)
        ->lists('tanggal');
        return json_encode($a);
    }

    public function carimyformAjax2(Request $request)
    {
        $kantor_cabang = $request->get('cabang');
        $tanggal = $request->get('tanggal');
        $a = DB::table('pengajuan_dropping_cabang')
             ->where('kantor_cabang', $kantor_cabang)
             ->where('tanggal', $tanggal)
             ->get();
        
        return view('pengajuan_dropping.approval2', compact('kantor_cabang', 'tanggal', 'a'));
    }

    public function verifikasi($id) 
    {
        $a =DB::table('pengajuan_dropping_cabang')
        ->where('id',$id)
        ->get();
        return view('pengajuan_dropping.verifikasi', compact('a'));
    }

    public function verifikasi2($id) 
    {
        $a =DB::table('pengajuan_dropping_cabang')
        ->where('id',$id)
        ->get();
        return view('pengajuan_dropping.verifikasi2', compact('a'));
    }

	public function store_pengajuandropping(Request $request)
    {   
    	$angka= $request->jumlah_diajukan;
		$nilai= str_replace('.', '', $angka);
        $a=$request->kantor_cabang;
        $b=$request->periode_realisasi;
        $c=$request->tanggal;
        $kirim='1';
        $db = DB::table('pengajuan_dropping_cabang')->where('kantor_cabang', $a)->where('periode_realisasi', $b)->where('tanggal', $c)->get();
        
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

	        $value['kantor_cabang'] = $a;
	        $value['nomor'] = $request->nomor;
	        $value['tanggal'] = $c;
	        $value['jumlah_diajukan'] = $nilai;
	        $value['periode_realisasi'] = $b;
			$value['name'] = $berkas->getClientOriginalName();
			$value['size'] = $berkas->getClientSize();
			$value['type'] = $berkas->getClientMimeType();
			$value['data'] = base64_encode(file_get_contents($berkas));
			$value['kirim'] = $kirim;
	        DB::table('pengajuan_dropping_cabang')->insert($value);
            return redirect()->back()->with('after_save', $after_save);
        }else {
        	$after_save = [
             'alert' => 'success',
             'title' => 'Data berhasil ditambah.'
            ];
	         $data = [
	         	'kantor_cabang' => $a,
		        'nomor' => $request->nomor,
		        'tanggal' => $c,
		        'jumlah_diajukan' => $nilai,
		        'periode_realisasi' => $b,
		        'kirim' => $kirim
	         ];
	        
	         $store = DB::table('pengajuan_dropping_cabang')->insert($data);
	       	 return redirect()->back()->with('after_save', $after_save);
        }
	}

	public function update_pengajuandropping(Request $request, $id)
     {
        $angka= $request->jumlah_diajukan;
		$nilai= str_replace('.', '', $angka); 
        $a=$request->kantor_cabang;
        $b=$request->periode_realisasi;
        $c=$request->tanggal;
        $db = DB::table('pengajuan_dropping_cabang')->where('kantor_cabang', $a)->where('periode_realisasi', $b)->where('tanggal', $c)
         ->where('id','<>', $id)->get();
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
            
	        $value['kantor_cabang'] = $a;
	        $value['nomor'] = $request->nomor;
	        $value['tanggal'] = $c;
	        $value['jumlah_diajukan'] = $nilai;
	        $value['periode_realisasi'] = $b;
			$value['name'] = $berkas->getClientOriginalName();
			$value['size'] = $berkas->getClientSize();
			$value['type'] = $berkas->getClientMimeType();
			$value['data'] = base64_encode(file_get_contents($berkas));
	        DB::table('pengajuan_dropping_cabang')->where('id', $id)->update($value);
            return redirect()->back()->with('after_update', $after_update);
        }
        else {
        	$after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil diubah.'
             ];
	         $data = [
	         	'kantor_cabang' => $a,
		        'nomor' => $request->nomor,
		        'tanggal' => $c,
		        'jumlah_diajukan' => $nilai,
		        'periode_realisasi' => $b
	         ];
 
         $update = DB::table('pengajuan_dropping_cabang')->where('id', $id)->update($data);

         return redirect()->back()->with('after_update', $after_update);
         }
         
     }

     public function update_verifikasi(Request $request, $id)
     {
         
        	$after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil diubah.'
             ];
             $verifikasi=$request->verifikasi;
             $keterangan=$request->keterangan;
		         $data = [
		         	'verifikasi' => $verifikasi,
		         	'keterangan' => $keterangan
		         ];

 			
         $update = DB::table('pengajuan_dropping_cabang')->where('id', $id)->update($data);

         return redirect()->back()->with('after_update', $after_update);
         
         
     }

      public function delete_pengajuandropping(Request $request, $id)
     {
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
         $update = \DB::table('pengajuan_dropping_cabang')->where('id', $id)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
      }

      public function kirim_pengajuandropping(Request $request, $id)
     {
         $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil dikirim.'
         ];
         $a = '2';
         $verifikasi = '';
         $keterangan = '';
         $data = [
             'kirim' => $a,
             'verifikasi' => $verifikasi,
             'keterangan' => $keterangan
         ];

 
         $update = DB::table('pengajuan_dropping_cabang')->where('id', $id)->update($data);
        
         NotificationSystem::send($id, 40);
         return redirect()->back()->with('after_update', $after_update);
     }

     public function kirim_pengajuandropping2(Request $request, $id)
     {
         $cek = DB::table('pengajuan_dropping_cabang')->where('id', $id)->first();
         $verifikasi=$cek->verifikasi;
         $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil dikirim.'
         ];
         if ($verifikasi == 1){
            $a = '3';
            $b = "";
            $data = [
             'kirim' => $a,
             'verifikasi' => $b,
             'keterangan' => $b
            ];
            NotificationSystem::send($id, 42);
         }
         if ($verifikasi == 2){
            $a = '1';
            $data = [
             'kirim' => $a
            ];
            NotificationSystem::send($id, 41);
         }
        $update = DB::table('pengajuan_dropping_cabang')->where('id', $id)->update($data);
        return redirect()->back()->with('after_update', $after_update);
     }

     public function kirim_pengajuandropping2lv2(Request $request, $id)
     {
         $cek = DB::table('pengajuan_dropping_cabang')->where('id', $id)->first();
         $verifikasi=$cek->verifikasi;
         $after_update = [
             'alert' => 'success',
             'title' => 'Data berhasil dikirim.'
         ];
         if ($verifikasi == 1){
            $a = '4';
            NotificationSystem::send($id, 44);
         }
         if ($verifikasi == 2){
            $a = '1';
            NotificationSystem::send($id, 43);
         }
         
         $data = [
             'kirim' => $a
         ];

         $update = DB::table('pengajuan_dropping_cabang')->where('id', $id)->update($data);
         return redirect()->back()->with('after_update', $after_update);
     }

     public function downloadberkas(Request $request, $id)
    {
        $berkas = DB::table('pengajuan_dropping_cabang')
        	 ->where('id', $id)
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

    public function print_pengajuandropping(Request $request, $id)
    {
        
        $a = DB::table('pengajuan_dropping_cabang')->where('id', $id)->get();
       
        return view('pengajuan_dropping.cetak', compact('a'));
	}  
}