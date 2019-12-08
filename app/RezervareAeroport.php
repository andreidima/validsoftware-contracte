<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RezervareAeroport extends Model
{
    protected $table = 'rezervari_aeroport';
    protected $guarded = [];

    public function path()
    {
        return "/rezervari-aeroport/{$this->id}";
    }
}
