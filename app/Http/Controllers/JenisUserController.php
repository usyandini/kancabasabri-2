<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\JenisUser;
use Validator;

class JenisUserController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
    	return view('user.list-jenis', [
            'users' => JenisUser::withTrashed()->get()]);
    }

    public function create()
    {
    	return view('user.input-jenis', [
    		'jenis_user' => true ]);
    }

    public function edit($id)
    {
        return view('user.edit-jenis', [
            'user' => JenisUser::withTrashed()->where('id', $id)->first()]);
    }
    
    public function store(Request $request)
    {
    	$input = $request->except('_method', '_token');
        $validator = $this->validateInputs($input);

    	if ($validator->passes()) {
            if ($input['perizinan']['data-cabang'] == 'off') { unset($input['perizinan']['data-cabang']); }    
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
            if ($input['perizinan']['data_cabang'] == 'off') { unset($input['perizinan']['data-cabang']); } 
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
