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
Route::resource('categories', 'ItemCategoryController');
Route::resource('items', 'ItemController');
Route::resource('rooms', 'RoomController');
Route::resource('users', 'UserController');
Route::resource('shelves', 'ShelfController');

Route::get('storages', 'StorageController@index');
Route::group(['prefix' => 'api'], function() {
	Route::get('category', 'ApiController@getCategory');
	Route::get('categories', 'ApiController@getCategories');
	Route::get('nestedcat', 'ApiController@getNestedCategories');
	Route::get('shelves/{id}', 'ApiController@getShelvesInRoom');
});