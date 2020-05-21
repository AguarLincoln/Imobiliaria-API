<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = "user_profiles";
    protected $fillable = [
        'social_networks', 'phone', 'mobile_phone', 'about'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
