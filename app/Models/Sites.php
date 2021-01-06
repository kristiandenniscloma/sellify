<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    use HasFactory, \App\Http\Traits\UsesUuid;
	
	protected $table = 'sites';
	
	protected $fillable = [
		'name',
		'category',
		'logo_image_path',
		'enable_menu',
		'user_id',
	];
}
