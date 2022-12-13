<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    protected $table = 'firme';
    protected $guarded = [];

    public function path()
    {
        return "/firme/{$this->id}";
    }
}
