<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceServiciuCategorie extends Model
{
    protected $table = 'service_servicii_categorii';
    protected $guarded = [];

    public function path()
    {
        return "/service/servicii/categorii/{$this->id}";
    }

    public function servicii()
    {
        return $this->hasMany(ServiceServiciu::class, 'categorie_id');
    }
}
