<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Pages\DashboardController;

Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
