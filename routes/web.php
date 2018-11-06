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

Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::get('register', 'Auth\LoginController@register')->name('register');

Route::get('/load', 'Auth\LoginController@load');

Route::get('/master-inventory', 'InventoryController@getMaster');

Route::get('/steignet-data', 'InventoryController@SteignetData');


