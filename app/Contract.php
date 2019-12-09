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

    // public function oras_plecare_nume()
    // {
    //     return $this->belongsTo('App\Oras', 'oras_plecare');
    // }

    // public function oras_sosire_nume()
    // {
    //     return $this->belongsTo('App\Oras', 'oras_sosire');
    // }
}
