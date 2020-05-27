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

        if ($key === $config_key){
            $cron_jobs = CronJob::all()
                ->where('ziua', \Carbon\Carbon::now()->isoFormat('D'))
                ->where('stare', 1);

            foreach ($cron_jobs as $cron_job) {
                if(isset($cron_job->client->email)) {
                    
                    $cron_job->client->email = str_replace(' ', '', $cron_job->client->email);
                    $to_email = explode(',', $cron_job->client->email);
                    // dd($cron_job->client->email, $to_email);

                    \Mail::
                        to('adima@validsoftware.ro')
                        // to($to_email)
                        // ->bcc(['contact@validsoftware.ro', 'adima@validsoftware.ro'])                        
                        ->send(new CronJobTrimitere($cron_job)
                    );

                    // \Mail::to('andrei.dima@usm.ro')->send(
                    //     new CronJobTrimitere($cron_job)
                    // );

                    $cron_job_trimis = CronJobTrimise::make();
                    $cron_job_trimis->cronjob_id = $cron_job->id;
                    $cron_job_trimis->save();
                }
            }
            dd($cron_jobs);
            return back()->with('status', 'Cron Joburile de astăzi au fost trimise!' . $cron_jobs);
        } else {
            return back()->with('error', 'Cron Joburile de astăzi nu fost trimise! Cheia ' . $key . ' nu este validă');
        }
        
    }
}
