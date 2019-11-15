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



// Route::group(['scheme' => 'https'], function () {

//     Route::get('/testari-cod', function () {
//         return view('testari-cod');
//     });


//     Auth::routes();
//     Route::get('login/google', 'Auth\LoginController@googleRedirectToProvider');
//     Route::get('login/google/callback', 'Auth\LoginController@googleHandleProviderCallback');
//     Route::get('login/facebook', 'Auth\LoginController@FacebookRedirectToProvider');
//     Route::get('login/facebook/callback', 'Auth\LoginController@facebookHandleProviderCallback');


//     Route::group(['middleware' => 'auth'], function () {

//         Route::redirect('/', 'produse');

//         // Route::any('/produse/vanzari', 'ProdusController@vanzari');
//         // Route::any('produse/vanzari/descarca-produs', 'ProdusController@vanzariDescarcaProdus');
//         // Route::any('produse/vanzari/goleste-cos', 'ProdusController@vanzariGolesteCos');
        
//         Route::resource('users', 'UserController');

//         // Comparatie Produse
//         Route::any('produse/comparatie-adauga-produs', 'ProdusController@comparatieAdaugaProdus')->name('comparatieAdaugaProdus');
//         Route::any('produse/comparatie-sterge-produse', 'ProdusController@comparatieStergeProduse')->name('comparatieStergeProduse');
//         Route::get('produse/comparatie-compara-produse', 'ProdusController@comparatieComparaProduse')->name('comparatieComparaProduse');

//         // Export Fisa produs
//         Route::get('produse/{produse}/export/{view_type}', 'ProdusController@fisaProdus')->name('fisaProdus');

//         Route::resource('produse', 'ProdusController')->only([
//             'index', 'show'
//         ]);
//     });
// });

// Auth::routes();

Route::get('/', function () {
    return view('acasa');
});

// Rute pentru rezervare facuta de guest
Route::get('/adauga-rezervare-pasul-1', 'RezervareController@adaugaRezervarePasul1');
// Route::post('/adauga-rezervare-pasul-1', 'RezervareController@postAdaugaRezervare1');
// Route::get('/adauga-rezervare-pasul-2', 'RezervareController@adaugaRezervare2');
// Route::post('/adauga-rezervare-pasul-2', 'RezervareController@postAdaugaRezervare2');
// Route::get('/adauga-rezervare-pasul-3', 'RezervareController@adaugaRezervare3');
// Route::get('/bilet-rezervat', 'RezervareController@pdfexportguest');