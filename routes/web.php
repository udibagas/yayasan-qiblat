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

Auth::routes();

// untuk login via sosmed
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('/', function () {
    return view('layouts.front');
});

// Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('navigation', 'NavigationController@index');
Route::post('uploadImage', 'PostCategoryController@uploadImage');

Route::resource('user', 'UserController')->except(['create', 'edit']);
Route::resource('post', 'PostController')->except(['create', 'edit']);
Route::resource('postCategory', 'PostCategoryController')->except(['create', 'edit']);

// untuk SPA backend
Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');
