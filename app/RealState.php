<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{

    protected $fillable = [
        'title', 'price', 'bathorooms', 'bedrooms',
        'classification', 'total_area', 'description',
        'slug', 'about', 'user_id'
    ];
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
