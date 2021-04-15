<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceServiciu extends Model
{
    protected $table = 'service_servicii';
    protected $guarded = [];

    public function path()
    {
        return "/service/servicii/{$this->id}";
    }

    public function categorie()
    {
        return $this->belongsTo('App\ServiceServiciuCategorie', 'categorie_id');
    }
}
