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

    public function imagini()
    {
        return $this->hasmany('App\ServiceComponentaPcImagine', 'referinta_id')->where('referinta_categorie', 'componenta_pc');
    }
}
