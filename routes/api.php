<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CurrencyController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/services', [ServiceController::class, 'index']);

// Currency Exchange API Routes
Route::prefix('currencies')->group(function () {
    // Public routes (no authentication required)
    Route::get('/', [CurrencyController::class, 'index']); // Get all currencies
    Route::get('/rates', [CurrencyController::class, 'getRates']); // Get exchange rates
    Route::get('/{code}', [CurrencyController::class, 'show']); // Get specific currency
    Route::post('/convert', [CurrencyController::class, 'convert']); // Convert currency
    Route::post('/bulk-convert', [CurrencyController::class, 'bulkConvert']); // Bulk convert
    
    // Admin only routes (authentication required)
    Route::middleware('auth:sanctum')->group(function () {
        // Rate Management
        Route::post('/update-rates', [CurrencyController::class, 'updateRates']); // Update rates
        Route::delete('/cache', [CurrencyController::class, 'clearCache']); // Clear cache
    });
});
