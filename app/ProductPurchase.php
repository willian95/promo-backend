<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    public function purchase(){
        return $this->belongsTo("App\Purchase");
    }

    public function postProduct(){
        return $this->belongsTo("App\PostProduct");
    }

}
