<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Profiles;


class ApiProfileController extends Controller
{
	
	private $validation = [
		'first_name' => ['required', 'string', 'max:50'],
		'last_name' => ['required', 'string', 'max:50'],
		'mobile_no' => ['required', 'string', 'max:20'],
	];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		try{
			$user = $request->user();
			
			$validator = Validator::make($request->all(), $this->validation);
			
			if($validator->fails()){
				return response()->json([
					'status' => 422,
					'messages' => $validator->errors(),
				]);
			}
			
			$profile = Profiles::create([
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'mobile_no' => $request->mobile_no,
				'user_id' => $user->id,
			]);
			
			return response()->json([
				'status' => 200,
				'messages' => 'Profile stored successfully',
				'user' => $profile,
			]);
		}catch(Exception $error){
			return response()->json([
				'status' => 500,
				'messages' => 'Error in store profile',
				'error' => $error,
			]);
		}
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profiles  $profiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		try{
			$validator = Validator::make($request->all(), $this->validation);
			
			if($validator->fails()){
				return response()->json([
					'status' => 422,
					'messages' => $validator->errors(),
				]);
			}
			
			$user = $request->user();
			
			$profile = tap(DB::table('profiles')
			->where('user_id', $user->id))
			->update([
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'mobile_no' => $request->mobile_no,
			])->first();
			
			return response()->json([
				'status' => 200,
				'messages' => 'Profile Updated',
				'profile' => $profile,
			]);
		}catch(Exception $error){
			return response()->json([
				'status' => 500,
				'messages' => 'Error in Profile Update',
				'error' => $error,
			]);
		}
    }
}
