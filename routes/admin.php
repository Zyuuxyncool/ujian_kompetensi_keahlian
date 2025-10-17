<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/admin', 'admin/dashboard')->name('admin');
Route::prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/user', App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::post('/user/search', [App\Http\Controllers\Admin\UserController::class, 'search'])->name('user.search');

    Route::resource('/categories', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::post('/categories/search', [App\Http\Controllers\Admin\CategoryController::class, 'search'])->name('categories.search');

    Route::resource('/category_sub', App\Http\Controllers\Admin\CategorySubController::class)->except(['show']);
    Route::post('/category_sub/search', [App\Http\Controllers\Admin\CategorySubController::class, 'search'])->name('category_sub.search');

    Route::resource('/brands', App\Http\Controllers\Admin\BrandController::class)->except(['show']);
    Route::post('/brands/search', [App\Http\Controllers\Admin\BrandController::class, 'search'])->name('brand.search');

});
