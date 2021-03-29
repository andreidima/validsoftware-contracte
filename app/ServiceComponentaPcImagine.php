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

    public function imagine()
    {
        return $this->hasmany('App\Models\ServiceComponentaPcImagine', 'referinta_id')->where('referinta_categorie', 'componenta_pc');
    }
}
