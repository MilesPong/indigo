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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth.basic');

Auth::routes();

Route::group(['namespace' => 'Backend', 'middleware' => 'auth', 'prefix' => 'dashboard', 'as' => 'admin.'], function () {
    Route::get('/', 'DashboardController@index')->name('home');

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users', 'UserController');
    Route::resource('categories', 'CategoryController');
    Route::resource('tags', 'TagController');
    Route::post('posts/{id}/restore', 'PostController@restore')->name('posts.restore');
    Route::delete('posts/{id}/force-delete', 'PostController@forceDelete')->name('posts.force-delete');
    Route::resource('posts', 'PostController');

    Route::resource('settings', 'SettingController', ['except' => ['show']]);

    // Helpers
    Route::group(['prefix' => 'helpers', 'namespace' => 'Helpers', 'as' => 'helpers.'], function () {
        Route::post('slug', 'SlugController@translate')->name('slug.translate');
        Route::post('image', 'UploadController@uploadImage')->name('upload.image');
    });

    // Page
    Route::post('pages/{id}/restore', 'PageController@restore')->name('pages.restore');
    Route::delete('pages/{id}/force-delete', 'PageController@forceDelete')->name('pages.force-delete');
    Route::resource('pages', 'PageController');
});

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'PostController@index')->name('home');

    // Markdown request
    Route::get('articles/{slug}.md', 'PostController@markdown')->name('articles.markdown');
    Route::resource('articles', 'PostController', ['only' => ['show'], 'middleware' => 'visitor']);
    Route::resource('categories', 'CategoryController', ['only' => ['show']]);
    Route::resource('tags', 'TagController', ['only' => ['show']]);

    // Page
    Route::get('{slug}', 'PageController@show')->name('pages.show');
});
