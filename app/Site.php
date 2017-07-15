<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
    	'site_name',
    	'site_url',
    	'site_category',
    	'user_id',
    	'site_handle'
    ];

    public function zones()
    {
    	return $this->hasMany('App\Zone');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    
    public function addZone($description, $location_type)
    {
        $pub_id = $this->user_id;
        $handle = bin2hex(random_bytes(5));
        $this->zones()->create(compact('description','location_type','pub_id','handle'));
    }

    public function stats()
    {
        return $this->hasMany('App\Stat');
    }
}
