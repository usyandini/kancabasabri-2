<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;


use App\Models\AkunBank;
use App\Models\KantorCabang;
use App\Models\Program;
use App\Models\Divisi;
use App\Models\SubPos;
use App\Models\Kegiatan;
use App\Models\RejectReason;
class ItemController extends Controller
{

    public function index()
    {
    	return view('master.item.index');
    }

    public function create()
    {
    	return view('master.item.tambah');
    }

    public function reason()
    {
    	$reject_reasons = RejectReason::all();
    	return view('master.reason.index', compact('reject_reasons'));
    }


    public function store(Request $request)
    {
         // memvalidasi inputan users, form tidak boleh kosong (required)
         // alasan, keterangan adalah name yang ada di form, contoh name="nama_kendaran" (lihat form)
         // \Validator adalah class yg ada pada Laravel untuk validasi
         // $request->all() adalah semua inputan dari form kita validasi
 
         $validate = \Validator::make($request->all(), [
                 'alasan' => 'required',
                 'keterangan' => 'required'
                 
             ],
 
             // $after_save adalah isi session ketika form kosong dan di kembalikan lagi ke form dengan membawa session di bawah ini (lihat form bagian part alert), dengan keterangan error dan alert warna merah di ambil dari 'alert' => 'danger', dst.
 
             $after_save = [
                 'alert' => 'danger',
                 'title' => 'Oh wait!',
                 'text-1' => 'Ada kesalahan',
                 'text-2' => 'Silakan coba lagi.'
             ]);
 
         // jika form kosong maka artinya fails() atau gagal di proses, maka di return redirect()->back()->with('after_save', $after_save) artinya page di kembalikan ke form dengan membawa session after_save yang sudah kita deklarasi di atas.
 
         if($validate->fails()){
             return redirect()->back()->with('after_save', $after_save);
         }
 
         // $after_save adalah isi session ketika data berhasil disimpan dan di kembalikan lagi ke form dengan membawa session di bawah ini (lihat form bagian part alert), dengan keterangan success dan alert warna merah di ganti menjadi warna hijau di ambil dari 'alert' => 'success', dst.
 
         $after_save = [
             'alert' => 'success',
             'title' => 'God Job!',
             'text-1' => 'Tambah lagi',
             'text-2' => 'Atau kembali.'
         ];
 
         // jika form tidak kosong artinya validasi berhasil di lalui maka proses di bawah ini di jalankan, yaitu mengambil semua kiriman dari form
         // content, type adalah nama kolom yang ada di table kendaraan
         // sedangkan $request->alasan adalah isi dari kiriman form
 
         $data = [
             'content' => $request->alasan,
             'type' => $request->keterangan
         ];
 
         // di bawah ini proses insert ke tabel reject_reasons
 
         $store = \App\Models\RejectReason::insert($data);
 
         // jika berhasil kembalikan ke page form dengan membawa session after_save success.
        
         return redirect()->back()->with('after_save', $after_save);
     }
}
