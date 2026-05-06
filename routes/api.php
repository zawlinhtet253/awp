<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication required)
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

// Public data routes
Route::get('/partners', [UserController::class, 'partners']);
Route::get('/engagements', [EngagementController::class, 'engagements']);
Route::get('/clients', [ClientController::class, 'clients']);
Route::get('/clients/{id}', [ClientController::class, 'client']);
Route::get('/industry_types', [ClientController::class, 'industryTypes']);

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    // Engagement routes
    Route::post('/engagement', [EngagementController::class, 'create']);
    
    
    // User routes
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/user', [UserController::class, 'update']);
    
    // Client routes
    Route::post('/client', [ClientController::class, 'create']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
});
