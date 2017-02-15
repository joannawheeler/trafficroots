<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    //TrafficRoots Ad Creative Model
    protected $table = 'creatives';
    protected $fillable = ['ad_id','weight','status','html_id','link_id'];
    //
}
