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
//petugas
Route::post('register1','petugasc@register');
Route::post('login1','petugasc@login');
//pelanggan
Route::post('register2','pelangganc@register');
Route::post('login2','pelangganc@login');
Route::get('logout','pelangganc@logout');
Route::get('tes','pelangganc@tes');
//kantin
Route::post('addkantin','kantinc@create')->middleware('jwt.verify');
Route::get('getkantin','kantinc@get')->middleware('jwt.verify');
Route::delete('delkantin/{id}','kantinc@delete')->middleware('jwt.verify');
Route::post('upkantin/{id}','kantinc@update')->middleware('jwt.verify');
Route::get('showkantin/{id}','kantinc@show');
//item
Route::post('additem1','itemc@create')->middleware('jwt.verify');
Route::get('getitem','itemc@get')->middleware('jwt.verify');
Route::delete('delitem/{id}','itemc@delete')->middleware('jwt.verify');
Route::post('upitem/{id}','itemc@update')->middleware('jwt.verify');
//transaksi
Route::post('addtrans','transaksic@create');
Route::post('additem2','transaksic@additem');
Route::get('showtrans3','transaksic@show');
route::put('confirm/{id}','transaksic@confirmation')->middleware('jwt.verify');




