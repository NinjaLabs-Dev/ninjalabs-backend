<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Pages\LoginController,
    App\Http\Controllers\Pages\DashboardController,
    App\Http\Controllers\DocumentController,
    App\Http\Controllers\Pages\InterestController
    ;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/interests', [InterestController::class, 'index'])->name('interest.overview');
Route::get('/interests/{id}', [InterestController::class, 'delete'])->name('interest.delete');

//Route::get('/temp', [\App\Http\Controllers\Pages\DashboardController::class, 'temp']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::prefix('image')->group(function() {
    Route::get('/update/{id}/{public}', [DashboardController::class, 'update'])->name('image.update');
    Route::get('/url/{id}', [DashboardController::class, 'getPrivateURL'])->name('image.url');
    Route::get('/delete/{id}', [DashboardController::class, 'destroy'])->name('image.delete');
});

Route::domain('cdn.ninjalabs.dev')->group(function () {
    Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
});

Route::domain('i.ninjalabs.dev')->group(function () {
    Route::get('/{slug}', [DocumentController::class, 'redirectToNew'])->name('image');
});
