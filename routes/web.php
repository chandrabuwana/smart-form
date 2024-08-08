<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\PDF\HelperPdfMobilisasiFormController;
use App\Http\Controllers\Master\DashboardController;
use App\Http\Controllers\SmartPica\DashboarController;
use App\Http\Controllers\SmartPica\HelperController;
use App\Http\Controllers\SmartPica\TransactionPicaController;
use App\Http\Controllers\Login\LoginKaryawanController;
use App\Http\Controllers\SM\AssetRequestController;


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
Route::get('/helper-download-pdf/{docno}', [HelperPdfMobilisasiFormController::class, 'DownloadPDFHelperPdf']);
Route::group(['middleware' => ['check.auth']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/landing-page-dashboard', [DashboardController::class, 'DashboardIndex']);

    Route::get('/add-smart-pica', [DashboarController::class, 'IndexFormAdd'])->name("add-smart-pica");

    Route::get('/smart-pica', [DashboarController::class, 'IndexSmartPicaDashboard'])->name("dashboard-smart-pica");
    Route::get('/update-progress', [DashboarController::class, 'IndexUpdateProgress'])->name(("dashboard-update-progress-smartpica"));
    Route::get('/add-step-smart-pica/{id}', [DashboarController::class, 'IndexFormStepPica']);
    Route::get('/view-data-detail-pica/{id}', [DashboarController::class, 'IndexViewDataDetailPica']);

    Route::get('/asset-request', [AssetRequestController::class, 'IndexForm'])->name("form-asset-request");
    Route::get('/dashboard-form-sm', [AssetRequestController::class, 'DashboardForm'])->name("dashboard-form-sm");
    Route::post('/add-asset-request', [AssetRequestController::class, 'SubmitFormAssetRequest'])->name("submit-asset-request");
    Route::get('/get-forms-data', [AssetRequestController::class, 'GetFormsData'])->name("get-form-data");
    Route::get('/get-form-detail', [AssetRequestController::class, 'FormDetailByNoDoc'])->name("form-detail-by-no-doc");

    Route::POST('/helper-kpi-lead-datalist', [HelperController::class, 'HelperSelect2PicaKPILead']);
    Route::POST('/helper-week', [HelperController::class, 'HelperSelectWeek']);
    Route::POST('/helper-department', [HelperController::class, 'HelperSelect2PicaKDept']);
    Route::POST('/helper-karyawan', [HelperController::class, 'HelperSelect2PicaKaryawanByDept']);
    Route::GET('/helper-data-pica', [HelperController::class, 'HelperDataTablePica']);
    Route::GET('/helper-data-update-progress', [HelperController::class, 'HelperDataTableStepSolutionPica']);
    Route::GET('/helper-data-history-progress', [HelperController::class, 'HelperDataTableHistoryProgressPica']);


    Route::POST('/add-transaction', [TransactionPicaController::class, 'AddDataTransactionPica']);
    Route::POST('/add-step-transaction', [TransactionPicaController::class, 'addDataStepTransactionPica']);
    Route::POST('/add-progress-history-transaction', [TransactionPicaController::class, 'addTransactionProgressStepSolutionPica']);

});

Route::get('/login', [LoginKaryawanController::class, 'IndexLoginKaryawan']);
Route::post('/login', [LoginKaryawanController::class, 'ProcessLogin'])->name("login");
Route::get('/logout', [LoginKaryawanController::class, 'LogoutAuthenticationProcess'])->name("logout");

