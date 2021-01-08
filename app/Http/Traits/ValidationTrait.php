<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait ValidationTrait
{
	private $validations = [
		'user_register' =>[
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
			'password' => ['required', 'confirmed', 'min:8'],
		],
		'user_login' =>[
			'email' => ['required', 'string', 'email', 'max:255'],
			'password' => ['required', 'min:8'],
		],
		'profile' => [
			'first_name' => ['required', 'string', 'max:50'],
			'last_name' => ['required', 'string', 'max:50'],
			'mobile_no' => ['required', 'string', 'max:20'],
		],
		'site' => [
			'id' => ['required', 'string', 'max:50'],
			'name' => ['required', 'string', 'max:50'],
			'category' => ['required', 'string', 'max:50'],
			'logo_image_path' => ['required', 'string', 'max:100'],
			'enable_menu' => ['required', 'string', 'max:5'],
		],
		'page' => [
			'id' => ['required', 'string', 'max:50'],
			'site_id' => ['required', 'string', 'max:50'],
			'theme' => ['required', 'string', 'max:50'],
		],
	];
}
