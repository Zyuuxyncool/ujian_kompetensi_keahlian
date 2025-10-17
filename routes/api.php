<?php

use Illuminate\Support\Facades\Route;

Route::get('/lokasi/{parent_id?}', [App\Http\Controllers\API\LokasiController::class, 'index']);
