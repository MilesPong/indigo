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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Auth::routes();

Route::group(['namespace' => 'Backend', 'middleware' => 'auth', 'prefix' => 'dashboard'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
});

Route::group(['namespace' => 'Frontend'], function () {

});
