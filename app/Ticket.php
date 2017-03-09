<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $connection = 'tradm';
    protected $fillable = ['buyer_id','pub_id','type','subject','status','description','comments'];
}
