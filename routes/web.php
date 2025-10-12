<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])->group(__DIR__ . '/auth.php');
Route::middleware(['buyer'])->group(__DIR__ . '/buyer.php');
Route::middleware(['auth', 'io'])->group(__DIR__ . '/admin.php');
