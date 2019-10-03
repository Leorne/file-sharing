<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\FileController;

Route::get('/', function () {
    return redirect('/main');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/main', 'FileController@main')->name('main');
Route::post('/main/upload', 'FileController@store');
Route::get('/main/list','FileController@index')->name('list');
Route::get('/main/list/{file}','FileController@show');
Route::delete('/main/list/{file}', 'FileController@destroy');

Route::post('/main/list/{file}/reply', 'ReplyController@store');
Route::get('/main/list/{file}/reply', 'ReplyController@index');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy');


Route::post('/main/list/{file}/favorites', 'FavoritesController@store');
Route::delete('/main/list/{file}/favorites', 'FavoritesController@destroy');


Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

Route::post('/profiles/{user}/avatar', 'UserAvatarController@store')->name('avatar');
Route::post('/profiles/{user}/status', 'UserStatusController@store')->name('status');


