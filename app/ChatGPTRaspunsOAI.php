<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatGPTRaspunsOAI extends Model
{
    protected $table = 'chatgpt_raspunsuri_oai';
    protected $guarded = [];

    public function path()
    {
        return "/chat-gpt/raspunsuri-oai/{$this->id}";
    }

    public function prompt()
    {
        return $this->belongsTo('App\ChatGPTPrompt', 'prompt_id');
    }

    /**
     * The produse that belong to the ChatGPTRaspunsOAI
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function produse()
    {
        return $this->belongsToMany(ChatGPTProdus::class, 'chatgpt_produse_raspunsuri_oai', 'raspuns_oai_id', 'produs_id');
    }

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
