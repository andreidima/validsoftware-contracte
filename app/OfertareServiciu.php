<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfertareServiciu extends Model
{
    protected $table = 'ofertari_servicii';
    protected $guarded = [];

    public function path()
    {
        return "/ofertari-servicii/{$this->id}";
    }
}
