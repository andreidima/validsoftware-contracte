<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceComponentaPc extends Model
{
    protected $table = 'service_componente_pc';
    protected $guarded = [];

    public function path()
    {
        return "/service/componente-pc/{$this->id}";
    }

    public function categorie()
    {
        return $this->belongsTo('App\ServiceComponentaPcCategorie');
    }
}
