<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignTarget extends Model
{
    protected $fillable = ['user_id','campaign_id','geos','states','cities','platforms','browsers','operating_systems','keywords','sites'];
    //
}
