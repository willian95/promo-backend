<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    function userBankAccounts(){
        return $this->hasMany(UserBankAccount::class);
    }
}
