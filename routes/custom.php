<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DocumentController;

Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
