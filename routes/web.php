<?php

use App\Http\Controllers\absensi\CompareAbsensiController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Approval\ApprovalFormController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\PDF\HelperPdfMobilisasiFormController;
use App\Http\Controllers\Master\DashboardController;
use App\Http\Controllers\SmartPica\DashboarController;
use App\Http\Controllers\SmartPica\HelperController;
use App\Http\Controllers\SmartPica\TransactionPicaController;
use App\Http\Controllers\Login\LoginKaryawanController;
use App\Http\Controllers\SM\AssetRequestController;


use App\Http\Controllers\SHE\DashboardSHEFRM19BController;
use App\Http\Controllers\SHE\TransactionSHEFRM19BController;


use App\Http\Controllers\Production\ProductionTimeSheetDashboarController;

use App\Http\Controllers\IC\ICFM05InduksiKaryawanController;
use App\Http\Controllers\IC\ICFM05TransactionController;
use App\Http\Controllers\MasterData\MasterFormPICController;
use App\Http\Controllers\TeamManagement\RoleManagementController;
use App\Http\Controllers\TeamManagement\UserManagementController;
use App\Http\Controllers\UnderCarriage\UnderCarriageInspectionController;
use App\Http\Middleware\FetchMenu;
use Modules\SmartForm\App\Http\Controllers\PLANT\PlantTransmissionController;

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
