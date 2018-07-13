<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdCreative extends Model
{
	protected $table = 'ad_creatives';
	protected $fillable = ['ad_id','description','weight','weight_fixed','status','media_id','link_id','folder_id','created_at','updated_at'];
	
	public function medias()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }
    
    public function links()
    {
        return $this->belongsTo('App\Links', 'link_id');
    }
}
