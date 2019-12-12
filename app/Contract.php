<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracte';
    protected $guarded = [];

    public function path()
    {
        return "/contracte/{$this->id}";
    }
}
