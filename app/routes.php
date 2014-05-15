<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/','UserController@index');
Route::get('/facebook','UserController@facebook');
Route::get('/pages','PageController@index');
Route::get('/facebookpages','PageController@facebookpages');
Route::get('/pages/{id}','PageController@show');