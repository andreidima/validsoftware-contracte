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

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

Route::middleware(['auth'])->group(function () {
    Route::view('/', 'home');
    // Route::redirect('/', 'service/clienti');

    Route::resource('service/clienti', 'ServiceClientController', ['names' => 'service.clienti']);

    Route::get('/service/fise/{fise}/export/{view_type}', 'ServiceFisaController@wordExport');
    Route::post('service/fise/{fisa}/trimite-email', 'ServiceFisaController@trimiteEmail');
    Route::resource('service/fise', 'ServiceFisaController', ['names' => 'service.fise']);
    Route::resource('service/servicii', 'ServiceServiciuController', ['names' => 'service.servicii']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Route::redirect('/', 'clienti');

    Route::resource('clienti', 'ClientController');

    Route::get('/contracte/{contracte}/export/{view_type}', 'ContractController@wordExport');
    Route::get('/ofertari/{ofertari}/export/{view_type}', 'OfertareController@wordExport');

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
    Route::resource('ofertari', 'OfertareController');
    Route::resource('ofertari-servicii', 'OfertareServiciuController');

    Route::get('generator', 'GeneratorController@index')->name('generator.index');
    Route::get('generator/{client}/{director}/{fisier}', 'GeneratorController@genereaza')->name('generator.genereaza');

    // Route::get('testare-cod/{view_type}', 'TestareCodController@testareCod')->name('testare.cod');
});

    Route::get('testare-cod/{view_type}', 'TestareCodController@testareCod')->name('testare.cod');

    // Trimitere Cron joburi din Cpanel
    Route::any('/cron-jobs/trimitere-automata/{key}', 'CronJobTrimitereController@trimitere')->name('cronjob.trimitere.automata');

    Route::get('teste', function() {
        return 'hi';
    });

    Route::get('teste2', function () {
        
        dd(
            \Mail::mailer('service')->to('asd'),
            \Mail::to('asd')
        );

    });


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