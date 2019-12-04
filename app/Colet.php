<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colet extends Model
{
    protected $table = 'colete';
    protected $guarded = [];

    public function path()
    {
        return "/colete/{$this->id}";
    }
}
