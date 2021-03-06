<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//Route::get('dni','App\Http\Controllers\DniController@showAll');
//Route::get('dni/{dni_number_pet}','App\Http\Controllers\DniController@show');

Route::post('dni','App\Http\Controllers\DniController@store');
//Route::get('dni/{dni_number_pet}','App\Http\Controllers\DniController@show');
Route::get('dni_front/{dni_number}','App\Http\Controllers\DniController@getDniFront');
Route::get('dni_back/{dni_number}','App\Http\Controllers\DniController@getDniBack');


Route::post('certipeid', 'App\Http\Controllers\CertipeidController@store');
Route::get('certipeid/{dni_number}','App\Http\Controllers\CertipeidController@getCertipeid');
//Route::get('certipeid/{cellphone_owner}','App\Http\Controllers\CertipeidController@show');
