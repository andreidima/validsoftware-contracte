<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentUniversal extends Model
{
    protected $table = 'documente_universale';
    protected $guarded = [];

    public function path()
    {
        return "/documente-universale/{$this->id}";
    }

    public function firma()
    {
        return $this->belongsTo('App\Firma', 'firma_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function fisiere()
    {
        return $this->hasMany('App\DocumentDiversFisier', 'document_divers_id');
    }

    public function emailuri_trimise()
    {
        return $this->hasMany('App\MesajTrimis', 'inregistrare_id')->where('categorie', 'Document universal');
    }
}
