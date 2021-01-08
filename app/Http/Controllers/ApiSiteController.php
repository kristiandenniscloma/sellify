<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ValidationTrait;

use App\Models\Sites;

class ApiSiteController extends Controller
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
			$validator = Validator::make($request->all(), $this->validations['site']);
			
			if($validator->fails()){
				return $this->responseMessage($validator->errors(), $request->all(), 'invalid_site_details', '');
			}
			
			$user = $request->user();
			
			$site = Sites::create([
				'name' => $request->name,
				'category' => $request->category,
				'logo_image_path' => $request->logo_image_path,
				'enable_menu' => ($request->enable_menu == 'true') ? true : false,
				'user_id' => $user->id,
			]);
			
			return $this->responseMessage('', $request->all(), 'saved_successfully', $site);
		}catch(Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
		}
	}	
		
	public function update(Request $request)
    {
		try{
			$this->validation['id'] = ['required', 'string', 'max:50'];
			$validator = Validator::make($request->all(), $this->validation);
			
			if($validator->fails()){
				return $this->responseMessage($validator->errors(), $request->all(), 'invalid_site_details', '');
			}
			
			$user = $request->user();
			
			if($this->ApiUserController->checkAccessToData($user->id, 'sites', $request->id)){
				$site = tap(DB::table('sites')
				->where('id', $request->id))
				->update([
					'name' => $request->name,
					'category' => $request->category,
					'logo_image_path' => $request->logo_image_path,
					'enable_menu' => ($request->enable_menu == 'true') ? true : false,
					'status' => ($request->status == 'true') ? true : false,
				])->first();
				
				return $this->responseMessage('', $request->all(), 'site_saved_success', $site);
			}else{
				return $this->responseMessage('', $request->all(), 'logged_in_not_authorized', '');
			}
		}catch(Exception $error){
			return $this->responseMessage($error, $request->all(), 'general_server_error', '');
		}
	}
}
