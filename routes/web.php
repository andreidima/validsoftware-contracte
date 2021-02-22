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

    Route::post('service/clienti/{client}/trimite-email', 'ServiceClientController@trimiteEmail');    
    Route::resource('service/clienti', 'ServiceClientController', ['names' => 'service.clienti']);

    Route::resource('service/parteneri', 'ServicePartenerController', ['names' => 'service.parteneri', 'parameters' => ['parteneri' => 'partener']]);

    Route::get('/service/fise/{fise}/export/word/{view_type}', 'ServiceFisaController@wordExport');
    Route::get('/service/fise/{fise}/export/{view_type}', 'ServiceFisaController@pdfExport');
    Route::post('service/fise/{fisa}/{tip_fisa}/trimite-email', 'ServiceFisaController@trimiteEmail');
    Route::resource('service/fise', 'ServiceFisaController', ['names' => 'service.fise']);
    Route::resource('service/servicii', 'ServiceServiciuController', ['names' => 'service.servicii']);
    Route::resource('service/anydeskuri', 'ServiceAnydeskController', ['names' => 'service.anydeskuri', 'parameters' => ['anydeskuri' => 'anydesk']]);

    Route::post('trimite-sms/{categorie}/{subcategorie}/{inregistrare_id}/{telefon}/{mesaj}', 'SmsTrimiteController@trimite_sms');

    Route::resource('service/fisiere', 'ServiceFisierController', ['names' => 'service.fisiere']);
    // Incarcare/ descarcare/ stergere - fisiere atasate la Fisele de service
    Route::post('/service/fisiere/{fisa}/file-upload', 'ServiceFisierController@store')->name('service.file.upload.post');
    Route::post('/service/fisiere/file-download/{fisier}', 'ServiceFisierController@fileDownload')->name('service.file.download');
    // Route::post('/fisiere/file-delete/{fisier}', 'FisierController@destroy')->name('file.delete');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Route::redirect('/', 'clienti');

    Route::resource('clienti', 'ClientController');

    Route::get('/contracte/{contracte}/export/{view_type}', 'ContractController@wordExport');
    Route::get('/ofertari/{ofertari}/export/{view_type}', 'OfertareController@wordExport');
    Route::get('/ofertari/{ofertari}/export/pdf/{view_type}', 'OfertareController@pdfExport');
    Route::post('ofertari/{ofertari}/trimite-email', 'OfertareController@trimiteEmail');

    // Incarcare/ descarcare/ stergere - fisiere atasate la contracte
    Route::post('/fisiere/{contracte}/file-upload', 'FisierController@store')->name('file.upload.post');
    Route::post('/fisiere/file-download/{fisier}', 'FisierController@fileDownload')->name('file.download');
    // Route::post('/fisiere/file-delete/{fisier}', 'FisierController@destroy')->name('file.delete');

    // Incarcare/ descarcare/ stergere - fisiere atasate la cron jobs
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
        echo \Carbon\Carbon::now()->hour;
        echo (\Carbon\Carbon::now()->hour > 5) && (\Carbon\Carbon::now()->hour < 9) ? 'da' : 'nu' ;
        echo (
            ((\Carbon\Carbon::now()->hour > 5) && (\Carbon\Carbon::now()->hour < 9)) ? 
                'Buna dimineata ' 
                : 
                (
                    ((\Carbon\Carbon::now()->hour >= 9) && (\Carbon\Carbon::now()->hour < 18)) ?
                        'Buna ziua '
                        :
                        'Buna seara '
                )
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