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

		Route::get('/verifikasi/tariktunai/{id}', 'DroppingController@verifikasi');
		Route::get('/verifikasi/tariktunai/{reaction}/{id}', 'DroppingController@submitVerification');

	    Route::post('/banks/', 'DroppingController@getChainedBank');
	});
   	
   	Route::group(['prefix' => 'transaksi'], function() {
   		Route::resource('/', 'TransaksiController');
   		Route::post('/filter/process', 'TransaksiController@filter_handle');
   		Route::get('/filter/result/{batch}/{batch_no}', 'TransaksiController@filter_result');

		Route::get('/get', 'TransaksiController@getAll');
		Route::get('get/batch/{batch}', 'TransaksiController@getByBatch');
		Route::get('/get/attributes/{type}', 'TransaksiController@getAttributes');
		Route::post('/submit/verify', 'TransaksiController@submit');
		Route::post('/berkas/remove', 'TransaksiController@removeBerkas');
		Route::get('/berkas/download/{id}', 'TransaksiController@downloadBerkas');
				
		Route::get('/persetujuan/{id_batch}', 'TransaksiController@persetujuan');
		Route::get('/verifikasi/{id_batch}', 'TransaksiController@verifikasi');

		Route::post('/submit/verifikasi/{type}/{id_batch}', 'TransaksiController@submitVerification');
	});

	Route::resource('/user', 'UserController');
	Route::post('/user/restore/{id}', 'UserController@restore');
});