<?php

// header('Access-Control-Allow-Origin: http://127.0.0.1:3000');
// header('Access-Control-Allow-Headers: x-xsrf-token, x-requested-with, content-type, *');
// header('Access-Control-Allow-Credentials: true');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'auth'], function() {
    Route::post('login', [LoginController::class, 'index']);
    Route::post('register', [RegisterController::class, 'store']);
    Route::post('logout', [LoginController::class, 'logout']);

    Route::prefix('email')->group(function () {
        Route::get('verify/{id}', [VerificationController::class, 'verify'])->name("verification.verify");
        Route::post('resend', [VerificationController::class, 'resend'])->name("verification.resend");;
    });

    Route::prefix('password')->group(function () {
        Route::get('reset/{token}')->name('password.reset');
        Route::post('reset', [ForgotController::class, 'reset']);
        Route::post('forgot', [ForgotController::class, 'forgot']);
    });
});

Route::get('test', function(Request $request) {
    return 'test';
});