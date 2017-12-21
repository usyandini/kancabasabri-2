<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\User;

use App\Models\AkunBank;

use Validator;
use Excel;

use App\Models\Item;
use App\Models\KantorCabang;
use App\Models\Program;
use App\Models\Divisi;
use App\Models\SubPos;
use App\Models\Kegiatan;

use App\Models\ItemMasterAnggaran;
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

            $this->middleware('can:manajemen_i', ['only' => 'index']);
            $this->middleware('can:manajemen_i_t', ['only' => 'listTransaksi',
                                                                'createItemTransaksi',
                                                                'editItemTransaksi']);
            $this->middleware('can:manajemen_i_a', ['only' => 'listAnggaran',
                                                                'createItemAnggaran',
                                                                'editItemAnggaran']);
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
        $itemAngg = ItemAnggaranMaster::orderby('type')->orderby('kode')->get();
        return view('master.item.edit-item', [
            'items' => $itemAngg, 
            'no' => 1
        ]);
    }

    public function listTransaksi()
    {
        $items = ItemMaster::orderBy('id','ASC')->get();
        return view('master.item.index', compact('items'));
    }

    public function listAnggaran()
    {
        $master_item = ItemMasterAnggaran::where('deleted_at',Null)->get();
        $jenis = ItemAnggaranMaster::withTrashed()->where('type', 1)->get();
        $kelompok = ItemAnggaranMaster::withTrashed()->where('type', 2)->get();
        $pos = ItemAnggaranMaster::withTrashed()->where('type', 3)->get();
        $subpos = SubPos::get();
        $kegiatan = Kegiatan::get();
        return view('master.item.list-anggaran', [
            'items'     => $master_item, 
            'no'        => 1, 
            'jenis'     => $jenis,
            'kelompok'  => $kelompok,
            'pos'       => $pos,
            'subpos'    => $subpos,
            'kegiatan'  => $kegiatan,
        ]);
    }
    public function getCombination($mainaccount, $tanggal)
    {
        $tanggal = date("Y-m-d", strtotime($tanggal));
        $result = ItemMaster::where([
            ['id', $mainaccount]])->first();
        // print_r( $result->axAnggaran($tanggal));
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

    public function createItemTransaksi()
    {
        $jenis = ItemAnggaranMaster::where('type', 1)->get();
        $kelompok = ItemAnggaranMaster::where('type', 2)->get();
        $pos = ItemAnggaranMaster::where('type', 3)->get();
    	return view('master.item.tambah-transaksi',
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

    public function createItemAnggaran()
    {
        $jenis = ItemAnggaranMaster::where('type', 1)->get();
        $kelompok = ItemAnggaranMaster::where('type', 2)->get();
        $pos = ItemAnggaranMaster::where('type', 3)->get();
        return view('master.item.tambah-anggaran',
            [   'subpos' => $this->subPosModel->get(),
                'm_anggaran' => $this->mAnggaranModel->get(),
                'item' => $this->itemModel->get(),
                'jenis' => $jenis,
                'kelompok' => $kelompok,
                'pos' => $pos
            ]);
    }

    public function addItemTransaksi(Request $request)
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
        return redirect('/item/create/transaksi');
    }

    public function addItemAnggaran(Request $request)
    {

        $inputItem = array(
            'jenis'    => $request->jenis,
            'kelompok' => $request->kelompok,
            'pos_anggaran'      => $request->pos,
            'sub_pos'           => $request->subpos,
            'mata_anggaran'     => $request->kegiatan,
            'account'           => $request->account,
        );
        
        ItemMasterAnggaran::create($inputItem);
        
        session()->flash('success', true);
        return redirect('/item/create/anggaran');
    }

    //item anggaran master
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
                case 'satuan':
                    $inputPos = array(
                        'kode'  => $request->kode_satuan,
                        'name'  => $request->nama_satuan,
                        'type'  => 4,
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

    public function editItemTransaksi($id)
    {
        $item = ItemMaster::where('id', $id)->first();
        return view('master.item.edit-transaksi', [
            'item' => $this->itemModel->get(),
            'program' => $this->programModel->where("VALUE", "THT")->get(),
            'kpkc' => $this->kpkcModel->get(),
            'divisi' => $this->divisiModel->get(),
            'subpos' => $this->subPosModel->get(),
            'm_anggaran' => $this->mAnggaranModel->get(),
            'items' => $item
        ]);
    }

    public function editItemAnggaran($id)
    {
        $item = ItemMasterAnggaran::where('id', $id)->first();
        $jenis = ItemAnggaranMaster::where('type', 1)->get();
        $kelompok = ItemAnggaranMaster::where('type', 2)->get();
        $pos = ItemAnggaranMaster::where('type', 3)->get();
        return view('master.item.edit-anggaran', [
            'item' => $this->itemModel->get(),
            'subpos' => $this->subPosModel->get(),
            'm_anggaran' => $this->mAnggaranModel->get(),
            'jenis' => $jenis,
            'kelompok' => $kelompok,
            'pos' => $pos,
            'items' => $item
        ]);
    }

    public function updateItemTransaksi($id, Request $request)
    {
        $name_subpos = $this->subPosModel->where('VALUE', $request->subpos)->first();
        $name_kegiatan = $this->mAnggaranModel->where('VALUE', $request->kegiatan)->first();

        $validatorItem = Validator::make($request->all(),
            ['kode_item' => 'unique:item_master_transaksi,kode_item,'.$id],
            ['kode_item.unique' => 'Kode item sudah ada.']
        );

        if($validatorItem->passes())
        {
            $update = array(
                'kode_item'         => $request->kode_item,
                'nama_item'         => $request->nama_item,
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
        return redirect('/item/edit/transaksi/'.$id);
    }

    public function updateItemAnggaran($id, Request $request)
    {
        
        $update = array(
            'jenis'    => $request->jenis,
            'kelompok' => $request->kelompok,
            'pos_anggaran'      => $request->pos,
            'sub_pos'           => $request->subpos,
            'mata_anggaran'     => $request->kegiatan,
            'account'           => $request->account,
        );
        ItemMasterAnggaran::where('id', $id)->update($update);   
        
        session()->flash('success', true);
        return redirect('/item/edit/anggaran/'.$id);
    }

    public function updateItem($id, Request $request)
    {
        $trashed = ItemAnggaranMaster::onlyTrashed()->where('kode', $request->edit_kode)->forceDelete();

        $validatorItemAnggaran = Validator::make($request->all(),
            [
             'edit_kode' => 'unique:item_anggaran,kode,'.$id
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
            case 'anggaran':
                $item = "Item Anggaran telah dihapus";
                ItemMasterAnggaran::where('id', $id)->delete(); break;
            case 'transaksi':
                $item = ItemMaster::where('id', $id)->first()->nama_item ? ItemMaster::where('id', $id)->first()->nama_item : ItemMaster::where('id', $id)->first()->kode_item;

                ItemMaster::where('id', $id)->delete(); break;
            case 'item':
                $item = ItemAnggaranMaster::where('id', $id)->first()->name ? ItemAnggaranMaster::where('id', $id)->first()->name : ItemAnggaranMaster::where('id', $id)->first()->kode;

                ItemAnggaranMaster::where('id', $id)->delete(); break;
        }

        session()->flash('deleted', 'Item <b>'.$item.'</b> berhasil dihapus');
        return redirect()->back();
    }


    public function reason()
    {

    	$reject_reasons = RejectReason::orderBy('id','DESC')->get();

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

    public function nilai_mataanggaran()
    {
        $a = DB::table('nilai_mata_anggaran')
             ->orderBy('id','DESC')->get();
        return view('master.nilai_mataanggaran.index', compact('a'));
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

    public function store_nilai_mataanggaran(Request $request)
    {
               
        $kode=$request->kode;
        $nilai= str_replace('.', '', $request->nilai);
        $db = DB::table('nilai_mata_anggaran')->where('value', $kode)->get();
        $z = DB::select("SELECT DESCRIPTION
                         FROM [AX_DUMMY].[dbo].[PIL_VIEW_KEGIATAN]
                         where VALUE= '$kode'");
        foreach ($z as $x) {
            $description=$x->DESCRIPTION;
        }
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
             'value' => $kode,
             'description' =>$description,
             'nilai' => $nilai
            ];
 
             $store = DB::table('nilai_mata_anggaran')->insert($data);
           
             return redirect()->back()->with('after_save', $after_save);
        }
    }

    public function update_nilai_mataanggaran(Request $request, $id)
     {
            $nilai= str_replace('.', '', $request->nilai);
            $after_update = [
                 'alert' => 'success',
                 'title' => 'Data berhasil diubah.'
             ];
     
             $data = [
                'nilai' => $nilai= str_replace('.', '', $request->nilai)
             ];
             
             $update = DB::table('nilai_mata_anggaran')->where('id', $id)->update($data);

             return redirect()->back()->with('after_update', $after_update);
         
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
            $after_update = ['alert' => 'danger','title' => 'Data gagal diubah, data sudah ada.'];
            return redirect()->back()->with('after_update', $after_update);
         }
         else{

            $after_update = [
                'alert' => 'success',
                'title' => 'Data berhasil diubah.'
            ];

            $data = ['arahan_rups' => $request->arahan_rups];

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

    public function delete_nilai_mataanggaran(Request $request, $id)
     {
         $after_delete = [
             'alert' => 'success',
             'title' => 'Data berhasil dihapus.'
         ];

         $update = \DB::table('nilai_mata_anggaran')->where('id', $id)->delete();
         return redirect()->back()->with('after_delete', $after_delete);
     }

    public function importXls()
    {
        return view('master.item.import-xls',['fail'=>null]);
    }

    public function importXlsProcess(Request $request)
    {
        $input['ext'] = strtolower($request->file->getClientOriginalExtension());
        $input['item'] = strtolower($request->item);

        $validator = Validator::make($input,
            [
             'ext' => 'in:xls,xlsx,csv',
             'item'=> 'required'
            ],
            [
             'ext.in'           => 'File yang diunggah untuk insert ke database harus berekstensi : <b>xls, xlsx, atau csv</b>.',
             'item.required'    => 'Jenis Item harus dipilih.'

            ]);   

        if ($validator->passes()) {
            $data = Excel::selectSheetsByIndex(0)->load($request->file->getRealPath(), function($reader) {})->toArray();

            
            $result;
            if($input['item'] == 1){
                $this->validateTransaksiXlsColumns($data[0]);
                $result = $this->insertTransaksiXlsData($data);
            }else{
                $this->validateAnggaranXlsColumns($data[0]);
                $result = $this->insertAnggaranXlsData($data);
            }

            if (count($result) > 0) {
                // return redirect()->back()->withErrors($result);
                return view('master.item.import-xls',['fail'=>$result]);
            }
            // redirect()->back();
             return view('master.item.import-xls',['fail'=>null]);
        }

        return redirect()->back()->withErrors($validator);
    }

    public function validateTransaksiXlsColumns($data)
    {
        $validator = Validator::make($data, 
            [
                "kode_item" => "present",
                "item"      => "present",
                "account"   => "present",
                // "account_dec"   => "present",
                "program"   => "present",
                // "prog_dec"  => "present",
                "kpkc"      => "present",
                // "kpkc_dec"  => "present",
                "divisi"    => "present",
                // "div_dec"   => "present",
                "sub_pos"   => "present",
                // "suppos_dec" => "present",
                "mata_anggaran" => "present",
                // "mata_ang_dec"  => "present",
                "display_item_semua_cabang" => "present"], 
            [
                "kode_item.present" => "<b>Kolom Kode Item</b> harus ada pada file Excel yang diupload.",
                "item.present" => "<b>Kolom Item</b> harus ada pada file Excel yang diupload.",
                "account.present" => "<b>Kolom Account</b> harus ada pada file Excel yang diupload.",
                // "account_dec.present" => "<b>Kolom Deskripsi Account</b> harus ada pada file Excel yang diupload.",
                "program.present" => "<b>Kolom Program</b> harus ada pada file Excel yang diupload.",
                // "prog_dec.present" => "<b>Kolom </b> harus ada pada file Excel yang diupload.",
                "kpkc.present" => "<b>Kolom KPKC</b> harus ada pada file Excel yang diupload.",
                // "kpkc_dec.present" => "<b>Kolom Nama KPKC</b> harus ada pada file Excel yang diupload.",
                "divisi.present" => "<b>Kolom Divisi</b> harus ada pada file Excel yang diupload.",
                // "div_dec.present" => "<b>Kolom Nama Divisi</b> harus ada pada file Excel yang diupload.",
                "sub_pos.present" => "<b>Kolom Subpos</b> harus ada pada file Excel yang diupload.",
                // "suppos_dec.present" => "<b>Kolom Nama Subpos</b> harus ada pada file Excel yang diupload.",
                "mata_anggaran.present" => "<b>Kolom Mata Anggaran</b> harus ada pada file Excel yang diupload.",
                // "mata_ang_dec.present" => "<b>Kolom Nama Mata Anggaran</b> harus ada pada file Excel yang diupload.",
                "display_item_semua_cabang.present" => "<b>Kolom Display Item untuk Semua Cabang</b> harus ada pada file Excel yang diupload."]);

        if ($validator->passes()) {
            return true;
        }
        return redirect()->back()->withErrors($validator);
    }

    public function validateAnggaranXlsColumns($data)
    {
        $validator = Validator::make($data, 
            [
                "jenis_anggaran"        => "present",
                "kelompok_anggaran"     => "present",
                "pos_anggaran"          => "present",
                "subpos"                => "present",
                "mata_anggaran"         => "present",
                "main_account"          => "present"], 
            [
                "JENIS ANGGARAN.present" => "<b>Kolom JENIS_ANGGARAN</b> harus ada pada file Excel yang diupload.",
                "KELOMPOK ANGGARAN.present" => "<b>Kolom KELOMPOK_ANGGARAN</b> harus ada pada file Excel yang diupload.",
                "POS ANGGARAN.present" => "<b>Kolom POS_ANGGARAN</b> harus ada pada file Excel yang diupload.",
                "SUBPOS.present" => "<b>Kolom SUBPOS</b> harus ada pada file Excel yang diupload.",
                "MATA ANGGARAN.present" => "<b>Kolom MATA_ANGGARAN</b> harus ada pada file Excel yang diupload.",
                "MAIN_ACCOUNT.present" => "<b>Kolom MAIN_ACCOUNT</b> harus ada pada file Excel yang diupload."]);

        if ($validator->passes()) {
            return true;
        }
        return redirect()->back()->withErrors($validator);
    }

    public function insertTransaksiXlsData($data)
    {
        $insert_success = $errors = [];
        if (isset($data) && !empty($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                if(isset($value['item'])){
                    $input = [
                        'kode_item' => $this->isExistInDB($value, 'item_kode'),
                        'nama_item' => $value['item'],
                        'SEGMEN_1'  => $this->isExistInDB($value['account'], 'account'),
                        'SEGMEN_2'  => $this->isExistInDB($value['program'], 'program'),
                        'SEGMEN_3'  => $this->isExistInDB($value['kpkc'], 'kpkc'),
                        'SEGMEN_4'  => $this->isExistInDB($value['divisi'], 'divisi'),
                        'SEGMEN_5'  => $this->isExistInDB($value['sub_pos'], 'sub_pos'),
                        'SEGMEN_6'  => $this->isExistInDB($value['mata_anggaran'], 'mata_anggaran'),
                        'is_displayed'  => $value['display_item_semua_cabang'] == 'Y' ? 1 : 0,
                        'created_by'    => \Auth::user()->id];
                    // print_r($value);
                    $validate[$key] = Validator::make($input, 
                        [
                            // 'kode_item' => 'required',
                            'nama_item' => 'required',
                            'SEGMEN_1'  => 'not_in:-',
                            'SEGMEN_2'  => 'not_in:-',
                            'SEGMEN_3'  => 'not_in:-',
                            'SEGMEN_4'  => 'not_in:-',
                            'SEGMEN_5'  => 'not_in:-',
                            'SEGMEN_6'  => 'not_in:-'], 
                        [
                            // 'kode_item.required'    => '<b>Nilai Kode Item ('.$value['kode_item'].')</b> pada <b>row '.($key+1).'</b> harus diisi. Row gagal diinput.',
                            'nama_item.required'    => '<b>Nilai Nama Item ('.$value['item'].')</b> pada <b>row '.($key+1).'</b> harus diisi. Row gagal diinput.',
                            'SEGMEN_1.not_in'       => '<b>Nilai (ID) Account ('.$value['account'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Row gagal diinput.',
                            'SEGMEN_2.not_in'       => '<b>Nilai (ID) Program ('.$value['program'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Row gagal diinput.',
                            'SEGMEN_3.not_in'       => '<b>Nilai (ID) KPKC ('.$value['kpkc'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Row gagal diinput.',
                            'SEGMEN_4.not_in'       => '<b>Nilai (ID) Divisi ('.$value['divisi'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Row gagal diinput.',
                            'SEGMEN_5.not_in'       => '<b>Nilai (ID) Subpos ('.$value['sub_pos'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Row gagal diinput.',
                            'SEGMEN_6.not_in'       => '<b>Nilai (ID) Mata Anggaran ('.$value['mata_anggaran'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Row gagal diinput.']);
                    
                    if ($validate[$key]->passes()) {
                        $kodeIsStored = ItemMaster::where('kode_item', $input['kode_item'])->first();
                        if (!$kodeIsStored) {
                            ItemMaster::create($input);
                            $insert_success[$key] = 'Item dengan <b>Kode Item '.$input['kode_item'].' '.$value['item'].'</b> berhasil diinput.';
                        } else {
                            ItemMaster::where('kode_item', $input['kode_item'])->update($input);
                            $insert_success[$key] = 'Item dengan <b>Kode Item '.$input['kode_item'].'</b> berhasil diperbarui.';
                        }
                    }

                    if (count($validate[$key]->failed()) == 8) {
                        unset($validate[$key]);
                    }
                }
            }

            foreach ($validate as $val) { 
                foreach ($val->errors()->messages() as $value) {
                    array_push($errors, $value);
                }
            }

            // print_r($errors);
            // print_r($insert_success);

            if (count($insert_success) > 0) { session()->flash('insert_success', $insert_success); }
        } else {
            $errors = ['1' => 'Data Excel tidak boleh kosong.'];
        }

        return $errors;
    }

    public function insertAnggaranXlsData($data)
    {
        $insert_success = $errors = [];
        $count = 0;
        if (isset($data) && !empty($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                if(isset($value['jenis_anggaran'])){
                    $input = [
                        'jenis'         => $this->isExistInDB($value['jenis_anggaran'], 'jenis_kode'),
                        'kelompok'      => $this->isExistInDB($value['kelompok_anggaran'], 'kelompok_kode'),
                        'pos_anggaran'  => $this->isExistInDB($value['pos_anggaran'], 'pos_kode'),
                        'sub_pos'       => $this->isExistInDB($value['subpos'], 'sub_pos_kode'),
                        'mata_anggaran' => $this->isExistInDB($value['mata_anggaran'], 'mata_anggaran_kode'),
                        'account'       => $this->isExistInDB($value['main_account'], 'account')];

                    $validate[$key] = Validator::make($input, 
                        [
                            'sub_pos'       => 'not_in:-',
                            'mata_anggaran' => 'not_in:-',
                            'account'       => 'not_in:-'],
                        [
                            'sub_pos.not_in'       => '<b>Nilai (ID) Sub Pos ('.$value['subpos'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Baris gagal diinput.',
                            'mata_anggaran.not_in' => '<b>Nilai (ID) Mata Anggaran ('.$value['mata_anggaran'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Baris gagal diinput.',
                            'account.not_in'       => '<b>Nilai (ID) Main Account ('.$value['main_account'].')</b> pada <b>row '.($key+1).'</b> tidak terdapat di basis data. Baris gagal diinput.']);
                    
                    if ($validate[$key]->passes()) {
                        $cek = ItemMasterAnggaran::where('jenis',$input['jenis'])->
                                                    where('kelompok',$input['kelompok'])->
                                                    where('pos_anggaran',$input['pos_anggaran'])->
                                                    where('sub_pos',$input['sub_pos'])->
                                                    where('mata_anggaran',$input['mata_anggaran'])->
                                                    where('account',$input['account'])->count();
                        if($cek > 0){
                            $insert_success[$count++] = 'Data baris ke-'.($key+1).' item anggaran terdapat di database.';
                        }else{
                            ItemMasterAnggaran::create($input); 
                            $count++ ;
                            $insert_success[$count] = "<b>".($count-count($insert_success)).' data item anggaran</b> berhasil di inputkan.';
            
                        }
                    }
                    if (count($validate[$key]->failed()) == 8) {
                        unset($validate[$key]);
                    }
                }
            }

            foreach ($validate as $val) { 
                foreach ($val->errors()->messages() as $value) {
                    array_push($errors, $value);
                }
            }
            // $insert_success[$count] = "<b>".($count-count($insert_success)).' data item anggaran</b> berhasil di inputkan.';
            if (count($insert_success) > 0) { session()->flash('insert_success', $insert_success); }
        } else {
            $errors = ['1' => 'Data Excel tidak boleh kosong.'];
        }

        return $errors;
    }

    public function isExistInDB($value, $type)
    {
        $return = null;
        switch ($type) {
            case 'jenis_kode':
                $jenis = ItemAnggaranMaster::withTrashed()->where('type',1)->get();
                $jenisVal = ItemAnggaranMaster::where('type',1)->where('name', $value)->get();
                if(count($jenisVal) == 0){
                    $kode = 'JA-'.(count($jenis)+1);
                    $inputJenis = array(
                        'kode'  => $kode,
                        'name'  => $value,
                        'type'  => 1,
                        'created_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::create($inputJenis);
                }
                // echo count($jenis);
                $return = ItemAnggaranMaster::where('type',1)->where('name', $value)->first()->kode;
                break;
            case 'kelompok_kode':
                $kelompok = ItemAnggaranMaster::withTrashed()->where('type',2)->get();
                $kelompokVal = ItemAnggaranMaster::where('type',2)->where('name', $value)->get();
                if(count($kelompokVal) == 0){
                    $kode = 'KA-'.(count($kelompok)+1);
                    $inputKelompok = array(
                        'kode'  => $kode,
                        'name'  => $value,
                        'type'  => 2,
                        'created_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::create($inputKelompok);
                }
                $return = ItemAnggaranMaster::where('type',2)->where('name', $value)->first()->kode;
                break;
            case 'pos_kode':
                $pos = ItemAnggaranMaster::withTrashed()->where('type',3)->get();
                $posVal = ItemAnggaranMaster::where('type',3)->where('name', $value)->get();
                if(count($posVal) == 0){
                    $kode = 'PA-'.(count($pos)+1);
                    $inputPos = array(
                        'kode'  => $kode,
                        'name'  => $value,
                        'type'  => 3,
                        'created_by' => \Auth::id()
                    );
                    ItemAnggaranMaster::create($inputPos);
                }
                $return = ItemAnggaranMaster::where('type',3)->where('name', $value)->first()->kode;
                break;
            case 'sub_pos_kode':
                $subVal = SubPos::where('DESCRIPTION', $value)->first();
                $return = $subVal ? $subVal->VALUE : '-';
                break;
            case 'mata_anggaran_kode':
                $mataVal = Kegiatan::where('DESCRIPTION', $value)->first();
                $return = $mataVal ? $mataVal->VALUE : '-';
                break;
            case 'item_kode':
                $item_master = ItemMaster::where('SEGMEN_1',$value['account'])->
                        where('SEGMEN_2',$value['program'])->
                        where('SEGMEN_3',$value['kpkc'])->
                        where('SEGMEN_4',$value['divisi'])->
                        where('SEGMEN_5',$value['sub_pos'])->
                        where('SEGMEN_6',$value['mata_anggaran'])->get();
                $kode = '';
                if(count($item_master) == 0){
                    $count_item = ItemMaster::orderBy('id', 'desc')->first()->id;
                    $kode = 'KD-'.($count_item+1);
                    // echo (ItemMaster::orderBy('id', 'desc')->first()->id);
                    // ItemMaster::create($item_master);
                }else{
                    foreach ($item_master as $row) {
                        $kode = $row->kode_item;
                    }
                }
                $return = $kode;
                // echo $return."<br />";
                break;
            case 'account':
                $return = Item::where('MAINACCOUNTID', $value)->first() ? $value : '-';
                break;
            case 'program':
                $return = Program::where('VALUE', $value)->first() ? $value : '-';
                break;
            case 'kpkc':
                $return = KantorCabang::where('VALUE', $value)->first() ? $value : '-';
                break;
            case 'divisi':
                $return = Divisi::where('VALUE', $value)->first() ? $value : '-';
                break;
            case 'sub_pos':
                $return = SubPos::where('VALUE', $value)->first() ? $value : '-';
                break;
            case 'mata_anggaran':
                $return = Kegiatan::where('VALUE', $value)->first() ? $value : '-';
                break;
        }

        return $return;
    }

}
