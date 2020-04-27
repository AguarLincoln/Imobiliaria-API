<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    
    protected $fillable = [
        'title', 'price', 'bathrooms', 'bedrooms',
        'classification', 'total_area', 'description',
        'slug', 'about', 'user_id'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function categories(){
        $this->belongsToMany(Category::class, 'real_state_categories');
    }
}
