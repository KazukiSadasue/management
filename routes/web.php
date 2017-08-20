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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'UserController@index');
Route::get('/create', 'UserController@create');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::post('/create', 'UserController@store');

Route::group(['middleware' => ['web', 'check']], function () {
    Route::get('/start', 'HistoryController@start');
    Route::get('/finish', 'HistoryController@finish');
    Route::get('/mypage', 'HistoryController@mypage');
});

Route::get('/calendar', 'UserController@calendarSelect');
Route::get('/calendar/{year}/{month}', 'UserController@calendarList');