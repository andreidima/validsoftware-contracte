<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceFisier extends Model
{
    protected $table = 'service_fisiere';
    protected $guarded = [];

    public function path()
    {
        return "/service/fisiere/{$this->id}";
    }

    public function service_fise()
    {
        return $this->belongsTo('App\ServiceFisa', 'service_fisa_id');
    }
}
