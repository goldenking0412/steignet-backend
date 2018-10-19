<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/steignet-search', 'SearchController@SearchData');
Route::get('/craglist-data', 'InventoryController@Craglist');
Route::get('/passthrough', 'InventoryController@PassThrough');
Route::get('/master_inventory', 'InventoryController@Master_inventory');
Route::get('/mispricing', 'MispricingController@Mispricing');
