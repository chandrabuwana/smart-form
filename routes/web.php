<?php

use App\Http\Controllers\admin\AdminController;
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
use App\Http\Controllers\UnderCarriage\UnderCarriageInspectionController;
use App\Http\Middleware\FetchMenu;

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
Route::group(['middleware' => ['check.auth', FetchMenu::class]], function () {
    Route::get('/', function () {
        return redirect(route('dashboard-smart-pica'));
    });

    Route::get('/landing-page-dashboard', [DashboardController::class, 'DashboardIndex']);

    Route::get('/add-smart-pica', [DashboarController::class, 'IndexFormAdd'])->name("add-smart-pica");

    Route::get('/smart-pica', [DashboarController::class, 'IndexSmartPicaDashboard'])->name("dashboard-smart-pica");
    Route::get('/update-progress', [DashboarController::class, 'IndexUpdateProgress'])->name(("dashboard-update-progress-smartpica"));
    Route::get('/add-step-smart-pica/{id}', [DashboarController::class, 'IndexFormStepPica']);
    Route::get('/view-data-detail-pica/{id}', [DashboarController::class, 'IndexViewDataDetailPica']);

    Route::get('/asset-request', [AssetRequestController::class, 'IndexForm'])->name("form-asset-request");
    Route::get('/edit-form-asset-request', [AssetRequestController::class, 'EditForm'])->name("edit-form-asset-request");
    Route::post('/submit-edit-asset-request', [AssetRequestController::class, 'SubmitEditForm'])->name("submit-edit-asset-request");
    Route::get('/dashboard-form-sm', [AssetRequestController::class, 'DashboardForm'])->name("dashboard-form-sm");
    Route::post('/add-asset-request', [AssetRequestController::class, 'SubmitFormAssetRequest'])->name("submit-asset-request");
    Route::get('/get-forms-data', [AssetRequestController::class, 'GetFormsData'])->name("get-form-data");
    Route::get('/get-form-detail', [AssetRequestController::class, 'FormDetailByNoDoc'])->name("form-detail-by-no-doc");
    Route::get('/asset-request-download/{fileName}', [AssetRequestController::class, 'download'])->name("asset-request-download");
    Route::post('/validasi-asset-request', [AssetRequestController::class, 'ValidasiRequest'])->name("validasi-asset-request");

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



    Route::get('/bss-form-prod-timesheet', [ProductionTimeSheetDashboarController::class, 'IndexDashboard'])->name("bss-form-prod-timesheet");
    Route::get('/get-forms-timesheet', [ProductionTimeSheetDashboarController::class, 'GetFormsTimesheet'])->name("get-form-timesheet");
    Route::get('/get-forms-timesheet-detail', [ProductionTimeSheetDashboarController::class, 'GetFormTimesheetDetail'])->name("get-form-timesheet-detail");
    Route::get('/add-form-timesheet', [ProductionTimeSheetDashboarController::class, 'FormTimesheetProduksi'])->name("form-timesheet-produksi");
    Route::post('/submit-form-timesheet', [ProductionTimeSheetDashboarController::class, 'SubmitFormTimesheet'])->name("add-form-action");


    Route::get('/bss-dashboard-IC-form-induksi', [ICFM05InduksiKaryawanController::class, 'IndexDashboard'])->name("bss-dahboard-ic-induksi-karyawan");
    Route::get('/bss-form-IC-form-induksi', [ICFM05InduksiKaryawanController::class, 'indexFormAddInduksiKaryawan'])->name("bss-form-ic-induksi-karyawan");
    Route::post('/bss-form-IC-form-induksi-add', [ICFM05TransactionController::class, 'SubmitALLData']);
    Route::post('/bss-form-IC-form-induksi-edit', [ICFM05TransactionController::class, 'SubmitALLDataEdit']);
    Route::post('/bss-ref-IC-form-induksi', [ICFM05InduksiKaryawanController::class, 'dataListPertanyaan']);
    Route::post('/bss-ref-IC-form-induksi-2', [ICFM05InduksiKaryawanController::class, 'dataListPertanyaan2']);
    Route::get('/bss-lst-IC-form-induksi', [ICFM05TransactionController::class, 'helperDataListInduksiKaryawan']);
    Route::get('/bss-form-edit-view-IC-form-induksi/{d}', [ICFM05InduksiKaryawanController::class, 'IndexDetailEditViewFormInduksiKaryawan'])->name("bss-edit-view-form-ic-induksi-karyawan");

    Route::get('/dashboard-plant', [PlantTransmissionController::class, 'dashboard'])->name('dashboard-form-plant');
    Route::get('/dashboard-plant/get-data', [PlantTransmissionController::class, 'getDashboardData'])->name('dashboard-plant-get-data');
    Route::get('/dashboard-plant/detail/{id}', [PlantTransmissionController::class, 'detail'])->name('detail-data-form-plant');
    Route::get('/bss-form-plant-transmission-test', [PlantTransmissionController::class, 'index'])->name('bss-form-plant-transmission');
    Route::post('/bss-form-plant-transmission-test/store', [PlantTransmissionController::class, 'store']);

    Route::get('/dashboard-undercarriage-inspection', [UnderCarriageInspectionController::class, 'dashboard'])->name('dashboard-undercarriage-inspection');
    Route::get('/dashboard-undercarriage-inspection/get-data', [UnderCarriageInspectionController::class, 'getDashboardData'])->name('dashboard-undercarriage-inspection-get-data');
    Route::get('/dashboard-undercarriage-inspection/detail/{id}', [UnderCarriageInspectionController::class, 'detail'])->name('detail-data-undercarriage-inspection');
    Route::get('/bss-form-undercarriage-inspection', [UnderCarriageInspectionController::class, 'form'])->name('form-undercarriage-inspection');
    Route::post('/bss-form-undercarriage-inspection/store', [UnderCarriageInspectionController::class, 'store'])->name('store-undercarriage-inspection');


    Route::get('/dashboard-menu', [AdminController::class, 'index'])->name('dashboard-menu');
    Route::get('/get-all-menu', [AdminController::class, 'GetAllMenu'])->name('get-all-menu');
    Route::post('/add-new-menu', [AdminController::class, 'AddNewMenu'])->name('add-new-menu');
});

Route::get('/login', [LoginKaryawanController::class, 'IndexLoginKaryawan']);
Route::post('/login', [LoginKaryawanController::class, 'ProcessLogin'])->name("login");
Route::get('/logout', [LoginKaryawanController::class, 'LogoutAuthenticationProcess'])->name("logout");
