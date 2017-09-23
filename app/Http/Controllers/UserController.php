<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Models\Divisi;
use App\Models\KantorCabang;
use App\Models\JenisUser;
use Validator;
use Adldap\Laravel\Facades\Adldap;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:info_u', ['only' => 'index']);
        $this->middleware('can:tambah_u', ['only' => 'create', 'store']);
        $this->middleware('can:edit_u', ['only' => 'edit', 'update']);
        $this->middleware('can:restore_u', ['only' => 'restore']);
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
            if (isset($input['password'])) {
                $input['password'] = bcrypt($input['password']);
                unset($input['password_confirmation']);
            }else{
                $input['password'] = "";
            }
            // if ($input['perizinan']['data-cabang'] == 'off') { unset($input['perizinan']['data-cabang']); }
            $input['created_by'] = \Auth::user()->id;
            User::create($input);

            session()->flash('success', 'User atas nama <b>'.$input['name'].'</b> berhasil disimpan');
            return redirect('user');
        } 

        // echo json_encode($input);
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

    public function profile($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        return view('user.edit', [
            'user' => $user, 
            'cabang' => KantorCabang::get(),
            'divisi' => Divisi::get(),
            'jenis_user' => JenisUser::get(),
            'profile_edit' => true]);   
    }

    public function update(Request $request, $id)
    {    	
    	$input = $request->except('_token' , '_method');
        if ($input['password'] == '') { unset($input['password']); unset($input['password_confirmation']); }
        $validator = $this->validateInputs($input, $id);

        if ($validator->passes()) {
            $input['updated_by'] = \Auth::user()->id;
            if (isset($input['password'])) {
                $input['password'] = bcrypt($input['password']);
                unset($input['password_confirmation']);
            }
            if (isset($input['perizinan'])) {
                // if ($input['perizinan']['data-cabang'] == 'off') { unset($input['perizinan']['data-cabang']); }
                $user = User::withTrashed()->where('id', $id)->first();
                $user->perizinan = $input['perizinan'];
                $user->save();
                
            echo json_encode($input['perizinan']);
                unset($input['perizinan']);
            }

            
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

    public function filterLDAP(){
        // $keyword_decode = urldecode($keyword);
        // $users = AdldapInterface::search()->users()->get();
        $hostname = '172.31.0.2';
        $ldap_username = 'fax.server@asabri.co.id';
        $ldap_password = 'f3x-serv.!!';
        $ldap_connection = ldap_connect($hostname);

        if (FALSE === $ldap_connection) {
            exit('Connection Refused With Hostname : ' . $hostname);
        }

        ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
        ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);

        $entries = Array();
        if (TRUE === ldap_bind($ldap_connection, $ldap_username, $ldap_password)) {
            $ldap_base_dn = 'DC=asabri,DC=co,DC=id';
            // $search_filter = '(&(objectCategory=person)(samaccountname=*'.$keyword_decode.'*))';
            $search_filter = '(&(objectCategory=person)(samaccountname=*))';
            $attributes = array();
            // $attributes[] = 'givenname';
            $attributes[] = 'mail';
            $attributes[] = 'samaccountname';
            $attributes[] = 'displayname';
            // $attributes[] = 'password';
            $result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter, $attributes);
            if (FALSE !== $result) {
                $entries = ldap_get_entries($ldap_connection, $result);
            }
            // echo "<pre>";
            // print_r($entries);
            // echo "</pre>";
            ldap_unbind($ldap_connection); // Clean up after ourselves.
        } else {
            exit("Connection Succesfully, But LDAP Bind host refused with status = false");
        }

        // echo json_encode($entries);

        // echo $entries[0]["samaccountname"]["0"].":".$entries[0]["displayname"]["0"];
        return response()->json($entries);
    }

}
