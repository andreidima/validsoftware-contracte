<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clienti';
    protected $guarded = [];

    public function path()
    {
        return "/clienti/{$this->id}";
    }
}
