<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    protected $fillable = ['description','campaign_id','user_id','weight','status','media_id','link_id','folder_id'];
    protected $table = 'creatives';
}
