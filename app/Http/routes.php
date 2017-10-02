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
		});


		Route::group(['middleware' => 'previlege:transaksi,2,3,4,6,7'], function() {
   			Route::get('/persetujuan/{id_batch}', 'TransaksiController@persetujuan');
   			Route::get('/persetujuan/', 'TransaksiController@persetujuan2');
			Route::get('/verifikasi/{id_batch}', 'TransaksiController@verifikasi');


		Route::get('/persetujuan/{id_batch}', 'TransaksiController@persetujuan');
		Route::get('/verifikasi/{id_batch}', 'TransaksiController@verifikasi');

		Route::post('/submit/verifikasi/{type}/{id_batch}', 'TransaksiController@submitVerification');

   		Route::post('/filter/process', 'TransaksiController@filter_handle');
   		Route::get('/filter/result/{batch}/{batch_no}', 'TransaksiController@filter_result');

		Route::get('/get', 'TransaksiController@getAll');
		Route::get('get/batch/{batch}', 'TransaksiController@getByBatch');
		Route::get('/get/attributes/{type}', 'TransaksiController@getAttributes');
		
		Route::post('/berkas/remove', 'TransaksiController@removeBerkas');
		Route::get('/berkas/download/{id}', 'TransaksiController@downloadBerkas');
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
		Route::get('/{kategori}/{id}/{type}', 'PelaporanController@form_master');
		Route::get('/lihat/{kategori}', 'PelaporanController@pelaporan');
		Route::get('/tambah/{kategori}', 'PelaporanController@tambah');
		Route::get('/removeFormMaster', 'PelaporanController@removeFormMasterAll');
		Route::get('/get/filtered/{id}/{type}', 'PelaporanController@getFiltered');
   	});

	Route::group(['prefix' => 'pelaporan'], function() {
   		Route::resource('/', 'PelaporanController');

		Route::post('/submit/tambah', 'PelaporanController@store');
		Route::post('/pelaporan/{kategori}/{id}/{type}', 'PelaporanController@form_master');
	});

	Route::resource('/user', 'UserController');
	Route::get('/user/profile/{id}', 'UserController@profile');
	Route::post('/user/restore/{id}', 'UserController@restore');



	Route::resource('/item', 'ItemController');
	Route::get('/item/tambah', 'ItemController@tambahItem');


	Route::resource('/jenis_user', 'JenisUserController');
	Route::post('/jenis_user/handle', 'JenisUserController@handleCombo');

	Route::group(['prefix' => 'item'], function(){
		Route::resource('/', 'ItemController');
		Route::get('/create', 'ItemController@create');
	});


	Route::group(['prefix' => 'reason'], function(){
		Route::resource('/', 'ItemController@reason');
		Route::post('/store', 'ItemController@store');
		Route::post('/update/{id}', 'ItemController@update');
		Route::get('/delete/{id}', 'ItemController@delete');
		
	});

	Route::group(['prefix' => 'program_prioritas'], function(){
		Route::resource('/', 'ItemController@program_prioritas');
		Route::post('/store_program_prioritas', 'ItemController@store_program_prioritas');
		Route::post('/update_program_prioritas/{id}', 'ItemController@update_program_prioritas');
		Route::get('/delete_program_prioritas/{id}', 'ItemController@delete_program_prioritas');
		
	});

	Route::group(['prefix' => 'arahan_rups'], function(){
		Route::resource('/', 'ItemController@arahan_rups');
		Route::post('/store_arahan_rups', 'ItemController@store_arahan_rups');
		Route::post('/update_arahan_rups/{id}', 'ItemController@update_arahan_rups');
		Route::get('/delete_arahan_rups/{id}', 'ItemController@delete_arahan_rups');
		
	});

	Route::group(['prefix' => 'unitkerja'], function(){
		Route::resource('/', 'TindaklanjutController');
		Route::post('/store_unitkerja', 'TindaklanjutController@store_unitkerja');
		Route::post('/update_unitkerja/{id1}', 'TindaklanjutController@update_unitkerja');
		Route::get('/delete_unitkerja/{id1}', 'TindaklanjutController@delete_unitkerja');
		Route::get('/tindaklanjut/{id1}', 'TindaklanjutController@tindaklanjut');
		
	});

	Route::group(['prefix' => 'tindaklanjut'], function(){
		Route::resource('/', 'TindaklanjutController');
		Route::post('/store_temuan/{id1}', 'TindaklanjutController@store_temuan');
		Route::post('/update_temuan/{id1}', 'TindaklanjutController@update_temuan');
		Route::post('/store_rekomendasi/{id2}', 'TindaklanjutController@store_rekomendasi');
		Route::post('/update_rekomendasi/{id2}', 'TindaklanjutController@update_rekomendasi');
		Route::post('/store_tindaklanjut/{id3}', 'TindaklanjutController@store_tindaklanjut');
		Route::post('/update_tindaklanjut/{id3}', 'TindaklanjutController@update_tindaklanjut');
		Route::post('/update_unitkerja/{id1}', 'TindaklanjutController@update_unitkerja');
		Route::get('/delete_unitkerja/{id1}', 'TindaklanjutController@delete_unitkerja');
		Route::get('/delete_temuan/{id2}', 'TindaklanjutController@delete_temuan');
		Route::get('/delete_rekomendasi/{id3}', 'TindaklanjutController@delete_rekomendasi');
		Route::get('/delete_tindaklanjut/{id4}', 'TindaklanjutController@delete_tindaklanjut');
		Route::get('/download/{id4}', 'TindaklanjutController@downloadberkas');
		Route::get('/tindaklanjut/{id1}', 'TindaklanjutController@tindaklanjut');
		Route::get('/export/{id1}', 'TindaklanjutController@export_tindaklanjut');
		Route::get('/print/{id1}', 'TindaklanjutController@print_tindaklanjut');
		
	});
 });