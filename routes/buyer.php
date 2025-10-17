<?php

use Illuminate\Support\Facades\Route;

// Landing page publik
Route::get('/', [App\Http\Controllers\Buyer\LandingController::class, 'index'])->name('landing');

// Redirect /buyer ke landing
Route::redirect('/buyer', '/buyer/landing')->name('buyer');

// Route /buyer/landing publik
Route::get('/buyer/landing', [App\Http\Controllers\Buyer\LandingController::class, 'index'])->name('buyer.landing');
Route::get('/buyer/landing/category/{uuid}', [App\Http\Controllers\Buyer\LandingController::class, 'showCategory'])->name('buyer.landing.category.index');


// Group route buyer yang butuh login
Route::prefix('/buyer')->middleware(['auth'])->name('buyer.')->group(function () {
    Route::get('/profil', [App\Http\Controllers\Buyer\ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil', [App\Http\Controllers\Buyer\ProfilController::class, 'update'])->name('profil.update');
    Route::get('/seller', [App\Http\Controllers\Buyer\SellerController::class, 'index'])->name('seller.index');
    Route::get('/seller/verify', [App\Http\Controllers\Buyer\SellerController::class, 'verify'])->name('seller.verify');
    Route::post('/seller/verify/store', [App\Http\Controllers\Buyer\SellerController::class, 'store'])->name('seller.verify.store');
    // route lain yang butuh login
});
