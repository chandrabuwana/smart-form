# Smart Form Controller Function Mapping

## Overview

This document maps all form controllers across departments:

1. IT Operations (4 forms)
   - BSS-FRM-IT-012 Checklist Maintenance IT
   - BSS-FRM-IT-013 Checklist Maintenance Printer
   - BSS-FRM-IT-013 Checklist Maintenance CCTV
   - BSS-FRM-IT-013 Checklist Maintenance Router

2. Logistics (6 forms)
   - BSS-FRM-LOG-022 Permintaan Pengisian FUEL
   - BSS-FRM-LOG-002 Request Master
   - BSS-FRM-LOG-031 Checklist OGC Compliance
   - BSS-FRM-LOG-012 Request PR SAP
   - BSS-FRM-LOG-034 Pengeluaran Oil, Grease & Coolant
   - BSS-FRM-LOG-037 Laporan Harian Pemakaian Solar

3. HSE/SHE (7 forms)
   - BSS-FRM-SHE-034 Inspeksi Toilet, Mess dan Kantor
   - BSS-FRM-SHE-027 Ergonomi Driver DT Dongfeng
   - BSS-FRM-SHE-037 Inspeksi Eye Wash
   - BSS-FRM-SHE-035 Inspeksi Kotak P3K
   - Inspeksi Apar
   - BSS-FRM-SHE-015 Kebisingan
   - BSS-FRM-SHE-049 Inspeksi Air Minum

4. Production (6 forms)
   - Form P2H A2B
   - Coal Getting
   - Anak Asuh Program
   - Form Checker
   - Calibration CT
   - LGMG Unit

5. Plant (10 forms)
   - BSS-FRM-PLA-040 P2H Compresor Pompa
   - BSS-FRM-PLA-045 P2H Welding
   - BSS-FRM-PLA-091 General Inspection CMT
   - BSS-FRM-PLA-092 General Inspection Dongfeng
   - BSS-FRM-PLA-070 PPM XCMG XE1250
   - BSS-FRM-PLA-071 PPM XCMG XE900D
   - BSS-FRM-PLA-072 PPM XCMG XE700D
   - BSS-FRM-PLA-073 PPM XCMG GR3005T
   - BSS-FRM-PLA-075 PPM Shantui DH24
   - BSS-FRM-PLA-083 PPU XE1250

6. Support Services/General Services (2 forms)
   - BSS-FRM-SM-00X Registrasi Supplier
   - Form 048 Inspeksi Catering

## Logistics Department Controllers

### 1. Fuel Request Controller (LOG-001)
**Controller**: `FuelController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\LOG`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| FuelDashboard | /log/request-fuel | GET | Display fuel request dashboard |
| GetListRequestFuel | /log/list-fuel | GET | Get list of fuel requests |
| FormFuel | /log/form-fuel | GET | Display fuel request form |
| CreateReqFuel | /log/create-fuel | POST | Create new fuel request |
| editReqFuel | /log/edit-req-fuel | GET | Edit fuel request form |
| updateReqFuel | /log/update-fuel | POST | Update fuel request |
| HapusReqFuel | /log/delete-fuel | GET | Delete fuel request |
| PdfReqFuel | /log/pdf-fuel | GET | Generate PDF for fuel request |
| FuelDetailById | /log/get-req-fuel-detail | GET | Get fuel request details |
| getNoBySite | /log/get-alat-by-site-fuel | GET | Get equipment by site |
| getModelByNo | /log/get-model-by-site-fuel | GET | Get model by number |quipment number |

### 2. OGC Compliance Controller (LOG-003)
**Controller**: `CheckOgcComController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\LOG`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| CheckOgcCompDashboard | /log/check-ogc-compliance | GET | Display OGC compliance dashboard |
| GetListCheckOgc | /log/list-check-ogc | GET | Get list of OGC checks |
| formCheckOgc | /log/form-check-ogc | GET | Display OGC check form |
| show | /log/show/{id} | GET | Show OGC compliance details |
| Delete | /log/delete/{id} | DELETE | Delete OGC compliance record |
| DeleteWeek | /log/delete-week/{id} | DELETE | Delete OGC compliance week record |
| Approve | /log/approve-log.ogc | POST | Approve OGC compliance |
| Reject | /log/reject-log.ogc | POST | Reject OGC compliance |
| Reset | /log/reset-log.ogc/{id} | POST | Reset OGC compliance status |

### 3. Solar Usage Controller (LOG-003)
**Controller**: `PemakaianSolarController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\LOG`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| PemakaianSolarDashboard | /log/pemakaian-solar | GET | Display solar usage dashboard |
| GetListPemakaianSolar | /log/list-pemakaian-solar | GET | Get list of solar usage records |
| formPemakaianSolar | /log/form-pemakaian-solar | GET | Display solar usage form |
| SubmitFormPemakaianSolar | /log/add-pemakaian-solar | POST | Save new solar usage record |
| editPemakaianSolar | /log/edit-pemakaian-solar | GET | Edit solar usage record |
| SubmitEditPemakaianSolar | /log/submit-edit-pemakaian-solar | POST | Update solar usage record |
| PdfPemakaianSolar | /log/pdf-pemakaian-solar | GET | Generate PDF report |
| SolarDetailByNoDoc | /log/get-pemakaian-solar-detail | GET | Get solar usage details |
| GetPemakaianSolarData | /log/get-pemakaian-solar-data | GET | Get solar usage data |
| DeletePemakaianSolar | /log/delete-pemakaian-solar | POST | Delete solar usage record |
| SubmitApprovePemakaianSolar | /log/submit-approve-pemakaian-solar | POST | Approve solar usage |
| SubmitRejectPemakaianSolar | /log/submit-reject-pemakaian-solar | POST | Reject solar usage |

### 4. SAP Request Controller (LOG-004)
**Controller**: `Pengajuan003SapController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\LOG`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| dashboard | /log/003-sap/dashboard | GET | Display SAP request dashboard |
| createForm | /log/003-sap/create-form | GET | Display new SAP request form |
| storeForm | /log/003-sap/store-form | POST | Store SAP request data |
| exportPDF | /log/003-sap/export-pdf/{id} | GET | Export SAP request as PDF |
| Update | /log/003-sap/update/{id} | POST | Update SAP request |
| detail | /log/003-sap/detail/{id} | GET | View SAP request details |
| Delete | /log/003-sap/delete/{id} | DELETE | Delete SAP request |
| show | /log/003-sap/show/{id} | GET | Show SAP request |
| Approve | /log/003-sap/approve-ppm.xe1250 | POST | Approve SAP request |
| Reject | /log/003-sap/reject-ppm.xe1250 | POST | Reject SAP request |
| Reset | /log/003-sap/reset-ppm.xe1250/{id} | POST | Reset approval status |

### 5. Oil Consumption Controller (LOG-005)
**Controller**: `PengeluaranOilController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\LOG`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| PengeluaranOliDashboard | /log/pengeluaran-oli | GET | Display oil consumption dashboard |
| GetListPengeluaranOli | /log/list-pengeluaran-oli | GET | Get list of oil consumption records |
| formPengeluaranOli | /log/form-pengeluaran-oli | GET | Display oil consumption form |
| SubmitFormPengeluaranOli | /log/add-pengeluaran-oli | POST | Save new oil consumption record |
| PdfPengeluaranOli | /log/pdf-pengeluaran-oli/{id} | GET | Generate PDF report |
| EditPengeluaranOli | /log/edit-pengeluaran-oli | GET | Edit oil consumption record |
| UpdateFormPengeluaranOli | /log/update-pengeluaran-oli | POST | Update oil consumption record |
| DetailPengeluaranOli | /log/detail-pengeluaran-oli | GET | View detailed oil consumption |
| ApproveRejectPengeluaranOli | /log/approve-reject-pengeluaran-oli | POST | Approve/reject oil consumption |
| DeletePengeluaranOli | /log/delete-pengeluaran-oli | POST | Delete oil consumption |

### 6. Request Master Controller (LOG-006)
**Controller**: `RequestMasterController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\LOG`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| RequestMasterDashboard | /log/request-master | GET | Display request master dashboard |
| GetListRequestMaster | /log/list | GET | Get list of material requests |
| formReqMaster | /log/form-req-master | GET | Display new material request form |
| SubmitFormRequestMaster | /log/add-request-master | POST | Create new material request |
| PdfReqMaster | /log/pdf-req-master/{id} | GET | Generate PDF report |
| EditReqMaster | /log/edit-req-master | GET | Edit material request |
| UpdateFormRequestMaster | /log/update-request-master | POST | Update material request |
| CatalogViewReqMaster | /log/catalog-view-req-master | GET | View material catalog |
| DetailReqMaster | /log/detail-req-master | GET | View detailed material request |
| ApproveRejectRequestMaster | /log/approve-reject-request-master | POST | Approve/reject material request |
| DeleteRequestMaster | /log/delete-request-master | POST | Delete material request |

## Safety, Health & Environment (SHE) Controllers

### 1. APAR Inspection Controller (SHE-036)
**Controller**: `AparController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SHE`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| inspeksiAparDashboard | /she-036/inspeksi-apar | GET | Display APAR inspection dashboard |
| GetListInspeksiApar | /she-036/list-inspeksi-apar | GET | Get list of APAR inspections |
| formInspeksiApar | /she-036/form-inspeksi-apar | GET | Display APAR inspection form |
| SubmitFormInspeksiApar | /she-036/add-inspeksi-apar | POST | Submit new APAR inspection |
| UpdateInspeksiApar | /she-036/update-inspeksi-apar | POST | Update APAR inspection |
| DetailInspeksiApar | /she-036/detail-inspeksi-apar/{id} | GET | View APAR inspection details |
| DeleteInspeksiApar | /she-036/delete-inspeksi-apar | POST | Delete APAR inspection |
| EditInspeksiApar | /she-036/edit-inspeksi-apar | GET | Edit APAR inspection form |
| ShowInspeksiApar | /she-036/show-inspeksi-apar/{id} | GET | Show APAR inspection |
| Approve | /she-036/approve-inspeksi-apar | POST | Approve APAR inspection |
| Reject | /she-036/reject-inspeksi-apar | POST | Reject APAR inspection |
| Reset | /she-036/reset-inspeksi-apar/{id} | POST | Reset APAR inspection status |
| PdfInspeksiApar | /she-036/pdf-inspeksi-apar/{id} | GET | Generate PDF for inspection |

### 2. Catering Inspection Controller (SHE-048)
**Controller**: `InspeksiCateringController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SHE`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| InspeksiCateringDashboard | /she-048/inspeksi-catering | GET | Display catering inspection dashboard |
| GetListInspeksiCatering | /she-048/list-inspeksi-catering | GET | Get list of catering inspections |
| FormInspeksiCatering | /she-048/form-inspeksi-catering | GET | Display catering inspection form |
| CreateInspeksiCatering | /she-048/create-inspeksi-catering | POST | Create new catering inspection |
| DetailInspeksiCatering | /she-048/detail-inspeksi-catering/{id} | GET | View inspection details |
| EditInspeksiCatering | /she-048/edit-inspeksi-catering | GET | Edit catering inspection |
| UpdateInspeksiCatering | /she-048/update-inspeksi-catering | POST | Update catering inspection |
| DeleteInspeksiCatering | /she-048/delete-inspeksi-catering | POST | Delete catering inspection |
| Approve | /she-048/approve-inspeksi-catering | POST | Approve catering inspection |
| Reject | /she-048/reject-inspeksi-catering | POST | Reject catering inspection |
| Reset | /she-048/reset-inspeksi-catering/{id} | POST | Reset inspection status |
| PdfInspeksiCatering | /she-048/pdf-inspeksi-catering/{id} | GET | Generate PDF for inspection |

### 3. Eyewash Inspection Controller
**Controller**: `EyewashController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SHE`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /she-inspeksi/dashboard | GET | Display eyewash inspection dashboard |
| ExportForm | /she-inspeksi/form/export/{id} | GET | Export inspection form |
| AddForm | /she-inspeksi/form | GET | Display new inspection form |
| Store | /she-inspeksi/store | POST | Store new inspection |
| Update | /she-inspeksi/form/{id} | PUT | Update inspection |
| EditForm | /she-inspeksi/edit/{id} | GET | Edit inspection form |
| UpdateForm | /she-inspeksi/update | POST | Update inspection form |
| DeleteRecord | /she-inspeksi/delete/{id} | DELETE | Delete inspection record |
| ApproveRecord | /she-inspeksi/approve/{id} | POST | Approve inspection |
| RejectRecord | /she-inspeksi/reject/{id} | POST | Reject inspection |

### 4. P3K Management Controller
**Controller**: `P3KController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SHE`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /she-p3k/dashboard | GET | Display P3K management dashboard |
| ExportForm | /she-p3k/form/export/{id} | GET | Export P3K form |
| AddForm | /she-p3k/form | GET | Display new P3K form |
| Store | /she-p3k/store | POST | Store new P3K record |
| EditForm | /she-p3k/form/edit/{id} | GET | Edit P3K form |
| Update | /she-p3k/update/{id} | POST | Update P3K record |
| Approve | /she-p3k/approve/{id}/{role} | GET | Approve P3K by role |
| ApproveAll | /she-p3k/approve-all/{id} | GET | Approve all P3K items |
| SetUserNik | /she-p3k/set-user-nik | POST | Set user NIK for P3K |
| Delete | /she-p3k/delete/{id} | DELETE | Delete P3K record |

### 5. Air Minum Quality Controller
**Controller**: `AirMinumController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SHE`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /she-air-minum/dashboard | GET | Display air minum quality dashboard |
| ExportForm | /she-air-minum/form/export/{id} | GET | Export quality check form |
| AddForm | /she-air-minum/form | GET | Display new quality check form |
| Store | /she-air-minum/store | POST | Store new quality check |
| Update | /she-air-minum/form/{id} | POST | Update quality check |
| UpdateApprovalStatus | /she-air-minum/approve/{id}/{role} | GET | Update approval status |
| Delete | /she-air-minum/delete/{id} | DELETE | Delete quality check record |

### 6. Noise Monitoring Controller
**Controller**: `NoiseController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SHE`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /she-noise/dashboard | GET | Display noise monitoring dashboard |
| ExportForm | /she-noise/form/export/{id} | GET | Export noise check form |
| AddForm | /she-noise/form | GET | Display new noise check form |
| Store | /she-noise/store | POST | Store new noise check |
| Update | /she-noise/form/{id} | PUT | Update noise check |
| EditForm | /she-noise/edit/{id} | GET | Edit noise check form |
| ViewForm | /she-noise/view/{id} | GET | View noise check details |
| Delete | /she-noise/delete/{id} | DELETE | Delete noise check record |
| UpdateStatus | /she-noise/update-status | POST | Update noise check status |

### 7. Mess Inspection Controller
**Controller**: `SheMessController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SHE`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /she-mess/dashboard | GET | Display mess inspection dashboard |
| ExportForm | /she-mess/form/export/{id} | GET | Export mess inspection form |
| AddForm | /she-mess/form/{id?} | GET | Display new/edit mess inspection form |
| Store | /she-mess/store | POST | Store new mess inspection |
| Update | /she-mess/form/{id} | PUT | Update mess inspection |
| Approve | /she-mess/approve/{id}/{role} | GET | Approve mess inspection |
| Reject | /she-mess/reject/{id}/{role} | GET | Reject mess inspection |
| Delete | /she-mess/delete | DELETE | Delete mess inspection |
| EditForm | /she-mess/edit/{id} | GET | Edit mess inspection form |

### 8. Ergonomics Assessment Controller
**Controller**: `ErgonomiController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SHE`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /she-ergonomi/dashboard | GET | Display ergonomics dashboard |
| ExportForm | /she-ergonomi/form/export/{id} | GET | Export ergonomics assessment |
| AddForm | /she-ergonomi/form | GET | Display new assessment form |
| Store | /she-ergonomi/store | POST | Store new assessment |
| EditForm | /she-ergonomi/edit/{id} | GET | Edit assessment form |
| UpdateForm | /she-ergonomi/update | POST | Update assessment |
| Delete | /she-ergonomi/delete/{id} | DELETE | Delete assessment |
| Approve | /she-ergonomi/approve | POST | Approve assessment |

## Plant Operations Controllers

### 1. Welding Controller
**Controller**: `PlantWeldingController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| dashboard | /plant-welding/dashboard | GET | Display welding inspection dashboard |
| ExportForm | /plant-welding/form-welding/export/{id} | GET | Export welding inspection form |
| AddFormWelding | /plant-welding/form-welding | GET | Display new welding form |
| StoreWelding | /plant-welding/store-welding | POST | Store welding inspection data |
| EditWelding | /plant-welding/edit-welding/{id} | GET | Edit welding inspection |
| UpdateWelding | /plant-welding/update-welding/{id} | POST | Update welding inspection |
| destroy | /plant-welding/form-welding/{id} | DELETE | Delete welding inspection |
| ApprovalWelding | /plant-welding/approval-welding/{id} | GET | View welding approval |
| ApproveWelding | /plant-welding/approve-welding/{id} | POST | Approve welding inspection |
| RejectWelding | /plant-welding/reject-welding/{id} | POST | Reject welding inspection |

### 2. CMT Inspection Controller
**Controller**: `InspectionCmtController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| index | /plant/general-inspection/cmt/dashboard | GET | Display CMT inspection dashboard |
| print | /plant/general-inspection/cmt/{id}/print | GET | Print CMT inspection report |
| Approve | /plant/general-inspection/approve-cmt | POST | Approve CMT inspection |
| Reject | /plant/general-inspection/reject-cmt | POST | Reject CMT inspection |
| Reset | /plant/general-inspection/reset-cmt/{id} | POST | Reset CMT inspection status |
| getData | /plant/general-inspection/cmt/get-data | GET | Get CMT inspection data |

### 3. Dongfeng Inspection Controller
**Controller**: `InspectionDongfengController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| index | /plant/general-inspection/dongfeng/dashboard | GET | Display Dongfeng inspection dashboard |
| print | /plant/general-inspection/dongfeng/{id}/print | GET | Print Dongfeng inspection report |
| Approve | /plant/general-inspection/approve-dongfeng | POST | Approve Dongfeng inspection |
| Reject | /plant/general-inspection/reject-dongfeng | POST | Reject Dongfeng inspection |
| Reset | /plant/general-inspection/reset-dongfeng/{id} | POST | Reset Dongfeng inspection status |
| getData | /plant/general-inspection/dongfeng/get-data | GET | Get Dongfeng inspection data |


### 4. Compressor & Pump Controller
**Controller**: `CompressorPompaController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| dashboard | /plant-compressor/dashboard | GET | Display compressor dashboard |
| ExportForm | /plant-compressor/form-compressor/export/{id} | GET | Export compressor form |
| AddForm | /plant-compressor/form | GET | Display new compressor form |
| Store | /plant-compressor/store | POST | Store compressor data |
| EditForm | /plant-compressor/edit/{id} | GET | Edit compressor form |
| Update | /plant-compressor/update/{id} | POST | Update compressor data |
| Delete | /plant-compressor/delete/{id} | DELETE | Delete compressor record |
| Approve | /plant-compressor/approve/{id} | POST | Approve compressor record |
| Reject | /plant-compressor/reject/{id} | POST | Reject compressor record |

### 5. PPM XCMG XE1250 Controller
**Controller**: `PpmXcmgXE1250Controller.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /ppm-xe1250/dashboard | GET | Display PPM XE1250 dashboard |
| Export | /ppm-xe1250/export/{id} | GET | Export PPM form as PDF |
| Add | /ppm-xe1250/add | GET | Display new PPM form |
| Store | /ppm-xe1250/store | POST | Store PPM data |
| Edit | /ppm-xe1250/edit/{id} | GET | Edit PPM form |
| Update | /ppm-xe1250/update | POST | Update PPM data |
| Delete | /ppm-xe1250/delete | POST | Delete PPM record |
| Approve | /ppm-xe1250/approve-ppm.xe1250 | POST | Approve PPM record |
| Reject | /ppm-xe1250/reject-ppm.xe1250 | POST | Reject PPM record |
| Reset | /ppm-xe1250/reset-ppm.xe1250/{id} | POST | Reset PPM status |

### 6. PPM XCMG XE900D Controller
**Controller**: `PpmXcmg900dController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /ppm-900d/dashboard | GET | Display PPM 900D dashboard |
| Export | /ppm-900d/export/{id} | GET | Export PPM form as PDF |
| Add | /ppm-900d/add | GET | Display new PPM form |
| Store | /ppm-900d/store | POST | Store PPM data |
| Edit | /ppm-900d/edit/{id} | GET | Edit PPM form |
| Update | /ppm-900d/update | POST | Update PPM data |
| Delete | /ppm-900d/delete | POST | Delete PPM record |
| Approve | /ppm-900d/approve-ppm.900d | POST | Approve PPM record |
| Reject | /ppm-900d/reject-ppm.900d | POST | Reject PPM record |
| Reset | /ppm-900d/reset-ppm.900d/{id} | POST | Reset PPM status |

### 7. PPM XCMG XE700D Controller
**Controller**: `PpmXCMG700DController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /ppm-700d/dashboard | GET | Display PPM 700D dashboard |
| Export | /ppm-700d/export/{id} | GET | Export PPM form as PDF |
| Add | /ppm-700d/add | GET | Display new PPM form |
| Store | /ppm-700d/store | POST | Store PPM data |
| Edit | /ppm-700d/edit/{id} | GET | Edit PPM form |
| Update | /ppm-700d/update | POST | Update PPM data |
| Delete | /ppm-700d/delete | POST | Delete PPM record |
| Approve | /ppm-700d/approve-ppm.700d | POST | Approve PPM record |
| Reject | /ppm-700d/reject-ppm.700d | POST | Reject PPM record |
| Reset | /ppm-700d/reset-ppm.700d/{id} | POST | Reset PPM status |

### 8. PPM XCMG GR3005T Controller
**Controller**: `PpmXCMG3005TController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /ppm-3005T/dashboard | GET | Display PPM 3005T dashboard |
| Export | /ppm-3005T/export/{id} | GET | Export PPM form as PDF |
| Add | /ppm-3005T/add | GET | Display new PPM form |
| Store | /ppm-3005T/store | POST | Store PPM data |
| Edit | /ppm-3005T/edit/{id} | GET | Edit PPM form |
| Update | /ppm-3005T/update | POST | Update PPM data |
| Delete | /ppm-3005T/delete | POST | Delete PPM record |
| Approve | /ppm-3005T/approve-ppm.3005 | POST | Approve PPM record |
| Reject | /ppm-3005T/reject-ppm.3005 | POST | Reject PPM record |
| Reset | /ppm-3005T/reset-ppm.3005/{id} | POST | Reset PPM status |

### 9. PPM Shantui DH24 Controller
**Controller**: `PpmShantuiDH24Controller.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /ppm-dh24/dashboard | GET | Display PPM DH24 dashboard |
| Add | /ppm-dh24/add | GET | Display new PPM form |
| Store | /ppm-dh24/store | POST | Store PPM data |
| Edit | /ppm-dh24/edit/{id} | GET | Edit PPM form |
| Export | /ppm-dh24/export/{id} | GET | Export PPM form as PDF |
| Delete | /ppm-dh24/delete | POST | Delete PPM record |
| Approve | /ppm-dh24/approve-dh24 | POST | Approve PPM record |
| Reject | /ppm-dh24/reject-dh24 | POST | Reject PPM record |
| Reset | /ppm-dh24/reset-dh24/{id} | POST | Reset PPM status |
| Update | /ppm-dh24/update | POST | Update PPM data |

### 10. PPU XE1250 Controller
**Controller**: `PpuXE1250Controller.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PLANT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /ppu-xe1250/dashboard | GET | Display PPU XE1250 dashboard |
| Export | /ppu-xe1250/export/{id} | GET | Export PPU form as PDF |
| Add | /ppu-xe1250/add | GET | Display new PPU form |
| Store | /ppu-xe1250/store | POST | Store PPU data |
| Edit | /ppu-xe1250/edit/{id} | GET | Edit PPU form |
| Update | /ppu-xe1250/update | POST | Update PPU data |
| Delete | /ppu-xe1250/delete | POST | Delete PPU record |
| Approve | /ppu-xe1250/approve-ppu-xe1250 | POST | Approve PPU record |
| Reject | /ppu-xe1250/reject-ppu-xe1250 | POST | Reject PPU record |
| Reset | /ppu-xe1250/reset-ppu-xe1250/{id} | POST | Reset PPU status |

## Production Controllers

### 1. Coal Getting Controller
**Controller**: `CoalGettingController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PROD`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /prod-coal/dashboard | GET | Display coal getting dashboard |
| ExportForm | /prod-coal/form/export/{id} | GET | Export coal getting form |
| AddForm | /prod-coal/form | GET | Display new coal getting form |
| EditForm | /prod-coal/form/edit/{id} | GET | Edit coal getting form |
| Store | /prod-coal/store | POST | Store coal getting data |
| Update | /prod-coal/update/{id} | POST | Update coal getting data |
| Delete | /prod-coal/delete | POST | Delete coal getting record |
| updateStatus | /prod-coal/update-status | POST | Update coal getting status |

### 2. Anak Asuh Program Controller
**Controller**: `AnakAsuhController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\PROD`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /prod-anak-asuh/dashboard | GET | Display program dashboard |
| ExportForm | /prod-anak-asuh/form/export/{id} | GET | Export program form |
| AddForm | /prod-anak-asuh/form | GET | Display new program form |
| EditForm | /prod-anak-asuh/form/edit/{id} | GET | Edit program form |
| Store | /prod-anak-asuh/store | POST | Store program data |
| UpdateAnakAsuh | /prod-anak-asuh/update | POST | Update program data |
| Delete | /prod-anak-asuh/delete | POST | Delete program record |

### 3. Form Checker Controller
**Controller**: `FormCheckerController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\Production`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| dashboard | /dashboard | GET | Display form checker dashboard |
| ExportForm | /form-checker/export/{id} | GET | Export form checker |
| AddFormChecker | /form-checker | GET | Display new checker form |
| ShowFormChecker | /show/{id} | GET | Show checker form details |
| StoreChecker | /store-form-checker | POST | Store new checker form |
| Delete | /delete/{id} | DELETE | Delete checker form |
| Approve | /approve-form-checker | POST | Approve checker form |
| Reject | /reject-form-checker | POST | Reject checker form |
| Reset | /reset-form-checker/{id} | POST | Reset checker form status |
| Update | /update-form-checker | POST | Update checker form |
| detail | /detail/{id} | GET | View checker form details |
| getAlatBySite | /get-alat-by-site | GET | Get equipment by site |

### 4. Calibration CT Controller
**Controller**: `KalibrasiCtController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\Production`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /dashboard | GET | Display calibration dashboard |
| ExportForm | /form-kalibrasi-ct/export/{id} | GET | Export calibration form |
| AddFormKalibrasi | /form-kalibrasi-ct | GET | Display new calibration form |
| StoreKalibrasi | /store-kalibrasi-ct | POST | Store calibration data |
| EditKalibrasi | /edit-kalibrasi-ct/{id} | GET | Edit calibration form |
| UpdateKalibrasi | /form-kalibrasi-ct/{id} | POST | Update calibration data |
| destroy | /form-kalibrasi-ct/{id} | DELETE | Delete calibration record |
| ApprovalKalibrasi | /approval-form-kalibrasi-ct/{id} | GET | View calibration approval |
| ApproveKalibrasi | /approve-form-kalibrasi-ct/{id} | POST | Approve calibration |
| RejectKalibrasi | /reject-form-kalibrasi-ct/{id} | POST | Reject calibration |


## IT Operations Controllers

### 1. Printer Management Controller
**Controller**: `PrinterFormController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\IT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| IndexPrinterForm | /it-ops/dashboard-printer | GET | Display printer management dashboard |
| ExportPrinter | /it-ops/form-printer/{id}/export-pdf | GET | Export printer form as PDF |
| SubmitPrinterForm | /it-ops/submit-printer | POST | Submit new printer form |
| CreatePrinterForm | /it-ops/form-printer | GET | Display new printer form |
| EditPrinterForm | /it-ops/edit-printer | GET | Edit printer form |
| UpdatePrinterForm | /it-ops/update-printer | POST | Update printer form |
| DeletePrinterForm | /it-ops/delete-printer | POST | Delete printer record |

### 2. CCTV Management Controller
**Controller**: `CctvFormController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\IT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| IndexCctvForm | /it-ops/dashboard-cctv | GET | Display CCTV management dashboard |
| CreateCctvForm | /it-ops/form-cctv | GET | Display new CCTV form |
| SubmitCctvForm | /it-ops/submit-cctv | POST | Submit new CCTV form |
| ExportCctv | /it-ops/form-cctv/{id}/export-pdf | GET | Export CCTV form as PDF |
| EditCctvForm | /it-ops/edit-cctv | GET | Edit CCTV form |
| UpdateCctvForm | /it-ops/update-cctv | POST | Update CCTV form |
| DeleteCctvForm | /it-ops/delete-cctv | POST | Delete CCTV record |

### 3. Device Management Controller
**Controller**: `DeviceFormController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\IT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| IndexDeviceForm | /it-ops/dashboard-device | GET | Display device management dashboard |
| CreateDeviceForm | /it-ops/form-device | GET | Display new device form |
| SubmitDeviceForm | /it-ops/submit-device | POST | Submit new device form |
| ExportDevice | /it-ops/form-device/{id}/export-pdf | GET | Export device form as PDF |
| EditDeviceForm | /it-ops/edit-device | GET | Edit device form |
| UpdateDeviceForm | /it-ops/update-device | POST | Update device form |
| DeleteDeviceForm | /it-ops/delete-device | POST | Delete device record |

### 4. Router Management Controller
**Controller**: `RouterFormController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\IT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| Dashboard | /it-ops/dashboard-router | GET | Display router management dashboard |
| CreateRouterForm | /it-ops/form-router | GET | Display new router form |
| SubmitRouterForm | /it-ops/submit-router | POST | Submit new router form |
| ExportRouter | /it-ops/form-router/{id}/export-pdf | GET | Export router form as PDF |
| EditRouterForm | /it-ops/edit-router | GET | Edit router form |
| UpdateRouterForm | /it-ops/update-router | POST | Update router form |
| DeleteRouterForm | /it-ops/delete-router | POST | Delete router record |

## Support Services Controllers

### 3. Asset Request Controller
**Controller**: `AssetRequestController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SUPPORT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| IndexForm | /sm/asset-request | GET | Display asset request form |
| EditForm | /sm/edit-form-asset-request | GET | Edit asset request |
| SubmitEditForm | /sm/submit-edit-asset-request | POST | Submit edited request |
| DashboardForm | /sm/dashboard | GET | Display request dashboard |
| SubmitFormAssetRequest | /sm/add-asset-request | POST | Submit new asset request |
| GetFormsData | /sm/get-forms-data | GET | Get request forms data |
| FormDetailByNoDoc | /sm/get-form-detail | GET | Get request details |
| download | /sm/asset-request-download/{fileName} | GET | Download request document |
| ValidasiRequest | /sm/validasi-asset-request | POST | Validate asset request |

### 4. Supplier Registration Controller
**Controller**: `RegistrasiSupplierController.php`
**Namespace**: `Modules\SmartForm\App\Http\Controllers\SUPPORT`

| Function | Route | Method | Purpose |
|----------|-------|--------|----------|
| RegisSupplierDashboard | /sm/registrasi-supplier | GET | Display registration dashboard |
| GetListRegistrasiSupplier | /sm/list-supplier | GET | Get list of suppliers |
| FormRegistrasiSupplier | /sm/form-registrasi-supplier | GET | Display registration form |
| CreateRegisSupplier | /sm/create-registrasi-supplier | POST | Create new supplier |
| RubahRegisSupplier | /sm/edit-supplier | GET | Edit supplier registration |
| ApproveRegisSupplier | /sm/lihat-approve-supplier | GET | View supplier approval |
| updateRegisSupplier | /sm/update-supplier | POST | Update supplier details |
| approveSupplier | /sm/approve-supplier | GET | Approve supplier |
| DeleteSupplier | /sm/delete-supplier | GET | Delete supplier |
| PdfRegSupplier | /sm/pdf-registrasi-supplier | GET | Generate PDF for supplier |
| SupplierDetailById | /sm/get-supplier-detail | GET | Get supplier details |
| DownloadNpwpSupplier | /sm/file-npwp-supplier-download/{fileNpwp} | GET | Download NPWP file |
| DownloadSppkpSupplier | /sm/file-sppkp-supplier-download/{fileSppkp} | GET | Download SPPKP file |
| DownloadNibSupplier | /sm/file-nib-supplier-download/{fileNib} | GET | Download NIB file |
| SubmitApproveSupplier | /sm/submit-approve-supplier | POST | Submit supplier approval |
| SubmitRejectSupplier | /sm/submit-reject-supplier | POST | Submit supplier rejection |
| DeleteRequestMaster | /log/delete-request-master | POST | Delete material request |
