<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function purchase(){
        return $this->belongsTo('App\Purchase');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function bank(){
        return $this->belongsTo('App\Bank');
    }

}
