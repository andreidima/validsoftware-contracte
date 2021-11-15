<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceLicenta extends Model
{
    protected $table = 'service_licente';
    protected $guarded = [];

    public function path()
    {
        return "/service/licente/{$this->id}";
    }
}
