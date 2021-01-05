<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiProfileController;

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


/* Route::get('admin/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('admin/stores/create', [StoreController::class, 'create'])->name('stores.create');
Route::post('admin/stores', [StoreController::class, 'store'])->name('stores.store');
Route::get('admin/stores/{id}', [StoreController::class, 'show'])->name('stores.show');
Route::get('admin/stores/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
Route::put('admin/stores/{id}', [StoreController::class, 'update'])->name('stores.update');
Route::delete('admin/stores/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');

*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/register', [ApiUserController::class, 'store']);
Route::post('user/login', [ApiUserController::class, 'login']);

Route::post('user/register', [ApiUserController::class, 'store']);
Route::post('user/login', [ApiUserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {
	Route::get('/test-token', function(){
		return response()->json([
			'messages' => 'authenticated',
		]);
	});
});