<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = [
    	'handle',
    	'site_id',
    	'pub_id',
    	'module_type',
    	'width',
    	'height',
    	'status',
    	'location_type',
    	'description'
    ];

    public function site()
    {
    	return $this->belongsTo('App\Site');
    }

    public function pub()
    {
    	return $this->belongsTo('App\User');
    }
}
