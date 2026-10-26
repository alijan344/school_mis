<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

// Test API using WelcomeController
Route::get('/hello', [WelcomeController::class, 'hello']);

// Check API status
Route::get('/ping', function () {
    return response()->json([
        'pong' => true,
        'time' => now(),
    ]);
});

// Greeting with a name parameter using WelcomeController
Route::get('/greet/{name}', [WelcomeController::class, 'greet']);

// Get authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');