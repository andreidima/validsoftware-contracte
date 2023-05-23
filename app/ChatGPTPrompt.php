<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatGPTPrompt extends Model
{
    protected $table = 'chatgpt_prompturi';
    protected $guarded = [];

    public function path()
    {
        return "/chat-gpt/prompturi/{$this->id}";
    }

    // public function firma()
    // {
    //     return $this->belongsTo('App\Firma', 'firma_id');
    // }

    // public function client()
    // {
    //     return $this->belongsTo('App\Client', 'client_id');
    // }

    // public function fisiere()
    // {
    //     return $this->hasMany('App\DocumentDiversFisier', 'document_divers_id');
    // }

    // public function emailuri_trimise()
    // {
    //     return $this->hasMany('App\MesajTrimis', 'inregistrare_id')->where('categorie', 'Document universal');
    // }
}
