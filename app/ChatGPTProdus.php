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
}
