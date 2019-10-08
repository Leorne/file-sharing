<?php

use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('files.main');
})->name('main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/upload', 'FileController@store');
Route::get('/list', 'FileController@index')->name('list');
Route::get('/list/get/files', 'FileController@getList');
Route::get('/list/{file}', 'FileController@show')->name('file');
Route::delete('/list/{file}', 'FileController@destroy');

Route::post('/list/{file}/reply', 'ReplyController@store');
Route::get('/list/{file}/reply', 'ReplyController@index');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy');


Route::post('/list/{file}/favorites', 'FavoritesController@store');
Route::delete('/list/{file}/favorites', 'FavoritesController@destroy');


Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

Route::post('/profiles/{user}/avatar', 'UserAvatarController@store')->name('avatar');
Route::post('/profiles/{user}/status', 'UserStatusController@store')->name('status');


//Route::post('/main/upload', 'FileController@store');
//Route::get('/main/list', 'FileController@index')->name('list');
//Route::get('/main/list/{file}', 'FileController@show');
//Route::delete('/main/list/{file}', 'FileController@destroy');
//
//Route::post('/main/list/{file}/reply', 'ReplyController@store');
//Route::get('/main/list/{file}/reply', 'ReplyController@index');
//Route::patch('/replies/{reply}', 'ReplyController@update');
//Route::delete('/replies/{reply}', 'ReplyController@destroy');
//
//
//Route::post('/main/list/{file}/favorites', 'FavoritesController@store');
//Route::delete('/main/list/{file}/favorites', 'FavoritesController@destroy');
//
//
//Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
//
//Route::post('/profiles/{user}/avatar', 'UserAvatarController@store')->name('avatar');
//Route::post('/profiles/{user}/status', 'UserStatusController@store')->name('status');


