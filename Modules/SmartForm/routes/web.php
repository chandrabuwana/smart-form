<?php

use App\Http\Middleware\FetchMenu;
use Illuminate\Support\Facades\Route;
use Modules\SmartForm\App\Http\Controllers\Admin\AdminController;
use Modules\SmartForm\App\Http\Controllers\Approval\ApprovalFormController;
use Modules\SmartForm\App\Http\Controllers\IC\ICFM05InduksiKaryawanController;
use Modules\SmartForm\App\Http\Controllers\IC\ICFM05TransactionController;
use Modules\SmartForm\App\Http\Controllers\Master\DashboardController;
use Modules\SmartForm\App\Http\Controllers\MasterData\MasterFormPICController;
use Modules\SmartForm\App\Http\Controllers\PDF\HelperPdfMobilisasiFormController;
use Modules\SmartForm\App\Http\Controllers\PLANT\PlantTransmissionController;
use Modules\SmartForm\App\Http\Controllers\Production\ProductionTimeSheetDashboarController;
use Modules\SmartForm\App\Http\Controllers\SHE\DashboardSHEFRM19BController;
use Modules\SmartForm\App\Http\Controllers\SHE\TransactionSHEFRM19BController;
use Modules\SmartForm\App\Http\Controllers\SM\AssetRequestController;
use Modules\SmartForm\App\Http\Controllers\SmartFormController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\DashboarController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\HelperController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\TransactionPicaController;
use Modules\SmartForm\App\Http\Controllers\TeamManagement\RoleManagementController;
use Modules\SmartForm\App\Http\Controllers\TeamManagement\UserManagementController;
use Modules\SmartForm\App\Http\Controllers\UnderCarriage\UnderCarriageInspectionController;

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

Route::group(['middleware' => ['check.auth', FetchMenu::class]], function () {
    Route::prefix('bss-form')->group(function () {
        Route::prefix('plant-transmission')->group(function () {
            Route::get('/dashboard', [PlantTransmissionController::class, 'dashboard'])->name('bss-form.plant-transmission.dashboard');
            Route::get('/dashboard/get-data', [PlantTransmissionController::class, 'getDashboardData'])->name('bss-form.plant-transmission.get-data-dashboard');
            Route::get('/dashboard/detail/{id}', [PlantTransmissionController::class, 'detail'])->name('bss-form.plant-transmission.detail');
            Route::get('/form', [PlantTransmissionController::class, 'form'])->name('bss-form.plant-transmission.form');
            Route::post('/form/store', [PlantTransmissionController::class, 'store'])->name('bss-form.plant-transmission.store');
        });

        Route::prefix('under-carriage')->group(function () {
            Route::get('/dashboard', [UnderCarriageInspectionController::class, 'dashboard'])->name('bss-form.undercarriage.dashboard');
            Route::get('/dashboard/get-data', [UnderCarriageInspectionController::class, 'getDashboardData'])->name('bss-form.undercarriage.get-data-dashboard');
            Route::get('/dashboard/detail/{id}', [UnderCarriageInspectionController::class, 'detail'])->name('bss-form.undercarriage.detail');
            Route::get('/form', [UnderCarriageInspectionController::class, 'form'])->name('bss-form.undercarriage.form');
            Route::post('/form/store', [UnderCarriageInspectionController::class, 'store'])->name('bss-form.undercarriage.store');
        });

        Route::prefix('sm')->group(function () {
            Route::get('/asset-request', [AssetRequestController::class, 'IndexForm'])->name("bss-form.sm.form-asset-request");
            Route::get('/edit-form-asset-request', [AssetRequestController::class, 'EditForm'])->name("bss-form.sm.edit-form-asset-request");
            Route::post('/submit-edit-asset-request', [AssetRequestController::class, 'SubmitEditForm'])->name("bss-form.sm.submit-edit-asset-request");
            Route::get('/dashboard', [AssetRequestController::class, 'DashboardForm'])->name("bss-form.sm.dashboard");
            Route::post('/add-asset-request', [AssetRequestController::class, 'SubmitFormAssetRequest'])->name("bss-form.sm.submit-asset-request");
            Route::get('/get-forms-data', [AssetRequestController::class, 'GetFormsData'])->name("bss-form.sm.get-form-data");
            Route::get('/get-form-detail', [AssetRequestController::class, 'FormDetailByNoDoc'])->name("bss-form.sm.form-detail-by-no-doc");
            Route::get('/asset-request-download/{fileName}', [AssetRequestController::class, 'download'])->name("bss-form.sm.asset-request-download");
            Route::post('/validasi-asset-request', [AssetRequestController::class, 'ValidasiRequest'])->name("bss-form.sm.validasi-asset-request");
        });

        Route::prefix('induksi-karyawan')->group(function () {
            Route::get('/dashboard', [ICFM05InduksiKaryawanController::class, 'IndexDashboard'])->name("bss-dahboard-ic-induksi-karyawan");
            Route::get('/form', [ICFM05InduksiKaryawanController::class, 'indexFormAddInduksiKaryawan'])->name("bss-form-ic-induksi-karyawan");
            Route::post('/form-add', [ICFM05TransactionController::class, 'SubmitALLData']);
            Route::post('/form-edit', [ICFM05TransactionController::class, 'SubmitALLDataEdit']);
            Route::post('/form-induksi', [ICFM05InduksiKaryawanController::class, 'dataListPertanyaan']);
            Route::post('/form-induksi-2', [ICFM05InduksiKaryawanController::class, 'dataListPertanyaan2']);
            Route::get('/lst-IC-form-induksi', [ICFM05TransactionController::class, 'helperDataListInduksiKaryawan']);
            Route::get('/lst-karyawan-induksi', [ICFM05TransactionController::class, 'helperDataListKaryawanInduksi']);
            Route::post('/helper-data-nik', [ICFM05TransactionController::class, 'HelperSelect2InduksiKaryawanByDept']);
            Route::get('/form-edit-view-IC-form-induksi/{d}', [ICFM05InduksiKaryawanController::class, 'IndexDetailEditViewFormInduksiKaryawan'])->name("bss-edit-view-form-ic-induksi-karyawan");
            Route::post('/generate-link', [ICFM05InduksiKaryawanController::class, 'GenerateLinkUrl']);
            Route::post('/activated-link', [ICFM05InduksiKaryawanController::class, 'ActivatedLink']);
            Route::post('/listing-karyawan-deleted', [ICFM05InduksiKaryawanController::class, 'formDeletedKaryawanListing']);
        });

        Route::prefix('she-019B')->group(function () {
            Route::get('/dashboard', [DashboardSHEFRM19BController::class, 'DashboardIndex'])->name("bss-form-she-019B");
            Route::get('/bss-form-she-019B-add-frm', [DashboardSHEFRM19BController::class, 'AddForm'])->name("add-bss-form-she-019B");
            Route::post('/store', [TransactionSHEFRM19BController::class, 'addDataPraCheckUp']);
            Route::get('/get-dashboard-data', [TransactionSHEFRM19BController::class, 'helperDataListSHE019B']);
            Route::post('/store-petugas-checker', [TransactionSHEFRM19BController::class, 'addDataCheckUpPetugas']);
        });

        Route::prefix('timesheet')->group(function () {
            Route::get('/dashboard', [ProductionTimeSheetDashboarController::class, 'IndexDashboard'])->name("bss-form-prod-timesheet");
            Route::get('/form', [ProductionTimeSheetDashboarController::class, 'GetFormsTimesheet'])->name("get-form-timesheet");
            Route::get('/detail', [ProductionTimeSheetDashboarController::class, 'GetFormTimesheetDetail'])->name("get-form-timesheet-detail");
            Route::get('/form-produksi', [ProductionTimeSheetDashboarController::class, 'FormTimesheetProduksi'])->name("form-timesheet-produksi");
            Route::post('/submit-form', [ProductionTimeSheetDashboarController::class, 'SubmitFormTimesheet'])->name("add-form-action");
        });
    });

    Route::get('/dashboard-menu', [AdminController::class, 'index'])->name('dashboard-menu');
    Route::get('/get-all-menu', [AdminController::class, 'GetAllMenu'])->name('get-all-menu');
    Route::post('/add-new-menu', [AdminController::class, 'AddNewMenu'])->name('add-new-menu');

    Route::prefix('helper')->group(function () {
        Route::post('/kpi-lead-datalist', [HelperController::class, 'HelperSelect2PicaKPILead']);
        Route::post('/week', [HelperController::class, 'HelperSelectWeek']);
        Route::post('/department', [HelperController::class, 'HelperSelect2PicaKDept']);
        Route::post('/karyawan', [HelperController::class, 'HelperSelect2PicaKaryawanByDept']);
        Route::get('/data-pica', [HelperController::class, 'HelperDataTablePica']);
        Route::get('/data-update-progress', [HelperController::class, 'HelperDataTableStepSolutionPica']);
        Route::get('/data-history-progress', [HelperController::class, 'HelperDataTableHistoryProgressPica']);
    });

    Route::prefix('role-management')->group(function () {
        Route::get('/dashboard', [RoleManagementController::class, 'dashboard'])->name('role-management.dashboard');
        Route::get('/dashboard/get-data', [RoleManagementController::class, 'getDashboardData'])->name('role-management.get-dashboard-data');
        Route::get('/create', [RoleManagementController::class, 'create'])->name('role-management.create');
        Route::post('/create/store', [RoleManagementController::class, 'store'])->name('role-management.store-create');
        Route::get('/edit/{id}', [RoleManagementController::class, 'edit'])->name('role-management.edit');
        Route::post('/edit/update/{id}', [RoleManagementController::class, 'update'])->name('role-management.store-edit');
        Route::get('/destroy/{id}', [RoleManagementController::class, 'destroy'])->name('role-management.destroy');
    });

    Route::prefix('user-management')->group(function () {
        Route::get('/dashboard', [UserManagementController::class, 'dashboard'])->name('user-management.dashboard');
        Route::get('/dashboard/get-data', [UserManagementController::class, 'getDashboardData'])->name('user-management.get-dashboard-data');
        Route::get('/create', [UserManagementController::class, 'create'])->name('user-management.create');
        Route::post('/create/store', [UserManagementController::class, 'store'])->name('user-management.store-create');
        Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('user-management.edit');
        Route::post('/edit/update/{id}', [UserManagementController::class, 'update'])->name('user-management.store-edit');
        Route::get('/destroy/{id}', [UserManagementController::class, 'destroy'])->name('user-management.destroy');
    });

    Route::prefix('master-form-pic')->group(function () {
        Route::get('/dashboard', [MasterFormPICController::class, 'dashboard'])->name('master-form-pic.dashboard');
        Route::get('/dashboard/get-data', [MasterFormPICController::class, 'getDashboardData'])->name('master-form-pic.get-dashboard-data');
        Route::get('/create', [MasterFormPICController::class, 'create'])->name('master-form-pic.create');
        Route::post('/create/store', [MasterFormPICController::class, 'store'])->name('master-form-pic.store-create');
        Route::get('/edit/{id}', [MasterFormPICController::class, 'edit'])->name('master-form-pic.edit');
        Route::post('/edit/update/{id}', [MasterFormPICController::class, 'update'])->name('master-form-pic.store-edit');
        Route::get('/destroy/{id}', [MasterFormPICController::class, 'destroy'])->name('master-form-pic.destroy');
    });

    Route::prefix('smart-pica')->group(function () {
        Route::get('/create', [DashboarController::class, 'IndexFormAdd'])->name("add-smart-pica");
        Route::get('/dashboard', [DashboarController::class, 'IndexSmartPicaDashboard'])->name("dashboard-smart-pica");
        Route::get('/update-progress', [DashboarController::class, 'IndexUpdateProgress'])->name(("dashboard-update-progress-smartpica"));
        Route::get('/create-step/{id}', [DashboarController::class, 'IndexFormStepPica']);
        Route::get('/view-data-detail-pica/{id}', [DashboarController::class, 'IndexViewDataDetailPica']);

        Route::post('/add-transaction', [TransactionPicaController::class, 'AddDataTransactionPica']);
        Route::post('/add-step-transaction', [TransactionPicaController::class, 'addDataStepTransactionPica']);
        Route::post('/add-progress-history-transaction', [TransactionPicaController::class, 'addTransactionProgressStepSolutionPica']);
    });

    Route::prefix('approval')->group(function () {
        Route::post('/form', [ApprovalFormController::class, 'approveForm'])->name('bss-approval-form');
    });

    Route::get('/', function () {
        return redirect(route('dashboard-smart-pica'));
    });

    Route::get('/landing-page-dashboard', [DashboardController::class, 'DashboardIndex']);
});

Route::get('/bss-form/induksi-karyawan/listing-karyawan/{data}', [ICFM05InduksiKaryawanController::class, 'indexFormAddKaryawanListing']);
Route::post('/bss-form/induksi-karyawan/listing-karyawan-add', [ICFM05InduksiKaryawanController::class, 'formAddKaryawanListing']);

Route::get('/helper-download-pdf/{docno}', [HelperPdfMobilisasiFormController::class, 'DownloadPDFHelperPdf']);
