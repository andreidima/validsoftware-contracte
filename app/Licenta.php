<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licenta extends Model
{
    protected $table = 'licente';
    protected $guarded = [];

    public function path()
    {
        return "/service/licente/{$this->id}";
    }
}
