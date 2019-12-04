<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colet extends Model
{
    protected $table = 'colete';
    protected $guarded = [];

    public function path()
    {
        return "/colete/{$this->id}";
    }

    public function oras_plecare_nume()
    {
        return $this->belongsTo('App\Oras', 'oras_plecare');
    }

    public function oras_sosire_nume()
    {
        return $this->belongsTo('App\Oras', 'oras_sosire');
    }
}
