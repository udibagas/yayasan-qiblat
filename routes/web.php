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
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('navigation', 'NavigationController@index');
Route::post('uploadImage', 'PostCategoryController@uploadImage');

Route::resource('user', 'UserController')->except(['create', 'edit', 'show']);
Route::resource('post', 'PostController')->except(['create', 'edit', 'show']);
Route::resource('postCategory', 'PostCategoryController')->except(['create', 'edit', 'show']);
Route::resource('carousel', 'CarouselController')->except(['create', 'edit', 'show']);
Route::resource('donation', 'DonationController')->except(['create', 'edit', 'show']);
Route::resource('program', 'ProgramController')->except(['create', 'edit']);
Route::resource('team', 'TeamController')->except(['create', 'edit', 'show']);
Route::resource('socialMedia', 'SocialMediaController')->except(['create', 'edit', 'show']);

Route::resource('setting', 'SettingController');
Route::post('backup', 'BackupController@store');
Route::get('backup', 'BackupController@index');
Route::delete('backup', 'BackupController@destroy');

// untuk SPA backend
Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');
