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
    	return view('user.list-jenis');
    }

    public function create()
    {
    	return view('user.input-jenis', [
    		'jenis_user' => true ]);
    }
    
    public function store(Request $request)
    {
    	$input = $request->except('_method', '_token');
    	$validator = $this->validateInputs($input);

    	if ($validator->passes()) {
    		if ($input['perizinan']['data-cabang'] == 'off') { unset($input['perizinan']['data-cabang']); }	
    		$input['created_by'] = $input['updated_by'] = \Auth::user()->id;
    		JenisUser::create($input);
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
}
