<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CompetenceController;
use App\Models\User;

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

Route::get('/user', function (Request $request) {return $request->user();});


Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::post('/refresh', [UserAuthController::class, 'refresh']);
Route::post('logout', [UserAuthController::class, 'logout'])->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);

Route::apiResource('offers', OfferController::class)->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);

Route::apiResource('competences', CompetenceController::class)->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);

Route::apiResource('applications', ApplicationController::class)->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);

Route::get('showResume/{id}', [ApplicationController::class, 'showResume'])->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);

Route::get('profile', [UserProfileController::class, 'show'])->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur']);
Route::put('profile', [UserProfileController::class, 'update'])->middleware(['auth:api', 'authorize.role:admin,candidat,recruteur',]);
