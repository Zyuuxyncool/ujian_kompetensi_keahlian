<?php
use App\Http\Controllers\Buyer\LandingController;
use Illuminate\Support\Facades\Route;

// Landing page publik
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Redirect /buyer ke landing
Route::redirect('/buyer', '/buyer/landing')->name('buyer');

// Route /buyer/landing publik
Route::get('/buyer/landing', [LandingController::class, 'index'])->name('buyer.landing');

// Group route buyer yang butuh login
Route::prefix('/buyer')->middleware(['buyer'])->name('buyer.')->group(function () {
    // Route::get('/dashboard', [App\Http\Controllers\Buyer\DashboardController::class, 'index'])->name('dashboard');
    // route lain yang butuh login
});
