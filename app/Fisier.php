<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fisier extends Model
{
    protected $table = 'fisiere';
    protected $guarded = [];

    public function path()
    {
        return "/fisiere/{$this->id}";
    }

    public function contract()
    {
        return $this->belongsTo('App\Contract', 'contract_id');
    }
}
