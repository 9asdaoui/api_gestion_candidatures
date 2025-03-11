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

// Get authenticated user information
// This route returns the currently logged-in user's details
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Job offers resource routes (index, store, show, update, destroy)
// Protected by authentication to ensure only logged-in users can access
Route::apiResource('offers', OfferController::class)->middleware('auth:sanctum');

// User authentication endpoints
// Register a new user account with email, password, etc.
Route::post('register', [UserAuthController::class, 'register']);

// Login endpoint - authenticate user and return access token
Route::post('login', [UserAuthController::class, 'login']);

// Logout endpoint - revoke the user's current access token
// Protected by authentication to ensure only logged-in users can logout
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');
