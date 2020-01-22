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

    Route::group(['middleware' => 'auth'], function () {
        Route::redirect('/', 'clienti');

        Route::resource('clienti', 'ClientController');

        Route::get('/contracte/{contracte}/export/{view_type}', 'ContractController@wordExport');
        
        Route::post('/fisiere/{contracte}/file-upload', 'FisierController@store')->name('file.upload.post');
        Route::post('/fisiere/file-download/{fisier}', 'FisierController@fileDownload')->name('file.download');
        Route::post('/fisiere/file-delete/{fisier}', 'FisierController@destroy')->name('file.delete');

        Route::resource('contracte', 'ContractController');
        Route::resource('fisiere', 'FisierController');
        Route::resource('rapoarte_activitate_trimise', 'RaportActivitateTrimisController');

        Route::any('/trimitere-raport-activitate', 'TrimiteRaportActivitateController@trimiteRaportCronJob')->name('trimitere.raport.activitate');
    });
// });