<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\AnalyticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Clients
    Route::apiResource('clients', ClientController::class);
    
    // Services
    Route::apiResource('services', ServiceController::class);
    
    // Bookings
    Route::apiResource('bookings', BookingController::class);
    
    // Staff
    Route::apiResource('staff', StaffController::class);
    
    // Inventory
    Route::apiResource('inventory', InventoryController::class);
    
    // Products
    Route::apiResource('products', ProductController::class);
    
    // Promotions
    Route::apiResource('promotions', PromotionController::class);
    
    // Subscriptions
    Route::apiResource('subscriptions', SubscriptionController::class);
    
    // Analytics
    Route::get('/analytics/dashboard', [AnalyticsController::class, 'dashboard']);
    Route::get('/analytics/revenue', [AnalyticsController::class, 'revenue']);
    Route::get('/analytics/top-services', [AnalyticsController::class, 'topServices']);
});
