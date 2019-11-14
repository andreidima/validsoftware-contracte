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
}
