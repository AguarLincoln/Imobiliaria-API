<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    public function state(){
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
