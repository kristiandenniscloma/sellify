<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\ApiProfileController;

/*
Status Code	Meaning
404	Not Found (page or other resource doesn’t exist)
401	Not authorized (not logged in)
403	Logged in but access to requested area is forbidden
400	Bad request (something wrong with URL or parameters)
422	Unprocessable Entity (validation failed)
500	General server error
*/

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	protected $ProfileController;
	 
	public function __contruct(ApiProfileController $ProfileController){
		$this->ProfileController = $ProfileController;
	}
	 
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 422,
                'messages' => $validator->errors(),
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
		

        return response()->json([
            'status' => 200,
            'messages' => 'User registered successfully',
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
		return response()->json([
			'status' => 200,
			'user' => $request->user(),
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request){
		try{
			$validator = Validator::make($request->all(), [
				'email' => ['required', 'string', 'email', 'max:255'],
				'password' => ['required', 'min:8'],
			]);

			if ($validator->fails()) {
				return response()->json($validator->errors());
			} else {
				$user = User::where('email', $request->email)->first();

				if($user){
					if (!Hash::check($request->password, $user->password, [])) {
						return response()->json([
							'status' => 422,
							'messages' => 'Invalid email or password.',
						]);
					}
				}else{
					return response()->json([
						'status' => 422,
						'messages' => 'Invalid email or password.',
					]);
				}

				$user = User::where('email', $request->email)->first();
				$user_info = $user->first();
				$token = $user_info->createToken('authToken')->plainTextToken;

				return response()->json([
					'status' => 200,
					'token' => $token,
					'user' => compact('user'),
				]);
			} catch (Exception $error){
				return response()->json([
					'status' => 500,
					'messages' => 'Error in Login',
					'error' = $error,
				]);
			}
        }
    }
}
