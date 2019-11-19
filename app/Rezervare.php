<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rezervare extends Model
{
    protected $table = 'rezervari';
    protected $guarded = [];

    public function path()
    {
        return "/rezervari/{$this->id}";
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
