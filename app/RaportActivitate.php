<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaportActivitate extends Model
{
    protected $table = 'rapoarte_activitate';
    protected $guarded = [];

    public function path()
    {
        return "/rapoarte_activitate/{$this->id}";
    }

    public function contract()
    {
        return $this->belongsTo('App\Contract', 'contract_id');
    }
}
