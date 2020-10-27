<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    
    function bank(){
        return $this->belongsTo(Bank::class);
    }

}
