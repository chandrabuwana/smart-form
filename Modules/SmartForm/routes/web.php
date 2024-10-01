<?php

// use App\Http\Controllers\GS\SmartCateringController;
use App\Http\Middleware\FetchMenu;
use App\Http\Middleware\PermissionMenu;
use Illuminate\Support\Facades\Route;
use Modules\SmartForm\App\Http\Controllers\Admin\AdminController;
use Modules\SmartForm\App\Http\Controllers\Approval\ApprovalFormController;
use Modules\SmartForm\App\Http\Controllers\GS\MessController;
use Modules\SmartForm\App\Http\Controllers\GS\SmartCateringController;
use Modules\SmartForm\App\Http\Controllers\GS\VendorController;
use Modules\SmartForm\App\Http\Controllers\IC\ICFM05InduksiKaryawanController;
use Modules\SmartForm\App\Http\Controllers\IC\ICFM05TransactionController;
use Modules\SmartForm\App\Http\Controllers\Master\DashboardController;
use Modules\SmartForm\App\Http\Controllers\MasterData\MasterFormPICController;
use Modules\SmartForm\App\Http\Controllers\PDF\HelperPdfMobilisasiFormController;
use Modules\SmartForm\App\Http\Controllers\PLANT\PlantTransmissionController;
use Modules\SmartForm\App\Http\Controllers\Production\ProductionTimeSheetDashboarController;
use Modules\SmartForm\App\Http\Controllers\SHE\DashboardSHEFRM19BController;
use Modules\SmartForm\App\Http\Controllers\SHE\TransactionSHEFRM19BController;
use Modules\SmartForm\App\Http\Controllers\SKL\DashboardSKLController;
use Modules\SmartForm\App\Http\Controllers\SKL\SKLFormController;
use Modules\SmartForm\App\Http\Controllers\SM\AssetRequestController;
use Modules\SmartForm\App\Http\Controllers\SmartFormController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\DashboarController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\HelperController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\MappingValidationController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\SectionDepartmentController;
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

Route::group(['middleware' => ['check.auth', FetchMenu::class, PermissionMenu::class]], function () {
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
            Route::post('/delete-induksi', [ICFM05TransactionController::class, 'DeletedInduksiKaryawan']);
            Route::post('/listing-karyawan-deleted', [ICFM05InduksiKaryawanController::class, 'formDeletedKaryawanListing']);
            Route::post('/check-nik-pdf', [ICFM05InduksiKaryawanController::class, 'checkNIKPDF']);
            Route::get('/download-pdf/{id}', [ICFM05InduksiKaryawanController::class, 'downloadPDF']);
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
            Route::get('/search-karyawan', [ProductionTimeSheetDashboarController::class, 'SearchKaryawan'])->name("search-karyawan");
            Route::post('/submit-action-pengawas', [ProductionTimeSheetDashboarController::class, 'ActionPengawasTimesheet'])->name("search-karyawan");
            // Route::get('/add-pemesanan-catering', [SmartCateringController::class, 'AddPemesanan'])->name('add-pemesanan-catering');
            // Route::post('/generate-detail-pemesanan-catering', [SmartCateringController::class, 'GenerateDetailPemesanan'])->name('generate-detail-pemesanan-catering');
        });

        Route::prefix('catering')->group( function() {
            Route::get('/pemesanan', [SmartCateringController::class, 'AddPemesanan'])->name('add-pemesanan-catering');
            Route::get('/dashboard-pemesanan', [SmartCateringController::class, 'DashboardPemesanan'])->name('dashboard-pemesanan-catering');
            Route::get('/detail-pemesanan', [SmartCateringController::class, 'DetailPemesanan'])->name('detail-pemesanan-catering');
            Route::get('/list-pemesanan', [SmartCateringController::class, 'GetListPemesanan'])->name('list-pemesanan');
            Route::post('/generate-detail', [SmartCateringController::class, 'GenerateDetailPemesanan'])->name('generate-detail-pemesanan-catering');
            Route::post('/order', [SmartCateringController::class, 'SubmitPesanMakan'])->name('submit-makan');

            Route::prefix('mess')->group( function() {
                Route::post('/add-mess', [MessController::class, 'AddMess'])->name('add-mess');
                Route::post('/add-kamar', [MessController::class, 'AddKamar'])->name('add-kamar');
                Route::post('/add-penghuni', [MessController::class, 'AddPenghuniMess'])->name('add-penghuni');
                Route::put('/edit-penghuni', [MessController::class, 'EditPenghuniMess'])->name('edit-penghuni');
                Route::put('/edit-kamar', [MessController::class, 'EditKamar'])->name('edit-kamar');
                Route::post('/delete-kamar', [MessController::class, 'Deletekamar'])->name('delete-kamar');
                Route::post('/delete-penghuni-mess', [MessController::class, 'DeletePenghuniMess'])->name('delete-penghuni-mess');
                Route::get('/dashboard', [MessController::class, 'DashboardMess'])->name('dashboard-mess');
                Route::get('/dashboard-huni', [MessController::class, 'DashboardHuni'])->name('dashboard-penghuni');
                Route::get('/dashboard-kamar', [MessController::class, 'DashboardKamar'])->name('dashboard-penghuni');
                // Route::get('/detail-huni', [MessController::class, 'DashboardHuni'])->name('detail-huni-mess');
                Route::get('/list-mess', [MessController::class, 'GetListMess'])->name('list-mess');
                Route::get('/list-huni', [MessController::class, 'GetListHuni'])->name('list-huni');
                Route::get('/list-kamar', [MessController::class, 'GetListKamar'])->name('list-kamar');
                Route::get('/helper-mess', [MessController::class, 'HelperMess'])->name('helper-mess');
                Route::get('/helper-kamar', [MessController::class, 'HelperKamar'])->name('helper-kamar');

            });

            Route::prefix('vendor')->group( function() {
                Route::get('/helper-vendor', [VendorController::class, 'HelperVendor'])->name('helper-vendor');
                Route::get('/helper-lokasi', [VendorController::class, 'HelperLokasi'])->name('helper-lokasi');
                Route::get('/dashboard-vendor', [VendorController::class, 'DashboardVendor'])->name('dashboard-vendor');
                Route::get('/list-vendor', [VendorController::class, 'ListVendor'])->name('list-vendor');
                Route::post('/add-vendor', [VendorController::class, 'AddVendor'])->name('add-vendor');
                Route::post('/add-mapping-vendor', [VendorController::class, 'AddMappingVendor'])->name('add-mapping-vendor');
                Route::put('/edit-vendor', [VendorController::class, 'EditVendor'])->name('edit-vendor');
                Route::put('/edit-mapping-vendor', [VendorController::class, 'EditMappingVendor'])->name('edit-mapping-vendor');
                Route::delete('/delete-vendor', [VendorController::class, 'DeleteVendor'])->name('delete-vendor');
                Route::delete('/delete-mapping-vendor', [VendorController::class, 'DeleteMappingVendor'])->name('delete-mapping-vendor');
                Route::get('/dashboard-vendor-mapping', [VendorController::class, 'DashboardVendorMappingCatering'])->name('dashboard-vendor-mapping-catering');
                Route::get('/list-vendor-mapping', [VendorController::class, 'ListVendorMappingCatering'])->name('list-vendor-mapping');
            });
        });
    });

    Route::get('/dashboard-menu', [AdminController::class, 'index'])->name('dashboard-menu');
    Route::get('/get-all-menu', [AdminController::class, 'GetAllMenu'])->name('get-all-menu');
    Route::post('/add-new-menu', [AdminController::class, 'AddNewMenu'])->name('add-new-menu');
    Route::put('/edit-menu', [AdminController::class, 'EditMenu'])->name('edit-menu');
    Route::delete('/delete-menu', [AdminController::class, 'DeleteMenu'])->name('delete-menu');
    
    Route::get('/dashboard-level-user', [MappingValidationController::class, 'IndexLevelUser']);
    Route::get('/list-level-user', [MappingValidationController::class, 'GetListLevelUser']);
    Route::post('/add-level-user', [MappingValidationController::class, 'AddLevelUser']);
    Route::put('/edit-level-user', [MappingValidationController::class, 'EditLevelUser']);
    Route::delete('/delete-level-user', [MappingValidationController::class, 'DeleteLevelUser']);
    
    Route::get('/dashboard-level-mapping', [MappingValidationController::class, 'IndexlevelMapping']);
    Route::get('/list-level-mapping', [MappingValidationController::class, 'GetListLevelMapping']);
    Route::post('/add-level-mapping', [MappingValidationController::class, 'AddLevelMapping']);
    Route::put('/edit-level-mapping', [MappingValidationController::class, 'EditLevelMapping']);
    Route::delete('/delete-level-mapping', [MappingValidationController::class, 'DeleteLevelMapping']);
    
    Route::get('/dashboard-section-department', [SectionDepartmentController::class, 'IndexSectionDepartment']);
    Route::get('/list-section-department', [SectionDepartmentController::class, 'GetListSectionDepartment']);
    Route::post('/add-section-department', [SectionDepartmentController::class, 'AddSectionDept']);
    Route::put('/edit-section-department', [SectionDepartmentController::class, 'EditSectionDept']);
    Route::delete('/delete-section-department', [SectionDepartmentController::class, 'DeleteSectionDept']);

    Route::prefix('helper')->group(function () {
        Route::post('/kpi-lead-datalist', [HelperController::class, 'HelperSelect2PicaKPILead']);
        Route::post('/week', [HelperController::class, 'HelperSelectWeek']);
        Route::post('/site', [HelperController::class, 'HelperSelect2PicaKSite']);
        Route::post('/department', [HelperController::class, 'HelperSelect2PicaKDept']);
        Route::post('/karyawan', [HelperController::class, 'HelperSelect2PicaKaryawanByDept']);
        Route::get('/data-pica', [HelperController::class, 'HelperDataTablePica']);
        Route::get('/data-update-progress', [HelperController::class, 'HelperDataTableStepSolutionPica']);
        Route::get('/data-history-progress', [HelperController::class, 'HelperDataTableHistoryProgressPica']);
        Route::get('/data-approvement-step-pica', [HelperController::class, 'HelperDataTableApprovementStepPica']);
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
        Route::get('/approvement-pica', [DashboarController::class, 'IndexApprovementProgress']);

        Route::post('/add-transaction', [TransactionPicaController::class, 'AddDataTransactionPica']);
        Route::post('/add-step-transaction', [TransactionPicaController::class, 'addDataStepTransactionPica']);
        Route::post('/add-progress-history-transaction', [TransactionPicaController::class, 'addTransactionProgressStepSolutionPica']);
        Route::post('/change-acceptance', [TransactionPicaController::class, 'changeAcceptanceStepSolutionPica']);
        Route::post('/approve-task-closing', [TransactionPicaController::class, 'ApproveClosingTask']);
        
    });

    Route::prefix('skl')->group( function() {
        Route::get('/dashboard', [DashboardSKLController::class, 'dashboard'])->name('bss-skl.dashboard');
        Route::get('/dashboard/get-data', [DashboardSKLController::class, 'getDashboardData'])->name('bss-skl.dashboard-get-data');
        Route::get('/form', [SKLFormController::class, 'create'])->name('bss-skl.create');
        Route::post('/store', [SKLFormController::class, 'store'])->name('bss-skl.store');
        Route::get('/get-karyawan', [SKLFormController::class, 'getKaryawan'])->name('bss-skl.get-karyawan');
        Route::get('/get-kategori-pekerjaan', [SKLFormController::class, 'getKategoriPekerjaan'])->name('bss-skl.get-kategori-pekerjaan');
        Route::get('/get-approver', [SKLFormController::class, 'getApprover'])->name('bss-skl.get-approver');
        Route::get('/detail', [DashboardSKLController::class, 'detail'])->name('bss-skl.detail');
        Route::post('/approval', [DashboardSKLController::class, 'storeApproval'])->name('bss-skl.store-approval');
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
// Route::get('/dashboard-pemesanan', [SmartCateringController::class, 'DashboardPemesanan'])->name('dashboard-pemesanan-catering');
