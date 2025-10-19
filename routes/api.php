<?php

use App\Http\Controllers\V1\Api\AuthController;
use App\Http\Controllers\V1\Api\CategoryController;
use App\Http\Controllers\V1\Api\DashboardController;
use App\Http\Controllers\V1\Api\TransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
})->middleware('web');

// Routes publiques (pas d'authentification requise)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Routes protégées (authentification requise)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    
    // Transactions
    Route::apiResource('transactions', TransactionController::class);
    
    // Catégories
    Route::apiResource('categories', CategoryController::class);
    
    // Dashboard
    Route::get('dashboard/summary', [DashboardController::class, 'summary']);
    Route::get('dashboard/chart-data', [DashboardController::class, 'chartData']);
});
