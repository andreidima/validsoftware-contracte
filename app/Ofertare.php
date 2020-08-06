<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ofertare extends Model
{
    protected $table = 'ofertari';
    protected $guarded = [];

    public function path()
    {
        return "/ofertari/{$this->id}";
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }
}
