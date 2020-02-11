<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronJobFile extends Model
{
    protected $table = 'cron_jobs_files';
    protected $guarded = [];

    public function path()
    {
        return "/cron-jobs-files/{$this->id}";
    }

    public function cronjob()
    {
        return $this->belongsTo('App\CronJob', 'cronjob_id');
    }
}
