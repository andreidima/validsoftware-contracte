<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = 'tarife';
    protected $guarded = [];

    public function path()
    {
        return "/tarife/{$this->id}";
    }
}
