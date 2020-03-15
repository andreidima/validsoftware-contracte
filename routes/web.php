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

        // Incarcare/ descarcare/ stergere - fisiere atasate la contracte
        Route::post('/fisiere/{contracte}/file-upload', 'FisierController@store')->name('file.upload.post');
        Route::post('/fisiere/file-download/{fisier}', 'FisierController@fileDownload')->name('file.download');
        // Route::post('/fisiere/file-delete/{fisier}', 'FisierController@destroy')->name('file.delete');

        // Incarcare/ descarcare/ stergere - fisiere atasate la contracte
        Route::post('/cron-jobs-files/{cron_job}/file-upload', 'CronJobFileController@store')->name('cronjob.file.upload.post');
        Route::post('/cron-jobs-files/file-download/{file}', 'CronJobFileController@fileDownload')->name('cronjob.file.download');

        // Activare/ dezactivare Cron Jobs
        Route::patch('/cron-jobs/{cron_job}/activare-dezactivare', 'CronJobController@activareDezactivare')->name('cronjob.activare.dezactivare');

        Route::resource('contracte', 'ContractController');
        Route::resource('fisiere', 'FisierController');
        Route::resource('cron-jobs', 'CronJobController');
        Route::resource('cron-jobs-files', 'CronJobFileController');
        Route::resource('cron-jobs-trimise', 'CronJobTrimiseController');
        // Route::resource('rapoarte_activitate_trimise', 'RaportActivitateTrimisController');
        Route::resource('variabile', 'VariabilaController');

        // Route::get('testare-cod/{view_type}', 'TestareCodController@testareCod')->name('testare.cod');
    });

        Route::get('testare-cod/{view_type}', 'TestareCodController@testareCod')->name('testare.cod');

        Route::any('/cron-jobs/trimitere-automata/{key}', 'CronJobTrimitereController@trimitere')->name('cronjob.trimitere.automata');

    Route::get('backup', function() {
        // Artisan::call('backup:run'
        //     , ['--only-db' => true]
        // );
        // Artisan::call('db:seed');

        // Artisan::call('inspire');
        // dd("Backup facut local");
        Artisan::call('inspire');
        dd(Artisan::output());
        });
// });