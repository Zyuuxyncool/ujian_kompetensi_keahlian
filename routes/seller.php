<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/seller', 'seller/dashboard')->name('seller');
Route::prefix('/seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('dashboard');

});
