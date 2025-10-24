<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::redirect('/seller', 'seller/dashboard')->name('seller');
Route::prefix('/seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('/products', App\Http\Controllers\Seller\ProductController::class)->except(['show']);
    Route::post('/products/search', [App\Http\Controllers\Seller\ProductController::class, 'search'])->name('user.search');

    Route::get('/profil', [App\Http\Controllers\Seller\ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil', [App\Http\Controllers\Seller\ProfilController::class, 'update'])->name('profil.update');
});
