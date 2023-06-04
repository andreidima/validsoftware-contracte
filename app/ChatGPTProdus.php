<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatGPTProdus extends Model
{
    protected $table = 'chatgpt_produse';
    protected $guarded = [];

    public function path()
    {
        return "/chat-gpt/produse/{$this->id}";
    }

    public function site()
    {
        return $this->belongsTo('App\ChatGPTSite', 'site_id');
    }

    /**
     * The raspunsuriOAI that belong to the ChatGPTProdus
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function raspunsuriOAI()
    {
        return $this->belongsToMany(ChatGPTRaspunsOAI::class, 'chatgpt_produse_raspunsuri_oai', 'produs_id', 'raspuns_oai_id');
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
