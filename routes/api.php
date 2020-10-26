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
    Route::get('/getTotal', 'App\Http\Controllers\ApiController@getTotal');
    Route::get('/getTodos', 'App\Http\Controllers\ApiController@getTodos');
    Route::post('/grant', 'App\Http\Controllers\ApiController@grant');
    Route::post('/addTodo', 'App\Http\Controllers\ApiController@addTodo');
    Route::delete('/deleteTodo/{id}', 'App\Http\Controllers\ApiController@deleteTodo');
    Route::put('/updateTodo/{id}', 'App\Http\Controllers\ApiController@updateTodo');
    Route::put('/mark/{id}', 'App\Http\Controllers\ApiController@mark');
    Route::get('/getActiveStores', 'App\Http\Controllers\ApiController@getActiveStores');
    Route::delete('/discard/{id}', 'App\Http\Controllers\ApiController@discard');
    Route::post('/addItem', 'App\Http\Controllers\ApiController@addItem');
});

Route::post('/register', 'App\Http\Controllers\ApiController@register');
Route::post('/login', 'App\Http\Controllers\ApiController@login');
