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
use Modules\SmartForm\App\Http\Controllers\PLANT\CompressorPompaController;
use Modules\SmartForm\App\Http\Controllers\PLANT\PlantWeldingController;
use Modules\SmartForm\App\Http\Controllers\Production\ProductionTimeSheetDashboarController;
use Modules\SmartForm\App\Http\Controllers\Production\AnakAsuhController;
use Modules\SmartForm\App\Http\Controllers\SHE\DashboardSHEFRM19BController;
use Modules\SmartForm\App\Http\Controllers\SHE\TransactionSHEFRM19BController;
use Modules\SmartForm\App\Http\Controllers\SHE\EyewashController;
use Modules\SmartForm\App\Http\Controllers\SHE\AparController;
use Modules\SmartForm\App\Http\Controllers\SHE\InspeksiCateringController;
use Modules\SmartForm\App\Http\Controllers\SHE\P3KController;
use Modules\SmartForm\App\Http\Controllers\SHE\AirMinumController;
use Modules\SmartForm\App\Http\Controllers\SHE\NoiseController;
use Modules\SmartForm\App\Http\Controllers\SHE\SheMessController;
use Modules\SmartForm\App\Http\Controllers\SHE\CoalGettingController;
use Modules\SmartForm\App\Http\Controllers\SKL\DashboardSKLController;
use Modules\SmartForm\App\Http\Controllers\SKL\SKLFormController;
use Modules\SmartForm\App\Http\Controllers\SM\AssetRequestController;
use Modules\SmartForm\App\Http\Controllers\SM\RegistrasiSupplierController;
use Modules\SmartForm\App\Http\Controllers\LOG\CheckOgcComController;
use Modules\SmartForm\App\Http\Controllers\LOG\LogController;
use Modules\SmartForm\App\Http\Controllers\SmartFormController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\DashboarController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\HelperController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\MappingValidationController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\SectionDepartmentController;
use Modules\SmartForm\App\Http\Controllers\SmartPica\TransactionPicaController;
use Modules\SmartForm\App\Http\Controllers\TeamManagement\RoleManagementController;
use Modules\SmartForm\App\Http\Controllers\TeamManagement\UserManagementController;
use Modules\SmartForm\App\Http\Controllers\UnderCarriage\UnderCarriageInspectionController;
use Modules\SmartForm\App\Http\Controllers\FAT\PPH\PPHDashboardController;
use Modules\SmartForm\App\Http\Controllers\FAT\PPH\HelperPPHController;
use Modules\SmartForm\App\Http\Controllers\IT\PrinterFormController;
use Modules\SmartForm\App\Http\Controllers\IT\CctvFormController;
use Modules\SmartForm\App\Http\Controllers\IT\DeviceFormController;
use Modules\SmartForm\App\Http\Controllers\IT\RouterFormController;
use Modules\SmartForm\App\Http\Controllers\PLANT\GeneralInspection\InspectionCmtController;

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
            Route::get('/download-report', [PlantTransmissionController::class, 'downloadReport'])->name('bss-form.plant-transmission.download');
        });

        // LOG BNP
        Route::prefix('log')->group(function () {

            // REQUEST MASTER MENU
            Route::get('/request-master', [LogController::class, 'RequestMasterDashboard'])->name('bss-form.log.request-master.dashboard');
            Route::get('/list', [LogController::class, 'GetListRequestMaster'])->name("bss-form.log.list-request-master");
            Route::get('/form-req-master', [LogController::class, 'formReqMaster'])->name('bss-form.log.form-req-master');
            Route::post('/add-request-master', [LogController::class, 'SubmitFormRequestMaster'])->name("bss-form.log.add-request-master");
            Route::get('/pdf-req-master/{id}', [LogController::class, 'PdfReqMaster'])->name('bss-form.log.pdf-req-master');

            // PERMINTAAN PENGISIAN FUEL
            Route::get('/request-fuel', [LogController::class, 'FuelDashboard'])->name('bss-form.log.fuel.dashboard');
            Route::get('/list-fuel', [LogController::class, 'GetListRequestFuel'])->name("bss-form.log.list-fuel");
            Route::get('/form-fuel', [LogController::class, 'FormFuel'])->name('bss-form.log.form-fuel');
            Route::post('/create-fuel', [LogController::class, 'CreateReqFuel'])->name('bss-form.log.create-req-fuel');
            Route::get('/edit-fuel/{id}', [LogController::class, 'editReqFuel'])->name('bss-form.log.edit-req-fuel');
            Route::post('/update-fuel/{id}', [LogController::class, 'updateReqFuel'])->name('bss-form.log.update-req-fuel');
            Route::get('/delete-fuel/{id}', [LogController::class, 'DeleteReqFuel'])->name('bss-form.log.delete-fuel');
            Route::get('/pdf-fuel/{id}', [LogController::class, 'PdfReqFuel'])->name('bss-form.log.pdf-fuel');

            // PENGELUARAN OIL, GREASE & COOLANT MENU
            Route::get('/pengeluaran-oli', [LogController::class, 'PengeluaranOliDashboard'])->name('bss-form.log.pengeluaran-oli.dashboard');
            Route::get('/list-pengeluaran-oli', [LogController::class, 'GetListPengeluaranOli'])->name("bss-form.log.list-pengeluaran-oli");
            Route::get('/form-pengeluaran-oli', [LogController::class, 'formPengeluaranOli'])->name('bss-form.log.form-pengeluaran-oli');
            Route::post('/add-pengeluaran-oli', [LogController::class, 'SubmitFormPengeluaranOli'])->name("bss-form.log.add-pengeluaran-oli");
            Route::get('/pdf-pengeluaran-oli/{id}', [LogController::class, 'PdfPengeluaranOli'])->name('bss-form.log.pdf-pengeluaran-oli');

            // PEMAKAIAN SOLAR
            Route::get('/pemakaian-solar', [LogController::class, 'PemakaianSolarDashboard'])->name('bss-form.log.pemakaian-solar.dashboard');
            Route::get('/list-pemakaian-solar', [LogController::class, 'GetListPemakaianSolar'])->name("bss-form.log.list-pemakaian-solar");
            Route::get('/form-pemakaian-solar', [LogController::class, 'formPemakaianSolar'])->name('bss-form.log.form-pemakaian-solar');
            Route::post('/add-pemakaian-solar', [LogController::class, 'SubmitFormPemakaianSolar'])->name("bss-form.log.add-pemakaian-solar");
            Route::get('/pdf-pemakaian-solar/{id}', [LogController::class, 'PdfPemakaianSolar'])->name('bss-form.log.pdf-pemakaian-solar');

            // CHECK OGC COMPLIANCE
            Route::get('/check-ogc-compliance', [CheckOgcComController::class, 'CheckOgcCompDashboard'])->name('bss-form.log.check-ogc-comp.dashboard');
            Route::get('/list-check-ogc', [CheckOgcComController::class, 'GetListCheckOgc'])->name("bss-form.log.list-check-ogc");
            Route::get('/form-check-ogc', [CheckOgcComController::class, 'formCheckOgc'])->name('bss-form.log.form-check-ogc');
        });

        Route::prefix('under-carriage')->group(function () {
            Route::get('/dashboard', [UnderCarriageInspectionController::class, 'dashboard'])->name('bss-form.undercarriage.dashboard');
            Route::get('/dashboard/get-data', [UnderCarriageInspectionController::class, 'getDashboardData'])->name('bss-form.undercarriage.get-data-dashboard');
            Route::get('/dashboard/detail/{id}', [UnderCarriageInspectionController::class, 'detail'])->name('bss-form.undercarriage.detail');
            Route::get('/form', [UnderCarriageInspectionController::class, 'form'])->name('bss-form.undercarriage.form');
            Route::post('/form/store', [UnderCarriageInspectionController::class, 'store'])->name('bss-form.undercarriage.store');
            Route::get('/download-report', [UnderCarriageInspectionController::class, 'downloadReport'])->name('bss-form.undercarriage.download');
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

            // REGISTRASI SUPPLIER
            Route::get('/registrasi-supplier', [RegistrasiSupplierController::class, 'RegisSupplierDashboard'])->name("bss-form.sm.registrasi-supplier");
            Route::get('/list-supplier', [RegistrasiSupplierController::class, 'GetListRegistrasiSupplier'])->name("bss-form.sm.list-supplier");
            Route::get('/form-registrasi-supplier', [RegistrasiSupplierController::class, 'FormRegistrasiSupplier'])->name('bss-form.sm.form-registrasi-supplier');
            Route::post('/create-registrasi-supplier', [RegistrasiSupplierController::class, 'CreateRegisSupplier'])->name('bss-form.sm.create-registrasi-supplier');
            Route::get('/edit-registrasi-supplier/{id}', [RegistrasiSupplierController::class, 'editRegisSupplier'])->name('bss-form.sm.edit-registrasi-supplier');
            Route::post('/update-fuel/{id}', [RegistrasiSupplierController::class, 'updateReqFuel'])->name('bss-form.sm.update-req-fuel');
            Route::get('/delete-supplier/{id}', [RegistrasiSupplierController::class, 'DeleteSupplier'])->name('bss-form.sm.delete-supplier');
            Route::get('/pdf-registrasi-supplier/{id}', [RegistrasiSupplierController::class, 'PdfRegSupplier'])->name('bss-form.sm.pdf-registrasi-supplier');
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

        Route::prefix('fat')->group(function () {
            Route::prefix('pph')->group(function () {
                Route::get('/dashboard', [PPHDashboardController::class, 'DashboardIndex'])->name("bss-dahboard-fat-pph-dashboard");
                Route::get('/add-data-upload', [PPHDashboardController::class, 'AddDatadIndex'])->name("bss-dahboard-fat-pph-add");
                Route::get('/lst-fat-doc-list-uploaded', [HelperPPHController::class, 'helperDataListHasilUploadDocument']);
                Route::get('/lst-fat-doc-list-master', [HelperPPHController::class, 'helperDataListMasterUploadDocumentPPH']);
                Route::post('/process-data-upload', [PPHDashboardController::class, 'ProcessZIPUpload']);
                Route::post('/hapus-document-potongan', [HelperPPHController::class, 'HapusDocumentPotonganPPH']);
                Route::post('/update-document-potongan', [HelperPPHController::class, 'UpdateDocumentPotonganPPH']);
                Route::get('/view-detail-master-potongan-pph/{id}', [PPHDashboardController::class, 'indexViewDataDetailMasterPPh']);
            });
        });

        Route::prefix('she-019B')->group(function () {
            Route::get('/dashboard', [DashboardSHEFRM19BController::class, 'DashboardIndex'])->name("bss-form-she-019B");
            Route::get('/bss-form-she-019B-add-frm', [DashboardSHEFRM19BController::class, 'AddForm'])->name("add-bss-form-she-019B");
            Route::post('/store', [TransactionSHEFRM19BController::class, 'addDataPraCheckUp']);
            Route::get('/get-dashboard-data', [TransactionSHEFRM19BController::class, 'helperDataListSHE019B']);
            Route::post('/store-petugas-checker', [TransactionSHEFRM19BController::class, 'addDataCheckUpPetugas']);

			// INSPEKSI APAR
            Route::get('/inspeksi-apar', [AparController::class, 'inspeksiAparDashboard'])->name('bss-form.she-019B.inspeksi-apar.dashboard');
            Route::get('/list-inspeksi-apar', [AparController::class, 'GetListInspeksiApar'])->name("bss-form.she-019B.list-inspeksi-apar");
            Route::get('/form-inspeksi-apar', [AparController::class, 'formInspeksiApar'])->name('bss-form.she-019B.form-inspeksi-apar');
            Route::post('/add-inspeksi-apar', [AparController::class, 'SubmitFormInspeksiApar'])->name("bss-form.she-019B.add-inspeksi-apar");
            Route::get('/pdf-inspeksi-apar/{id}', [AparController::class, 'PdfInspeksiApar'])->name('bss-form.log.pdf-inspeksi-apar');

            // INSPEKSI CATERING
            Route::get('/inspeksi-catering', [InspeksiCateringController::class, 'InspeksiCateringDashboard'])->name('bss-form.she-048.inspeksi-catering.dashboard');
            Route::get('/list-inspeksi-catering', [InspeksiCateringController::class, 'GetListInspeksiCatering'])->name("bss-form.she-048.list-inspeksi-catering");
            Route::get('/form-inspeksi-catering', [InspeksiCateringController::class, 'FormInspeksiCatering'])->name('bss-form.she-019B.form-inspeksi-catering');
            Route::post('/create-inspeksi-catering', [InspeksiCateringController::class, 'CreateInspeksiCatering'])->name('bss-form.she-019B.create-inspeksi-catering');
            Route::get('/edit-fuel/{id}', [LogController::class, 'editReqFuel'])->name('bss-form.log.edit-req-fuel');
            Route::post('/update-fuel/{id}', [LogController::class, 'updateReqFuel'])->name('bss-form.log.update-req-fuel');
            Route::get('/delete-inspeksi-catering/{id}', [InspeksiCateringController::class, 'DeleteInspeksiCatering'])->name('bss-form.she-019B.delete-inspeksi-catering');
            Route::get('/pdf-inspeksi-catering/{id}', [InspeksiCateringController::class, 'PdfInspeksiCatering'])->name('bss-form.she-019B.pdf-inspeksi-catering');
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

        Route::prefix('catering')->group(function () {
            Route::get('/pemesanan', [SmartCateringController::class, 'AddPemesanan'])->name('add-pemesanan-catering');
            Route::get('/dashboard-pemesanan', [SmartCateringController::class, 'DashboardPemesanan'])->name('dashboard-pemesanan-catering');
            Route::get('/detail-pemesanan', [SmartCateringController::class, 'DetailPemesanan'])->name('detail-pemesanan-catering');
            Route::get('/list-pemesanan', [SmartCateringController::class, 'GetListPemesanan'])->name('list-pemesanan');
            Route::get('/list-pemesanan-lokasi', [SmartCateringController::class, 'GetListPemesananPerLokasi'])->name('list-pemesanan-lokasi');
            Route::get('/list-pemesanan-per-vendor', [SmartCateringController::class, 'GetListPemesananPerVendor'])->name('list-pemesanan-per-vendor');
            Route::post('/generate-detail', [SmartCateringController::class, 'GenerateDetailPemesanan'])->name('generate-detail-pemesanan-catering');
            Route::post('/order', [SmartCateringController::class, 'SubmitPesanMakan'])->name('submit-makan');
            Route::put('/update-status-pemesanan', [SmartCateringController::class, 'UpdateStatusPemesanan'])->name('update-status-pemesanan');
            Route::put('/update-status-pemesanan-vendor', [SmartCateringController::class, 'UpdateStatusPemesananVendor'])->name('update-status-pemesanan-vendor');
            Route::post('/helper-site', [SmartCateringController::class, 'HelperSite']);
            Route::get('/dashboard/download-report', [SmartCateringController::class, 'generateReport'])->name('dashboard.download-report');

            Route::get('/import-mapping-gs', [SmartCateringController::class, 'viewImportMappingGS'])->name('view-import-mapping-gs-catering');
            Route::post('/import-mapping-gs/store', [SmartCateringController::class, 'importMappingGS'])->name('import-mapping-gs-catering');

            Route::prefix('mess')->group(function () {
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

            Route::prefix('vendor')->group(function () {
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
                Route::get('/helper-vendor-waktu-lokasi', [VendorController::class, 'HelperVendorByLokasiAndWaktu'])->name('helper-vendor-waktu-lokasi');
                Route::post('/add-mapping-vendor-day', [VendorController::class, 'AddMappingVendorDay'])->name('add-mapping-vendor-day');
                Route::put('/edit-mapping-vendor-day', [VendorController::class, 'EditMappingVendorDay'])->name('edit-mapping-vendor-day');
                Route::get('/list-vendor-mapping-day', [VendorController::class, 'ListVendorMappingCateringDay'])->name('list-vendor-mapping-day');
                Route::delete('/delete-mapping-vendor-day', [VendorController::class, 'DeleteMappingVendorDay'])->name('delete-mapping-vendor-day');
                Route::post('toggle-mapping-day', [VendorController::class, 'toggleMappingDayStatus'])->name('toggle-mapping-day');
            });
        });

        Route::prefix('it-ops')->group(function () {
            // PRINTER
            Route::get('/dashboard-printer', [PrinterFormController::class, 'IndexPrinterForm'])->name('it-ops.dashboard-printer');
            Route::get('/form-printer/{id}/export-pdf', [PrinterFormController::class, 'ExportPrinter'])->name('it-ops.form-printer.export');
            Route::post('/submit-printer', [PrinterFormController::class, 'SubmitPrinterForm'])->name('it-ops.submit-printer');
            Route::get('/form-printer', [PrinterFormController::class, 'CreatePrinterForm'])->name('it-ops.form-printer');
            // CCTV
            Route::get('/dashboard-cctv', [CctvFormController::class, 'IndexCctvForm'])->name('it-ops.dashboard-cctv');
            Route::get('/form-cctv', [CctvFormController::class, 'CreateCctvForm'])->name('it-ops.form-cctv');
            Route::post('/submit-cctv', [CctvFormController::class, 'SubmitCctvForm'])->name('it-ops.submit-cctv');
            Route::get('/form-cctv/{id}/export-pdf', [CctvFormController::class, 'ExportCctv'])->name('it-ops.form-cctv.export');
            // DEVICE
            Route::get('/dashboard-device', [DeviceFormController::class, 'IndexDeviceForm'])->name('it-ops.dashboard-device');
            Route::get('/form-device', [DeviceFormController::class, 'CreateDeviceForm'])->name('it-ops.form-device');
            Route::post('/submit-device', [DeviceFormController::class, 'SubmitDeviceForm'])->name('it-ops.submit-device');
            Route::get('/form-device/{id}/export-pdf', [DeviceFormController::class, 'ExportDevice'])->name('it-ops.form-device.export');
            // ROUTER
            Route::get('/dashboard-router', [RouterFormController::class, 'Dashboard'])->name('it-ops.dashboard-router');
            Route::get('/form-router', [RouterFormController::class, 'CreateRouterForm'])->name('it-ops.form-router');
            Route::post('/submit-router', [RouterFormController::class, 'SubmitRouterForm'])->name('it-ops.submit-router');
            Route::get('/form-router/{id}/export-pdf', [RouterFormController::class, 'ExportRouter'])->name('it-ops.form-router.export');
        });

        Route::prefix('she-inspeksi')->group(function () {
            Route::get('/dashboard', [EyewashController::class, 'Dashboard'])->name('she-inspeksi.dashboard');
            Route::get('/form/export/{id}', [EyewashController::class, 'ExportForm'])->name('she-inspeksi.form.export');
            Route::get('/form', [EyewashController::class, 'AddForm'])->name('she-inspeksi.form');
            Route::post('/store', [EyewashController::class, 'Store'])->name('she-inspeksi.submit');
            Route::put('/form/{id}', [EyewashController::class, 'Update'])->name('she-inspeksi.form.update');
        });

        Route::prefix('she-p3k')->group(function () {
            Route::get('/dashboard', [P3KController::class, 'Dashboard'])->name('she-p3k.dashboard');
            Route::get('/form/export/{id}', [P3KController::class, 'ExportForm'])->name('she-p3k.export');
            Route::get('/form', [P3KController::class, 'AddForm'])->name('she-p3k.form');
            Route::post('/store', [P3KController::class, 'Store'])->name('she-p3k.submit');
            Route::put('/form/{id}', [P3KController::class, 'Update'])->name('she-p3k.form.update');
        });

        Route::prefix('she-air-minum')->group(function () {
            Route::get('/dashboard', [AirMinumController::class, 'Dashboard'])->name('she.air-minum.dashboard');
            Route::get('/form/export/{id}', [AirMinumController::class, 'ExportForm'])->name('she.air-minum.export');
            Route::get('/form', [AirMinumController::class, 'AddForm'])->name('she.air-minum.form');
            Route::post('/store', [AirMinumController::class, 'Store'])->name('she.air-minum.store');
            Route::put('/form/{id}', [AirMinumController::class, 'Update'])->name('she.air-minum.form.update');
        });

        Route::prefix('she-noise')->group(function () {
            Route::get('/dashboard', [NoiseController::class, 'Dashboard'])->name('she.noise.dashboard');
            Route::get('/form/export/{id}', [NoiseController::class, 'ExportForm'])->name('she.noise.export');
            Route::get('/form', [NoiseController::class, 'AddForm'])->name('she.noise.form');
            Route::post('/store', [NoiseController::class, 'Store'])->name('she.noise.store');
            Route::put('/form/{id}', [NoiseController::class, 'Update'])->name('she.noise.form.update');
        });

        Route::prefix('she-mess')->group(function () {
            Route::get('dashboard', [SheMessController::class, 'Dashboard'])->name('she.mess.dashboard');
            Route::get('form/export/{id}', [SheMessController::class, 'ExportForm'])->name('she.mess.export');
            Route::get('form/{id?}', [SheMessController::class, 'AddForm'])->name('she.mess.form');
            Route::post('store', [SheMessController::class, 'Store'])->name('she.mess.store');
            Route::put('form/{id}', [SheMessController::class, 'Update'])->name('she.mess.form.update');
        });

        Route::prefix('she-coal')->group(function () {
            Route::get('dashboard', [CoalGettingController::class, 'Dashboard'])->name('she.coal.dashboard');
            Route::get('form/export/{id}', [CoalGettingController::class, 'ExportForm'])->name('she.coal.export');
            Route::get('form', [CoalGettingController::class, 'AddForm'])->name('she.coal.form');
            Route::post('store', [CoalGettingController::class, 'Store'])->name('she.coal.store');
            Route::put('form/{id}', [CoalGettingController::class, 'Update'])->name('she.coal.form.update');
        });

        Route::prefix('prod-anak-asuh')->group(function () {
            Route::get('/dashboard', [AnakAsuhController::class, 'Dashboard'])->name('prod.anak-asuh.dashboard');
            Route::get('/form/export/{id}', [AnakAsuhController::class, 'ExportForm'])->name('prod.anak-asuh.export');
            Route::get('/form', [AnakAsuhController::class, 'AddForm'])->name('prod.anak-asuh.form');
            Route::post('/store', [AnakAsuhController::class, 'Store'])->name('prod.anak-asuh.store');
            Route::put('/form/{id}', [AnakAsuhController::class, 'Update'])->name('prod.anak-asuh.form.update');
        });

        Route::prefix('plant-compressor')->group(function(){
            Route::get('/dashboard', [CompressorPompaController::class, 'dashboard'])->name('plant.compressor.dashboard');
            Route::get('/form-compressor/export/{id}', [CompressorPompaController::class, 'ExportForm'])->name('plant.compressor.export');
            Route::get('/form-compressor', [CompressorPompaController::class, 'AddFormCompressor'])->name('plant.compressor.form');
            Route::post('/store-compressor', [CompressorPompaController::class, 'StoreCompressor'])->name('plant.compressor.store');
            Route::put('/form-compressor/{id}', [CompressorPompaController::class, 'UpdateCompressor'])->name('plant.compressor.update');
        });

        Route::prefix('plant-welding')->group(function(){
            Route::get('/dashboard',[PlantWeldingController::class, 'dashboard'])->name('plant.welding.dashboard');
            Route::get('/form-welding/export/{id}',[PlantWeldingController::class, 'ExportForm'])->name('plant.welding.export');
            Route::get('/form-welding', [PlantWeldingController::class, 'AddFormWelding'])->name('plant.welding.form');
            Route::post('/store-welding', [PlantWeldingController::class, 'StoreWelding'])->name('plant.welding.store');
            Route::put('/form-welding/{id}', [PlantWeldingController::class, 'UpdateWelding'])->name('plant.welding.update');
        });
        // PLANT
        Route::prefix('plant')->name('bss-form.plant.')->group(function () {
            // General Inspection
            Route::prefix('general-inspection')->name('general-inspection.')->group(function () {
                Route::get('cmt/{id}/print', [InspectionCmtController::class, 'print'])->name('cmt.print');
                Route::get('cmt/get-data', [InspectionCmtController::class, 'getData'])->name('cmt.get-data');
                Route::resource('cmt', InspectionCmtController::class);
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
        Route::post('/change-password-pegawai', [HelperController::class, 'ChangepasswordPegawaiPost']);
        Route::get('/data-pica', [HelperController::class, 'HelperDataTablePica']);
        Route::get('/data-update-progress', [HelperController::class, 'HelperDataTableStepSolutionPica']);
        Route::get('/data-history-progress', [HelperController::class, 'HelperDataTableHistoryProgressPica']);
        Route::get('/data-dashboard-history-progress', [HelperController::class, 'HelperDataTableDashboardHistoryProgressPica']);
        Route::get('/data-approvement-step-pica', [HelperController::class, 'HelperDataTableApprovementStepPica']);
        Route::get('/data-approvement-master-pica', [HelperController::class, 'HelperDataTableApprovementMasterPica']);
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
        Route::post('/change-pic-solution', [TransactionPicaController::class, 'changeSolutionPIC']);
        Route::post('/add-progress-history-transaction', [TransactionPicaController::class, 'addTransactionProgressStepSolutionPica']);
        Route::post('/deleted-progress-history-transaction', [TransactionPicaController::class, 'deleteTransactionProgressStepSolutionPica']);
        Route::post('/change-acceptance', [TransactionPicaController::class, 'changeAcceptanceStepSolutionPica']);
        Route::post('/approve-task-closing', [TransactionPicaController::class, 'ApproveClosingTask']);
        Route::post('/approve-pica-master', [TransactionPicaController::class, 'ApproveMasterPica']);
        Route::post('/update-master-pica', [TransactionPicaController::class, 'UpdateMasterPica']);
        Route::post('/add-why-spesific-data', [TransactionPicaController::class, 'AddWhySpesificData']);
        Route::post('/edit-why-spesific-data', [TransactionPicaController::class, 'EditWhySpesificData']);
        Route::post('/check-data-step', [TransactionPicaController::class, 'checkDataStep']);
        Route::post('/change-flag-revision', [TransactionPicaController::class, 'ChangeFlagRevision']);

    });

    Route::prefix('skl')->group(function () {
        Route::get('/dashboard', [DashboardSKLController::class, 'dashboard'])->name('bss-skl.dashboard');
        Route::get('/dashboard/get-data', [DashboardSKLController::class, 'getDashboardData'])->name('bss-skl.dashboard-get-data');
        Route::get('/form', [SKLFormController::class, 'create'])->name('bss-skl.create');
        Route::post('/store', [SKLFormController::class, 'store'])->name('bss-skl.store');
        Route::get('/get-karyawan', [SKLFormController::class, 'getKaryawan'])->name('bss-skl.get-karyawan');
        Route::get('/get-kategori-pekerjaan', [SKLFormController::class, 'getKategoriPekerjaan'])->name('bss-skl.get-kategori-pekerjaan');
        Route::get('/get-approver', [SKLFormController::class, 'getApprover'])->name('bss-skl.get-approver');
        Route::get('/detail', [DashboardSKLController::class, 'detail'])->name('bss-skl.detail');
        Route::post('/approval', [DashboardSKLController::class, 'storeApproval'])->name('bss-skl.store-approval');
        Route::get('/download', [DashboardSKLController::class, 'downloadExcel'])->name('bss-skl.download-excel');
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
