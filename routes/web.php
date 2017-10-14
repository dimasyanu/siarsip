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
Auth::routes();

Route::get('/', 'DashboardController');

Route::get('records/print/{by}/{id}', 'PDFController@printRecords');

Route::get('box/print/{id}', 'PDFController@printBoxPreview');
Route::get('records/print', 'PDFController@printAllPreview');
Route::get('shelf/print/{id}', 'PDFController@printShelfPreview');

Route::resource('boxes', 'BoxController');
Route::resource('categories', 'RecordCategoryController');
Route::resource('records', 'RecordController');
Route::resource('sections', 'SectionController');
Route::resource('shelves', 'ShelfController');
Route::resource('rooms', 'RoomController');
Route::get('users/{id}/resetpass', 'UserController@viewResetPass');
Route::post('users/{id}/resetpass', 'UserController@doResetPass');
Route::get('users/{id}/changepass', 'UserController@viewChangePass');
Route::post('users/{id}/changepass', 'UserController@doChangePass');
Route::resource('users', 'UserController');

Route::get('storages', 'StorageController@index');
Route::group(['prefix' => 'api'], function() {
	Route::get('boxes/{shelf_id}', 'ApiController@getBoxesInShelf');
	Route::get('category', 'ApiController@getCategory');
	Route::get('categories', 'ApiController@getCategories');
	Route::get('nestedcat', 'ApiController@getNestedCategories');
	Route::get('sections/{box_id}', 'ApiController@getSectionsInBox');
	Route::get('shelves/{room_id}', 'ApiController@getShelvesInRoom');

	Route::get('box/form', 'ApiController@getBoxForm');
	Route::get('box/form/{id}', 'ApiController@getBoxFormById');
	Route::get('room/form', 'ApiController@getRoomForm');
	Route::get('room/form/{id}', 'ApiController@getRoomFormById');
	Route::get('section/form', 'ApiController@getSectionForm');
	Route::get('section/form/{id}', 'ApiController@getSectionFormById');
	Route::get('shelf/form', 'ApiController@getShelfForm');
	Route::get('shelf/form/{id}', 'ApiController@getShelfFormById');

	Route::post('room/new', 'ApiController@addRoom');
	Route::post('shelf/new', 'ApiController@addShelf');
	Route::post('box/new', 'ApiController@addBox');
	Route::post('section/new', 'ApiController@addSection');

	Route::post('storage/edit/{storage}/{id}', 'ApiController@editStorage');
	Route::delete('storage/delete/{storage}/{id}', 'ApiController@deleteStorage');
});