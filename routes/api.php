<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangayApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/barangay', [BarangayApiController::class, 'index']);
Route::prefix('/barangay')->group(function () {
    Route::post('/store', [BarangayApiController::class, 'store_barangay']);
    // Route::put('/{id}', [ItemController::class, 'update']);
    // Route::delete('/{id}', [ItemController::class, 'destroy']);
});

Route::prefix('/admin')->group(function () {
    Route::post('/store', [BarangayApiController::class, 'store_barangayAdmin']);
});
