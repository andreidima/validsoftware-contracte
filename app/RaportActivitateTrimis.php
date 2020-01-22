<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaportActivitateTrimis extends Model
{
    protected $table = 'rapoarte_activitate_trimise';
    protected $guarded = [];

    public function path()
    {
        return "/rapoarte_activitate_trimise/{$this->id}";
    }

    public function contract()
    {
        return $this->belongsTo('App\Contract', 'contract_id');
    }
}
