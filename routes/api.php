<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DocumentController,
    App\Http\Controllers\APIFallback,
    App\Http\Controllers\InterestController,
    App\Http\Controllers\Resources\ShowImageController
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

Route::fallback([APIFallback::class, 'index']);

Route::middleware('api')->group(function() {
    Route::post('/upload', [DocumentController::class, 'store'])->name('upload.file');
    Route::post('/interest', [InterestController::class, 'store'])->name('upload.interest');

// Route::get('/images', [ImageController::class, 'getData'])->name('images');
    Route::post('/show-image', [ShowImageController::class, 'store'])->name('upload.show.image');
    Route::get('/show-image', [ShowImageController::class, 'index'])->name('upload.show.get');
});
