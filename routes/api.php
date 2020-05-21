<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Rotas gerais
Route::namespace('Api')->group(function(){
    Route::post('/login','Auth\\LoginJWTController@login')->name('login');
    Route::get('/logout','Auth\\LoginJWTController@logout')->name('logout');
    Route::get('/refresh','Auth\\LoginJWTController@refresh')->name('refresh');
    Route::post('/cadastro', 'UserController@store')->name('cadastro.usuario');
});


// Grupo de rotas por model

Route::group(['middleware' => 'jwt.auth'], function(){

    //Real States
    Route::namespace('Api')->group(function(){

        Route::resource('real-state', 'RealStateController');
    });
    
    //Users
    Route::namespace('Api')->group(function(){
    
        Route::resource('user', 'UserController')->except(['store']);
    });
    
    //Categories
    Route::namespace('Api')->group(function(){
        Route::get('category/{id}/real-state', 'CategoryController@realState');
        Route::resource('category', 'CategoryController');
    });

});



