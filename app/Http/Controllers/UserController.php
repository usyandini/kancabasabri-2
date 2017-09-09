<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Models\Divisi;
use App\Models\KantorCabang;
use Validator;

// ------- PERIZINAN --------
//  0 = Not authorized at all
//  1 = Staff
//  2 = Approver
//  3 = Staff + Approver
//  4 = Superuser
//  5 = Staff + Superuser
//  6 = Approver + Superuser
//  7 = Staff + Approver + Superuser
// --------------------------
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
            'divisi' => Divisi::get()
        ]);
    }

    public function store(Request $request)
    {
    	$input = $request->except('_method', '_token');
    	$validator = $this->validateInputs($input);

    	if ($validator->passes()) {
		    $input['perizinan_dropping'] = isset($input['perizinan_dropping']) ? array_sum($input['perizinan_dropping']) : 0;
            $input['perizinan_transaksi'] = isset($input['perizinan_transaksi']) ? array_sum($input['perizinan_transaksi']) : 0;
            $input['perizinan_anggaran'] = isset($input['perizinan_anggaran']) ? array_sum($input['perizinan_anggaran']) : 0;

            $input['password'] = bcrypt($input['password']);
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
            'divisi' => Divisi::get()]);
    }

    public function update(Request $request, $id)
    {    	
    	$input = $request->except('_token' , '_method');
        if ($input['password'] == '') { unset($input['password']); unset($input['password_confirmation']); }
        $validator = $this->validateInputs($input, $id);

    	if ($validator->passes()) {
            $input['perizinan_dropping'] = isset($input['perizinan_dropping']) ? array_sum($input['perizinan_dropping']) : 0;
            $input['perizinan_transaksi'] = isset($input['perizinan_transaksi']) ? array_sum($input['perizinan_transaksi']) : 0;
            $input['perizinan_anggaran'] = isset($input['perizinan_anggaran']) ? array_sum($input['perizinan_anggaran']) : 0;
            $input['updated_by'] = \Auth::user()->id;

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
