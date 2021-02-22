<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceClient extends Model
{
    protected $table = 'service_clienti';
    protected $guarded = [];

    public function path()
    {
        return "/service/clienti/{$this->id}";
    }

    public function anydeskuri()
    {
        return $this->hasMany('App\ServiceAnydesk', 'client_id');
    }

    public function servicii_review()
    {
        return $this->belongsToMany('App\ServiceServiciu', 'service_clienti_servicii_review', 'service_client_id', 'service_serviciu_id');
    }
}
