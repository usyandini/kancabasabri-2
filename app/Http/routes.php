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
	Route::get('notification/read_all/', 'NotificationController@read_all');
	Route::get('notification/mark_all', 'NotificationController@markAllAsRead');
	Route::get('notification/del_all', 'NotificationController@deleteAll');
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
		Route::resource('/', 'TransaksiController', ['except' => ['index']]);
		Route::get('/{batch_id?}', 'TransaksiController@index');
		Route::post('/create/process', 'TransaksiController@createProcess');
		Route::post('/submit/verify/{batch}', 'TransaksiController@submit');

		Route::get('/persetujuan/{id_batch}', 'TransaksiController@persetujuan');
		Route::get('/persetujuan/', 'TransaksiController@persetujuan2');
		Route::get('/verifikasi/{id_batch}', 'TransaksiController@verifikasi');

		Route::post('/submit/verifikasi/{type}/{id_batch}', 'TransaksiController@submitVerification');

		Route::post('/filter/process', 'TransaksiController@filter_handle');
		Route::get('/filter/result/{batch}', 'TransaksiController@filter_result');

		Route::get('/get', 'TransaksiController@getAll');
		Route::get('get/batch/{batch}', 'TransaksiController@getByBatch');
		Route::get('/get/attributes/{type}', 'TransaksiController@getAttributes');
		
		Route::post('/berkas/remove', 'TransaksiController@removeBerkas');
		Route::get('/berkas/download/{id}', 'TransaksiController@downloadBerkas');

		Route::get('/refresh/anggaran/{batch_id}', 'TransaksiController@refreshAnggaran');

		Route::get('/report/realisasi', 'TransaksiController@realisasi');
		Route::post('/filter/reports', 'TransaksiController@filter_handle_realisasi');
		Route::get('/filter/realisasi/{cabang}/{awal}/{akhir}/{transyear}', 'TransaksiController@filter_result_realisasi');

		Route::get('/print/realisasi/{cabang}/{awal}/{akhir}/{transyear}/{type}', 'TransaksiController@cetakRealisasi');
	});


	Route::group(['prefix' => 'anggaran'], function() {
		Route::resource('/', 'AnggaranController');

		Route::get('/batas/', 'AnggaranController@batas');
		Route::post('/batas/tambah/', 'AnggaranController@add_pengajuan');
		Route::post('/batas/ubah/{id}', 'AnggaranController@change_pengajuan');
		Route::get('/tambah/', 'AnggaranController@tambah_anggaran');
		Route::get('/edit/{nd}', 'AnggaranController@edit_anggaran');
		Route::get('/persetujuan/{nd}/{status}', 'AnggaranController@persetujuan_anggaran');
		Route::get('/get/attributes/{type}/{id}', 'AnggaranController@getAttributes');
		Route::get('/get/filtered/{nd_surat}/{type}', 'AnggaranController@getFiltered');
		Route::get('/get/filteredHistory/{tahun}/{unit}/{kategori}/{keyword}', 'AnggaranController@getFilteredHistory');
		Route::get('/get/filteredAnggaran/{nd_surat}/{status}/{unit}', 'AnggaranController@getFilteredAnggaran');
		Route::get('/get/download/{id}', 'AnggaranController@unduh_file');
		Route::get('/riwayat/', 'AnggaranController@riwayat');
		Route::post('/riwayat/', 'AnggaranController@riwayat');
		Route::post('/cari/', 'AnggaranController@cari');
		Route::post('/submit/tambah', 'AnggaranController@store');

	});

	Route::group(['prefix' => 'pelaporan'], function() {

		Route::resource('/', 'PelaporanController');
		Route::get('/tambah/{kategori}', 'PelaporanController@tambah');

		Route::post('/submit/tambah', 'PelaporanController@store');
		// Route::get('/{kategori}/{id}/{type}', 'PelaporanController@form_master');
		Route::get('/edit/{type}/{kategori}/{id}', 'PelaporanController@edit');
		Route::get('/informasi/{type}/{kategori}', 'PelaporanController@pelaporan');
		Route::post('/cari/{kategori}/{type}', 'PelaporanController@cari');
		Route::get('/usulan_program_prioritas', 'PelaporanController@usulan_program_prioritas');
		Route::get('/tambah_usulan_program', 'PelaporanController@tambah_usulan_program_prioritas');
		Route::get('/edit_usulan_program/{id}', 'PelaporanController@edit_usulan_program_prioritas');
		Route::get('/tambah/{type}/{kategori}/{id}', 'PelaporanController@tambah');
		Route::get('/removeFormMaster', 'PelaporanController@removeFormMasterAll');
		Route::get('/get/filtered/{type}/{id}/{kategori}', 'PelaporanController@getFiltered');
		Route::get('/get/attributes/{type}/{id}', 'PelaporanController@getAttributes');
		Route::get('/get/check/{id}/{type}', 'PelaporanController@check_tambah');
		Route::get('/get/filteredMaster/{kategori}/{type}/{id}', 'PelaporanController@getDataFormMaster');
		Route::get('/get/filteredPelaporan/{type}/{kategori}/{tahun}/{tw_dari}/{tw_ke}/{unit_kerja}', 'PelaporanController@getFilteredPelaporan');
		Route::get('/get/download/{id}', 'PelaporanController@unduh_file');
		
   	});

	Route::get('/user/ldap/', 'UserController@filterLDAP');
	Route::resource('/user', 'UserController');
	Route::get('/user/profile/{id}', 'UserController@profile');
	Route::post('/user/restore/{id}', 'UserController@restore');

	Route::post('/jenis_user/restore/{id}', 'JenisUserController@restore');
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
		Route::get('/anggaran', 'ItemController@editItemAnggaran');
		Route::post('/update/anggaran/{id}', 'ItemController@updateItemAnggaran');
		Route::get('/delete/{jenis}/{id}', 'ItemController@destroy');
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

	Route::group(['prefix' => 'tindaklanjutex'], function(){
		Route::resource('/', 'TindaklanjutController@unitkerjaex');
		Route::post('/store_unitkerjaex', 'TindaklanjutController@store_unitkerjaex');
		Route::get('/tindaklanjutext/{id1}', 'TindaklanjutController@tindaklanjutext');
		Route::get('/tindaklanjuteksternal', 'TindaklanjutController@tindaklanjuteksternal');
		Route::get('/myform/{unitkerja}', 'TindaklanjutController@myformAjaxtindaklanjut');
		
	});

	Route::group(['prefix' => 'tindaklanjut'], function(){
		Route::get('/', 'TindaklanjutController@tindaklanjutmaster');
		Route::post('/store_temuan', 'TindaklanjutController@store_temuan');
		Route::post('/update_temuan/{id1}', 'TindaklanjutController@update_temuan');
		Route::post('/store_rekomendasi', 'TindaklanjutController@store_rekomendasi');
		Route::post('/update_rekomendasi/{id2}', 'TindaklanjutController@update_rekomendasi');
		Route::post('/store_tindaklanjut', 'TindaklanjutController@store_tindaklanjut');
		Route::post('/update_tindaklanjut/{id3}', 'TindaklanjutController@update_tindaklanjut');
		Route::post('/update_unitkerja/{id1}', 'TindaklanjutController@update_unitkerja');
		Route::get('/delete_unitkerja/{id1}', 'TindaklanjutController@delete_unitkerja');
		Route::get('/delete_temuan/{id2}', 'TindaklanjutController@delete_temuan');
		Route::get('/delete_rekomendasi/{id3}', 'TindaklanjutController@delete_rekomendasi');
		Route::get('/delete_tindaklanjut/{id4}', 'TindaklanjutController@delete_tindaklanjut');
		Route::get('/download/{id4}', 'TindaklanjutController@downloadberkas');
		Route::get('/lihat/{id4}', 'TindaklanjutController@lihatberkas');
		Route::get('/tindaklanjut/{id1}', 'TindaklanjutController@tindaklanjut');
		Route::get('/export/{id1}', 'TindaklanjutController@export_tindaklanjut');
		Route::get('/print/{id1}', 'TindaklanjutController@print_tindaklanjut');
		Route::get('/kirim/{id1}', 'TindaklanjutController@kirim_tindaklanjut');
		Route::get('/myform/{unitkerja}', 'TindaklanjutController@myformAjaxunitkerja');
		
	});

	Route::group(['prefix' => 'tindaklanjutinternal'], function(){
		Route::get('/', 'TindaklanjutController@tindaklanjutinternal');
		Route::get('/myform/{unitkerja}', 'TindaklanjutController@myformAjax');
		Route::get('/kirim2/{id1}', 'TindaklanjutController@kirim_tindaklanjut2');
		
	});
	// Route::get('myform/ajax/{unitkerja}',array('as'=>'myform.ajax','uses'=>'TindaklanjutController@myformAjax'));
});

