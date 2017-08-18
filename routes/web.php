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
Route::resource('boxes', 'BoxController');
Route::resource('categories', 'RecordCategoryController');
Route::resource('records', 'RecordController');
Route::resource('rooms', 'RoomController');
Route::resource('sections', 'SectionController');
Route::resource('users', 'UserController');
Route::resource('shelves', 'ShelfController');

Route::get('storages', 'StorageController@index');
Route::group(['prefix' => 'api'], function() {
	Route::get('boxes/{shelf_id}', 'ApiController@getBoxesInShelf');
	Route::get('category', 'ApiController@getCategory');
	Route::get('categories', 'ApiController@getCategories');
	Route::get('nestedcat', 'ApiController@getNestedCategories');
	Route::get('sections/{box_id}', 'ApiController@getSectionsInBox');
	Route::get('shelves/{room_id}', 'ApiController@getShelvesInRoom');
});