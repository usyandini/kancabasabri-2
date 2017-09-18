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
               
        $a=$request->alasan;
        $b=$request->keterangan;
        $db = \App\Models\RejectReason::where('content', $a)->where('type', $b)->get();
        $db = $db->toArray(); 

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
             'content' => $request->alasan,
             'type' => $request->keterangan
         ];
 
         
 
         $store = \App\Models\RejectReason::insert($data);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

     public function update(Request $request, $id)
     {
         
         $a=$request->alasan;
         $b=$request->keterangan;
         $db = \App\Models\RejectReason::where('content', $a)->where('type', $b)->where('id','<>', $id)->get();
         $db = $db->toArray(); 

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
             
             'content' => $request->alasan,
             'type' => $request->keterangan
         ];
 
         
         $update = \App\Models\RejectReason::where('id', $id)->update($data);

         return redirect()->back()->with('after_update', $after_update);
         }
         
     }


     public function delete(Request $request, $id)
     {
         
 
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
         
 
         $update = \App\Models\RejectReason::where('id', $id)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
         

     }
}
