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

	    Route::get('/tariktunai/{id_dropping}', 'DroppingController@tarik_tunai');
	    Route::post('/tariktunai/{id_dropping}', 'DroppingController@tarik_tunai_process');

	    Route::post('/banks/', 'DroppingController@getChainedBank');
	});
   	
   	Route::group(['prefix' => 'transaksi'], function() {
   		Route::resource('/', 'TransaksiController');

		Route::get('/get', 'TransaksiController@getAll');
		Route::get('/get/attributes/{type}', 'TransaksiController@getAttributes');
		Route::post('/submit/verify', 'TransaksiController@submit');
		// Route::get('/berkas/remove', 'TransaksiController@removeBerkas');
		
		Route::get('/viewtransaksi/{created_at}', 'TransaksiController@view_transaksi');
	});
});