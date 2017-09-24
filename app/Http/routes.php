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
	Route::get('/login', 'Auth\AuthController@showLoginForm');
});

Route::group(['middleware' => 'auth'], function() {
	Route::get('notification/', 'NotificationController@get');
	Route::get('notification/redirect/{id}', 'NotificationController@redirect');
	Route::get('/dashboard', 'DashboardController@index');


	Route::group(['prefix' => 'dropping'], function() {
		Route::resource('/', 'DroppingController');
		Route::get('/get', 'DroppingController@getAll');
		
		Route::post('/filter', 'DroppingController@filterHandle');
		Route::get('/filter/{transyear}/{periode}/{kcabang}', 'DroppingController@filter');
		Route::get('/get/filtered/{transyear}/{periode}/{kcabang}', 'DroppingController@getFiltered');
		
		Route::get('/penyesuaian/{id_dropping}', 'DroppingController@penyesuaian');
		Route::post('/penyesuaian/{id_dropping}', 'DroppingController@penyesuaian_process');
		
		Route::get('/tariktunai/{id_dropping}', 'DroppingController@tarik_tunai');
		Route::post('/tariktunai/{id_dropping}', 'DroppingController@tarik_tunai_process');
		
		Route::get('/{routes}/berkas/download/{id}', 'DroppingController@downloadBerkas');
		Route::get('/verifikasi/tariktunai/{id}', 'DroppingController@verifikasiTarikTunai');
		Route::get('/verifikasi/tariktunai/{reaction}/{id}', 'DroppingController@submitVerification');

		Route::get('/verifikasi/penyesuaian/{id}', 'DroppingController@verifikasiPenyesuaian');
		Route::get('/verifikasi/penyesuaian/final/{id}', 'DroppingController@verifikasiPenyesuaianLv2');
		Route::get('/verifikasi/penyesuaian/{level}/{reaction}/{id}', 'DroppingController@submitVerificationPenyesuaian');

		Route::post('/banks/', 'DroppingController@getChainedBank');
	});

	Route::group(['prefix' => 'transaksi'], function() {
		Route::resource('/', 'TransaksiController');
		Route::post('/submit/verify', 'TransaksiController@submit');

		Route::get('/persetujuan/{id_batch}', 'TransaksiController@persetujuan');
		Route::get('/persetujuan/', 'TransaksiController@persetujuan2');
		Route::get('/verifikasi/{id_batch}', 'TransaksiController@verifikasi');

		Route::post('/submit/verifikasi/{type}/{id_batch}', 'TransaksiController@submitVerification');

		Route::post('/filter/process', 'TransaksiController@filter_handle');
		Route::get('/filter/result/{batch}/{batch_no}', 'TransaksiController@filter_result');

		Route::get('/get', 'TransaksiController@getAll');
		Route::get('get/batch/{batch}', 'TransaksiController@getByBatch');
		Route::get('/get/attributes/{type}', 'TransaksiController@getAttributes');
		
		Route::post('/berkas/remove', 'TransaksiController@removeBerkas');
		Route::get('/berkas/download/{id}', 'TransaksiController@downloadBerkas');

		Route::get('/refresh/anggaran/{batch_id}', 'TransaksiController@refreshAnggaran');
	});


	Route::group(['prefix' => 'anggaran'], function() {
		Route::resource('/', 'AnggaranController');

		Route::get('/tambah/', 'AnggaranController@tambah_anggaran');
		Route::get('/edit/{nd}/{status}', 'AnggaranController@edit_anggaran');
		Route::get('/persetujuan/{nd}/{status}', 'AnggaranController@persetujuan_anggaran');
		Route::get('/get/attributes/{type}/{id}', 'AnggaranController@getAttributes');
		Route::get('/get/filtered/{nd_surat}/{type}', 'AnggaranController@getFiltered');
		Route::get('/get/filteredHistory/{tahun}/{unit}/{kategori}/{keyword}', 'AnggaranController@getFilteredHistory');
		Route::get('/get/filteredAnggaran/{nd_surat}/{status}/{unit}', 'AnggaranController@getFilteredAnggaran');
		Route::get('/get/download/{id}', 'AnggaranController@unduh_file');
		Route::get('/riwayat/', 'AnggaranController@riwayat');
		Route::post('/riwayat/', 'AnggaranController@riwayat');
		Route::post('/cari/', 'AnggaranController@index');
		Route::get('/removeAnggaran/', 'AnggaranController@removeAnggaranAll');
		Route::get('/activeFileListAnggaran/', 'AnggaranController@activeFileListAnggaranAll');
		Route::post('/submit/tambah', 'AnggaranController@store');

	});

	Route::group(['prefix' => 'pelaporan'], function() {

		Route::resource('/', 'PelaporanController');
		Route::get('/tambah/{kategori}', 'PelaporanController@tambah');

		Route::post('/submit/tambah', 'PelaporanController@store');
		// Route::get('/{kategori}/{id}/{type}', 'PelaporanController@form_master');
		Route::get('/detail/{kategori}/{id}/{type}', 'PelaporanController@form_master_detail');
		Route::get('/form_master/{kategori}', 'PelaporanController@form_master');
		Route::get('/lihat/{kategori}', 'PelaporanController@pelaporan');
		Route::get('/tambah/{type}/{kategori}', 'PelaporanController@tambah');
		Route::get('/removeFormMaster', 'PelaporanController@removeFormMasterAll');
		Route::get('/get/filtered/{id}/{type}', 'PelaporanController@getFiltered');

		Route::get('/get/filteredMaster/{type}', 'PelaporanController@getDataFormMaster');
   	});

	Route::get('/user/ldap/', 'UserController@filterLDAP');
	Route::resource('/user', 'UserController');
	Route::get('/user/profile/{id}', 'UserController@profile');
	Route::post('/user/restore/{id}', 'UserController@restore');

	// Route::resource('/item', 'ItemController');
	// Route::get('/item/tambah', 'ItemController@tambahItem');

	Route::resource('/jenis_user', 'JenisUserController');
	Route::post('/jenis_user/handle', 'JenisUserController@handleCombo');

	Route::group(['prefix' => 'item'], function(){
		Route::resource('/', 'ItemController');
		Route::get('/get/combination/{id}/{cabang}/{divisi}/{tanggal}', 'ItemController@getCombination');
		Route::get('/create', 'ItemController@create');
		Route::post('/add', 'ItemController@addItem');
		Route::post('/submit/{type}', 'ItemController@submitAnggaranItem');
		Route::get('/edit/{id}', 'ItemController@editItem');
		Route::post('/update/{id}', 'ItemController@updateItem');
		Route::get('/delete/{id}', 'ItemController@destroy');
	});

	Route::group(['prefix' => 'reason'], function(){
		Route::resource('/', 'ItemController@reason');
		Route::post('/store', 'ItemController@store');
		Route::post('/update/{id}', 'ItemController@update');
		Route::get('/delete/{id}', 'ItemController@delete');		
	});
});