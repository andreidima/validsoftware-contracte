<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentDiversFisier extends Model
{
    protected $table = 'documente_diverse_fisiere';
    protected $guarded = [];

    public function path()
    {
        return "/documente-diverse-fisiere/{$this->id}";
    }

    public function documentDivers()
    {
        return $this->belongsTo('App\DocumentDivers', 'document_divers_id');
    }
}
