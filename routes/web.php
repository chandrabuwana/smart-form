<?php

use App\Http\Controllers\absensi\CompareAbsensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginKaryawanController;
use App\Http\Controllers\REVA\produksi\RevaProduksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [LoginKaryawanController::class, 'IndexLoginKaryawan']);
Route::post('/login', [LoginKaryawanController::class, 'ProcessLogin'])->name("login");
Route::get('/logout', [LoginKaryawanController::class, 'LogoutAuthenticationProcess'])->name("logout");
Route::get('/absensi', [CompareAbsensiController::class, 'Absensi'])->name('absensi');
Route::get('/compare-absensi', [CompareAbsensiController::class, 'CompareAbsensi'])->name('compare-absensi');

Route::prefix('reva')->group( function(){
    Route::get('produksi', [RevaProduksiController::class, 'index']);
    Route::get('api/ob', [RevaProduksiController::class, 'getOB']);
    Route::get('api/const', [RevaProduksiController::class, 'getConstraint']);
    Route::get('api/event', [RevaProduksiController::class, 'getEvent']);
});
