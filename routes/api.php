<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// No errors detected in the route definitions.
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::get('/partners', [UserController::class, 'partners']);
Route::get('/engagements', [EngagementController::class, 'engagements']);
Route::get('/clients', [ClientController::class, 'clients']);

Route::middleware('auth:sanctum')->group(function () {    
    Route::post('/engagement', [EngagementController::class, 'create']);
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/user', [UserController::class, 'update']);
    Route::post('/client', [ClientController::class, 'create']);
});
