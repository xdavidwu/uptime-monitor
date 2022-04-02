<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProbeInstance extends Model
{
    public function logs()
    {
        return $this->hasMany('App\Models\ProbeLog');
    }
}
