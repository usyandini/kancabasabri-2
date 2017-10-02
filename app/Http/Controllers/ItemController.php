<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;
use App\Models\AkunBank;
use App\Models\KantorCabang;
use App\Models\Program;
use App\Models\Divisi;
use App\Models\SubPos;
use App\Models\Kegiatan;
use App\Models\RejectReason;
use App\Models\ProgramPrioritas;
use App\Models\ArahanRups;

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

    public function reason() : \Illuminate\View\View
    {
    	$reject_reasons = RejectReason::orderBy('id','DESC')->paginate(10);
    	return view('master.reason.index', compact('reject_reasons'));
    }

    public function program_prioritas()
    {
        $program_prioritas = ProgramPrioritas::orderBy('id','DESC')->get();
        return view('master.program_prioritas.index', compact('program_prioritas'));
    }
    
    public function arahan_rups()
    {
        $arahan_rups = ArahanRups::orderBy('id','DESC')->get();
        return view('master.arahan_rups.index', compact('arahan_rups'));
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

    public function store_program_prioritas(Request $request)
    {
               
        $a=$request->program_prioritas;
        $db = \App\Models\ProgramPrioritas::where('program_prioritas', $a)->get();
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
             'program_prioritas' => $request->program_prioritas
         ];
 
         
 
         $store = \App\Models\ProgramPrioritas::insert($data);
       
         return redirect()->back()->with('after_save', $after_save);
        }
    }

    public function store_arahan_rups(Request $request)
    {
               
        $a=$request->arahan_rups;
        $db = \App\Models\ArahanRups::where('arahan_rups', $a)->get();
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
             'arahan_rups' => $request->arahan_rups
         ];
 
         
 
         $store = \App\Models\ArahanRups::insert($data);
       
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

     public function update_program_prioritas(Request $request, $id)
     {
         
         $a=$request->program_prioritas;
         $db = \App\Models\ProgramPrioritas::where('program_prioritas', $a)->where('id','<>', $id)->get();
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
             
             'program_prioritas' => $request->program_prioritas
         ];
 
         
         $update = \App\Models\ProgramPrioritas::where('id', $id)->update($data);

         return redirect()->back()->with('after_update', $after_update);
         }
         
     }

     public function update_arahan_rups(Request $request, $id)
     {
         
         $a=$request->arahan_rups;
         $db = \App\Models\ArahanRups::where('arahan_rups', $a)->where('id','<>', $id)->get();
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
             
             'arahan_rups' => $request->arahan_rups
         ];
 
         
         $update = \App\Models\ArahanRups::where('id', $id)->update($data);

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

    public function delete_program_prioritas(Request $request, $id)
     {
         
 
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
         
 
         $update = \App\Models\ProgramPrioritas::where('id', $id)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
      }

    
     
    public function delete_arahan_rups(Request $request, $id)
    {
         
 
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
         
 
         $update = \App\Models\ArahanRups::where('id', $id)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
    }

    

}
