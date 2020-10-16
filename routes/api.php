<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function(){
    Route::put('/updateMe', 'App\Http\Controllers\ApiController@updateMe');
    Route::get('/getAllUsers', 'App\Http\Controllers\ApiController@getAllUsers');
    Route::put('/deactivateUser/{id}', 'App\Http\Controllers\ApiController@deactivateUser');
    Route::put('/activateUser/{id}', 'App\Http\Controllers\ApiController@activateUser');
    Route::get('/profile', 'App\Http\Controllers\ApiController@profile');
    Route::post('/storeRegistration', 'App\Http\Controllers\ApiController@storeRegistration');
    Route::get('/checkIfExists/{id}', 'App\Http\Controllers\ApiController@checkIfExists');
    Route::get('/getAllStores', 'App\Http\Controllers\ApiController@getAllStores');
    Route::post('/grant', 'App\Http\Controllers\ApiController@grant');
});

Route::post('/register', 'App\Http\Controllers\ApiController@register');
Route::post('/login', 'App\Http\Controllers\ApiController@login');
