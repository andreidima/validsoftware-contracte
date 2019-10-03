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
Route::group(['scheme' => 'https'], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();
    Route::get('login/google', 'Auth\LoginController@googleRedirectToProvider');
    Route::get('login/google/callback', 'Auth\LoginController@googleHandleProviderCallback');
    Route::get('login/facebook', 'Auth\LoginController@FacebookRedirectToProvider');
    Route::get('login/facebook/callback', 'Auth\LoginController@facebookHandleProviderCallback');

    // Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'auth'], function () {

        Route::redirect('/', 'produse');

        // Route::any('/produse/vanzari', 'ProdusController@vanzari');
        // Route::any('produse/vanzari/descarca-produs', 'ProdusController@vanzariDescarcaProdus');
        // Route::any('produse/vanzari/goleste-cos', 'ProdusController@vanzariGolesteCos');
        
        Route::resource('users', 'UserController');
        Route::resource('produse', 'ProdusController');
    });
});