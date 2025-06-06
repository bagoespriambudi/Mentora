<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\TutorDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;


// Guest landing page
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
})->name('welcome');

// Authentication Routes
require __DIR__ . '/auth.php';

// Basic authenticated route
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment Routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

    // Refund Routes
    Route::get('/payments/{payment}/refund', [RefundController::class, 'create'])->name('refunds.create');
    Route::post('/payments/{payment}/refund', [RefundController::class, 'store'])->name('refunds.store');

    // Tutor Dashboard Route
    Route::get('/tutor/dashboard', [TutorDashboardController::class, 'index'])->name('tutor.dashboard');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show', 'create', 'store']);

    // Admin Category Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Admin Financial Routes
    Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
    Route::post('/financial/report', [FinancialController::class, 'generateReport'])->name('financial.report');
    Route::get('/financial/report/{report}/export', [FinancialController::class, 'exportReport'])->name('financial.export');
    
    // Refund Management
    Route::post('/refunds/{refund}/approve', [RefundController::class, 'approve'])->name('refunds.approve');
    Route::post('/refunds/{refund}/reject', [RefundController::class, 'reject'])->name('refunds.reject');
});

// Tutee Reviews
Route::middleware(['auth'])->prefix('tutee')->name('tutee.')->group(function () {
    Route::get('reviews', [\App\Http\Controllers\ReviewController::class, 'tuteeIndex'])->name('reviews.index');
    Route::get('reviews/create/{service}', [\App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews/{service}', [\App\Http\Controllers\ReviewController::class, 'storeTuteeReview'])->name('reviews.store');
});

// Tutor Reviews
Route::middleware(['auth'])->prefix('tutor')->name('tutor.')->group(function () {
    Route::get('reviews', [\App\Http\Controllers\ReviewController::class, 'tutorIndex'])->name('reviews.index');
    Route::post('reviews/respond/{review}', [\App\Http\Controllers\ReviewController::class, 'respond'])->name('reviews.respond');
});

// Admin Review Monitor
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewMonitorController::class, 'index'])->name('reviews.index');
});

// Order Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/services/{service}/order', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/services/{service}/order', [OrderController::class, 'store'])->name('orders.store');
});

