<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function discountDays(){
        return $this->hasMany('App\DiscountDay');
    }

    public function post(){
        return $this->hasMany('App\Purchase');
    }

}
