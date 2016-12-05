<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/home', 'HomeController@index');
	/*
	|--------------------------------------------------------------------------
	| slots
	|--------------------------------------------------------------------------
	|
	| Here is where user can see their slots time.
	/user can able to delete edit their slots.

	*/
	Route::get('/view/account', 'HomeController@viewAccount');
	Route::get('/slot/new', 'SlotController@index');
	Route::get('/slot/list', 'SlotController@showSlotList');
	Route::get('slot/edit/{id}', 'SlotController@edit');
	Route::get('slot/repeat/{id}', 'SlotController@repeat');
	
	Route::post('/slot/save', 'SlotController@saveSlot');
	Route::post('/slot/approve', 'SlotController@approve');
	Route::post('/slot/cancel', 'SlotController@cancel');
	
   Route::post('/slot/list', 'SlotController@showSlotList');
   Route::post('/slot/list1', 'SlotController@showSlotList1');
});

Route::get('/slot/load', 'SlotController@load');
Route::get('/slot/view', 'SlotController@viewSlot');
