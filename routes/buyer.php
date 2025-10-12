<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/buyer', 'buyer/landing')->name('buyer');
Route::prefix('/buyer')->name('buyer.')->group(function () {
    Route::get('/landing', [App\Http\Controllers\Buyer\LandingController::class, 'index'])->name('landing');

    Route::middleware(['auth'])->group(function () {
        Route::middleware(['buyer'])->group(function () {
        });

        Route::middleware(['perusahaan'])->group(function () {
            Route::name('profil.perusahaan.')->group(function () {

            });
        });

    });
});
