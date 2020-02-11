<?php

namespace App\Http\Controllers;

use App\CronJob;
use App\CronJobFile;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class CronJobFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CronJob $cron_job)
    {
        $request->validate([
            'fisier' => 'required|mimes:pdf,xlx,csv,doc,docx,jpg,jpeg|max:2048',
        ]);

        $fisier = request()->file('fisier');
        $fileName = pathinfo($fisier->getClientOriginalName(), PATHINFO_FILENAME) . ' ' .
            \Carbon\Carbon::now()->isoFormat('HHMMSSDDMMYY') . '.' .
            $fisier->extension();
        // $filePath = "contracte/" . date("Y") . '/' . date("m");
        $filePath = "cronjobs/" . $cron_job->id . '/';
        // dd($fisier, $fileName, $filePath);
        $fisier->storeAs($filePath, $fileName);
        // $request->fisier->move(public_path($filePath), $fileName);

        // Storage::disk('local')->put($filePath, $fileName);

        $fisier_database = new CronJobFile;
        $fisier_database->cronjob_id = $cron_job->id;
        $fisier_database->path = $filePath;
        $fisier_database->nume = $fileName;
        $fisier_database->save();

        return back()->with('success', 'Fișierul "' . $fileName . '" a fost încărcat cu succes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CronJobFile  $cronJobFile
     * @return \Illuminate\Http\Response
     */
    public function show(CronJobFile $cronJobFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CronJobFile  $cronJobFile
     * @return \Illuminate\Http\Response
     */
    public function edit(CronJobFile $cronJobFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CronJobFile  $cronJobFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CronJobFile $cronJobFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CronJobFile  $cronJobFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(CronJobFile $cron_jobs_file)
    {
        // dd($cron_jobs_file);
        $cron_jobs_file->delete();

        $cale_si_fisier = $cron_jobs_file->path . $cron_jobs_file->nume;
        Storage::delete($cale_si_fisier);

        // return redirect('/contracte')->with('status', 'Fișierul "' . $fisiere->nume . '" a fost șters cu succes!');
        return back()->with('status', 'Fișierul "' . $cron_jobs_file->nume . '" a fost șters cu succes!');
    }

    /**
     * Download files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDownload(Request $request, CronJobFile $file)
    {
        // dd($file);
        $cale_si_fisier = $file->path . $file->nume;

        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        return Storage::download($cale_si_fisier);
    }
}
