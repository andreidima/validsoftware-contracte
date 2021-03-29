<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceComponentaPcImagine extends Model
{
    protected $table = 'service_componente_pc_imagini';
    protected $guarded = [];

    public function path()
    {
        return "/service/componente-pc/imagini/{$this->id}";
    }
}
