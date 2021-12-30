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
    \App\Http\Controllers\Resources\GithubServerStatsController as GithubServerStatsResource

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
//Route::get('/twitch-users', [TwitchUserController::class, 'index'])->name('twitch');
Route::get('/user/settings', [UserSettings::class, 'index'])->name('user.settings');
Route::get('/server-stats', [ServerStatsController::class, 'index'])->name('server-stats');

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

    Route::post('/server-stats', [ServerStatsResource::class, 'store']);
    Route::get('/server-stats/{server_id}', [ServerStatsResource::class, 'index']);
    Route::post('/server-stats/{id}/github', [GithubServerStatsResource::class, 'store']);
    Route::delete('/server-stats/{server_id}/github/{id}', [GithubServerStatsResource::class, 'destroy']);
//    Route::resource('/twitch-users', TwitchUserControllerResources::class, [
//        'only' => ['index', 'update', 'destroy']
//    ]);

    //Route::post('/image-upload', [DocumentController::class, 'manual']);
});

if(config('app.env') !== 'production') {
    Route::domain('localhost')->group(function () {
        Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
    });
}

//Route::domain('cdn.ninjalabs.dev')->group(function () {
//    Route::get('/{slug}', [DocumentController::class, 'index'])->name('image');
//});
//
//Route::domain('i.ninjalabs.dev')->group(function () {
//    Route::get('/{slug}', [DocumentController::class, 'redirectToNew']);
//});
//

//Route::get('/test', [\App\Http\Controllers\TestingController::class, 'index']);
//Route::get('/stream', [TFMStreamController::class, 'index'])->name('stream.live');
//Route::get('/temp', [\App\Http\Controllers\Pages\DashboardController::class, 'temp']);
