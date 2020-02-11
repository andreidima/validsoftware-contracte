<?php

namespace App\Http\Controllers;

use App\CronJobTrimise;
use Illuminate\Http\Request;

class CronJobTrimiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $cron_jobs_trimise = CronJobTrimise::with('cronjob')
            ->whereHas('cronjob', function ($query) use ($search_nume) {
                $query->where('nume', 'like', '%' . str_replace(' ', '%', $search_nume) . '%');
            })
            ->latest()
            ->Paginate(25);

        return view('cron-jobs-trimise.index', compact('cron_jobs_trimise', 'search_nume'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CronJobTrimise  $cronJobTrimise
     * @return \Illuminate\Http\Response
     */
    public function show(CronJobTrimise $cronJobTrimise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CronJobTrimise  $cronJobTrimise
     * @return \Illuminate\Http\Response
     */
    public function edit(CronJobTrimise $cronJobTrimise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CronJobTrimise  $cronJobTrimise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CronJobTrimise $cronJobTrimise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CronJobTrimise  $cronJobTrimise
     * @return \Illuminate\Http\Response
     */
    public function destroy(CronJobTrimise $cronJobTrimise)
    {
        //
    }
}
