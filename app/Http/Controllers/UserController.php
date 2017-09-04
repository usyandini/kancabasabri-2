<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Models\Divisi;
use App\Models\KantorCabang;
use Validator;

// ------- PERIZINAN --------
//  0 = Not authorized
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
    	$validator = Validator::make($input, 
            [
            	'username'	=> 'required|unique:users',
            	'name'	=> 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4|confirmed'],
            [
            	'username.required' => 'Kolom <b>username</b> tidak boleh kosong.',
                'username.unique' => '<b>Usename</b> yang anda masukkan sudah terdaftar di database sistem.',
                'email.unique' => '<b>E-mail</b> yang anda masukkan sudah terdaftar di database sistem.',
                'password.min' => 'Panjang isian di kolom <b>password</b> minimal 4 karakter.',
                'password.confirmed' => 'Kolom <b>password dan konfirmasi password</b> tidak sesuai.']);

    	if ($validator->passes()) {
    		$input['perizinan_dropping'] = array_sum($input['perizinan_dropping']);
            $input['perizinan_transaksi'] = array_sum($input['perizinan_transaksi']);
            $input['perizinan_anggaran'] = array_sum($input['perizinan_anggaran']);

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
        // dd($request->all());
    	$input = $request->except('_token' , '_method');
    	$validator = Validator::make($input, 
            [
            	'username'	=> 'required|unique:users,username,'.$id,
            	'name'	    => 'required',
                'email'     => 'required|email|unique:users,email,'.$id,
                'cabang'    => 'required'
                ],
            [
            	'username.required' => 'Kolom <b>username</b> tidak boleh kosong.',
                'username.unique'   => '<b>Usename</b> yang anda masukkan sudah terdaftar di database sistem.',
                'email.unique'      => '<b>E-mail</b> yang anda masukkan sudah terdaftar di database sistem.',
                'cabang.required'   => 'Kolom <b>Kantor Cabang</b> tidak boleh kosong.', 
                'divisi.required'   => 'Kolom <b>Divisi</b> tidak boleh kosong.']);

    	if ($validator->passes()) {
            $input['perizinan_dropping'] = array_sum($input['perizinan_dropping']);
            $input['perizinan_transaksi'] = array_sum($input['perizinan_transaksi']);
            $input['perizinan_anggaran'] = array_sum($input['perizinan_anggaran']);
            $input['updated_by'] = \Auth::user()->id;

    		User::where('id', $id)->update($input);
	    	$user = User::withTrashed()->where('id', $id)->first()->name;

	    	session()->flash('success', 'User atas nama <b>'.$user.'</b> berhasil diperbarui');
	    	return redirect('user');
    	}

    	return redirect()->back()->withInput()->withErrors($validator);
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
