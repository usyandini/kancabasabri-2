<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
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

//---------- TYPE ITEM ANGGARAN MASTER --------------//
//      1 = Jenis Anggaran
//      2 = Kelompok Anggaran
//      3 = Pos Anggaran
//---------------------------------------------------//

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

            // $this->middleware('can:info_i', ['only' => 'index']);
            // $this->middleware('can:tambah_i', ['only' => 'create']);
            // $this->middleware('can:jenis_i', ['only' => 'submitAnggaranItem']);
            // $this->middleware('can:kelompok_i', ['only' => 'submitAnggaranItem']);
            // $this->middleware('can:pos_i', ['only' => 'submitAnggaranItem']);
            // $this->middleware('can:simpan_i', ['only' => 'addItem']);
        }

    public function index()
    {
        $master_item = ItemMaster::orderby('kode_item')->get();
        $jenis = ItemAnggaranMaster::where('type', 1)->get();
        $kelompok = ItemAnggaranMaster::where('type', 2)->get();
        $pos = ItemAnggaranMaster::where('type', 3)->get();
    	return view('master.item.index', [
            'items' => $master_item, 
            'no' => 1, 
            'jenis' => $jenis,
            'kelompok' => $kelompok,
            'pos' => $pos,
        ]);
    }

    public function create()
    {
        //dd(ItemAnggaranMaster::where('type', 1)->first());
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
                'created_by'        => \Auth::id()
            );
            ItemMaster::create($inputItem);
        }
        session()->flash('success', true);
        return redirect('/item/create');
    }

    public function submitAnggaranItem($type, Request $request)
    {
        switch($type){
            case 'jenis':
                $inputJenis = array(
                    'kode'  => $request->kode_jenis,
                    'name'  => $request->nama_jenis,
                    'type'  => 1,
                    'created_by' => \Auth::id()
                );
                ItemAnggaranMaster::create($inputJenis);
                break;
            case 'kelompok':
                $inputKelompok = array(
                    'kode'  => $request->kode_kelompok,
                    'name'  => $request->nama_kelompok,
                    'type'  => 2,
                    'created_by' => \Auth::id()
                );
                ItemAnggaranMaster::create($inputKelompok);
                break;
            case 'pos':
                $inputPos = array(
                    'kode'  => $request->kode_pos,
                    'name'  => $request->nama_pos,
                    'type'  => 3,
                    'created_by' => \Auth::id()
                );
                ItemAnggaranMaster::create($inputPos);
                break;
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
            'master' => $item
        ]);
    }

    public function updateItem($id, Request $request)
    {
        $name_subpos = $this->subPosModel->where('VALUE', $request->subpos)->first();
        $name_kegiatan = $this->mAnggaranModel->where('VALUE', $request->kegiatan)->first();
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
                'SEGMEN_6'          => $request->kegiatan
            );
        ItemMaster::where('id', $id)->update($update);
        return redirect('/item/edit/'.$id);
    }

    public function reason()
    {
    	$reject_reasons = RejectReason::orderby('id','DESC')->get();
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

     public function delete(Request $request, $id)
     {
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];
 
        $update = \App\Models\RejectReason::where('id', $id)->delete();

         return redirect()->back()->with('after_delete', $after_delete);
    }

     public function carialasan(Request $request)
     {
        $cari = $request->get('alasan');
        $alasan =  \App\Models\RejectReason::where('content','LIKE','%'.$cari.'%')->paginate(10);
        return view('master.reason.index', compact('alasan'));       
     }
}
