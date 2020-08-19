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
}
