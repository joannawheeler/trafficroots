<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['user_id','transaction_amount','running_balance'];   
 //
}
