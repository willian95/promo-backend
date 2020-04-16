<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }
}
