<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDF\HelperPdfMobilisasiFormController;
use App\Http\Controllers\Master\DashboardController;
use App\Http\Controllers\SmartPica\DashboarController;
use App\Http\Controllers\SmartPica\HelperController;
use App\Http\Controllers\SmartPica\TransactionPicaController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/helper-download-pdf/{docno}',  [HelperPdfMobilisasiFormController::class, 'DownloadPDFHelperPdf']);
Route::get('/landing-page-dashboard', [DashboardController::class, 'DashboardIndex']);


Route::get('/smart-pica', [DashboarController::class, 'IndexSmartPicaDashboard']);
Route::get('/add-smart-pica', [DashboarController::class, 'IndexFormAdd']);
Route::get('/add-step-smart-pica/{id}', [DashboarController::class, 'IndexFormStepPica']);

Route::POST('/helper-kpi-lead-datalist', [HelperController::class,'HelperSelect2PicaKPILead']);
Route::POST('/helper-week', [HelperController::class,'HelperSelectWeek']);
Route::POST('/helper-department', [HelperController::class,'HelperSelect2PicaKDept']);
Route::POST('/helper-karyawan', [HelperController::class,'HelperSelect2PicaKaryawanByDept']);

Route::POST('/add-transaction', [TransactionPicaController::class,'AddDataTransactionPica']);
Route::POST('/add-step-transaction', [TransactionPicaController::class,'addDataStepTransactionPica']);