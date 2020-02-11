<?php

namespace App\Http\Controllers;

use App\CronJob;
use App\Client;
use App\Variabila;
use DB;
use Illuminate\Http\Request;

class CronJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $cron_jobs = CronJob::with('fisiere')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            })
            ->latest()
            ->withCount('fisiere')
            ->Paginate(25);

        return view('cron-jobs.index', compact('cron_jobs', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clienti = Client::select('id', 'nume')
            ->orderBy('nume')
            ->get();

        return view('cron-jobs.create', compact('clienti'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $cron_job = CronJob::create($this->validateRequest($request));

        $cron_job->stare = 1;
        $cron_job->update();

        return redirect($cron_job->path())->with(
            'status',
            'Cron Jobul "' . $cron_job->nume . '", pentru clientul "' . ($cron_job->client->nume ?? '') . '", a fost adăugat cu succes!'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CronJob  $cronJob
     * @return \Illuminate\Http\Response
     */
    public function show(CronJob $cron_job)
    {

        return view('cron-jobs.show', compact('cron_job', 'data_curenta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CronJob  $cronJob
     * @return \Illuminate\Http\Response
     */
    public function edit(CronJob $cron_job)
    {
        $clienti = Client::select('id', 'nume')
            ->orderBy('nume')
            ->get();

        return view('cron-jobs.edit', compact('cron_job', 'clienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CronJob  $cronJob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CronJob $cron_job)
    {
        $this->validateRequest($request, $cron_job);
        $cron_job->update($request->all());

        return redirect($cron_job->path())->with(
            'status',
            'Cron Jobul "' . $cron_job->nume . '", pentru clientul "' . ($cron_job->client->nume ?? '') . '", a fost modificat cu succes!'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CronJob  $cronJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(CronJob $cron_job)
    {
        if ($cron_job->fisiere()->exists()) {
            return back()->with('error', 'Cron Jobul are fișiere atașate. Pentru a putea șterge Cron Jobul "' . $cron_job->nume . '", ștergeți mai întâi fișierele atașate acestuia.');
        } else {
            $cron_job->delete();
            return redirect('/contracte')->with(
                'status',
                'Cron Jobul "' . $cron_job->nume . '", pentru clientul "' . ($cron_job->client->nume ?? '') . '", a fost șters cu succes!'
            );
        } 
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nume' => ['required', 'max:150'],
            'client_id' => ['required'],
            'ziua' => ['required', 'min:1', 'max:28'],
            'ora' => [''],
            'subiect' => [''],
            'email' => [''],
        ]);
    }

    /**
     * Activare/ dezactivare Cron Jobs
     *
     * @return array
     */
    protected function activareDezactivare(Request $request, CronJob $cron_job)
    {
        if($cron_job->stare === 1){
            $cron_job->stare = 0;
        } else {
            $cron_job->stare = 1;
        }
        $cron_job->update();

        return back();
    }
}
