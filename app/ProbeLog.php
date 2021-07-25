<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProbeLog extends Model
{
    public function instance()
    {
        return $this->belongsTo('App\ProbeInstance');
    }
}
