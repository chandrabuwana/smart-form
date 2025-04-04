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
use Modules\SmartForm\App\Http\Controllers\PLANT\PpmXcmg900dController;
use Modules\SmartForm\App\Http\Controllers\PLANT\PpmXCMG700DController;
use Modules\SmartForm\App\Http\Controllers\PLANT\PpmXCMG3005TController;
use Modules\SmartForm\App\Http\Controllers\PLANT\PpuXE1250Controller;
use Modules\SmartForm\App\Http\Controllers\LOG\OgcComplianceController;
use Modules\SmartForm\App\Http\Controllers\PLANT\PlantWeldingController;
use Modules\SmartForm\App\Http\Controllers\Production\FormCheckerController;
use Modules\SmartForm\App\Http\Controllers\Production\KalibrasiCtController;
use Modules\SmartForm\App\Http\Controllers\Production\ProductionTimeSheetDashboarController;
use Modules\SmartForm\App\Http\Controllers\Production\AnakAsuhController;
use Modules\SmartForm\App\Http\Controllers\Production\CoalGettingController;
use Modules\SmartForm\App\Http\Controllers\Production\A2bBaruController;
use Modules\SmartForm\App\Http\Controllers\SHE\DashboardSHEFRM19BController;
use Modules\SmartForm\App\Http\Controllers\SHE\TransactionSHEFRM19BController;
use Modules\SmartForm\App\Http\Controllers\SHE\EyewashController;
use Modules\SmartForm\App\Http\Controllers\SHE\AparController;
use Modules\SmartForm\App\Http\Controllers\SHE\InspeksiCateringController;
use Modules\SmartForm\App\Http\Controllers\SHE\P3KController;
use Modules\SmartForm\App\Http\Controllers\SHE\AirMinumController;
use Modules\SmartForm\App\Http\Controllers\SHE\NoiseController;
use Modules\SmartForm\App\Http\Controllers\SHE\SheMessController;
use Modules\SmartForm\App\Http\Controllers\SHE\ErgonomiController;
use Modules\SmartForm\App\Http\Controllers\SKL\DashboardSKLController;
use Modules\SmartForm\App\Http\Controllers\SKL\SKLFormController;
use Modules\SmartForm\App\Http\Controllers\SM\AssetRequestController;
use Modules\SmartForm\App\Http\Controllers\SM\RegistrasiSupplierController;
use Modules\SmartForm\App\Http\Controllers\LOG\CheckOgcComController;
use Modules\SmartForm\App\Http\Controllers\LOG\LogController;
use Modules\SmartForm\App\Http\Controllers\LOG\RequestMasterController;
use Modules\SmartForm\App\Http\Controllers\LOG\PengeluaranOilController;
use Modules\SmartForm\App\Http\Controllers\LOG\PemakaianSolarController;
use Modules\SmartForm\App\Http\Controllers\LOG\FuelController;
use Modules\SmartForm\App\Http\Controllers\LOG\Pengajuan003SapController;
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
use Modules\SmartForm\App\Http\Controllers\IT\PrinterFormController;
use Modules\SmartForm\App\Http\Controllers\IT\CctvFormController;
use Modules\SmartForm\App\Http\Controllers\IT\DeviceFormController;
use Modules\SmartForm\App\Http\Controllers\IT\RouterFormController;
use Modules\SmartForm\App\Http\Controllers\PLANT\GeneralInspection\InspectionCmtController;
use Modules\SmartForm\App\Http\Controllers\PLANT\GeneralInspection\InspectionDongfengController;
use Modules\SmartForm\App\Http\Controllers\GS\InspeksiToiletMessKantorController;
use Modules\SmartForm\App\Http\Controllers\PLANT\PpmShantuiDH24Controller;
use Modules\SmartForm\App\Http\Controllers\PLANT\PpmXcmgXE1250Controller;
use Modules\SmartForm\App\Http\Controllers\Production\LgmgController;

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
            Route::get('/request-master', [RequestMasterController::class, 'RequestMasterDashboard'])->name('bss-form.log.request-master.dashboard');
            Route::get('/list', [RequestMasterController::class, 'GetListRequestMaster'])->name("bss-form.log.list-request-master");
            Route::get('/form-req-master', [RequestMasterController::class, 'formReqMaster'])->name('bss-form.log.form-req-master');
            Route::post('/add-request-master', [RequestMasterController::class, 'SubmitFormRequestMaster'])->name("bss-form.log.add-request-master");
            Route::get('/pdf-req-master/{id}', [RequestMasterController::class, 'PdfReqMaster'])->name('bss-form.log.pdf-req-master');
            Route::get('/edit-req-master', [RequestMasterController::class, 'EditReqMaster'])->name('bss-form.log.edit-request-master');
            Route::post('/update-request-master', [RequestMasterController::class, 'UpdateFormRequestMaster'])->name("bss-form.log.update-request-master");
            Route::get('/catalog-view-req-master', [RequestMasterController::class, 'CatalogViewReqMaster'])->name('bss-form.log.catalog-view-request-master');
            Route::get('/detail-req-master', [RequestMasterController::class, 'DetailReqMaster'])->name('bss-form.log.detail-request-master');
            Route::post('/approve-reject-request-master', [RequestMasterController::class, 'ApproveRejectRequestMaster'])->name('bss-form.log.approve-reject-request-master');
            Route::post('/delete-request-master', [RequestMasterController::class, 'DeleteRequestMaster'])->name('bss-form.log.delete-request-master');

            // PERMINTAAN PENGISIAN FUEL
            Route::get('/request-fuel', [FuelController::class, 'FuelDashboard'])->name('bss-form.log.fuel.dashboard');
            Route::get('/list-fuel', [FuelController::class, 'GetListRequestFuel'])->name("bss-form.log.list-fuel");
            Route::get('/form-fuel', [FuelController::class, 'FormFuel'])->name('bss-form.log.form-fuel');
            Route::post('/create-fuel', [FuelController::class, 'CreateReqFuel'])->name('bss-form.log.create-req-fuel');
            Route::get('/edit-req-fuel', [FuelController::class, 'editReqFuel'])->name('bss-form.log.edit-req-fuel');
            Route::post('/update-fuel', [FuelController::class, 'updateReqFuel'])->name('bss-form.log.update-fuel');
            Route::get('/delete-fuel', [FuelController::class, 'HapusReqFuel'])->name('bss-form.log.delete-fuel');
            Route::get('/pdf-fuel', [FuelController::class, 'PdfReqFuel'])->name('bss-form.log.pdf-fuel');
            Route::get('/get-req-fuel-detail', [FuelController::class, 'FuelDetailById'])->name("bss-form.log.form-detail-by-id");

            // PENGELUARAN OIL, GREASE & COOLANT MENU
            Route::get('/pengeluaran-oli', [PengeluaranOilController::class, 'PengeluaranOliDashboard'])->name('bss-form.log.pengeluaran-oli.dashboard');
            Route::get('/list-pengeluaran-oli', [PengeluaranOilController::class, 'GetListPengeluaranOli'])->name("bss-form.log.list-pengeluaran-oli");
            Route::get('/form-pengeluaran-oli', [PengeluaranOilController::class, 'formPengeluaranOli'])->name('bss-form.log.form-pengeluaran-oli');
            Route::post('/add-pengeluaran-oli', [PengeluaranOilController::class, 'SubmitFormPengeluaranOli'])->name("bss-form.log.add-pengeluaran-oli");
            Route::get('/pdf-pengeluaran-oli/{id}', [PengeluaranOilController::class, 'PdfPengeluaranOli'])->name('bss-form.log.pdf-pengeluaran-oli');
            Route::get('/edit-pengeluaran-oli', [PengeluaranOilController::class, 'EditPengeluaranOli'])->name('bss-form.log.edit-pengeluaran-oli');
            Route::post('/update-pengeluaran-oli', [PengeluaranOilController::class, 'UpdateFormPengeluaranOli'])->name("bss-form.log.update-pengeluaran-oli");
            Route::get('/detail-pengeluaran-oli', [PengeluaranOilController::class, 'DetailPengeluaranOli'])->name('bss-form.log.detail-pengeluaran-oli');
            Route::post('/approve-reject-pengeluaran-oli', [PengeluaranOilController::class, 'ApproveRejectPengeluaranOli'])->name('bss-form.log.approve-reject-pengeluaran-oli');
            Route::post('/delete-pengeluaran-oli', [PengeluaranOilController::class, 'DeletePengeluaranOli'])->name('bss-form.log.delete-pengeluaran-oli');

            // PEMAKAIAN SOLAR
            Route::get('/pemakaian-solar', [PemakaianSolarController::class, 'PemakaianSolarDashboard'])->name('bss-form.log.pemakaian-solar.dashboard');
            Route::get('/list-pemakaian-solar', [PemakaianSolarController::class, 'GetListPemakaianSolar'])->name("bss-form.log.list-pemakaian-solar");
            Route::get('/form-pemakaian-solar', [PemakaianSolarController::class, 'formPemakaianSolar'])->name('bss-form.log.form-pemakaian-solar');
            Route::post('/add-pemakaian-solar', [PemakaianSolarController::class, 'SubmitFormPemakaianSolar'])->name("bss-form.log.add-pemakaian-solar");
            Route::get('/edit-pemakaian-solar', [PemakaianSolarController::class, 'editPemakaianSolar'])->name('bss-form.log.edit-pemakaian-solar');
            Route::post('/submit-edit-pemakaian-solar', [PemakaianSolarController::class, 'SubmitEditPemakaianSolar'])->name("bss-form.log.submit-edit-pemakaian-solar");
            Route::get('/pdf-pemakaian-solar/{id}', [PemakaianSolarController::class, 'PdfPemakaianSolar'])->name('bss-form.log.pdf-pemakaian-solar');
            Route::get('/get-pemakaian-solar-detail', [PemakaianSolarController::class, 'SolarDetailByNoDoc'])->name("bss-form.log.form-detail-by-id");
            Route::get('/get-pemakaian-solar-data', [PemakaianSolarController::class, 'GetPemakaianSolarData'])->name("bss-form.log.get-pemakaian-solar-data");

            Route::post('/submit-approve-pemakaian-solar', [PemakaianSolarController::class, 'SubmitApprovePemakaianSolar'])->name("bss-form.log.submit-approve-pemakaian-solar");
            Route::post('/submit-reject-pemakaian-solar', [PemakaianSolarController::class, 'SubmitRejectPemakaianSolar'])->name("bss-form.log.submit-reject-pemakaian-solar");

            // // CHECK OGC COMPLIANCE
            Route::get('/check-ogc-compliance', [CheckOgcComController::class, 'CheckOgcCompDashboard'])->name('bss-form.log.check-ogc-comp.dashboard');
            Route::get('/list-check-ogc', [CheckOgcComController::class, 'GetListCheckOgc'])->name("bss-form.log.list-check-ogc");
            Route::get('/form-check-ogc', [CheckOgcComController::class, 'formCheckOgc'])->name('bss-form.log.form-check-ogc');

            // 003 PENGAJUAN PR SAP
            Route::prefix('003-sap')->group(function () {
                Route::get('/dashboard', [Pengajuan003SapController::class, 'dashboard'])->name('dashboard-003-sap');
                Route::get('/create-form', [Pengajuan003SapController::class, 'createForm'])->name('create-003-sap');
                Route::post('/store-form', [Pengajuan003SapController::class, 'storeForm'])->name('store-003-sap');
                Route::get('/export-pdf/{id}', [Pengajuan003SapController::class, 'exportPDF'])->name('export-003-sap');
                Route::post('/update/{id}',[Pengajuan003SapController::class, 'Update'])->name('003-sap-update');
                Route::get('/detail/{id}', [Pengajuan003SapController::class, 'detail'])->name('003-sap-detail');
                Route::delete('/delete/{id}', [Pengajuan003SapController::class, 'Delete'])->name('003-sap-delete');
                Route::get('/show/{id}', [Pengajuan003SapController::class, 'show'])->name('003-sap-show');
                Route::post('/approve-ppm.xe1250', [Pengajuan003SapController::class, 'Approve'])->name("003-sap-approve");
                Route::post('/reject-ppm.xe1250', [Pengajuan003SapController::class, 'Reject'])->name("003-sap-reject");
                Route::post('/reset-ppm.xe1250/{id}', [Pengajuan003SapController::class, 'Reset'])->name("003-sap-reset");
            });

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
            Route::get('/edit-supplier', [RegistrasiSupplierController::class, 'RubahRegisSupplier'])->name('bss-form.sm.edit-registrasi-supplier');
            Route::get('/lihat-approve-supplier', [RegistrasiSupplierController::class, 'ApproveRegisSupplier'])->name('bss-form.sm.lihat-approve-supplier');
            Route::post('/update-supplier', [RegistrasiSupplierController::class, 'updateRegisSupplier'])->name('bss-form.sm.update-supplier');
            Route::get('/approve-supplier', [RegistrasiSupplierController::class, 'approveSupplier'])->name('bss-form.sm.approve-supplier');
            Route::get('/delete-supplier', [RegistrasiSupplierController::class, 'DeleteSupplier'])->name('bss-form.sm.delete-supplier');
            Route::get('/pdf-registrasi-supplier', [RegistrasiSupplierController::class, 'PdfRegSupplier'])->name('bss-form.sm.pdf-registrasi-supplier');
            Route::get('/get-supplier-detail', [RegistrasiSupplierController::class, 'SupplierDetailById'])->name("bss-form.sm.supplier-detail-by-id");

            Route::post('/submit-approve-supplier', [RegistrasiSupplierController::class, 'SubmitApproveSupplier'])->name("bss-form.sm.submit-approve-supplier");
            Route::post('/submit-reject-supplier', [RegistrasiSupplierController::class, 'SubmitRejectSupplier'])->name("bss-form.sm.submit-reject-supplier");
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
        });

        Route::prefix('she-036')->group(function () {
            Route::get('/inspeksi-apar', [AparController::class, 'inspeksiAparDashboard'])->name('bss-form.she-036.inspeksi-apar.dashboard');
            Route::get('/list-inspeksi-apar', [AparController::class, 'GetListInspeksiApar'])->name('bss-form.she-036.list-inspeksi-apar');
            Route::get('/form-inspeksi-apar', [AparController::class, 'formInspeksiApar'])->name('bss-form.she-036.form-inspeksi-apar');
            Route::post('/add-inspeksi-apar', [AparController::class, 'SubmitFormInspeksiApar'])->name('bss-form.she-036.add-inspeksi-apar');
            Route::post('/update-inspeksi-apar', [AparController::class, 'UpdateInspeksiApar'])->name('bss-form.she-036.update-inspeksi-apar');
            Route::get('/detail-inspeksi-apar/{id}', [AparController::class, 'DetailInspeksiApar'])->name('bss-form.she-036.detail-inspeksi-apar');
            Route::post('/delete-inspeksi-apar', [AparController::class, 'DeleteInspeksiApar'])->name('bss-form.she-036.delete-inspeksi-apar');
            Route::get('/edit-inspeksi-apar', [AparController::class, 'EditInspeksiApar'])->name('bss-form.she-036.edit-inspeksi-apar');
            Route::get('/show-inspeksi-apar/{id}', [AparController::class, 'ShowInspeksiApar'])->name('bss-form.she-036.show-inspeksi-apar');
            Route::post('/approve-inspeksi-apar', [AparController::class, 'Approve'])->name('bss-form.she-036.approve-inspeksi-apar');
            Route::post('/reject-inspeksi-apar', [AparController::class, 'Reject'])->name('bss-form.she-036.reject-inspeksi-apar');
            Route::post('/reset-inspeksi-apar/{id}', [AparController::class, 'Reset'])->name('bss-form.she-036.reset-inspeksi-apar');
            Route::get('/pdf-inspeksi-apar/{id}', [AparController::class, 'PdfInspeksiApar'])->name('bss-form.she-036.pdf-inspeksi-apar');
        });

        Route::prefix('she-048')->group(function () {
            Route::get('/inspeksi-catering', [InspeksiCateringController::class, 'InspeksiCateringDashboard'])->name('bss-form.she-048.inspeksi-catering.dashboard');
            Route::get('/list-inspeksi-catering', [InspeksiCateringController::class, 'GetListInspeksiCatering'])->name("bss-form.she-048.list-inspeksi-catering");
            Route::get('/form-inspeksi-catering', [InspeksiCateringController::class, 'FormInspeksiCatering'])->name('bss-form.she-048.form-inspeksi-catering');
            Route::post('/create-inspeksi-catering', [InspeksiCateringController::class, 'CreateInspeksiCatering'])->name('bss-form.she-048.create-inspeksi-catering');
            Route::get('/detail-inspeksi-catering/{id}', [InspeksiCateringController::class, 'DetailInspeksiCatering'])->name('bss-form.she-048.detail-inspeksi-catering');
            Route::get('/edit-inspeksi-catering', [InspeksiCateringController::class, 'EditInspeksiCatering'])->name('bss-form.she-048.edit-inspeksi-catering');
            Route::post('/update-inspeksi-catering', [InspeksiCateringController::class, 'UpdateInspeksiCatering'])->name('bss-form.she-048.update-inspeksi-catering');
            Route::post('/delete-inspeksi-catering', [InspeksiCateringController::class, 'DeleteInspeksiCatering'])->name('bss-form.she-048.delete-inspeksi-catering');
            Route::post('/approve-inspeksi-catering', [InspeksiCateringController::class, 'Approve'])->name('bss-form.she-048.approve-inspeksi-catering');
            Route::post('/reject-inspeksi-catering', [InspeksiCateringController::class, 'Reject'])->name('bss-form.she-048.reject-inspeksi-catering');
            Route::post('/reset-inspeksi-catering/{id}', [InspeksiCateringController::class, 'Reset'])->name('bss-form.she-048.reset-inspeksi-catering');
            Route::get('/pdf-inspeksi-catering/{id}', [InspeksiCateringController::class, 'PdfInspeksiCatering'])->name('bss-form.she-048.pdf-inspeksi-catering');
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

        Route::prefix('wc')->group(function () {
            Route::get('/dashboard', [InspeksiToiletMessKantorController::class, 'Dashboard'])->name('dashboard-wc');
            Route::get('/create-form', [InspeksiToiletMessKantorController::class, 'createForm'])->name('create-wc');
            Route::post('/store-form', [InspeksiToiletMessKantorController::class, 'storeForm'])->name('store-wc');
            Route::get('/list', [InspeksiToiletMessKantorController::class, 'list'])->name('list-wc');
            Route::get('/export-inspeksi/{id}', [InspeksiToiletMessKantorController::class, 'exportPDF'])->name('export-inspeksi');
            Route::put('/update/{id}', [InspeksiToiletMessKantorController::class, 'Update'])->name('wc-update');
            Route::get('/detail/{id}', [InspeksiToiletMessKantorController::class, 'detail'])->name('wc-detail');
            Route::delete('/delete/{id}', [InspeksiToiletMessKantorController::class, 'Delete'])->name('wc-delete');
            Route::get('/show/{id}', [InspeksiToiletMessKantorController::class, 'show'])->name('wc-show');
            Route::post('/approve-wc', [InspeksiToiletMessKantorController::class, 'Approve'])->name("wc-approve");
            Route::post('/reject-wc', [InspeksiToiletMessKantorController::class, 'Reject'])->name("wc-reject");
            Route::post('/reset-wc/{id}', [InspeksiToiletMessKantorController::class, 'Reset'])->name("wc-reset");
        });

        Route::prefix('it-ops')->group(function () {
            // PRINTER
            Route::get('/dashboard-printer', [PrinterFormController::class, 'IndexPrinterForm'])->name('it-ops.dashboard-printer');
            Route::get('/form-printer/{id}/export-pdf', [PrinterFormController::class, 'ExportPrinter'])->name('it-ops.form-printer.export');
            Route::post('/submit-printer', [PrinterFormController::class, 'SubmitPrinterForm'])->name('it-ops.submit-printer');
            Route::get('/form-printer', [PrinterFormController::class, 'CreatePrinterForm'])->name('it-ops.form-printer');
            Route::get('/edit-printer', [PrinterFormController::class, 'EditPrinterForm'])->name('it-ops.edit-printer');
            Route::post('/update-printer', [PrinterFormController::class, 'UpdatePrinterForm'])->name('it-ops.update-printer');
            Route::post('/delete-printer', [PrinterFormController::class, 'DeletePrinterForm'])->name('it-ops.delete-printer');
            // CCTV
            Route::get('/dashboard-cctv', [CctvFormController::class, 'IndexCctvForm'])->name('it-ops.dashboard-cctv');
            Route::get('/form-cctv', [CctvFormController::class, 'CreateCctvForm'])->name('it-ops.form-cctv');
            Route::post('/submit-cctv', [CctvFormController::class, 'SubmitCctvForm'])->name('it-ops.submit-cctv');
            Route::get('/form-cctv/{id}/export-pdf', [CctvFormController::class, 'ExportCctv'])->name('it-ops.form-cctv.export');
            Route::get('/edit-cctv', [CctvFormController::class, 'EditCctvForm'])->name('it-ops.edit-cctv');
            Route::post('/update-cctv', [CctvFormController::class, 'UpdateCctvForm'])->name('it-ops.update-cctv');
            Route::post('/delete-cctv', [CctvFormController::class, 'DeleteCctvForm'])->name('it-ops.delete-cctv');
            // DEVICE
            Route::get('/dashboard-device', [DeviceFormController::class, 'IndexDeviceForm'])->name('it-ops.dashboard-device');
            Route::get('/form-device', [DeviceFormController::class, 'CreateDeviceForm'])->name('it-ops.form-device');
            Route::post('/submit-device', [DeviceFormController::class, 'SubmitDeviceForm'])->name('it-ops.submit-device');
            Route::get('/form-device/{id}/export-pdf', [DeviceFormController::class, 'ExportDevice'])->name('it-ops.form-device.export');
            Route::get('/edit-device', [DeviceFormController::class, 'EditDeviceForm'])->name('it-ops.edit-device');
            Route::post('/update-device', [DeviceFormController::class, 'UpdateDeviceForm'])->name('it-ops.update-device');
            Route::post('/delete-device', [DeviceFormController::class, 'DeleteDeviceForm'])->name('it-ops.delete-device');
            // ROUTER
            Route::get('/dashboard-router', [RouterFormController::class, 'Dashboard'])->name('it-ops.dashboard-router');
            Route::get('/form-router', [RouterFormController::class, 'CreateRouterForm'])->name('it-ops.form-router');
            Route::post('/submit-router', [RouterFormController::class, 'SubmitRouterForm'])->name('it-ops.submit-router');
            Route::get('/form-router/{id}/export-pdf', [RouterFormController::class, 'ExportRouter'])->name('it-ops.form-router.export');
            Route::get('/edit-router', [RouterFormController::class, 'EditRouterForm'])->name('it-ops.edit-router');
            Route::post('/update-router', [RouterFormController::class, 'UpdateRouterForm'])->name('it-ops.update-router');
            Route::post('/delete-router', [RouterFormController::class, 'DeleteRouterForm'])->name('it-ops.delete-router');
        });

        Route::prefix('she-inspeksi')->group(function () {
            Route::get('/dashboard', [EyewashController::class, 'Dashboard'])->name('she-inspeksi.dashboard');
            Route::get('/form/export/{id}', [EyewashController::class, 'ExportForm'])->name('she-inspeksi.form.export');
            Route::get('/form', [EyewashController::class, 'AddForm'])->name('she-inspeksi.form');
            Route::post('/store', [EyewashController::class, 'Store'])->name('she-inspeksi.submit');
            Route::put('/form/{id}', [EyewashController::class, 'Update'])->name('she-inspeksi.form.update');
            Route::get('/edit/{id}', [EyewashController::class, 'EditForm'])->name('she-inspeksi.edit');
            Route::post('/update', [EyewashController::class, 'UpdateForm'])->name('she-inspeksi.update');
            Route::delete('/delete/{id}', [EyewashController::class, 'DeleteRecord'])->name('she-inspeksi.delete');
            Route::post('/approve/{id}', [EyewashController::class, 'ApproveRecord'])->name('she-inspeksi.approve');
            Route::post('/reject/{id}', [EyewashController::class, 'RejectRecord'])->name('she-inspeksi.reject');
        });

        Route::prefix('she-p3k')->group(function () {
            Route::get('/dashboard', [P3KController::class, 'Dashboard'])->name('she-p3k.dashboard');
            Route::get('/form/export/{id}', [P3KController::class, 'ExportForm'])->name('she-p3k.export');
            Route::get('/form', [P3KController::class, 'AddForm'])->name('she-p3k.form');
            Route::post('/store', [P3KController::class, 'Store'])->name('she-p3k.submit');
            Route::get('/form/edit/{id}', [P3KController::class, 'EditForm'])->name('she-p3k.edit');
            Route::post('/update/{id}', [P3KController::class, 'Update'])->name('she-p3k.update');
            Route::get('/approve/{id}/{role}', [P3KController::class, 'Approve'])->name('she-p3k.approve');
            Route::get('/approve-all/{id}', [P3KController::class, 'ApproveAll'])->name('she-p3k.approve-all');
            Route::post('/set-user-nik', [P3KController::class, 'SetUserNik'])->name('she-p3k.set-user-nik');
            Route::delete('/delete/{id}', [P3KController::class, 'Delete'])->name('she-p3k.delete');
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
            Route::get('/edit/{id}', [NoiseController::class, 'EditForm'])->name('she.noise.edit');
            Route::get('/view/{id}', [NoiseController::class, 'ViewForm'])->name('she.noise.view');
            Route::delete('/delete/{id}', [NoiseController::class, 'Delete'])->name('she.noise.delete');
            Route::post('/update-status', [NoiseController::class, 'UpdateStatus'])->name('she.noise.update.status');
        });

        Route::prefix('she-mess')->group(function () {
            Route::get('dashboard', [SheMessController::class, 'Dashboard'])->name('she.mess.dashboard');
            Route::get('form/export/{id}', [SheMessController::class, 'ExportForm'])->name('she.mess.export');
            Route::get('form/{id?}', [SheMessController::class, 'AddForm'])->name('she.mess.form');
            Route::post('store', [SheMessController::class, 'Store'])->name('she.mess.store');
            Route::put('form/{id}', [SheMessController::class, 'Update'])->name('she.mess.form.update');
            Route::get('approve/{id}/{role}', [SheMessController::class, 'Approve'])->name('she.mess.approve');
            Route::get('reject/{id}/{role}', [SheMessController::class, 'Reject'])->name('she.mess.reject');
            Route::delete('delete', [SheMessController::class, 'Delete'])->name('she.mess.delete');
            Route::get('edit/{id}', [SheMessController::class, 'EditForm'])->name('she.mess.form.edit');
        });

        Route::prefix('prod-coal')->group(function(){
            Route::get('dashboard', [CoalGettingController::class, 'Dashboard'])->name('prod.coal.dashboard');
            Route::get('form/export/{id}', [CoalGettingController::class, 'ExportForm'])->name('prod.coal.export');
            Route::get('form', [CoalGettingController::class, 'AddForm'])->name('prod.coal.form');
            Route::get('form/edit/{id}', [CoalGettingController::class, 'EditForm'])->name('prod.coal.form.edit');
            Route::post('store', [CoalGettingController::class, 'Store'])->name('prod.coal.store');
            Route::post('update', [CoalGettingController::class, 'Update'])->name('prod.coal.update');
            Route::post('delete', [CoalGettingController::class, 'Delete'])->name('prod.coal.delete');
            Route::post('/update-status', [CoalGettingController::class, 'updateStatus'])->name('prod.coal.update-status');
        });

        Route::prefix('she-ergonomi')->group(function () {
            Route::get('dashboard', [ErgonomiController::class, 'Dashboard'])->name('she.ergonomi.dashboard');
            Route::get('form/export/{id}', [ErgonomiController::class, 'ExportForm'])->name('she.ergonomi.export');
            Route::get('form', [ErgonomiController::class, 'AddForm'])->name('she.ergonomi.form');
            Route::post('store', [ErgonomiController::class, 'Store'])->name('she.ergonomi.store');
            Route::put('form/{id}', [ErgonomiController::class, 'Update'])->name('she.ergonomi.form.update');
        });

        Route::prefix('prod-anak-asuh')->group(function () {
            Route::get('/dashboard', [AnakAsuhController::class, 'Dashboard'])->name('prod.anak-asuh.dashboard');
            Route::get('/form/export/{id}', [AnakAsuhController::class, 'ExportForm'])->name('prod.anak-asuh.export');
            Route::get('/form', [AnakAsuhController::class, 'AddForm'])->name('prod.anak-asuh.form');
            Route::get('/form/edit/{id}', [AnakAsuhController::class, 'EditForm'])->name('prod.anak-asuh.form.edit');
            Route::post('/store', [AnakAsuhController::class, 'Store'])->name('prod.anak-asuh.store');
            Route::post('/update', [AnakAsuhController::class, 'UpdateAnakAsuh'])->name('prod.anak-asuh.update');
            Route::post('/delete', [AnakAsuhController::class, 'Delete'])->name('prod.anak-asuh.delete');
        });

        Route::prefix('plant-compressor')->group(function(){
            Route::get('/dashboard', [CompressorPompaController::class, 'dashboard'])->name('plant.compressor.dashboard');
            Route::get('/form-compressor/export/{id}', [CompressorPompaController::class, 'ExportForm'])->name('plant.compressor.export');
            Route::get('/form-compressor', [CompressorPompaController::class, 'AddFormCompressor'])->name('plant.compressor.form');
            Route::post('/store-compressor', [CompressorPompaController::class, 'StoreCompressor'])->name('plant.compressor.store');
            Route::POST('/update', [CompressorPompaController::class, 'UpdateCompressor'])->name('plant.compressor.update');
            Route::delete('/delete/{id}', [CompressorPompaController::class, 'DeleteCompressor'])->name('plant.compressor.delete');
        });

        Route::prefix('plant-welding')->group(function(){
            Route::get('/dashboard',[PlantWeldingController::class, 'dashboard'])->name('plant.welding.dashboard');
            Route::get('/form-welding/export/{id}',[PlantWeldingController::class, 'ExportForm'])->name('plant.welding.export');
            Route::get('/form-welding', [PlantWeldingController::class, 'AddFormWelding'])->name('plant.welding.form');
            Route::post('/store-welding', [PlantWeldingController::class, 'StoreWelding'])->name('plant.welding.store');
            Route::get('/edit-welding/{id}', [PlantWeldingController::class, 'EditWelding'])->name('plant.welding.edit');
            Route::post('/update-welding/{id}', [PlantWeldingController::class, 'UpdateWelding'])->name('plant.welding.update');
            Route::delete('/form-welding/{id}', [PlantWeldingController::class, 'destroy'])->name('plant.welding.delete');
            Route::get('/approval-welding/{id}', [PlantWeldingController::class, 'ApprovalWelding'])->name('plant.welding.approval');
            Route::post('/approve-welding/{id}', [PlantWeldingController::class, 'ApproveWelding'])->name('plant.welding.approve');
            Route::post('/reject-welding/{id}', [PlantWeldingController::class, 'RejectWelding'])->name('plant.welding.reject');
        });

        // PLANT
        Route::prefix('plant')->name('bss-form.plant.')->group(function () {
            // General Inspection
            Route::prefix('general-inspection')->name('general-inspection.')->group(function () {
                // CMT
                Route::get('cmt/{id}/print', [InspectionCmtController::class, 'print'])->name('cmt.print');
                Route::get('cmt/dashboard', [InspectionCmtController::class, 'index'])->name('cmt.dashboard');
                Route::post('/approve-cmt', [InspectionCmtController::class, 'Approve'])->name("cmt.approve");
                Route::post('/reject-cmt', [InspectionCmtController::class, 'Reject'])->name("cmt.reject");
                Route::post('/reset-cmt/{id}', [InspectionCmtController::class, 'Reset'])->name("cmt.reset");
                Route::get('cmt/get-data', [InspectionCmtController::class, 'getData'])->name('cmt.get-data');
                Route::resource('cmt', InspectionCmtController::class);

                // Dongfeng
                Route::get('dongfeng/{id}/print', [InspectionDongfengController::class, 'print'])->name('dongfeng.print');
                Route::get('dongfeng/dashboard', [InspectionDongfengController::class, 'index'])->name('dongfeng.dashboard');
                Route::post('/approve-dongfeng', [InspectionDongfengController::class, 'Approve'])->name("dongfeng.approve");
                Route::post('/reject-dongfeng', [InspectionDongfengController::class, 'Reject'])->name("dongfeng.reject");
                Route::post('/reset-dongfeng/{id}', [InspectionDongfengController::class, 'Reset'])->name("dongfeng.reset");
                Route::get('dongfeng/get-data', [InspectionDongfengController::class, 'getData'])->name('dongfeng.get-data');
                Route::resource('dongfeng', InspectionDongfengController::class);
            });
        });

        Route::prefix('prod-form-checker')->group(function(){
            Route::get('/dashboard', [FormCheckerController::class, 'dashboard'])->name('prod.form.checker.dashboard');
            Route::get('/form-checker/export/{id}', [FormCheckerController::class, 'ExportForm'])->name('prod.form.checker.export');
            Route::get('/form-checker', [FormCheckerController::class, 'AddFormChecker'])->name('prod.form.checker.form');
            Route::get('/show/{id}', [FormCheckerController::class, 'ShowFormChecker'])->name('prod.form.checker.show');
            Route::post('/store-form-checker', [FormCheckerController::class, 'StoreChecker'])->name('prod.checker.submit');
            Route::delete('/delete/{id}', [FormCheckerController::class, 'Delete'])->name('prod.form.checker.delete');
            Route::post('/approve-form-checker', [FormCheckerController::class, 'Approve'])->name("prod.form.checker.approve");
            Route::post('/reject-form-checker', [FormCheckerController::class, 'Reject'])->name("prod.form.checker.reject");
            Route::post('/reset-form-checker/{id}', [FormCheckerController::class, 'Reset'])->name("prod.form.checker.reset");
            Route::post('/update-form-checker',[FormCheckerController::class, 'Update'])->name('prod.form.checker.update');
            Route::get('/detail/{id}', [FormCheckerController::class, 'detail'])->name('prod.form.checker.detail');

        });


        Route::prefix('prod-kalibrasi-ct')->group(function () {
            Route::get('/dashboard', [KalibrasiCtController::class, 'Dashboard'])->name('prod.kalibrasi-ct.dashboard');
            Route::get('/form-kalibrasi-ct/export/{id}', [KalibrasiCtController::class, 'ExportForm'])->name('prod.kalibrasi-ct.export');
            Route::get('/form-kalibrasi-ct', [KalibrasiCtController::class, 'AddFormKalibrasi'])->name('prod.kalibrasi-ct.form');
            Route::post('/store-kalibrasi-ct', [KalibrasiCtController::class, 'StoreKalibrasi'])->name('prod.kalibrasi-ct.store');
            Route::get('/edit-kalibrasi-ct/{id}', [KalibrasiCtController::class, 'EditKalibrasi'])->name('prod.kalibrasi-ct.edit');
            Route::post('/form-kalibrasi-ct/{id}', [KalibrasiCtController::class, 'UpdateKalibrasi'])->name('prod.kalibrasi-ct.update');
            Route::delete('/form-kalibrasi-ct/{id}', [KalibrasiCtController::class, 'destroy'])->name('prod.kalibrasi-ct.delete');
            Route::get('/approval-form-kalibrasi-ct/{id}', [KalibrasiCtController::class, 'ApprovalKalibrasi'])->name('prod.kalibrasi-ct.approval');
            Route::post('/approve-form-kalibrasi-ct/{id}', [KalibrasiCtController::class, 'ApproveKalibrasi'])->name('prod.kalibrasi-ct.approve');
            Route::post('/reject-form-kalibrasi-ct/{id}', [KalibrasiCtController::class, 'RejectKalibrasi'])->name('prod.kalibrasi-ct.reject');
        });

        Route::prefix('prod-a2b-baru')->group(function () {
            Route::get('/dashboard', [A2bBaruController::class, 'Dashboard'])->name('prod.a2b-baru.dashboard');
            Route::get('/form-a2b-baru/export/{id}', [A2bBaruController::class, 'ExportForm'])->name('prod.a2b-baru.export');
            Route::get('/form-a2b-baru', [A2bBaruController::class, 'AddFormA2bBaru'])->name('prod.a2b-baru.form');
            Route::post('/store-a2b-baru', [A2bBaruController::class, 'StoreA2bBaru'])->name('prod.a2b-baru.store');
            Route::get('/edit-a2b-baru/{id}', [A2bBaruController::class, 'EditA2bBaru'])->name('prod.a2b-baru.edit');
            Route::post('/form-a2b-baru/{id}', [A2bBaruController::class, 'UpdateA2bBaru'])->name('prod.a2b-baru.update');
            Route::delete('/form-a2b-baru/{id}', [A2bBaruController::class, 'destroy'])->name('prod.a2b-baru.delete');
            Route::get('/approval-a2b-baru/{id}', [A2bBaruController::class, 'ApprovalA2bBaru'])->name('prod.a2b-baru.approval');
            Route::post('/approve-a2b-baru/{id}', [A2bBaruController::class, 'ApproveA2bBaru'])->name('prod.a2b-baru.approve');
            Route::post('/reject-a2b-baru/{id}', [A2bBaruController::class, 'RejectA2bBaru'])->name('prod.a2b-baru.reject');
        });

        Route::prefix('ppm-900d')->group(function(){
            Route::get('/dashboard', [PpmXcmg900dController::class, 'Dashboard'])->name('plant.ppm.900d.dashboard');
            Route::get('/export/{id}', [PpmXcmg900dController::class, 'Export'])->name('plant.ppm.900d.export');
            Route::get('/add', [PpmXcmg900dController::class, 'Add'])->name('plant.ppm.900d.form');
            Route::post('/store', [PpmXcmg900dController::class, 'Store'])->name('plant.ppm.900d.store');
            Route::post('/update',[PpmXcmg900dController::class, 'Update'])->name('plant.ppm.900d.update');
            Route::get('/detail/{id}', [PpmXcmg900dController::class, 'detail'])->name('plant.ppm.900d.detail');
            Route::delete('/delete/{id}', [PpmXcmg900dController::class, 'Delete'])->name('plant.ppm.900d.delete');
            Route::get('/show/{id}', [PpmXcmg900dController::class, 'show'])->name('plant.ppm.900d.show');
            Route::post('/approve-ppm.900d', [PpmXcmg900dController::class, 'Approve'])->name("plant.ppm.900d.approve");
            Route::post('/reject-ppm.900d', [PpmXcmg900dController::class, 'Reject'])->name("plant.ppm.900d.reject");
            Route::post('/reset-ppm.900d/{id}', [PpmXcmg900dController::class, 'Reset'])->name("plant.ppm.900d.reset");

        });
        Route::prefix('ppm-3005T')->group(function(){
            Route::get('/dashboard', [PpmXCMG3005TController::class, 'Dashboard'])->name('plant.ppm.3005.dashboard');
            Route::get('/export/{id}', [PpmXCMG3005TController::class, 'Export'])->name('plant.ppm.3005.export');
            Route::get('/add', [PpmXCMG3005TController::class, 'Add'])->name('plant.ppm.3005.form');
            Route::post('/store', [PpmXCMG3005TController::class, 'Store'])->name('plant.ppm.3005.store');
            Route::post('/update',[PpmXCMG3005TController::class, 'Update'])->name('plant.ppm.3005.update');
            Route::get('/detail/{id}', [PpmXCMG3005TController::class, 'detail'])->name('plant.ppm.3005.detail');
            Route::delete('/delete/{id}', [PpmXCMG3005TController::class, 'Delete'])->name('plant.ppm.3005.delete');
            Route::get('/show/{id}', [PpmXCMG3005TController::class, 'show'])->name('plant.ppm.3005.show');
            Route::post('/approve-ppm.3005', [PpmXCMG3005TController::class, 'Approve'])->name("plant.ppm.3005.approve");
            Route::post('/reject-ppm.3005', [PpmXCMG3005TController::class, 'Reject'])->name("plant.ppm.3005.reject");
            Route::post('/reset-ppm.3005/{id}', [PpmXCMG3005TController::class, 'Reset'])->name("plant.ppm.3005.reset");
        });
        Route::prefix('ppm-700d')->group(function(){
            Route::get('/dashboard', [PpmXCMG700DController::class, 'Dashboard'])->name('plant.ppm.700d.dashboard');
            Route::get('/export/{id}', [PpmXCMG700DController::class, 'Export'])->name('plant.ppm.700d.export');
            Route::get('/add', [PpmXCMG700DController::class, 'Add'])->name('plant.ppm.700d.form');
            Route::post('/store', [PpmXCMG700DController::class, 'Store'])->name('plant.ppm.700d.store');
            Route::post('/update',[PpmXCMG700DController::class, 'Update'])->name('plant.ppm.700d.update');
            Route::get('/detail/{id}', [PpmXCMG700DController::class, 'detail'])->name('plant.ppm.700d.detail');
            Route::delete('/delete/{id}', [PpmXCMG700DController::class, 'Delete'])->name('plant.ppm.700d.delete');
            Route::get('/show/{id}', [PpmXCMG700DController::class, 'show'])->name('plant.ppm.700d.show');
            Route::post('/approve-ppm.700d', [PpmXCMG700DController::class, 'Approve'])->name("plant.ppm.700d.approve");
            Route::post('/reject-ppm.700d', [PpmXCMG700DController::class, 'Reject'])->name("plant.ppm.700d.reject");
            Route::post('/reset-ppm.700d/{id}', [PpmXCMG700DController::class, 'Reset'])->name("plant.ppm.700d.reset");
        });
        Route::prefix('ppu-xe1250')->group(function(){
            Route::get('/dashboard', [PpuXE1250Controller::class, 'Dashboard'])->name('plant.ppu.xe1250.dashboard');
            Route::get('/export/{id}', [PpuXE1250Controller::class, 'Export'])->name('plant.ppu.xe1250.export');
            Route::get('/add', [PpuXE1250Controller::class, 'Add'])->name('plant.ppu.xe1250.form');
            Route::post('/store', [PpuXE1250Controller::class, 'Store'])->name('plant.ppu.xe1250.store');
            Route::post('/update',[PpuXE1250Controller::class, 'Update'])->name('plant.ppu.xe1250.update');
            Route::get('/detail/{id}', [PpuXE1250Controller::class, 'detail'])->name('plant.ppu.xe1250.detail');
            Route::get('/show/{id}', [PpuXE1250Controller::class, 'show'])->name('plant.ppu.xe1250.show');
            Route::delete('/delete/{id}', [PpuXE1250Controller::class, 'Delete'])->name('plant.ppu.xe1250.delete');
            Route::post('/approve-ppu-xe1250', [PpuXE1250Controller::class, 'Approve'])->name("plant.ppu.xe1250.approve");
            Route::post('/reject-ppu-xe1250', [PpuXE1250Controller::class, 'Reject'])->name("plant.ppu.xe1250.reject");
            Route::post('/reset-ppu-xe1250/{id}', [PpuXE1250Controller::class, 'Reset'])->name("plant.ppu.xe1250.reset");
        });


        Route::prefix('ppm-dh24')->group(function(){
            Route::get('/dashboard', [PpmShantuiDH24Controller::class, 'Dashboard'])->name('dashboard-dh24');
            Route::get('/add', [PpmShantuiDH24Controller::class, 'Add'])->name('form-create-dh24');
            Route::post('/store', [PpmShantuiDH24Controller::class, 'Store'])->name('store-dh24');
            Route::get('/export/{id}', [PpmShantuiDH24Controller::class, 'ExportPDF'])->name('export-pdf-dh24');
            Route::delete('/delete/{id}', [PpmShantuiDH24Controller::class, 'Delete'])->name('delete-dh24');
            Route::get('/show/{id}', [PpmShantuiDH24Controller::class, 'show'])->name('show-dh24');
            Route::get('/detail/{id}', [PpmShantuiDH24Controller::class, 'detail'])->name('detail-dh24');
            Route::post('/approve-dh24', [PpmShantuiDH24Controller::class, 'Approve'])->name("plant.dh24.approve");
            Route::post('/reject-dh24', [PpmShantuiDH24Controller::class, 'Reject'])->name("plant.dh24.reject");
            Route::post('/reset-dh24/{id}', [PpmShantuiDH24Controller::class, 'Reset'])->name("plant.dh24.reset");
            Route::post('/update',[PpmShantuiDH24Controller::class, 'Update'])->name('plant.dh24.update');
        });

        Route::prefix('ppm-xe1250')->group(function(){
            Route::get('/dashboard', [PpmXcmgXE1250Controller::class, 'Dashboard'])->name('plant.ppm.xe1250.dashboard');
            Route::get('/export/{id}', [PpmXcmgXE1250Controller::class, 'Export'])->name('plant.ppm.xe1250.export');
            Route::get('/add', [PpmXcmgXE1250Controller::class, 'Add'])->name('plant.ppm.xe1250.form');
            Route::post('/store', [PpmXcmgXE1250Controller::class, 'Store'])->name('plant.ppm.xe1250.store');
            Route::post('/update',[PpmXcmgXE1250Controller::class, 'Update'])->name('plant.ppm.xe1250.update');
            Route::get('/detail/{id}', [PpmXcmgXE1250Controller::class, 'detail'])->name('plant.ppm.xe1250.detail');
            Route::delete('/delete/{id}', [PpmXcmgXE1250Controller::class, 'Delete'])->name('plant.ppm.xe1250.delete');
            Route::get('/show/{id}', [PpmXcmgXE1250Controller::class, 'show'])->name('plant.ppm.xe1250.show');
            Route::post('/approve-ppm.xe1250', [PpmXcmgXE1250Controller::class, 'Approve'])->name("plant.ppm.xe1250.approve");
            Route::post('/reject-ppm.xe1250', [PpmXcmgXE1250Controller::class, 'Reject'])->name("plant.ppm.xe1250.reject");
            Route::post('/reset-ppm.xe1250/{id}', [PpmXcmgXE1250Controller::class, 'Reset'])->name("plant.ppm.xe1250.reset");
        });

        Route::prefix('ogc-compliance')->group(function(){
            Route::get('/dashboard', [OgcComplianceController::class, 'Dashboard'])->name('log.ogc.dashboard');
            Route::get('/export/{id}', [OgcComplianceController::class, 'Export'])->name('log.ogc.export');
            Route::get('/add', [OgcComplianceController::class, 'Add'])->name('log.ogc.form');
            Route::post('/store', [OgcComplianceController::class, 'Store'])->name('log.ogc.store');
            Route::post('/update',[OgcComplianceController::class, 'Update'])->name('log.ogc.update');
            Route::get('/detail/{id}', [OgcComplianceController::class, 'detail'])->name('log.ogc.detail');
            Route::get('modal/{id}/{doc_num}', [OgcComplianceController::class, 'modal'])->name('log.ogc.modal');
            Route::get('/show/{id}', [OgcComplianceController::class, 'show'])->name('log.ogc.show');
            Route::delete('/delete/{id}', [OgcComplianceController::class, 'Delete'])->name('log.ogc.delete');
            Route::delete('/delete-week/{id}', [OgcComplianceController::class, 'DeleteWeek'])->name('log.ogc.deleteWeek');
            Route::post('/approve-log.ogc', [OgcComplianceController::class, 'Approve'])->name('log.ogc.approve');
            Route::post('/reject-log.ogc', [OgcComplianceController::class, 'Reject'])->name('log.ogc.reject');
            Route::post('/reset-log.ogc/{id}', [OgcComplianceController::class, 'Reset'])->name('log.ogc.reset');
        });

        Route::prefix('lgmg')->group(function(){
            Route::get('/dashboard', [LgmgController::class, 'Dashboard'])->name('lgmg.dashboard');
            Route::get('/export/{id}', [LgmgController::class, 'Export'])->name('lgmg.export');
            Route::get('/add', [LgmgController::class, 'Add'])->name('lgmg.form');
            Route::post('/store', [LgmgController::class, 'Store'])->name('lgmg.store');
            Route::post('/update/{id}',[LgmgController::class, 'Update'])->name('lgmg.update');
            Route::get('/detail/{id}', [LgmgController::class, 'detail'])->name('lgmg.detail');
            Route::delete('/delete/{id}', [LgmgController::class, 'Delete'])->name('lgmg.delete');
            Route::get('/show/{id}', [LgmgController::class, 'show'])->name('lgmg.show');
            Route::post('/approve-lgmg', [LgmgController::class, 'Approve'])->name("lgmg.approve");
            Route::post('/reject-lgmg', [LgmgController::class, 'Reject'])->name("lgmg.reject");
            Route::post('/reset-lgmg/{id}', [LgmgController::class, 'Reset'])->name("lgmg.reset");
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
        Route::get('/data-regis-supplier', [HelperController::class, 'HelperDataTableRegisSupplier']);
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
