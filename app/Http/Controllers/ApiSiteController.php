<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Sites;

class ApiSiteController extends Controller
{
	private $validation = [
		'name' => ['required', 'string', 'max:50'],
		'category' => ['required', 'string', 'max:50'],
		'logo_image_path' => ['required', 'string', 'max:100'],
		'enable_menu' => ['required', 'string', 'max:5'],
	];
		
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
			$validator = Validator::make($request->all(), $this->validation);
			
			if($validator->fails()){
				return response()->json([
					'status' => 422,
					'messages' => $validator->errors(),
					'request' => $request->all(),
				]);
			}
			
			$user = $request->user();
			
			$site = Sites::create([
				'name' => $request->name,
				'category' => $request->category,
				'logo_image_path' => $request->logo_image_path,
				'enable_menu' => ($request->enable_menu == 'true') ? true : false,
				'user_id' => $user->id,
			]);
			
			return response()->json([
				'status' => 200,
				'messages' => 'Site stored successfully',
				'site' => $site,
			]);
		}catch(Exception $error){
			return response()->json([
				'status' => 500,
				'messages' => 'Error in store site',
				'error' => $error,
			]);
		}
	}	
		
	public function update(Request $request)
    {
		try{
			$this->validation['id'] = ['required', 'string', 'max:50'];
			$validator = Validator::make($request->all(), $this->validation);
			
			if($validator->fails()){
				return response()->json([
					'status' => 422,
					'messages' => $validator->errors(),
					'request' => $request->all(),
				]);
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
				])->first();
				
				return response()->json([
					'status' => 200,
					'messages' => 'Site Updated',
					'site' => $site,
				]);
			}else{
				return response()->json([
					'status' => 403,
					'messages' => 'Access Denied',
				]);
			}
		}catch(Exception $error){
			return response()->json([
				'status' => 500,
				'messages' => 'Error in store site',
				'error' => $error,
			]);
		}
	}
}
