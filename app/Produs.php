<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produs extends Model
{
    protected $table = 'produse';
    protected $guarded = [];

    public $timestamps = false;

    public function path()
    {
        return "/produse/{$this->id}";
    }
}
