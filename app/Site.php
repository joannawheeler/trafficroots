<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['site_name','site_url','site_category','user_id','site_handle'];
}
