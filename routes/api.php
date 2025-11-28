<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// ------------------------------
// PUBLIC AUTH ROUTES
// ------------------------------
Route::post('/users/login', [UserController::class, 'login']);

// ------------------------------
// PROTECTED ROUTES (must use Bearer token)
// ------------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Authenticated user info
    Route::get('/users/me', [UserController::class, 'me']);

    // Update authenticated user password
    Route::put('/users/me/password', [UserController::class, 'updatePassword']);

});

// ------------------------------
// USER CRUD (public for your project)
// ------------------------------
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// ------------------------------
// FRIENDS
// ------------------------------
Route::get('/users/{id}/friends', [UserController::class, 'friends']);
Route::post('/users/{id}/friends', [UserController::class, 'addFriend']);
