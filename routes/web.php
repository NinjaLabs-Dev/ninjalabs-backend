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
    \App\Http\Controllers\UserPasswordController,
    \App\Models\Domain,
    \App\Http\Controllers\Pages\ServerStatsController,
    \App\Http\Controllers\Resources\ServerStatsController as ServerStatsResource,
    \App\Http\Controllers\Resources\GithubServerStatsController as GithubServerStatsResource,
    \App\Http\Controllers\FireworkController
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
Route::get('/user/settings', [UserSettings::class, 'index'])->name('user.settings');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('image')->group(function() {
    Route::get('/update/{id}/{public}', [DashboardController::class, 'update'])->name('image.update');
    Route::get('/url/{id}', [DashboardController::class, 'getPrivateURL'])->name('image.url');
    Route::get('/delete/{id}', [DashboardController::class, 'destroy'])->name('image.delete');
    Route::get('/{slug}', [DocumentController::class, 'index']);
});

$domains = Domain::getDomainList();

foreach ($domains as $domain) {
    Route::domain($domain)->group(function() {
        Route::get('/{slug}', [DocumentController::class, 'index']);
    });
}

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
});

if(config('app.env') !== 'production') {
    Route::domain('localhost')->group(function () {
        Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
    });
}
