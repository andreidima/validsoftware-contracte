<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceFisa extends Model
{
    protected $table = 'service_fise';
    protected $guarded = [];

    public function path()
    {
        return "/service/fise/{$this->id}";
    }

    public function client()
    {
        return $this->belongsTo('App\ServiceClient', 'client_id');
    }

    public function servicii()
    {
        return $this->belongsToMany('App\ServiceServiciu', 'service_fise_servicii', 'service_fisa_id', 'service_serviciu_id');
    }
}
