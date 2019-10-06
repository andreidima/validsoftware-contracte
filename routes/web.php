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

    // Route::get('/', function () {
    //     return view('welcome');
    // });
    
    // Route::get('/home', 'HomeController@index')->name('home');

    Auth::routes();
    Route::get('login/google', 'Auth\LoginController@googleRedirectToProvider');
    Route::get('login/google/callback', 'Auth\LoginController@googleHandleProviderCallback');
    Route::get('login/facebook', 'Auth\LoginController@FacebookRedirectToProvider');
    Route::get('login/facebook/callback', 'Auth\LoginController@facebookHandleProviderCallback');


    Route::group(['middleware' => 'auth'], function () {

        Route::redirect('/', 'produse');

        // Route::any('/produse/vanzari', 'ProdusController@vanzari');
        // Route::any('produse/vanzari/descarca-produs', 'ProdusController@vanzariDescarcaProdus');
        // Route::any('produse/vanzari/goleste-cos', 'ProdusController@vanzariGolesteCos');
        
        Route::resource('users', 'UserController');

        // Comparatie Produse
        Route::any('produse/comparatie-adauga-produs', 'ProdusController@comparatieAdaugaProdus')->name('comparatieAdaugaProdus');
        Route::any('produse/comparatie-sterge-produse', 'ProdusController@comparatieStergeProduse')->name('comparatieStergeProduse');
        Route::get('produse/comparatie-compara-produse', 'ProdusController@comparatieComparaProduse')->name('comparatieComparaProduse');

        // Export Fisa produs
        Route::get('produse/{produse}/export/{view_type}', 'ProdusController@fisaProdus')->name('fisaProdus');

        Route::resource('produse', 'ProdusController')->only([
            'index', 'show'
        ]);
    });
});