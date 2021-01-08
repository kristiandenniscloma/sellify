<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ValidationTrait;

use App\Models\Profiles;


class ApiProfileController extends Controller
{
	use ValidationTrait, ResponseTrait;

    public function index()
    {
        
    }
	
    public function store(Request $request)
    {
		try{
			$user = $request->user();
			
			$validator = Validator::make($request->all(), $this->validations['profile']);
			
			if($validator->fails()){
				return $this->responseMessage($validator->errors(), $request->all(), 'validation_error', '');
			}
			
			$profile = Profiles::create([
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'mobile_no' => $request->mobile_no,
				'user_id' => $user->id,
			]);
			
			return $this->responseMessage('', $request->all(), 'saved_successfully', $profile);
		}catch(Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
		}
    }

    public function update(Request $request)
    {
		try{
			$validator = Validator::make($request->all(), $this->validations['profile']);
			
			if($validator->fails()){
				return $this->responseMessage($validator->errors(), $request->all(), 'validation_error', '');
			}
			
			$user = $request->user();
			
			$profile = tap(DB::table('profiles')
			->where('user_id', $user->id))
			->update([
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'mobile_no' => $request->mobile_no,
			])->first();
			
			return $this->responseMessage('', $request->all(), 'updated_successfully', $profile);
		}catch(Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
		}
    }
}
