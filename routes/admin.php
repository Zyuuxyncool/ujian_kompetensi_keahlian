<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/admin', 'admin/dashboard')->name('admin');
Route::prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/user', App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::post('/user/search', [App\Http\Controllers\Admin\UserController::class, 'search'])->name('user.search');

    Route::resource('/categories', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::post('/categories/search', [App\Http\Controllers\Admin\CategoryController::class, 'search'])->name('categories.search');
});
