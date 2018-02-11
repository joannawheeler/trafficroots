<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
	protected $fillable('name', 'url', 'added_by', 'created_at', 'updated_at');
	protected $table = 'affiliates';
}
