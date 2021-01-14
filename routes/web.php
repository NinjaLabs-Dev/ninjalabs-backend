<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Pages\LoginController,
    \App\Http\Controllers\Pages\DashboardController,
    App\Http\Controllers\DocumentController
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
Route::get('/temp', function(){
    return view('pages.temp');
})->name('temp');

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
