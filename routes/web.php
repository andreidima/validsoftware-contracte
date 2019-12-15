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


    // Rute pentru rezervare aeroport facuta de guest
    Route::get('/adauga-rezervare-aeroport-pasul-1', 'RezervareAeroportController@adaugaRezervareAeroportPasul1');
    Route::post('/adauga-rezervare-aeroport-pasul-1', 'RezervareAeroportController@postAdaugaRezervareAeroportPasul1');
    Route::get('/adauga-rezervare-aeroport-pasul-2', 'RezervareAeroportController@adaugaRezervareAeroportPasul2');
    Route::post('/adauga-rezervare-aeroport-pasul-2', 'RezervareAeroportController@postAdaugaRezervareAeroportPasul2');
    Route::get('/adauga-rezervare-aeroport-pasul-3', 'RezervareAeroportController@adaugaRezervareAeroportPasul3');
    Route::get('/rezervare-aeroport/{view_type}', 'RezervareAeroportController@pdfExportGuest');


    Route::group(['middleware' => 'auth'], function () {
        Route::redirect('/', 'clienti');

        Route::resource('clienti', 'ClientController');

        Route::get('/contracte/{contracte}/export/{view_type}', 'ContractController@wordExport');
        Route::resource('contracte', 'ContractController');

        Route::resource('colete', 'ColetController')->only([
                'index', 'show'
            ]);

        Route::resource('rezervari-aeroport', 'RezervareAeroportController')->only([
            'index', 'show'
        ]);
    });
// });