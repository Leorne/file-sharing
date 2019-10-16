<?php

use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('files.main');
})->name('main');

Auth::routes(['verify' => true]);

Route::post('/upload', 'FileController@store')->middleware('should-be-confirmed');
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


Route::get('/profiles/{user}', 'ProfilesController@show')->middleware('should-be-confirmed')->name('profile');

Route::post('/profiles/{user}/avatar', 'UserAvatarController@store')->name('avatar');
Route::post('/profiles/{user}/status', 'UserStatusController@store')->name('status');



