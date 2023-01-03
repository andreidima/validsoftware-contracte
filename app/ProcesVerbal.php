<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcesVerbal extends Model
{
    protected $table = 'procese_verbale';
    protected $guarded = [];

    public function path()
    {
        return "/procese-verbale/{$this->id}";
    }

    public function firma()
    {
        return $this->belongsTo('App\Firma', 'firma_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function emailuri_trimise()
    {
        return $this->hasMany('App\MesajTrimis', 'inregistrare_id')->where('categorie', 'Proces verbal');
    }
}
