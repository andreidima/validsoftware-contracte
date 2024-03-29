<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ofertare extends Model
{
    protected $table = 'ofertari';
    protected $guarded = [];

    public function path()
    {
        return "/ofertari/{$this->id}";
    }

    public function firma()
    {
        return $this->belongsTo('App\Firma', 'firma_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function servicii()
    {
        return $this->belongsToMany('App\OfertareServiciu', 'ofertari_ofertari_servicii', 'ofertare_id', 'ofertare_serviciu_id');
    }

    public function emailuri_trimise()
    {
        return $this->hasMany('App\MesajTrimis', 'inregistrare_id')->where('categorie', 'Ofertare');
    }
}
