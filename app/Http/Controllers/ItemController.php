<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;

use App\Models\AkunBank;

use Validator;

use App\Models\Item;
use App\Models\KantorCabang;
use App\Models\Program;
use App\Models\Divisi;
use App\Models\SubPos;
use App\Models\Kegiatan;

use App\Models\ItemMaster;
use App\Models\ItemAnggaranMaster;
use App\Models\RejectReason;

use App\Models\ProgramPrioritas;
use App\Models\ArahanRups;


//---------- TYPE ITEM ANGGARAN MASTER --------------//
//      1 = Jenis Anggaran
//      2 = Kelompok Anggaran
//      3 = Pos Anggaran
//---------------------------------------------------//

//-------- SEGMEN-SEGMEN -------------------------//
//  SEGMEN_1 = Jenis Barang/Jasa / MAINACCOUNTID
//  SEGMEN_2 = Program / THT
//  SEGMEN_3 = KPKC / VALUE
//  SEGMEN_4 = DIVISI / VALUE
//  SEGMEN_5 = SUB_POS / VALUE
//  SEGMEN_6 = Mata Anggaran / VALUE
//-------------------------------------------------//


class ItemController extends Controller
{
    protected $itemModel;
    protected $programModel;
    protected $kpkcModel;
    protected $divisiModel;
    protected $subPosModel;
    protected $mAnggaranModel;

    public function __construct(
        Item $item,
        Program $program,
        KantorCabang $kpkc,
        Divisi $divisi,
        SubPos $subpos,
        Kegiatan $m_anggaran)
        {
            $this->itemModel = $item;
            $this->programModel = $program;
            $this->kpkcModel = $kpkc;
            $this->divisiModel = $divisi;
            $this->subPosModel = $subpos;
            $this->mAnggaranModel = $m_anggaran;

            $this->middleware('can:manajemen_k_i', ['only' => 'index']);
            $this->middleware('can:manajemen_i_a', ['only' => 'editItemAnggaran']);
            $this->middleware('can:manajemen_a_m', ['only' => 'reason']);
            $this->middleware('can:manajemen_p_p', ['only' => 'program_prioritas',
                                                        'store_program_prioritas',
                                                        'update_program_prioritas',
                                                        'delete_program_prioritas']);
            $this->middleware('can:manajemen_a_RUPS', ['only' => 'arahan_rups',
                                                        'store_arahan_rups',
                                                        'update_arahan_rups',
                                                        'delete_arahan_rups']);
            // $this->middleware('can:tambah_k_i', ['only' => 'create']);
            // $this->middleware('can:edit_k_i', ['only' => 'submitAnggaranItem']);
            // $this->middleware('can:pos_i', ['only' => 'submitAnggaranItem']);
            // $this->middleware('can:simpan_i', ['only' => 'addItem']);
        }

    public function index()
    {
        $master_item = ItemMaster::orderby('kode_item')->get();
        $jenis = ItemAnggaranMaster::withTrashed()->where('type', 1)->get();
        $kelompok = ItemAnggaranMaster::withTrashed()->where('type', 2)->get();
        $pos = ItemAnggaranMaster::withTrashed()->where('type', 3)->get();
    	return view('master.item.index', [
            'items' => $master_item, 
            'no' => 1, 
            'jenis' => $jenis,
            'kelompok' => $kelompok,
            'pos' => $pos
        ]);
    }

    public function getCombination($mainaccount, $tanggal)
    {
        $tanggal = date("Y-m-d", strtotime($tanggal));
        $result = ItemMaster::where([
            ['id', $mainaccount]])->first();
        if (isset($result) && $result->isAxAnggaranAvailable($tanggal)) {
            $result['ax_anggaran'] = $result->axAnggaran($tanggal);
            $result['ax_anggaran']['PIL_AMOUNTAVAILABLE'] = $result['actual_anggaran'] = (int)$result['ax_anggaran']['PIL_AMOUNTAVAILABLE'];

            if ($result->budgetHistory($tanggal)) {
                $result['actual_anggaran'] = $result->budgetHistory($tanggal)['actual_amount']; 
            }
            return response()->json($result);    
        }

        return null;
    }

    public function create()
    {
        $jenis = ItemAnggaranMaster::where('type', 1)->get();
        $kelompok = ItemAnggaranMaster::where('type', 2)->get();
        $pos = ItemAnggaranMaster::where('type', 3)->get();
    	return view('master.item.tambah',
            [   'item' => $this->itemModel->get(),
                'program' => $this->programModel->where("VALUE", "THT")->get(),
                'kpkc' => $this->kpkcModel->get(),
                'divisi' => $this->divisiModel->get(),
                'subpos' => $this->subPosModel->get(),
                'm_anggaran' => $this->mAnggaranModel->get(),
                'jenis' => $jenis,
                'kelompok' => $kelompok,
                'pos' => $pos
            ]);
    }

    public function addItem(Request $request)
    {
        //$inputItem = $request->except('_method', '_token');
        $name_subpos = $this->subPosModel->where('VALUE', $request->subpos)->first();
        $name_kegiatan = $this->mAnggaranModel->where('VALUE', $request->kegiatan)->first();

        $kode = $request->kode_item;
        $findKode = ItemMaster::where('kode_item', $kode)->first(); //kode unik

        if($findKode){
            session()->flash('unique', true);
            return redirect()->back()->withInput();
        }else{
            $inputItem = array(
                'kode_item'         => $request->kode_item,
                'nama_item'         => $request->nama_item,
                'jenis_anggaran'    => $request->jenis,
                'kelompok_anggaran' => $request->kelompok,
                'pos_anggaran'      => $request->pos,
                'sub_pos'           => $name_subpos->DESCRIPTION,
                'mata_anggaran'     => $name_kegiatan->DESCRIPTION,

                'SEGMEN_1'          => $request->account,
                'SEGMEN_2'          => $request->program,
                'SEGMEN_3'          => $request->kpkc,
                'SEGMEN_4'          => $request->divisi,
                'SEGMEN_5'          => $request->subpos,
                'SEGMEN_6'          => $request->kegiatan,
                'created_by'        => \Auth::id(),
                'is_displayed'      => $request->item_display
            );
            
            ItemMaster::create($inputItem);
        }
        session()->flash('success', true);
        return redirect('/item/create');
    }

    public function submitAnggaranItem($type, Request $request)
    {
        $arraykode = array($request->kode, $request->kode_jenis, $request->kode_kelompok, $request->kode_pos);
        $findkode = ItemAnggaranMaster::whereIn('kode', $arraykode)->first();
        $trashed = ItemAnggaranMaster::onlyTrashed()->whereIn('kode', $arraykode)->forceDelete();

        if($findkode){
            session()->flash('unique', true);
            return redirect()->back()->withInput();
        }else{
            switch($type){
                case 'jenis':
                    $inputJenis = array(
                        'kode'  => $request->kode_jenis,
                        'name'  => $request->nama_jenis,
                        'type'  => 1,
                        'created_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::create($inputJenis); // Jenis Anggaran
                    break;
                case 'kelompok':
                    $inputKelompok = array(
                        'kode'  => $request->kode_kelompok,
                        'name'  => $request->nama_kelompok,
                        'type'  => 2,
                        'created_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::create($inputKelompok); //Kelompok Anggaran
                    break;
                case 'pos':
                    $inputPos = array(
                        'kode'  => $request->kode_pos,
                        'name'  => $request->nama_pos,
                        'type'  => 3,
                        'created_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::create($inputPos); //Pos Anggaran
                    break;
                case 'all':
                    $inputAll = array(
                        'kode'  => $request->kode,
                        'name'  => $request->name,
                        'type'  => $request->type,
                        'created_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::create($inputAll); //All item anggaran
                    break;
            }
            session()->flash('add', true);   
        }
        return redirect()->back()->withInput();
    }

    public function editItem($id)
    {
        $item = ItemMaster::where('id', $id)->first();

        $jenis = ItemAnggaranMaster::where('type', 1)->get();
        $kelompok = ItemAnggaranMaster::where('type', 2)->get();
        $pos = ItemAnggaranMaster::where('type', 3)->get();
        return view('master.item.edit-item', [
            'item' => $this->itemModel->get(),
            'program' => $this->programModel->where("VALUE", "THT")->get(),
            'kpkc' => $this->kpkcModel->get(),
            'divisi' => $this->divisiModel->get(),
            'subpos' => $this->subPosModel->get(),
            'm_anggaran' => $this->mAnggaranModel->get(),
            'jenis' => $jenis,
            'kelompok' => $kelompok,
            'pos' => $pos,
            'items' => $item
        ]);
    }

    public function updateItem($id, Request $request)
    {
        $name_subpos = $this->subPosModel->where('VALUE', $request->subpos)->first();
        $name_kegiatan = $this->mAnggaranModel->where('VALUE', $request->kegiatan)->first();

        $validatorItem = Validator::make($request->all(),
            ['kode_item' => 'unique:item_master,kode_item,'.$id],
            ['kode_item.unique' => 'Kode item sudah ada.']
        );

        if($validatorItem->passes())
        {
            $update = array(
                'kode_item'         => $request->kode_item,
                'nama_item'         => $request->nama_item,
                'jenis_anggaran'    => $request->jenis,
                'kelompok_anggaran' => $request->kelompok,
                'pos_anggaran'      => $request->pos,
                'sub_pos'           => $name_subpos->DESCRIPTION,
                'mata_anggaran'     => $name_kegiatan->DESCRIPTION,

                'SEGMEN_1'          => $request->account,
                'SEGMEN_2'          => $request->program,
                'SEGMEN_3'          => $request->kpkc,
                'SEGMEN_4'          => $request->divisi,
                'SEGMEN_5'          => $request->subpos,
                'SEGMEN_6'          => $request->kegiatan,
                'is_displayed'      => $request->item_display
            );
            ItemMaster::where('id', $id)->update($update);   
        }else{
            //dd($request->all());
            return redirect()->back()->withErrors($validatorItem)->withInput();
        }
        session()->flash('success', true);
        return redirect('/item/edit/'.$id);
    }

    public function editItemAnggaran()
    {
        $itemAngg = ItemAnggaranMaster::orderby('type')->orderby('kode')->get();
        return view('master.item.edit-anggaran', [
            'items' => $itemAngg, 
            'no' => 1
        ]);
    }

    public function updateItemAnggaran($id, Request $request)
    {
        $trashed = ItemAnggaranMaster::onlyTrashed()->where('kode', $request->edit_kode)->forceDelete();

        $validatorItemAnggaran = Validator::make($request->all(),
            [
             'edit_kode' => 'unique:item_anggaran_master,kode,'.$id
            ],
            [
             'edit_kode.unique' => 'Kode item anggaran sudah ada.'
            ]
        );

        if($validatorItemAnggaran->passes())
        {        
            $updateItemAngg = array(
                'kode'  => $request->edit_kode,
                'name'  => $request->edit_nama,
                'updated_by' => \Auth::id()
            );
            $itemAnggaran = ItemAnggaranMaster::where('id', $id);
            
            ItemMaster::where('jenis_anggaran',$itemAnggaran->first()->kode)->update(['jenis_anggaran' => $request->edit_kode]);
            ItemMaster::where('kelompok_anggaran',$itemAnggaran->first()->kode)->update(['kelompok_anggaran' => $request->edit_kode]);
            ItemMaster::where('pos_anggaran',$itemAnggaran->first()->kode)->update(['pos_anggaran' => $request->edit_kode]);

            ItemAnggaranMaster::where('id', $id)->update($updateItemAngg);
        }else{
            return redirect()->back()->withErrors($validatorItemAnggaran)->withInput();
        }
        session()->flash('success', true);
        return redirect()->back()->withInput();
    }

    public function destroy($jenis, $id, Request $request)
    {
        switch($jenis){
            case 'master':
                $item = ItemMaster::withTrashed()->where('id', $id)->first()->nama_item ? ItemMaster::withTrashed()->where('id', $id)->first()->nama_item : ItemMaster::withTrashed()->where('id', $id)->first()->kode_item;

                ItemMaster::where('id', $id)->delete(); break;
            case 'anggaran':
                $item = ItemAnggaranMaster::withTrashed()->where('id', $id)->first()->name ? ItemAnggaranMaster::withTrashed()->where('id', $id)->first()->name : ItemAnggaranMaster::withTrashed()->where('id', $id)->first()->kode;

                ItemAnggaranMaster::where('id', $id)->delete(); break;
        }

        session()->flash('deleted', 'Item <b>'.$item.'</b> berhasil dihapus');
        return redirect()->back();
    }


    public function reason()
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
         }else{
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
         }else{
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
