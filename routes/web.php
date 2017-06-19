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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Auth::routes();

Route::group(['namespace' => 'Backend', 'middleware' => 'auth', 'prefix' => 'dashboard', 'as' => 'admin.'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users', 'UserController');
    Route::resource('categories', 'CategoryController');
    Route::resource('tags', 'TagController');
    Route::post('posts/{id}/restore', 'PostController@restore')->name('posts.restore');
    Route::post('posts/{id}/force-delete', 'PostController@forceDelete')->name('posts.force-delete');
    Route::resource('posts', 'PostController');
});

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'PostController@index')->name('home');
    Route::resource('articles', 'PostController', ['only' => ['show'], 'middleware' => 'visitor']);
});
