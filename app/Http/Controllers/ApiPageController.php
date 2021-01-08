<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ValidationTrait;

use App\Models\Pages;

class ApiPageController extends Controller
{
	use ValidationTrait, ResponseTrait;
	
		protected $ApiUserController;
		
	public function __construct(ApiUserController $ApiUserController){
		$this->ApiUserController = $ApiUserController;
	}
	
    public function show(Request $request)
    {
			
	}
	
    public function store(Request $request)
    {
		try{
			$validator = Validator::make($request->all(), $this->validations['page']);
			
			if($validator->fails()){
				return $this->responseMessage($validator->errors(), $request->all(), 'invalid_details', '');
			}
			
			$user = $request->user();
			
			$page = Pages::create([
				'site_id' => $request->site_id,
				'theme' => $request->theme,
			]);
			
			return $this->responseMessage('', $request->all(), 'saved_successfully', $page);
		}catch(Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
		}
	}	
		
	public function update(Request $request)
    {
		try{
			$validator = Validator::make($request->all(), $this->validations['page']);
			
			if($validator->fails()){
				return $this->responseMessage($validator->errors(), $request->all(), 'invalid_details', '');
			}
			
			$user = $request->user();
			
			if($this->ApiUserController->checkAccessToData($user->id, 'sites', $request->site_id)){
				$page = tap(DB::table('pages')
				->where('id', $request->id))
				->update([
				'site_id' => $request->site_id,
				'theme' => $request->theme,
				'status' => ($request->status == 'true') ? true : false,
				])->first();
				
				return $this->responseMessage('', $request->all(), 'updated_successfully', '');
			}else{
				return $this->responseMessage('', $request->all(), 'logged_in_not_authorized', '');
			}
		}catch(Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
		}
	}
}
