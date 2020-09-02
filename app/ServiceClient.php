<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceClient extends Model
{
    protected $table = 'service_clienti';
    protected $guarded = [];

    public function path()
    {
        return "/service/clienti/{$this->id}";
    }
}