<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['user_id','campaign_type','campaign_category','location_type','campaign_name','status'];
}
