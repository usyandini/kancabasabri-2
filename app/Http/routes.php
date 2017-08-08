<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();
Route::group(['middleware' => 'guest'], function() {
	Route::get('/', 'Auth\AuthController@showLoginForm'); 
	Route::get('/login', 'Auth\AuthController@postLogin');

	/*Route::get('/login', function()
	{
	    $ldap_dn    = 'cn=read-only-admin,dc=example,dc=com';
	    $ldap_pass  = 'password';
	    $ldap_conn  = ldap_connect('ldap.forumsys.com');
	    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

	    if (ldap_bind($ldap_conn, $ldap_dn, $ldap_pass)) {
	        echo "BERHASIL MASUK LDAP SERVER";
	    }else{
	        echo 'GAGAL CONNECT LDAP SERVER!';
	    }

	});*/
});

Route::group(['middleware' => 'auth'], function() {
	// Route::get('/home', 'HomeController@index');
   	Route::get('/dashboard', 'DashboardController@index');

   	Route::group(['prefix' => 'dropping'], function() {
		Route::resource('/', 'DroppingController');
		Route::get('/get', 'DroppingController@getAll');
		
		Route::post('/filter', 'DroppingController@filterHandle');
		Route::get('/filter/{transyear}/{periode}/{kcabang}', 'DroppingController@filter');
		Route::get('/get/filtered/{transyear}/{periode}/{kcabang}', 'DroppingController@getFiltered');
		
		Route::post('/tariktunai/{id_dropping}', 'DroppingController@postDropping');
	    Route::get('/tariktunai/{id_dropping}', 'DroppingController@tarik_tunai');
	    Route::post('/tariktunai/{id_dropping}', 'DroppingController@tarik_tunai_process');

	    Route::post('/banks/', 'DroppingController@getChainedBank');
	});
   	
   	Route::group(['prefix' => 'transaksi'], function() {
   		Route::resource('/', 'TransaksiController');

		Route::get('/get', 'TransaksiController@getAll');
		Route::get('/get/attributes/{type}', 'TransaksiController@getAttributes');
		
		Route::post('/post', 'TransaksiController@transaksi_process');
		
		Route::get('/viewtransaksi', 'TransaksiController@view_transaksi');
		Route::get('/persetujuan', 'TransaksiController@persetujuan_transaksi');
		Route::get('/verifikasi', 'TransaksiController@verifikasi_transaksi');
	});
});