<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RefundController;
// use App\Http\Controllers\FinancialController;
use App\Http\Controllers\TutorDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\SessionController;
use App\Models\Content;

// Guest landing page
Route::get('/', function () {
    $contents = Content::where('is_active', true)->latest()->take(6)->get();
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome', compact('contents'));
})->name('welcome');

// Authentication Routes
require __DIR__ . '/auth.php';

// Basic authenticated route
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment Routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::post('/payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');

    // Refund Routes
    Route::get('/payments/{payment}/refund', [RefundController::class, 'create'])->name('refunds.create');
    Route::post('/payments/{payment}/refund', [RefundController::class, 'store'])->name('refunds.store');

    // Tutor Dashboard Route
    Route::get('/tutor/dashboard', [TutorDashboardController::class, 'index'])->name('tutor.dashboard');

    // Service Routes
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/services/manage', [ServiceController::class, 'manage'])->name('services.manage');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Session Management for Tutors
    Route::get('/sessions/manage', [SessionController::class, 'index'])->name('sessions.manage');
    Route::get('/sessions/create', [SessionController::class, 'create'])->name('sessions.create');
    Route::post('/sessions', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/sessions/{session}/edit', [SessionController::class, 'edit'])->name('sessions.edit');
    Route::put('/sessions/{session}', [SessionController::class, 'update'])->name('sessions.update');
    Route::delete('/sessions/{session}', [SessionController::class, 'destroy'])->name('sessions.destroy');
});

// Public Content Routes (accessible to all)
Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
Route::get('/contents/{content}', [ContentController::class, 'show'])->name('contents.show');
Route::get('/contents/{content}/report', [ContentController::class, 'reportForm'])->name('contents.report');
Route::post('/contents/{content}/report', [ContentController::class, 'reportSubmit'])->name('contents.report.submit');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    // Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show', 'create', 'store']);

    // Admin Category Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Admin Financial Routes
    // Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
    // Route::post('/financial/report', [FinancialController::class, 'generateReport'])->name('financial.report');
    // Route::get('/financial/report/{report}/export', [FinancialController::class, 'exportReport'])->name('financial.export');
    
    // Refund Management
    Route::post('/refunds/{refund}/approve', [RefundController::class, 'approve'])->name('refunds.approve');
    Route::post('/refunds/{refund}/reject', [RefundController::class, 'reject'])->name('refunds.reject');

    // Admin Content Management
    Route::resource('contents', AdminContentController::class);
    Route::get('reported-contents', [AdminContentController::class, 'reportedIndex'])->name('contents.reported');
    Route::get('reported-contents/{report}', [AdminContentController::class, 'reviewReport'])->name('contents.review_report');
    Route::post('reported-contents/{report}/resolve', [AdminContentController::class, 'resolveReport'])->name('contents.resolve_report');
    Route::post('reported-contents/{report}/reject', [AdminContentController::class, 'rejectReport'])->name('contents.reject_report');
});

// Tutee Reviews
Route::middleware(['auth'])->prefix('tutee')->name('tutee.')->group(function () {
    Route::get('reviews', [\App\Http\Controllers\ReviewController::class, 'tuteeIndex'])->name('reviews.index');
    Route::get('reviews/create/{service}', [\App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews/{service}', [\App\Http\Controllers\ReviewController::class, 'storeTuteeReview'])->name('reviews.store');
    Route::get('reviews/edit/{review}', [\App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::delete('reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::put('reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
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
