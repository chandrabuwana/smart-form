<?php

use App\Http\Middleware\FetchMenu;
use App\Http\Middleware\PermissionMenu;
use Illuminate\Support\Facades\Route;
use Modules\DokumenMutu\App\Http\Controllers\DocoController;
use Modules\DokumenMutu\App\Http\Controllers\DokumenMutuController;
use Modules\DokumenMutu\App\Http\Controllers\FormDocoController;
use Modules\DokumenMutu\App\Http\Controllers\ValidasiDocoController;

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

Route::middleware([ FetchMenu::class, 'check.auth', PermissionMenu::class ])->prefix('doco')->group( function() {
    Route::prefix('form-pengajuan')->group( function() {
        Route::get('/', [FormDocoController::class, 'formPengajuan'])->name('form-pengajuan.index');
        Route::post('/store', [FormDocoController::class, 'storeFormPengajuan'])->name('form-pengajuan.store');
    });

    Route::get('/detail', [FormDocoController::class, 'detailDoco'])->name('dokumen-mutu.detail');

    Route::prefix('riwayat-pengajuan')->group( function() {
        Route::get('/', [DocoController::class, 'riwayat'])->name('dokumen-mutu.riwayat-pengajuan');
        Route::get('/fetch-data', [DocoController::class, 'fetchRiwayat'])->name('dokumen-mutu.riwayat-pengajuan.fetch');
        Route::get('/detail/{id}', [DocoController::class, 'detailRiwayat'])->name('dokumen-mutu.detail-riwayat');
        Route::post('/revisi', [FormDocoController::class, 'submitRevisiPengajuan'])->name('dokumen-mutu.revisi.store');

        Route::post('/validasi-penghapusan', [ValidasiDocoController::class, 'validPenghapusan'])->name('dokumen-mutu.validasi.penghapusan');

        Route::prefix('validasi/{id}')->group( function() {
            Route::get('/', [ValidasiDocoController::class, 'index'])->name('dokumen-mutu.validasi.index');
            Route::get('/reject', [ValidasiDocoController::class, 'reject'])->name('dokumen-mutu.validasi.reject');
            Route::get('/feedbacks', [ValidasiDocoController::class, 'getFeedback'])->name('dokumen-mutu.validasi.get-feedbacks');
            Route::post('/approved', [ValidasiDocoController::class, 'approved'])->name('dokumen-mutu.validasi.approved');
            Route::post('/add-komentar', [ValidasiDocoController::class, 'storeKomentar'])->name('dokumen-mutu.validasi.store-komentar');
        });
    });

    Route::prefix('nomor-induk')->group( function() {
        Route::get('/', [DocoController::class, 'indexNomorInduk'])->name('dokumen-mutu.nomor-induk-dokumen');
        Route::get('/fetch-data', [DocoController::class, 'fetchNomorInduk'])->name('dokumen-mutu.nomor-induk-dokumen.fetch');
        Route::get('/detail', [DocoController::class, 'detailNomorInduk'])->name('dokumen-mutu.nomor-induk-dokumen.detail');
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
