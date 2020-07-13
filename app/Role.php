<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users(){
        return $this->hasMany('App\Class');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
