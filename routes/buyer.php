<?php

use Illuminate\Support\Facades\Route;

// Landing page publik
Route::get('/', [App\Http\Controllers\Buyer\LandingController::class, 'index'])->name('landing');

// Redirect /buyer ke landing
Route::redirect('/buyer', '/buyer/landing')->name('buyer');

// Route /buyer/landing publik
Route::get('/buyer/landing', [App\Http\Controllers\Buyer\LandingController::class, 'index'])->name('buyer.landing');
Route::get('/buyer/landing/category/{uuid}', [App\Http\Controllers\Buyer\LandingController::class, 'showCategory'])->name('buyer.landing.category.index');
Route::get('/search/autocomplete', [App\Http\Controllers\Buyer\SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/search/results', [App\Http\Controllers\Buyer\SearchController::class, 'index'])->name('search.results');

// Group route buyer yang butuh login
Route::prefix('/buyer')->middleware(['auth'])->name('buyer.')->group(function () {
    Route::get('/profil', [App\Http\Controllers\Buyer\ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil', [App\Http\Controllers\Buyer\ProfilController::class, 'update'])->name('profil.update');
    Route::get('/seller', [App\Http\Controllers\Buyer\SellerController::class, 'index'])->name('seller.index');
    Route::get('/seller/verify', [App\Http\Controllers\Buyer\SellerController::class, 'verify'])->name('seller.verify');
    Route::post('/seller/verify/store', [App\Http\Controllers\Buyer\SellerController::class, 'store'])->name('seller.verify.store');
    Route::get('/seller/informasi_toko', [App\Http\Controllers\Buyer\SellerController::class, 'informasiToko'])->name('seller.informasi_toko');
    Route::post('/seller/informasi_toko/store', [App\Http\Controllers\Buyer\SellerController::class, 'storeInformasiToko'])->name('seller.informasi_toko.store');
    Route::get('/upload_produk', [App\Http\Controllers\Buyer\SellerController::class, 'uploadProduk'])->name('seller.upload_produk');
    Route::post('/upload_produk/store', [App\Http\Controllers\Buyer\SellerController::class, 'storeUploadProduk'])->name('seller.upload_produk.store');
    // route lain yang butuh login
});
