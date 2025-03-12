<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('offers', OfferController::class)->middleware('auth:sanctum');

Route::get('profile', [App\Http\Controllers\UserProfileController::class, 'show'])->middleware('auth:sanctum');
Route::put('profile', [App\Http\Controllers\UserProfileController::class, 'update'])->middleware('auth:sanctum');

