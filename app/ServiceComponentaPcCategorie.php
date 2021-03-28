<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceComponentaPcCategorie extends Model
{
    protected $table = 'service_componente_pc_categorii';
    protected $guarded = [];

    public function path()
    {
        return "/service/componente-pc/categorii/{$this->id}";
    }
}
