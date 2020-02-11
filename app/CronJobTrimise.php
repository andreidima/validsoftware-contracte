<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronJobTrimise extends Model
{
    protected $table = 'cron_jobs_trimise';
    protected $guarded = [];

    public function path()
    {
        return "/cron-jobs-trimise/{$this->id}";
    }

    public function cronjob()
    {
        return $this->belongsTo('App\CronJob', 'cronjob_id');
    }
}
