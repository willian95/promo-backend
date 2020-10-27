<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $table = "communes";

    public function users(){
        return $this->hasMany('App\User');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }

}
