<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = ['description','zone_handle','location_type','status','buyer_id','weight','country_id','state_id',
	    'city_id','county_id','category_id','device_id','os_id','browser_id','keywords','frequency_capping','start_date','end_date','impression_cap',
            'created_at','updated_at','deleted_at'];
	
    public function status_type()
    {
    	return $this->belongsTo('App\StatusType', 'status');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function targets()
    {
        return $this->hasOne('App\CampaignTarget');
    }
}
