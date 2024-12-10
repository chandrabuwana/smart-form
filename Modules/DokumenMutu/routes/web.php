<?php

use App\Http\Middleware\FetchMenu;
use Illuminate\Support\Facades\Route;
use Modules\DokumenMutu\App\Http\Controllers\DocoController;
use Modules\DokumenMutu\App\Http\Controllers\DokumenMutuController;
use Modules\DokumenMutu\App\Http\Controllers\FormDocoController;

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

Route::middleware([ FetchMenu::class, 'check.auth' ])->prefix('doco')->group( function() {
    Route::prefix('form-pengajuan')->group( function() {
        Route::get('/', [FormDocoController::class, 'formPengajuan'])->name('form-pengajuan.index');
        Route::post('/store', [FormDocoController::class, 'storeFormPengajuan'])->name('form-pengajuan.store');
    });

    Route::get('/detail', [FormDocoController::class, 'detailDoco'])->name('dokumen-mutu.detail');

    Route::prefix('riwayat-pengajuan')->group( function() {
        Route::get('/', [DocoController::class, 'riwayat'])->name('dokumen-mutu.riwayat-pengajuan');
        Route::get('/fetch-data', [DocoController::class, 'fetchRiwayat'])->name('dokumen-mutu.riwayat-pengajuan.fetch');
    });

    Route::prefix('nomor-induk')->group( function() {
        Route::get('/', [DocoController::class, 'indexNomorInduk'])->name('dokumen-mutu.nomor-induk-dokumen');
        Route::get('/fetch-data', [DocoController::class, 'fetchNomorInduk'])->name('dokumen-mutu.nomor-induk-dokumen.fetch');
    });

    Route::prefix('form-revisi')->group( function() {
        Route::get('/', [FormDocoController::class, 'formRevisi'])->name('form-revisi.index');
        Route::post('/store', [FormDocoController::class, 'storeFormRevisi'])->name('form-revisi.store');
    });

    Route::prefix('form-penghapusan')->group( function() {
        Route::get('/', [FormDocoController::class, 'formPenghapusan'])->name('form-penghapusan.index');
        Route::post('/store', [FormDocoController::class, 'storeFormPenghapusan'])->name('form-penghapusan.store');
    });
});
