<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceAnydesk extends Model
{
    protected $table = 'service_anydesk';
    protected $guarded = [];

    public function path()
    {
        return "/service/anydeskuri/{$this->id}";
    }

    public function client()
    {
        return $this->belongsTo('App\ServiceClient', 'client_id');
    }
}
