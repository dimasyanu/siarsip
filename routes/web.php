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
Route::resource('rooms', 'RoomController');
Route::resource('users', 'UserController');
Route::resource('wardrobes', 'WardrobeController');

Route::get('storages', 'StorageController@index');