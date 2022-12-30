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

Route::middleware('role:service_voluntar,service,admin')->group(function () {
    Route::view('/', 'home');
});

Route::middleware('role:service_voluntar,service,admin', 'restrict_ip_adress')->group(function () {
    Route::resource('service/componente-pc/categorii', 'ServiceComponentaPcCategorieController', ['names' => 'service.componente_pc.categorii', 'parameters' => ['categorii' => 'categorie']]);

    Route::any('service/componente-pc/sterge-imagine/{imagine}', 'ServiceComponentaPcController@stergeImagine');
    Route::any('service/componente-pc/schimba-cantitatea/{componenta_pc}', 'ServiceComponentaPcController@schimbaCantitatea');
    Route::resource('service/componente-pc', 'ServiceComponentaPcController', ['names' => 'service.componente_pc', 'parameters' => ['componente-pc' => 'componenta_pc']]);
});

// Route::middleware(['auth'])->group(function () {
Route::middleware('role:service,admin')->group(function () {
    // Route::view('/', 'home');
    // Route::redirect('/', 'service/clienti');

    // Afisarea tuturor emailurilor clientilor de service pentru folosirea lor externa. de trimitere mesaje in masă
    Route::get('service/clienti/emailuri', 'ServiceClientController@emailuri')->name('service.clienti.emailuri');
    Route::post('service/clienti/{client}/trimite-email', 'ServiceClientController@trimiteEmail');
    Route::resource('service/clienti', 'ServiceClientController', ['names' => 'service.clienti']);

    Route::resource('service/parteneri', 'ServicePartenerController', ['names' => 'service.parteneri', 'parameters' => ['parteneri' => 'partener']]);

    Route::get('service/fise/axios/fise-vechi', 'ServiceFisaController@axiosFiseVechi');
    Route::get('/service/fise/{fise}/export/word/{view_type}', 'ServiceFisaController@wordExport');
    Route::get('/service/fise/{fise}/export/{view_type}', 'ServiceFisaController@pdfExport');
    Route::patch('service/fise/{fise}/deschide-inchide', 'ServiceFisaController@deschideInchide');
    Route::post('service/fise/{fisa}/{tip_fisa}/trimite-email', 'ServiceFisaController@trimiteEmail');
    Route::resource('service/fise', 'ServiceFisaController', ['names' => 'service.fise']);

    Route::resource('service/servicii/categorii', 'ServiceServiciuCategorieController', ['names' => 'service.servicii.categorii', 'parameters' => ['categorii' => 'categorie']]);
    Route::resource('service/servicii', 'ServiceServiciuController', ['names' => 'service.servicii']);
    Route::resource('service/anydeskuri', 'ServiceAnydeskController', ['names' => 'service.anydeskuri', 'parameters' => ['anydeskuri' => 'anydesk']]);

    Route::any('service/licente/schimba-cantitatea/{licenta}', 'ServiceLicentaController@schimbaCantitatea');
    Route::resource('service/licente', 'ServiceLicentaController', ['names' => 'service.licente', 'parameters' => ['licente' => 'licenta']]);

    Route::post('trimite-sms/{categorie}/{subcategorie}/{inregistrare_id}/{telefon}/{mesaj}', 'SmsTrimiteController@trimite_sms');

    Route::resource('service/fisiere', 'ServiceFisierController', ['names' => 'service.fisiere']);
    // Incarcare/ descarcare/ stergere - fisiere atasate la Fisele de service
    Route::post('/service/fisiere/{fisa}/file-upload', 'ServiceFisierController@store')->name('service.file.upload.post');
    Route::post('/service/fisiere/file-download/{fisier}', 'ServiceFisierController@fileDownload')->name('service.file.download');
    // Route::post('/fisiere/file-delete/{fisier}', 'FisierController@destroy')->name('file.delete');

    // Autocomplete cautare clienti la completare fise service
    Route::get('vuejs/autocomplete', 'VueJSController@autocomplete');
    Route::get('vuejs/autocomplete/search', 'VueJSController@autocompleteSearch');
});

// Route::middleware(['auth', 'admin'])->group(function () {
Route::middleware('role:admin')->group(function () {
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

    Route::get('contracte/{contract}/duplica', 'ContractController@duplicaContract');
    Route::get('ofertari/{ofertare}/duplica', 'OfertareController@duplicaOfertare');

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

    Route::get('emailuri-clienti', 'EmailuriClientiController@index')->name('emailuriClienti');
});

    Route::get('testare-cod/copy-to-clipboard', 'TestareCodController@CopyToClipboard')->name('copy.to.clipboard');
    Route::get('testare-cod/{view_type}', 'TestareCodController@testareCod')->name('testare.cod');

    // Trimitere Cron joburi din Cpanel
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
