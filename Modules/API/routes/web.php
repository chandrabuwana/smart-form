<?php

use App\Http\Middleware\JwtAuth;
use Illuminate\Support\Facades\Route;
use Modules\API\App\Http\Controllers\Invoice\InvoiceMobileController;
use Modules\API\App\Http\Controllers\Login\CateringController;
use Modules\API\App\Http\Controllers\Login\MobileLoginController;
use Modules\API\App\Http\Controllers\Order\OrderMobileController;
use Modules\API\App\Http\Controllers\User\SettingsMobileController;
use Modules\API\App\Http\Controllers\User\UserMobileController;

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

Route::prefix('api/v1')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::group(['middleware' => [JwtAuth::class]], function () {
            Route::get('/logout', [MobileLoginController::class, 'logout'])->name('logout-mobile');
        });

        Route::post('/login', [MobileLoginController::class, 'login'])->name('login-mobile');
    });

    Route::prefix('user')->group(function () {

        Route::group(['middleware' => [JwtAuth::class]], function () {
            Route::post('/profile', [UserMobileController::class, 'GetUser'])->name('user-profile');

            Route::post('/update-fcm-token', [UserMobileController::class, 'UpdateFcmToken'])->name('update-fcm-token');
        });
    });

    Route::prefix('catering')->group(function () {

        Route::group(['middleware' => [JwtAuth::class]], function () {
            Route::get('/history', [CateringController::class, 'history'])->name('history-order');
            Route::post('/request-order', [CateringController::class, 'RequestOrder'])->name('request-order');
        });
    });

    Route::prefix('vendor')->middleware([JwtAuth::class])->group( function() {

        Route::prefix('user')->group( function() {
            Route::get('/profile', [UserMobileController::class, 'GetUserVendor'])->name('user-profile-vendor');

            Route::prefix('settings')->group( function() {
                Route::post('/account', [SettingsMobileController::class, 'UpdateAccount'])->name('settings-account-vendor');
                Route::post('/password', [SettingsMobileController::class, 'UpdatePassword'])->name('settings-password-vendor');
            });
        });

        Route::prefix('invoice')->group( function() {
            Route::get('/', [InvoiceMobileController::class, 'index'])->name('invoice-vendor');
            Route::get('/statistics', [InvoiceMobileController::class, 'statistics'])->name('invoice-vendor-statistics');
            Route::post('/store', [InvoiceMobileController::class, 'store'])->name('invoice-vendor-store');
            Route::post('/detail', [InvoiceMobileController::class, 'detail'])->name('invoice-vendor-detail');
        });

        Route::prefix('order')->group( function() {
            Route::get('/', [OrderMobileController::class, 'index'])->name('order-vendor');
            Route::get('/detail/{id}', [OrderMobileController::class, 'detail'])->name('order-vendor-detail');
            Route::post('/change-status', [OrderMobileController::class, 'changeStatus'])->name('order-vendor-change-status');
        });
    });
});
