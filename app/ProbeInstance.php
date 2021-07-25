<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProbeInstance extends Model
{
    public function logs()
    {
        return $this->hasMany('App\ProbeLog');
    }
}
