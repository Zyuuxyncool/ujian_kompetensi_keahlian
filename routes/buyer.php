<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/buyer', 'buyer/landing')->name('buyer');
Route::prefix('/buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
});
