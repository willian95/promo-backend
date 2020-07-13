<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    
    public function payments(){
        return $this->hasMany('App\Payment');
    }

    public function post(){
        return $this->belongsTo('App\Post');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function productsPurchase(){
        return $this->hasMany("App\ProductPurchase");
    }

}
