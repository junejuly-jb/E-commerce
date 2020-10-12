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

Route::group(['middleware' => ['auth:api']], function(){
    Route::put('/updateMe', 'App\Http\Controllers\ApiController@updateMe');
    Route::get('/getAllUsers', 'App\Http\Controllers\ApiController@getAllUsers');
});

Route::post('/register', 'App\Http\Controllers\ApiController@register');
Route::post('/login', 'App\Http\Controllers\ApiController@login');
