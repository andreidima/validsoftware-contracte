<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePartener extends Model
{
    protected $table = 'service_parteneri';
    protected $guarded = [];

    public function path()
    {
        return "/service/parteneri/{$this->id}";
    }
}
