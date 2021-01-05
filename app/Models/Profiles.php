<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Profiles extends Model
{
    use HasFactory;
	use \App\Http\Traits\UsesUuid;
	
	protected $table = 'profiles';
	
	protected $fillable = [
		'first_name',
		'last_name',
		'mobile_no',
		'user_id',
	];
}
