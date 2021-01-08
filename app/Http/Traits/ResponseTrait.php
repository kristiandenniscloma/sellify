<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait ResponseTrait
{
	public function responseMessage($messages, $request, $type, $items){
		$response_types = [
			'user_register_success' => [
				'response_code' => 200,
				'response_message' => 'User registered Successfully',
			],
			'site_saved_success' => [
				'response_code' => 200,
				'response_message' => 'Site Saved Successfully',
			],
			'invalid_site_details' => [
				'response_code' => 422,
				'response_message' => 'Invalid Site Details',
			],
			'invalid_details' => [
				'response_code' => 422,
				'response_message' => 'Invalid Details',
			],
			'profile_saved_succcess' => [
				'response_code' => 200,
				'response_message' => 'Profile Saved Successfully',
			],
			'saved_successfully' => [
				'response_code' => 200,
				'response_message' => 'Saved Successfully'
			],
			'updated_successfully' => [
				'response_code' => 200,
				'response_message' => 'Updated Successfully'
			],
			'success' => [
				'response_code' => 200,
				'response_message' => 'Success'
			],
			'validation_error' => [
				'response_code' => 422,
				'response_message' => 'Validation Error',
			],
			'invalid_user_login_details' => [
				'response_code' => 422,
				'response_message' => 'Invalid Email or Password.',
			],
			'invalid_profile_details' => [
				'response_code' => 422,
				'response_message' => 'Invalid Profile Details.',
			],
			'page_not_found' => [
				'response_code' => 404,
				'response_message' => 'Page Not found',
			],
			'not_logged_in_not_authorized' => [
				'response_code' => 401,
				'response_message' => 'Not Logged In and Not Authorized',
			],
			'logged_in_not_authorized' => [
				'response_code' => 403,
				'response_message' => 'Logged In and Not Authorized',
			],
			'bad_request' => [
				'response_code' => 400,
				'response_message' => 'Bad Request'
			],
			'general_server_error' => [
				'response_code' => 500,
				'response_message' => 'General Server Error'
			],
		];
		
		$response = $response_types[$type];
		
		if(isset($request['password'])){
			$request['password'] = 'hidden';
		}
		if(isset($request['password_confirmation'])){
			$request['password_confirmation'] = 'hidden';
		}
		
		return response()->json([
			'status_code' => $response['response_code'],
			'status_message' => $response['response_message'],
			'messages' => ($messages == '') ? $response['response_message'] : $messages,
			'request' => $request,
			'items' => $items,
		]);
	}
}
