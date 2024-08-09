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


use App\Http\Controllers\SHE\DashboardSHEFRM19BController;
use App\Http\Controllers\SHE\TransactionSHEFRM19BController;


use App\Http\Controllers\Production\ProductionTimeSheetDashboarController;

use App\Http\Controllers\IC\ICFM05InduksiKaryawanController;
use App\Http\Controllers\IC\ICFM05TransactionController;
use App\Http\Controllers\PLANT\PlantTransmissionController;

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



    Route::get('/bss-form-she-019B', [DashboardSHEFRM19BController::class, 'DashboardIndex'])->name("bss-form-she-019B");
    Route::get('/bss-form-she-019B-add-frm', [DashboardSHEFRM19BController::class, 'AddForm'])->name("add-bss-form-she-019B");
    Route::POST('/add-bss-form-she-019B', [TransactionSHEFRM19BController::class, 'addDataPraCheckUp']);
    Route::GET('/lst-bss-form-she-019B', [TransactionSHEFRM19BController::class, 'helperDataListSHE019B']);
    Route::POST('/add-bss-form-she-019B-petugas-checker', [TransactionSHEFRM19BController::class, 'addDataCheckUpPetugas']);



    Route::get('/bss-form-prod-timeheet', [ProductionTimeSheetDashboarController::class, 'IndexDashboard'])->name("bss-form-prod-timesheet");


    Route::get('/bss-form-IC-form-induksi', [ICFM05InduksiKaryawanController::class, 'IndexDashboard'])->name("bss-form-ic-induksi-karyawan");
    Route::post('/bss-form-IC-form-induksi-add', [ICFM05TransactionController::class, 'SubmitALLData']);
    Route::post('/bss-ref-IC-form-induksi', [ICFM05InduksiKaryawanController::class, 'dataListPertanyaan']);

    Route::get('/bss-form-plant-transmission-test', [PlantTransmissionController::class, 'index'])->name('bss-form-plant-transmission');
    Route::post('/bss-form-plant-transmission-test/store', [PlantTransmissionController::class, 'store']);
});

Route::get('/login', [LoginKaryawanController::class, 'IndexLoginKaryawan']);
Route::post('/login', [LoginKaryawanController::class, 'ProcessLogin'])->name("login");
Route::get('/logout', [LoginKaryawanController::class, 'LogoutAuthenticationProcess'])->name("logout");

