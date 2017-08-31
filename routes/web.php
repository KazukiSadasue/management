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

Route::get('/user/logout', 'Admin\LoginController@logout');
Route::get('/admin/login', 'Admin\LoginController@index');
Route::post('/admin/login', 'Admin\LoginController@login');

Route::group(['prefix' => 'calendar', 'middleware' => ['web', 'checkLogin']], function () {
    Route::get('/', 'CalendarController@index');
    Route::get('/{year}/{month}', 'CalendarController@list');
    Route::get('/{year}/{month}/{day}', 'CalendarController@entry');
    Route::post('/{year}/{month}/{day}', 'CalendarController@save');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['web', 'checkAdmin']], function () {
    Route::get('/calendar', 'WorkScheduleController@calendar');
    Route::get('/calendar/{id}/{year}/{month}', 'WorkScheduleController@calendar');
    Route::get('/calendar/{id}/{year}/{month}/{day}', 'WorkScheduleController@workSchedule');
    Route::post('/calendar/{id}/{year}/{month}/{day}', 'WorkScheduleController@save');
    Route::get('/calendar/calendarAjax', 'WorkScheduleController@calendarAjax');

    Route::get('/search', 'WorkScheduleController@search');
    Route::get('/search/detail', 'WorkScheduleController@detail');
});





//使っていない勤怠管理システム
Route::get('/start', 'HistoryController@start');
Route::get('/finish', 'HistoryController@finish');
Route::get('/mypage', 'HistoryController@mypage');