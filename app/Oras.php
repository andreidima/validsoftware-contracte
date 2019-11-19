<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oras extends Model
{
    protected $table = 'orase';
    protected $guarded = [];

    public function path()
    {
        return "/orase/{$this->id}";
    }

    public function rezervari()
    {
        return $this->hasMany('App\Rezervare', 'oras_plecare');
    }
}
