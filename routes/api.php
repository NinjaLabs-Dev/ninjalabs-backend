<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DocumentController,
    App\Http\Controllers\APIFallback,
    App\Http\Controllers\Pages\DashboardController,
    App\Http\Controllers\ImageController,
    App\Http\Controllers\InterestController
    ;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::put('/upload', [DocumentController::class, 'store'])->name('upload.file');
Route::put('/interest', [InterestController::class, 'store'])->name('upload.interest');

// Route::get('/images', [ImageController::class, 'getData'])->name('images');

Route::fallback([APIFallback::class, 'index']);
