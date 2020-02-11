<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variabila extends Model
{
    protected $table = 'variabile';
    protected $guarded = [];

    public function path()
    {
        return "/variabile/{$this->id}";
    }

    public function scopeNr_document()
    {
        $nr_document_actual = \DB::table('variabile')
            ->where('nume', 'nr_document')
            ->first();

        $nr_document_viitor = $nr_document_actual->valoare + 1;

        \DB::table('variabile')
            ->where('nume', 'nr_document')
            ->update(['valoare' => $nr_document_viitor]);

        return $nr_document_actual->valoare;
    }
}
