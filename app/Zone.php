<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['handle','site_id','module_type','width','height','status','location_type','description'];
}
