<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronJob extends Model
{
    protected $table = 'cron_jobs';
    protected $guarded = [];

    public function path()
    {
        return "/cron-jobs/{$this->id}";
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function contract()
    {
        return $this->belongsTo('App\Contract', 'contract_id');
    }

    public function fisiere()
    {
        return $this->hasMany('App\CronJobFile', 'cronjob_id');
    }
}
