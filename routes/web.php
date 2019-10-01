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

Auth::routes();
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');

Route::redirect('/', 'produse');

Route::any('/produse/vanzari', 'ProdusController@vanzari');
Route::any('produse/vanzari/descarca-produs', 'ProdusController@vanzariDescarcaProdus');
Route::any('produse/vanzari/goleste-cos', 'ProdusController@vanzariGolesteCos');

Route::resource('produse', 'ProdusController');
