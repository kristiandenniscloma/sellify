<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiProfileController;
use App\Http\Controllers\ApiSiteController;
use App\Http\Controllers\ApiPageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/register', [ApiUserController::class, 'store']);
Route::post('user/login', [ApiUserController::class, 'login']);

Route::post('user/register', [ApiUserController::class, 'store']);
Route::post('user/login', [ApiUserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {
	Route::get('user/show', [ApiUserController::class, 'show']);
	
	Route::post('profile/store', [ApiProfileController::class, 'store']);
	Route::post('profile/update', [ApiProfileController::class, 'update']);
	
	Route::post('site/store', [ApiSiteController::class, 'store']);
	Route::post('site/update', [ApiSiteController::class, 'update']);
	
	Route::post('page/store', [ApiPageController::class, 'store']);
	Route::post('page/update', [ApiPageController::class, 'update']);
});

