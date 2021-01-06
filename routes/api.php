<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiProfileController;
use App\Http\Controllers\ApiSiteController;

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


/* 
1|DVlap5d7NXsfsflMuI5w7MzSqyBupCHewzD7BaGl
*/


/*
Status Code	Meaning
404	Not Found (page or other resource doesn’t exist)
401	Not authorized (not logged in)
403	Logged in but access to requested area is forbidden
400	Bad request (something wrong with URL or parameters)
422	Unprocessable Entity (validation failed)
500	General server error
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/register', [ApiUserController::class, 'store']);
Route::post('user/login', [ApiUserController::class, 'login']);

Route::post('user/register', [ApiUserController::class, 'store']);
Route::post('user/login', [ApiUserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {
	Route::get('/user/show', [ApiUserController::class, 'show']);
	
	Route::post('/profile/store', [ApiProfileController::class, 'store']);
	Route::post('/profile/update', [ApiProfileController::class, 'update']);
	
	Route::post('/site/store', [ApiSiteController::class, 'store']);
	Route::post('/site/update', [ApiSiteController::class, 'update']);
});

