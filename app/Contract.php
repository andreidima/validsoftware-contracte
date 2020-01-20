<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracte';
    protected $guarded = [];

    public function path()
    {
        return "/contracte/{$this->id}";
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function fisiere()
    {
        return $this->hasMany('App\Fisier', 'contract_id');
    }
}
