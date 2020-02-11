<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CronJob;
use App\CronJobTrimise;
use App\Mail\CronJobTrimitere;

class CronJobTrimitereController extends Controller
{
    public function trimitere(CronJob $cron_job, $key = null)
    {
        $config_key = \Config::get('variabile.cron_job_key');
        // dd($key, $config_key);
        // if ($key === $config_key){
        //     dd(\Carbon\Carbon::now()->isoFormat('D'));
        // }

        $cron_jobs = CronJob::all()
            ->where('ziua', \Carbon\Carbon::now()->isoFormat('D'))
            ->where('stare', 1);

        foreach ($cron_jobs as $cron_job) {
            if(isset($cron_job->client->email)){
                \Mail::to($cron_job->client->email)->send(
                    new CronJobTrimitere($cron_job)
                );

                $cron_job_trimis = CronJobTrimise::make();
                $cron_job_trimis->cronjob_id = $cron_job->id;
                $cron_job_trimis->save();
            }
        }
        
        return back()->with('status', 'Cron Joburile de astăzi au fost trimise!');
    }
}
