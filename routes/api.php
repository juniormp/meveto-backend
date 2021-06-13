<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Encryption\EncryptionController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
});

Route::prefix('encryption')->group(function () {
    Route::get('getServerKey', [EncryptionController::class, 'findServerKey']);
    Route::post('storeSecret', [EncryptionController::class, 'storeSecretData']);
});

Route::get('foo', [\App\Http\Controllers\TestController::class, 'foo']);
