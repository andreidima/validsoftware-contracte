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

Route::group(['scheme' => 'https'], function () {
    Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

    Route::get('/rezervare-client', function () {
        return view('acasa');
    });

    //MobilPay
    Route::get('/trimitere-catre-plata', 'PlataOnlineController@trimitereCatrePlata')->name('trimitere-catre-plata');
    Route::post('/confirmare-plata', 'PlataOnlineController@confirmarePlata')->name('confirmare-plata');

    // Rute pentru rezervare facuta de guest
    Route::get('/adauga-rezervare-pasul-1', 'RezervareController@adaugaRezervarePasul1');
    Route::post('/adauga-rezervare-pasul-1', 'RezervareController@postAdaugaRezervarePasul1');
    Route::get('/adauga-rezervare-pasul-2', 'RezervareController@adaugaRezervarePasul2');
    Route::post('/adauga-rezervare-pasul-2', 'RezervareController@postAdaugaRezervarePasul2');
    Route::get('/adauga-rezervare-pasul-3', 'RezervareController@adaugaRezervarePasul3');
    Route::get('/bilet-rezervat/{view_type}', 'RezervareController@pdfExportGuest');

    // Extras date cu Axios
    Route::get('/orase_rezervari', 'RezervareController@orase_rezervari');

    // Testare Extras date cu Axios
    Route::get('/testare-axios', 'RezervareController@testare_axios');


    // Rute pentru colete facuta de guest
    Route::get('/adauga-colet-pasul-1', 'ColetController@adaugaColetPasul1');
    Route::post('/adauga-colet-pasul-1', 'ColetController@postAdaugaColetPasul1');
    Route::get('/adauga-colet-pasul-2', 'ColetController@adaugaColetPasul2');
    Route::post('/adauga-colet-pasul-2', 'ColetController@postAdaugaColetPasul2');
    Route::get('/adauga-colet-pasul-3', 'ColetController@adaugaColetPasul3');
    Route::get('/transport-colete/{view_type}', 'ColetController@pdfExportGuest');

    // Extras date cu Axios
    Route::get('/orase_colete', 'ColetController@orase_colete');


    Route::group(['middleware' => 'auth'], function () {
        Route::redirect('/', 'rezervari');

        Route::resource('rezervari', 'RezervareController')->only([
                'index', 'show'
            ]);

        Route::resource('colete', 'ColetController')->only([
                'index', 'show'
            ]);
    });
});