<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\JenisUser;
use App\Models\Divisi;
use App\Models\KantorCabang;
use Validator;

class JenisUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:jenis_u', ['only' => 'index']);
        $this->middleware('can:edit_jenis', ['only' => 'edit', 'update']);
        $this->middleware('can:tambah_jenis', ['only' => 'create', 'store']);
    }

    public function index()
    {
    	return view('user.list-jenis', [
            'users' => JenisUser::withTrashed()->get()]);
    }

    public function create()
    {
    	// return view('user.input-jenis');
        return view('user.input-jenis', [
            'cabang' => KantorCabang::get(),
            'divisi' => Divisi::get()
            ]);
    }

    public function edit($id)
    {
        // return view('user.edit-jenis', [
        //     'user' => JenisUser::withTrashed()->where('id', $id)->first()]);
        $user = JenisUser::withTrashed()->where('id', $id)->first();
        return view('user.edit-jenis', [
            'user' => $user,
            'cabang' => KantorCabang::get(),
            'divisi' => Divisi::get()
            ]);

        // return response()->json(JenisUser::withTrashed()->where('id', $id)->first());
    }

    public function restore(Request $request, $id)
    {
      JenisUser::where('id', $id)->restore();
      $jenis_user = JenisUser::where('id', $id)->first()->nama;

      session()->flash('success', 'Jenis User atas nama <b>'.$jenis_user.'</b> berhasil direstore');
      return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        // $user = JenisUser::withTrashed()->where('id', $id)->first();
        $jenis_user = JenisUser::withTrashed()->where('id', $id)->first()->nama;
        if ($request->is_force == '1') {
            JenisUser::where('id', $id)->forceDelete();
        } else {
            JenisUser::where('id', $id)->delete();
        }
        session()->flash('success', 'Jenis user <b>'.$jenis_user.'</b> berhasil dihapus.');
        return redirect()->back();
    
    }
    public function store(Request $request)
    {
    	$input = $request->except('_method', '_token');
        $validator = $this->validateInputs($input);

    	if ($validator->passes()) {
            // if ($input['perizinan']['data_cabang'] == 'off') { unset($input['perizinan']['data_cabang']); }    
            $input['created_by'] = $input['updated_by'] = \Auth::user()->id;

    		JenisUser::create($input);

            session()->flash('success', 'Jenis user <b>'.$input['nama'].'</b> berhasil disimpan.');
            return redirect('jenis_user');
    	}
    	return redirect()->back()->withInput()->withErrors($validator);
    }

    public function update(Request $request, $id)
    {
        $input = $request->except('_method', '_token');
        $validator = $this->validateInputs($input, $id);

        if ($validator->passes()) {
            // if ($input['perizinan']['data-cabang'] == 'off') { unset($input['perizinan']['data-cabang']); } 
            $input['updated_by'] = \Auth::user()->id;

            $jenisUser = JenisUser::withTrashed()->where('id', $id)->first();
            $jenisUser->perizinan = $input['perizinan'];

            $jenisUser->save();
            unset($input['perizinan']);
            JenisUser::where('id', $id)->update($input);

            session()->flash('success', 'Jenis user <b>'.$input['nama'].'</b> berhasil diperbaharui.');
            return redirect('jenis_user');
        }
        return redirect()->back()->withInput()->withErrors($validator);   
    }

    public function validateInputs($input, $id = null)
    {
    	return Validator::make($input, 
    		[
    			'nama'	=> 'required|unique:jenis_user,nama,'.$id ],
    		[
    			'nama.required'	=> 'Nama jenis user dibutuhkan.',
    			'nama.unique'	=> 'Nama jenis user yang anda masukkan sudah terdaftar di basis data.'
    		]);
    }

    public function handleCombo(Request $request)
    {
        $result = JenisUser::where('id', $request->input('id'))->first();
        return response()->json($result['perizinan']);
    }
}
