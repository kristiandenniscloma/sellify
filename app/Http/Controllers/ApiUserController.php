<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ValidationTrait;

use App\Models\User;
use App\Models\Profiles;

use App\Http\Controllers\ApiProfileController;


class ApiUserController extends Controller
{
	use ValidationTrait, ResponseTrait;
	
	public function __construct(){
		
	} 
	 
    public function index()
    {
        
    }

    public function store(Request $request)
    {
		try{
			$validator = Validator::make($request->all(), $this->validations['user_register']);

			if ($validator->fails()) {
				return $this->responseMessage($validator->errors(), $request->all(), 'validation_error', '');
			}

			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password),
			]);
			
			return $this->responseMessage('', $request->all(), 'user_register_success', $user);
		}catch(Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
		}
    }

    public function show(Request $request)
    {
		$user = $request->user();
		$profile = Profiles::where('user_id', $user->id)->first();
		return $this->responseMessage('', $request->all(), 'success', ['user'=>$user, 'profile'=>$profile]);
    }

    public function update(Request $request)
    {

    }

    public function destroy($id)
    {
        //
    }

    public function login(Request $request){
		try{
			$validator = Validator::make($request->all(), $this->validations['user_login']);

			if ($validator->fails()) {
				return $this->responseMessage($validator->errors(), $request->all(), 'validation_error', '');
			} else {
				$user = User::where('email', $request->email)->first();

				if($user){
					if (!Hash::check($request->password, $user->password, [])) {
						return $this->responseMessage('', $request->all(), 'invalid_user_login_details', '');
					}
				}else{
					return $this->responseMessage('', $request->all(), 'invalid_user_login_details', '');
				}

				$user = User::where('email', $request->email)->first();
				$token = $user->createToken('authToken')->plainTextToken;
				return $this->responseMessage('', $request->all(), 'success', ['user'=>$user, 'token'=> $token]);
			} 
			
		}catch (Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
        }
    }
	
	public function checkAccessToData($user_id, $table, $id){
		try{
			$data = DB::table($table)
			->where('user_id', $user_id)
			->where('id', $id)->first();
			
			return ($data) ? true : false;
		}catch (Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
        }
	}
}
