<?php

namespace App\Http\Controllers;

use App\Models\Profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ApiProfileController extends Controller
{
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
			return response()->json([
				'data' => $request->all(),
			]);
			
			$validator = Validator::make($request->all(), [
				'first_name' => ['required', 'string', 'max:50'],
				'last_name' => ['required', 'string', 'max:50'],
				'mobile_no' => ['required', 'string', 'max:20'],
			]);
			
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
     * Display the specified resource.
     *
     * @param  \App\Models\Profiles  $profiles
     * @return \Illuminate\Http\Response
     */
    public function show(Profiles $profiles)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profiles  $profiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profiles $profiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profiles  $profiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profiles $profiles)
    {
        //
    }
}
