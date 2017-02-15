<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //TrafficRoots Bid Model
    protected $table = 'bids';
    protected $fillable = ['zone_handle','location_type','status','buyer_id','weight','country_id','state_id',
                           'city_id','category_id','device_id','os_id','browser_id'];
    //
}
