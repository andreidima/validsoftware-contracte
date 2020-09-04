<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceFisa extends Model
{
    protected $table = 'service_fise';
    protected $guarded = [];

    public function path()
    {
        return "/service/fise/{$this->id}";
    }

    public function client()
    {
        return $this->belongsTo('App\ServiceClient', 'client_id');
    }

    public function servicii()
    {
        return $this->belongsToMany('App\ServiceServiciu', 'service_fise_servicii', 'service_fisa_id', 'service_serviciu_id');
    }

    public function mesaje_trimise_fisa_intrare()
    {
        return $this->hasMany('App\MesajTrimis', 'inregistrare_id')->where('categorie', 'Fise')->where('subcategorie', 'Intrare');
    }

    public function mesaje_trimise_fisa_iesire()
    {
        return $this->hasMany('App\MesajTrimis', 'inregistrare_id')->where('categorie', 'Fise')->where('subcategorie', 'Iesire');
    }

    public function sms_trimise_fisa_intrare()
    {
        return $this->hasMany('App\SmsTrimis', 'inregistrare_id')->where('categorie', 'Fise')->where('subcategorie', 'Intrare');
    }

    public function sms_trimise_fisa_intrare_cu_succes()
    {
        return $this->hasMany('App\SmsTrimis', 'inregistrare_id')->where('categorie', 'Fise')->where('subcategorie', 'Intrare')->where('trimis', 1);
    }

    public function sms_trimise_fisa_iesire()
    {
        return $this->hasMany('App\SmsTrimis', 'inregistrare_id')->where('categorie', 'Fise')->where('subcategorie', 'Iesire');
    }

    public function sms_trimise_fisa_iesire_cu_success()
    {
        return $this->hasMany('App\SmsTrimis', 'inregistrare_id')->where('categorie', 'Fise')->where('subcategorie', 'Iesire')->where('trimis', 1);
    }
}
