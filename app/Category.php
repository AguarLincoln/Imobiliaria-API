<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name', 'description', 'slug'
    ];

    public function realState(){
        $this->belongsToMany(realState::class,'real_state_categories');
    }
}
