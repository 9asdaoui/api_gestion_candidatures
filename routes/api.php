<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserProfileController;

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

Route::get('profile', [UserProfileController::class, 'show'])->middleware('auth:sanctum');
Route::put('profile', [UserProfileController::class, 'update'])->middleware('auth:sanctum');


Route::get('applications', [ApplicationController::class, 'index']);
Route::get('applications/{id}', [ApplicationController::class, 'show']);
Route::post('applications', [ApplicationController::class, 'store']);
Route::delete('applications/{id}', [ApplicationController::class, 'destroy']);
Route::get('showResume/{id}', [ApplicationController::class, 'showResume']);


