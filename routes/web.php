<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Pages\LoginController,
    App\Http\Controllers\Pages\DashboardController,
    App\Http\Controllers\DocumentController,
    \App\Http\Controllers\Pages\CustomController,
    \App\Http\Controllers\Resources\CustomController as CustomControllerResource,
    \App\Http\Controllers\Pages\DBBackupController,
    \App\Http\Controllers\Resources\TwitchUserController as TwitchUserControllerResources,
    \App\Http\Controllers\pages\TwitchUserController,
    \App\Http\Controllers\Pages\UserSettings,
    \App\Http\Controllers\APITokenController,
    \App\Http\Controllers\UserPasswordController
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
Route::get('/customs', [CustomController::class, 'index'])->name('custom.urls');
Route::get('/backups', [DBBackupController::class, 'index'])->name('backups');
Route::get('/backups/{id}', [DBBackupController::class, 'download']);
Route::get('/twitch-users', [TwitchUserController::class, 'index'])->name('twitch');
//Route::get('/stream', [TFMStreamController::class, 'index'])->name('stream.live');
Route::get('/user/settings', [UserSettings::class, 'index'])->name('user.settings');

//Route::get('/temp', [\App\Http\Controllers\Pages\DashboardController::class, 'temp']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('image')->group(function() {
    Route::get('/update/{id}/{public}', [DashboardController::class, 'update'])->name('image.update');
    Route::get('/url/{id}', [DashboardController::class, 'getPrivateURL'])->name('image.url');
    Route::get('/delete/{id}', [DashboardController::class, 'destroy'])->name('image.delete');
    Route::get('/{slug}', [DocumentController::class, 'index']);
});

//Route::domain('cdn.ninjalabs.dev')->group(function () {
//    Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
//});
//
//Route::domain('i.ninjalabs.dev')->group(function () {
//    Route::get('/{slug}', [DocumentController::class, 'redirectToNew']);
//});
//
Route::domain('{domain}')->group(function() {
    Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
});

Route::prefix('api')->group(function() {
    Route::resource('/custom-images', CustomControllerResource::class, [
        'only' => ['index', 'store', 'destroy']
    ])->names('customs');
    Route::resource('/user/token', APITokenController::class, [
        'only' => ['index', 'store', 'destroy']
    ]);
    Route::resource('/user/password', UserPasswordController::class, [
        'only' => 'store'
    ]);
//    Route::resource('/twitch-users', TwitchUserControllerResources::class, [
//        'only' => ['index', 'update', 'destroy']
//    ]);
});

if(config('app.env') !== 'production') {
    Route::domain('localhost')->group(function () {
        Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
    });
}
