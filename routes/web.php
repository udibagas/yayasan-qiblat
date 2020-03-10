<?php

use App\Setting;
use App\SocialMedia;
use App\Carousel;
use App\Post;
// use Illuminate\Support\Facades\Session;
use App\Achievement;
use App\PostCategory;

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
    return redirect(app()->getLocale());
});

Route::group([ 'prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}'], 'middleware' => 'setlocale' ], function () {
    Auth::routes();
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('contact', 'HomeController@contact')->name('contact');
    Route::get('/post', 'PostController@index')->name('post');
    Route::get('/program', 'ProgramController@index')->name('program');
    Route::get('/program/{program}', 'ProgramController@show')->name('show-program');
    Route::get('/donation/create', 'ProgramController@create')->name('create-donation');
    Route::get('/category/{slug}', 'PostCategoryController@showBySlug')->name('category');
    Route::get('/{slug}', 'PostController@showBySlug')->name('show-post');
});

// Route::get('locale/{locale}', function ($locale) {
//     Session::put('locale', $locale);
//     return redirect()->back();
// });

// untuk login via sosmed
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
// Route::get('/', 'HomeController@index');
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('navigation', 'NavigationController@index');
Route::get('acknowledgement', 'PostController@acknowledgement');
Route::post('uploadImage', 'PostCategoryController@uploadImage');

Route::resource('user', 'UserController')->except(['create', 'edit', 'show']);
Route::resource('post', 'PostController')->except(['create', 'edit']);
Route::get('postCategory/getList', 'PostCategoryController@getList');
Route::resource('postCategory', 'PostCategoryController')->except(['create', 'edit', 'show']);
Route::resource('carousel', 'CarouselController')->except(['create', 'edit', 'show']);
Route::get('postImage', 'PostImageController@index');
Route::post('postImage', 'PostImageController@store');
Route::put('postImage/{postImage}', 'PostImageController@update');
Route::delete('postImage', 'PostImageController@destroy');
Route::delete('carouselButton/{carouselButton}', 'CarouselButtonController@destroy');
Route::post('donation/pay', 'DonationController@pay');
Route::post('donation/callback', 'DonationController@callback');
Route::resource('donation', 'DonationController')->except(['edit']);
Route::get('program/getList', 'ProgramController@getList');
Route::resource('program', 'ProgramController')->except(['create', 'edit']);
Route::resource('achievement', 'AchievementController')->except(['create', 'edit']);
Route::resource('programGallery', 'ProgramGalleryController')->except(['create', 'edit']);
Route::resource('programPackage', 'ProgramPackageController')->except(['create', 'edit']);
Route::resource('team', 'TeamController')->except(['create', 'edit', 'show']);
Route::resource('socialMedia', 'SocialMediaController')->except(['create', 'edit', 'show']);
Route::resource('setting', 'SettingController');
Route::delete('currencyRate/deleteFlag', 'CurrencyRateController@deleteFlag');
Route::resource('currencyRate', 'CurrencyRateController')->only(['index', 'store', 'update', 'destroy']);

Route::post('backup', 'BackupController@store');
Route::get('backup', 'BackupController@index');
Route::delete('backup', 'BackupController@destroy');

Route::get('brosur', function() {
    return response()->download(public_path('/Yayasan Qiblat 1440 H - '.strtoupper(app()->getLocale()).'.pdf'));
});

Route::get('privacy', function() {
    return 'privacy policy';
});

Route::get('tos', function() {
    return 'TOS';
});

Route::get('/mailcreated', function () {
    $donation = App\Donation::find(1);
    return new App\Mail\DonationCreated($donation);
});

Route::get('/mailcompleted', function () {
    $donation = App\Donation::find(1);
    return new App\Mail\DonationCompleted($donation);
});

Route::get('/migrate', function()  {
    // Artisan::call('clear-compiled');
    // Artisan::call('route:clear');
    // Artisan::call('cache:clear');
    // Artisan::call('config:clear');
    // Artisan::call('view:clear');
    Artisan::call('migrate');
    echo 'migrated';
});

Route::get('aaa', function() {
    return \App\ProgramPackage::all();
});

Route::get('/down-bismillah12345', function()  {
    Artisan::call('down');
    echo 'App is Down!';
});

// untuk SPA backend
Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');

// Route::get('/category/{slug}', 'PostCategoryController@showBySlug');
// Route::get('/{slug}', 'PostController@showBySlug');

View::composer('partial.footer', function($view) {
    $setting = Setting::all();
    $settings = [];

    foreach ($setting as $s) {
        $settings[$s->name] = $s->value;
    }

    $view->with('settings', $settings)
        ->with('socialMedia', SocialMedia::all());
});

View::composer('home.jumbotron', function($view) {
    $view->with('slider', Carousel::active()->first());
});

View::composer('home.post', function($view) {
    $view->with('posts', Post::limit(10)->active()->post()->latest()->get());
});

View::composer('partial.nav', function($view) {
    $view->with('pages', Post::active()->page()->get());
    $view->with('categories', PostCategory::where('parent_id', null)->get());
});

View::composer('partial.nav-ar', function($view) {
    $view->with('pages', Post::active()->page()->get());
    $view->with('categories', PostCategory::where('parent_id', null)->get());

});

View::composer('home.achievement', function($view) {
    $view->with('achievements', Achievement::all());
});
