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

Route::get('/user/login', 'UserController@index');
Route::post('/user/login', 'UserController@login');
Route::get('/user/create', 'UserController@create');
Route::post('/user/create', 'UserController@store');
Route::get('/user/logout', 'UserController@logout');
Route::get('/admin/login', 'AdminController@index');
Route::post('/admin/login', 'AdminController@login');

Route::group(['middleware' => ['web', 'checkLogin']], function () {
    Route::get('/calendar', 'CalendarController@index');
    Route::get('/calendar/{year}/{month}', 'CalendarController@list');
    Route::get('/calendar/{year}/{month}/{day}', 'CalendarController@entry');
    Route::post('/calendar/{year}/{month}/{day}', 'CalendarController@store');
});

Route::group(['middleware' => ['web', 'checkAdmin']], function () {
    Route::get('/admin/search', 'AdminController@search');
});






//使っていない勤怠管理システム
Route::get('/start', 'HistoryController@start');
Route::get('/finish', 'HistoryController@finish');
Route::get('/mypage', 'HistoryController@mypage');