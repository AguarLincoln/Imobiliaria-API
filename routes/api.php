<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function(){

    Route::resource('real-state', 'RealStateController');
});


Route::namespace('Api')->group(function(){

    Route::resource('user', 'UserController');
});

Route::namespace('Api')->group(function(){

    Route::resource('category', 'CategoryController');
});

