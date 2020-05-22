<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class Country extends Model
{
    public function states()
    {
        return $this->hasMany(State::class);
    }

    
}
