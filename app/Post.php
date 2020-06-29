<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    public function commune(){
        return $this->belongsTo('App\Commune');
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

    public function purchase(){
        return $this->hasMany('App\Purchase');
    }

}
