<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes Example
|--------------------------------------------------------------------------
|
| Example API routes file showing how to organize your generated APIs
| with proper versioning, middleware, and resource grouping.
|
*/

// API v1 Routes
Route::prefix('v1')->group(function () {
    
    // Public routes (no authentication required)
    Route::prefix('public')->group(function () {
        Route::get('products', [App\Http\Controllers\Api\ProductController::class, 'index']);
        Route::get('products/{product}', [App\Http\Controllers\Api\ProductController::class, 'show']);
        Route::get('categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);
    });
    
    // Protected routes (authentication required)
    Route::middleware('auth:sanctum')->group(function () {
        
        // User profile
        Route::get('user', function (Request $request) {
            return $request->user();
        });
        
        // Product management
        Route::apiResource('products', App\Http\Controllers\Api\ProductController::class)
             ->except(['index', 'show']); // Exclude public routes
        
        // Category management
        Route::apiResource('categories', App\Http\Controllers\Api\CategoryController::class)
             ->except(['index']);
        
        // Order management
        Route::apiResource('orders', App\Http\Controllers\Api\OrderController::class);
        
        // Additional endpoints for soft-deleted items
        Route::prefix('products')->group(function () {
            Route::patch('{id}/restore', [App\Http\Controllers\Api\ProductController::class, 'restore']);
            Route::delete('{id}/force', [App\Http\Controllers\Api\ProductController::class, 'forceDelete']);
        });
        
        Route::prefix('categories')->group(function () {
            Route::patch('{id}/restore', [App\Http\Controllers\Api\CategoryController::class, 'restore']);
            Route::delete('{id}/force', [App\Http\Controllers\Api\CategoryController::class, 'forceDelete']);
        });
    });
    
    // Admin routes (admin middleware)
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Api\Admin\DashboardController::class, 'index']);
        Route::get('users', [App\Http\Controllers\Api\Admin\UserController::class, 'index']);
        Route::apiResource('settings', App\Http\Controllers\Api\Admin\SettingController::class);
    });
});

// API v2 Routes (future version)
Route::prefix('v2')->group(function () {
    // Future API version routes
    Route::get('info', function () {
        return response()->json([
            'message' => 'API v2 coming soon',
            'version' => '2.0',
            'status' => 'development'
        ]);
    });
});

// Health check endpoint
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'version' => config('app.version', '1.0.0'),
    ]);
});

// API Documentation route
Route::get('docs', function () {
    return response()->json([
        'message' => 'API Documentation',
        'documentation_url' => url('/docs'),
        'postman_collection' => url('/api/postman-collection'),
    ]);
});