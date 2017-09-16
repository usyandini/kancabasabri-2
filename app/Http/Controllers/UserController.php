<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Models\Divisi;
use App\Models\KantorCabang;
use App\Models\JenisUser;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
    	return view('user.index', ['users' => User::withTrashed()->get()]);
    }

    public function create()
    {
    	return view('user.input', [
            'cabang' => KantorCabang::get(),
            'divisi' => Divisi::get(),
            'jenis_user' => JenisUser::get()
        ]);
    }

    public function store(Request $request)
    {
    	$input = $request->except('_method', '_token');
    	$validator = $this->validateInputs($input);

    	if ($validator->passes()) {
            // $input['password'] = bcrypt($input['password']);
            if ($input['perizinan']['data-cabang'] == 'off') { unset($input['perizinan']['data-cabang']); }
            $input['password'] = bcrypt('rahasia');
            $input['created_by'] = \Auth::user()->id;
    		User::create($input);

    		session()->flash('success', 'User atas nama <b>'.$input['name'].'</b> berhasil disimpan');
    		return redirect('user');
    	} 

    	return redirect()->back()->withInput()->withErrors($validator);
    }

    public function edit($id)
    {
    	$user = User::withTrashed()->where('id', $id)->first();
    	return view('user.edit', [
            'user' => $user, 
            'cabang' => KantorCabang::get(),
            'divisi' => Divisi::get(),
            'jenis_user' => JenisUser::get()]);
    }

    public function update(Request $request, $id)
    {    	
    	$input = $request->except('_token' , '_method');
        // if ($input['password'] == '') { unset($input['password']); unset($input['password_confirmation']); }
        $validator = $this->validateInputs($input, $id);

    	if ($validator->passes()) {
            $input['updated_by'] = \Auth::user()->id;
            if ($input['perizinan']['data-cabang'] == 'off') { unset($input['perizinan']['data-cabang']); }

            $user = User::withTrashed()->where('id', $id)->first();
            $user->perizinan = $input['perizinan'];
            $user->save();
            unset($input['perizinan']);
    		User::where('id', $id)->update($input);
	    	$user = User::withTrashed()->where('id', $id)->first();

	    	session()->flash('success', 'User atas nama <b>'.$user->name.' ('.$user->username.')</b> berhasil diperbarui.');
	    	return redirect('user');
    	}

    	return redirect()->back()->withInput()->withErrors($validator);
    }

    public function validateInputs($input, $id = null)
    {
        return Validator::make($input, 
            [
                'username'  => 'required|unique:users,username,'.$id,
                'name'      => 'required',
                'email'     => 'required|email|unique:users,email,'.$id,
                'cabang'    => 'required',
                'divisi'    => 'required_if:cabang,00',
                'password'  => 'sometimes|required|min:4|confirmed'
            ], [
                'username.required' => 'Kolom <b>username</b> tidak boleh kosong.',
                'username.unique'   => '<b>Usename</b> yang anda masukkan sudah terdaftar di database sistem.',
                'email.unique'      => '<b>E-mail</b> yang anda masukkan sudah terdaftar di database sistem.',
                'cabang.required'   => 'Kolom <b>Kantor Cabang</b> tidak boleh kosong.', 
                'divisi.required_if'   => 'Kolom <b>Divisi</b> tidak boleh kosong jika cabang yang dipilih <b>kantor pusat</b>.',
                'password.required'   => 'Kolom <b>password</b> tidak boleh kosong.',
                'password.min'      => 'Panjang isian kolom <b>password</b> minimal 4 karakter.',
                'password.confirmed' => 'Kolom <b>password dan konfirmasi password</b> harus cocok.']);
    }

    public function restore(Request $request, $id)
    {
		User::where('id', $id)->restore();
		$user = User::where('id', $id)->first()->name ? User::where('id', $id)->first()->name : User::where('id', $id)->first()->username;

		session()->flash('success', 'User atas nama <b>'.$user.'</b> berhasil direstore');
    	return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
    	$user = User::withTrashed()->where('id', $id)->first()->name ? User::withTrashed()->where('id', $id)->first()->name : User::withTrashed()->where('id', $id)->first()->username;
        
        if ($request->is_force == '1') {
            User::where('id', $id)->forceDelete();
        } else {
            User::where('id', $id)->delete();
        }
    
    	session()->flash('success', 'User atas nama <b>'.$user.'</b> berhasil dihapus');
    	return redirect()->back();
    }
}
