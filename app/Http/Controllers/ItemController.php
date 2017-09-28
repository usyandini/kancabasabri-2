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

    public function getCombination($id, $cabang, $divisi, $tanggal)
    {
        $tanggal = date("Y-m-d", strtotime($tanggal));
        $result = ItemMaster::where([
            ['SEGMEN_1', $id], 
            ['SEGMEN_2', 'THT'],
            ['SEGMEN_3', $cabang],
            ['SEGMEN_4', $divisi]])->first();
        
        if (isset($result) && $result->isAxAnggaranAvailable($tanggal)) {
            $result['ax_anggaran'] = $result->axAnggaran($tanggal);
            $result['ax_anggaran']['PIL_AMOUNTAVAILABLE'] = (int)$result['ax_anggaran']['PIL_AMOUNTAVAILABLE'];
            return response()->json($result);    
        }

        return null;
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
        $arraykode = array($request->kode_jenis, $request->kode_kelompok, $request->kode_pos);
        $findkode = ItemAnggaranMaster::whereIn('kode', $arraykode)->first();

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
            'no' => 1, 
            // 'jenis' => $jenis,
            // 'kelompok' => $kelompok,
            // 'pos' => $pos,
        ]);
    }

    public function updateItemAnggaran($type, $id, Request $request)
    {
        $validatorItemAnggaran = Validator::make($request->all(),
            [
             'edit_kode_jenis' => 'unique:item_anggaran_master,kode,'.$id,
             'kode_kelompok' => 'unique:item_anggaran_master,kode,'.$id,
             'kode_pos' => 'unique:item_anggaran_master,kode,'.$id
            ],
            [
             'edit_kode_jenis.unique' => 'Kode jenis anggaran sudah ada.',
             'kode_kelompok.unique' => 'Kode kelompok anggaran sudah ada.',
             'kode_pos.unique' => 'Kode pos anggaran sudah ada.'
            ]
        );

        //dd($request->all());

        if($validatorItemAnggaran->passes())
        {
            switch($type){
                case 'jenis':
                    $inputJenis = array(
                        'kode'  => $request->edit_kode_jenis,
                        'name'  => $request->edit_nama_jenis,
                        'updated_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::where('kode', $id)->update($inputJenis);
                    break;
                case 'kelompok':
                    $inputKelompok = array(
                        'kode'  => $request->kode_kelompok,
                        'name'  => $request->nama_kelompok,
                        'updated_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::update($inputKelompok);
                    break;
                case 'pos':
                    $inputPos = array(
                        'kode'  => $request->kode_pos,
                        'name'  => $request->nama_pos,
                        'updated_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::update($inputPos);
                    break;
            }
        }else{
            return redirect()->back()->withErrors($validatorItemAnggaran)->withInput();
        }
        return redirect()->back()->withInput();
    }

    public function destroy($jenis, $id, Request $request)
    {
        switch($jenis){
            case 'master':
                $item = ItemMaster::where('id', $id)->first()->nama_item ? ItemMaster::where('id', $id)->first()->nama_item : ItemMaster::where('id', $id)->first()->kode_item;

                ItemMaster::where('id', $id)->delete(); break;
            case 'anggaran':
                $item = ItemAnggaranMaster::where('id', $id)->first()->name ? ItemAnggaranMaster::where('id', $id)->first()->name : ItemAnggaranMaster::where('id', $id)->first()->kode;

                ItemAnggaranMaster::where('id', $id)->delete(); break;
        }

        session()->flash('success', 'Item dengan kode <b>'.$item.'</b> berhasil dihapus');
        return redirect()->back();
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
