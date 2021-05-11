<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DocumentController,
    App\Http\Controllers\APIFallback,
    App\Http\Controllers\Resources\CustomController
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
});
