@extends('master.master_page')


@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .is-invalid {
        border-bottom-color: #dc3545 !important;
    }

    .input-group.input-group-dynamic.is-focused label, .input-group.input-group-static.is-focused label {
        color: #7b809a !important;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">FORM BSS-FRM-LOG-002 REQUEST MASTER</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <form action="">
                        <div class="row gx-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="w-100">
                                            <tr>
                                                <td class="fw-bold">No. Doc</td>
                                                <td id="noDoc">No.Doc</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Created  By</td>
                                                <td>{{ session('username') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Created  Date</td>
                                                <td id="tglDoc"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="w-100">
                                            <tr>
                                                <td class="fw-bold">Request Cataloging</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="idCataloging" name="idCataloging">
                                                        <option disabled selected>-- select user --</option>
                                                        @forelse($users as $catalog)
                                                            <option value="{{ $catalog->NIK ?? '' }}">
                                                                {{ $catalog->nama ?? 'Nama tidak tersedia' }}
                                                            </option>
                                                        @empty
                                                            <option>Data karyawan tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="fw-bold">Request Approval</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iApproval" name="iApproval" required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                    </select>
                                                    <input type="hidden" name="acknowledged_by_nik" value="{{ $record->acknowledged_by_nik ?? '' }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="fw-bold">Site</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iSite" name="iSite">
                                                        <option disabled selected>-- select site --</option>
                                                        @forelse($sites as $site)
                                                            <option value="{{ $site->KodeST ?? '' }}">
                                                                {{ $site->KodeST ?? 'Site tidak tersedia' }}
                                                            </option>
                                                        @empty
                                                            <option>Data site tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Kode Plant</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iPlant" name="iPlant">
                                                        <option disabled selected>-- select kode plant --</option>
                                                        @forelse($plants as $code => $value)
                                                            <option value="{{ $code }}">
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data kode plan tidak ditemukan</option>
                                                        @endforelse
        
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                   
                                    
                                </div>
                            </div>
                        
                               
                        </div>

                        <div class="my-3">
                            <div class="mb-1">
                                <h4 class="h4 mb-3">Item</h4>
                                <hr class="border-bottom">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iKodeMaster">Kode Master</label>
                                            <input type="text" class="form-control" id="iKodeMaster" name="iKodeMaster" disabled>
                                            <small class="text-muted">kode master akan di isi oleh cataloging</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iPartName">Part Name</label>
                                            <input type="text" class="form-control" id="iPartName" name="iPartName">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iUom">UoM</label>
                                            <select class="form-control form-select" id="iUom" name="iUom">
                                                @forelse($uoms as $code => $value)
                                                    <option value="{{ $code }}">
                                                        {{ $value }}
                                                    </option>
                                                @empty
                                                    <option>Data UoM tidak ditemukan</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iPartNumber">Part Number</label>
                                            <input type="text" class="form-control" id="iPartNumber" name="iPartNumber">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iBrand">Brand</label>
                                            <input type="text" class="form-control" id="iBrand" name="iBrand">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iGen">Gen/ITC</label>
                                            <select class="form-control form-select" id="iGen" name="iGen">
                                                <option value="Yes">Yes</option>
                                                <option value="Yes">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iModel">Model</label>
                                            <input type="text" class="form-control" id="iModel" name="iModel">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iCompartemen">Compartemen</label>
                                            <input type="text" class="form-control" id="iCompartemen" name="iCompartemen">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iFff">FFF Class</label>
                                            <input type="text" class="form-control" id="iFff" name="iFff">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iPlanMat">Plan Material Status</label>
                                            <input type="text" class="form-control" id="iPlanMat" name="iPlanMat">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iMrp">MRP Type</label>
                                            <select class="form-control form-select" id="iMrp" name="iMrp">
                                                <option value="" selected disabled>-- Select MRP Type --</option>
                                                <option value="ND">ND - No Planning</option>
                                                <option value="PD">PD - MRP</option>
                                                <option value="V1">V1 - Manual Reorder Point w. ext.reqs</option>
                                                <option value="ZB">ZB - BSS Automatic Reorder Point Plng</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iScrap">SCRAP</label>
                                            <select class="form-control form-select" id="iScrap" name="iScrap">
                                                <option value="" selected disabled>-- Select Scrap --</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iMatType">Material Type</label>
                                            <select class="form-control form-select" id="iMatType" name="iMatType">
                                                @forelse($materialTypes as $code => $value)
                                                    <option value="{{ $code }}">
                                                        {{ $value }}
                                                    </option>
                                                @empty
                                                    <option>Data Material Type tidak ditemukan</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iMatGroup">Material Group</label>
                                            <select class="form-control form-select" id="iMatGroup" name="iMatGroup">
                                                @forelse($materialGroups as $code => $value)
                                                    <option value="{{ $code }}">
                                                        {{ $value }}
                                                    </option>
                                                @empty
                                                    <option>Data Material Group tidak ditemukan</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iVal">Valuation Class</label>
                                            <select class="form-control form-select" id="iVal" name="iVal">
                                                @forelse($vulationClass as $code => $value)
                                                    <option value="{{ $code }}">
                                                        {{ $value }}
                                                    </option>
                                                @empty
                                                    <option>Data Vulation class tidak ditemukan</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iPG">Purchasing Group</label>
                                            <select class="form-control form-select" id="iPG" name="iPG">
                                                @forelse($purchasingGroups as $code => $value)
                                                    <option value="{{ $code }}">
                                                        {{ $value }}
                                                    </option>
                                                @empty
                                                    <option>Data Purchasing Group tidak ditemukan</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iSerialNum">Serial Number</label>
                                            <select class="form-control form-select" id="iSerialNum" name="iSerialNum">
                                                @forelse($serialNumbers as $code => $value)
                                                    <option value="{{ $code }}">
                                                        {{ $value }}
                                                    </option>
                                                @empty
                                                    <option>Data Serial Number tidak ditemukan</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group-static mb-4">
                                            <button id="btn-add-item" class="btn btn-primary">Tambah</button> 
                                            <button id="btn-reset-item" style="margin-left:2px" class="btn btn-secondary">Reset</button>                                            
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="item-master" class="display" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="kodeMaster">Kode Master</th>
                                        <th data-field="partName">Part Name</th>
                                        <th data-field="uom">UoM</th>
                                        <th data-field="partNumber">Part Number</th>
                                        <th data-field="brand">Brand</th>
                                        <th data-field="gen">Gen/ITC</th>
                                        <th data-field="model">Model</th>
                                        <th data-field="compartement">Compartement</th>
                                        <th data-field="fffC">FFF Class</th>
                                        <th data-field="planMatStatus">Plan Material Status</th>
                                        <th data-field="mrpType">MRP TYPE</th>
                                        <th data-field="scrap">SCRAP</th>
                                        <th data-field="matType">Material Type</th>
                                        <th data-field="matGroup">Material Group</th>
                                        <th data-field="valuationStatus">Valuation Status</th>
                                        <th data-field="purchasingGroup">Purchasing Group</th>
                                        <th data-field="serialNumber">Serial Number</th>
                                        <th data-formatter="actionFormatter">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>

                     <!-- Edit Item Modal -->
                     <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editItemForm">
                                        <input type="hidden" id="editIndex">
                                        <div class="row mb-2">
                                            {{-- <div class="col-12">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iKodeMaster">Kode Master</label>
                                                    <input type="text" class="form-control" id="editKodeMaster" name="iKodeMaster" disabled>
                                                </div>
                                            </div> --}}
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iPartName">Part Name</label>
                                                    <input type="text" class="form-control" id="editPartName" name="iPartName">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iUom">UoM</label>
                                                    <select class="form-control form-select" id="editUom" name="iUom">
                                                        @forelse($uoms as $code => $value)
                                                            <option value="{{ $code }}">
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data UoM tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iPartNumber">Part Number</label>
                                                    <input type="text" class="form-control" id="editPartNumber" name="iPartNumber">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iBrand">Brand</label>
                                                    <input type="text" class="form-control" id="editBrand" name="iBrand">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iGen">Gen/ITC</label>
                                                    <select class="form-control form-select" id="editGen" name="iGen">
                                                        <option value="Yes">Yes</option>
                                                        <option value="Yes">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iModel">Model</label>
                                                    <input type="text" class="form-control" id="editModel" name="iModel">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iCompartemen">Compartement</label>
                                                    <input type="text" class="form-control" id="editCompartement" name="iCompartemen">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iFff">FFF Class</label>
                                                    <input type="text" class="form-control" id="editFffC" name="iFff">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iPlanMat">Plan Material Status</label>
                                                    <input type="text" class="form-control" id="editPlanMatStatus" name="iPlanMat">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iMrp">MRP Type</label>
                                                    <select class="form-control form-select" id="editMrpType" name="iMrp">
                                                        <option value="" selected disabled>-- Select MRP Type --</option>
                                                        <option value="ND">ND - Not Planned</option>
                                                        <option value="PD">PD - MRP</option>
                                                        <option value="VB">VB - Manual Reorder Point</option>
                                                        <option value="VV">VV - Automatic Reorder Point</option>
                                                        <option value="X1">X1 - Project Planning</option>
                                                        <option value="R1">R1 - Time-Phased Planning</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iScrap">SCRAP</label>
                                                    <input type="text" class="form-control" id="editScrap" name="iScrap">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iMatType">Material Type</label>
                                                    <select class="form-control form-select" id="editMatType" name="iMatType">
                                                        @forelse($materialTypes as $code => $value)
                                                            <option value="{{ $code }}">
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data Material Type tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iMatGroup">Material Group</label>
                                                    <select class="form-control form-select" id="editMatGroup" name="iMatGroup">
                                                        @forelse($materialGroups as $code => $value)
                                                            <option value="{{ $code }}">
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data Material Group tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iVal">Valuation Class</label>
                                                    <select class="form-control form-select" id="editValuationStatus" name="iVal">
                                                        @forelse($vulationClass as $code => $value)
                                                            <option value="{{ $code }}">
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data Vulation class tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iPG">Purchasing Group</label>
                                                    <select class="form-control form-select" id="editPurchasingGroup" name="iPG">
                                                        @forelse($purchasingGroups as $code => $value)
                                                            <option value="{{ $code }}">
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data Purchasing Group tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="iSerialNum">Serial Number</label>
                                                    <select class="form-control form-select" id="editSerialNumber" name="iSerialNum">
                                                        @forelse($serialNumbers as $code => $value)
                                                            <option value="{{ $code }}">
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data Serial Number tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveEditItem">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitRequestMaster" style="margin:5px">
                                <i class="fas fa-save"></i> &nbsp;
                                Submit Form
                            </button>
                            <a href="{{url()->previous()}}" class="btn btn-secondary" style="margin:5px"><i class="fas fa-cancel"></i> &nbsp; Cancel</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        $(function() {
            $('#iApproval').select2({
                placeholder: '-- Pilih Pengawas --',
                width: '50%',
                ajax: {
                    url: '{{ route("approval.list") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { search: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.nama,
                                    text: item.nama + ' (' + item.nik + ')',
                                    nik: item.nik
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#idCataloging').select2();
            $('#iSite').select2();
            $('#iSite').select2();
            $('#iPlant').select2();
        });
        var tglNow = new Date()
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var months_romawi = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

        var btnSubmitRequestMaster = $("#btnSubmitRequestMaster");
        var $table = $("#item-master");
        var $buttonTambah = $("#btn-add-item")
        var $buttonReset = $("#btn-reset-item")
        
        // Variable form
        var tanggalSekarang = $("#tanggalSekarang")
        var noDoc = $("#noDoc");
        var tglDoc = $("#tglDoc");
        var iApproval = $("#iApproval")
        var iSite = $("#iSite")
        var idCataloging = $("#idCataloging")
        var iPlant = $("#iPlant")
        
        // Variable items
        var iKodeMaster = $("#iKodeMaster")
        var iPartName = $("#iPartName")
        var iUom = $("#iUom")
        var iPartNumber = $("#iPartNumber")
        var iBrand = $("#iBrand")
        var iGen = $("#iGen")
        var iModel = $("#iModel")
        var iCompartemen = $("#iCompartemen")
        var iFff = $("#iFff")
        var iPlanMat = $("#iPlanMat")
        var iMrp = $("#iMrp")
        var iScrap = $("#iScrap")
        var iMatType = $("#iMatType")
        var iMatGroup = $("#iMatGroup")
        var iVal = $("#iVal")
        var iPG = $("#iPG")
        var iSerialNum = $("#iSerialNum")

        var dataRequestMaster = {
            formName: "Request Master",
            noDoc: "",
            tglDoc: "",
            site: "",
            approval: "",
            cataloging: "",
            kodePlant: "",
            item: [{}]
        }

        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        tanggalSekarang.attr('min', getTodayDate())

        function indexFormatter(value, row, index) {
            return index + 1;
        }

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }

        function generateNoDoc() {
            return "_/BSS-FRM-LOG-002/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
        }

        function validateInput() {

        }

        function actionFormatter(value, row, index) {
            return `
                    <a class="btn btn-warning btn-sm edit-kode-master " data-index="${index}" href="javascript:void(0)">
                    Edit
                </a>
                    <a class="btn btn-danger btn-sm " onclick="deleteRow(${index})" href="javascript:void(0)">Delete</a>
            `;
        }

        function deleteRow(id) {
            $table.bootstrapTable('remove', {
                field: '$index',
                values: [id]
            })
        }

        function submitRequestMaster(data) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                url: "bss-form/log/add-request-master",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {

                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                    console.log()
                }
            })
        }

        $table.on('post-body.bs.table', function(data) {
            var items = [];
            data.sender.data.forEach(function (item, index, arr) {
                // console.log(item)
                if(item.currency == "IDR") {
                    idr = idr + parseInt(item.price) * item.qty
                }
                if(item.currency == "USD") {
                    usd = usd + parseInt(item.price) * item.qty
                }
                if(item.currency == "CNY") {
                    cny = cny + parseInt(item.price) * item.qty
                }
                item.no = index;
                items.push(item)
            })
            dataRequestMaster.item = items
        })

        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }

        $(function() {
            // Handle supervisor selection
            $('select[name="iApproval"]').change(function() {
                var selectedText = $(this).find('option:selected').text();
                var match = selectedText.match(/\(([^)]+)\)/);
                var nik = match ? match[1] : '';
                $('input[name="acknowledged_by_nik"]').val(nik);
            });

            // Trigger change on load if there's a value
            if ($('select[name="iApproval"]').val()) {
                $('select[name="iApproval"]').trigger('change');
            }

            noDoc.text(generateNoDoc())
            tglDoc.text(formatTgl() || "-")

            dataRequestMaster.approval = iApproval.val()
            dataRequestMaster.site = iSite.val()

            
             // Edit item functionality
             $(document).on('click', '.edit-kode-master', function() {
                var index = $(this).data('index');
                var rowData = $table.bootstrapTable('getData')[index];

                 // Clear previous validation errors
                $('#editItemForm').find('.is-invalid').removeClass('is-invalid');
                $('#editItemForm').find('.invalid-feedback').remove();

                // Populate the modal with row data
                $('#editIndex').val(index);
                $('#editKodeMaster').val(rowData.kodeMaster);
                $('#editPartName').val(rowData.partName);
                $('#editUom').val(rowData.uom);
                $('#editPartNumber').val(rowData.partNumber);
                $('#editBrand').val(rowData.brand);
                $('#editGen').val(rowData.gen);
                $('#editModel').val(rowData.model);
                $('#editCompartement').val(rowData.compartement);
                $('#editFffC').val(rowData.fffC);
                $('#editPlanMatStatus').val(rowData.planMatStatus);
                $('#editMrpType').val(rowData.mrpType);
                $('#editScrap').val(rowData.scrap);
                $('#editMatType').val(rowData.matType);
                $('#editMatGroup').val(rowData.matGroup);
                $('#editValuationStatus').val(rowData.valuationStatus);
                $('#editPurchasingGroup').val(rowData.purchasingGroup);
                $('#editSerialNumber').val(rowData.serialNumber);
                
                // Show the modal
                var editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
                editModal.show();
            });

            // Function to validate edit form
            function validateEditForm() {
                let isValid = true;
                const requiredFields = [
                    'editPartName', 'editUom', 'editPartNumber', 'editBrand', 'editGen',
                    'editModel', 'editCompartement', 'editFffC', 'editPlanMatStatus',
                    'editMrpType', 'editScrap', 'editMatType', 'editMatGroup',
                    'editValuationStatus', 'editPurchasingGroup', 'editSerialNumber'
                ];

                // Clear previous validation errors
                $('#editItemForm').find('.is-invalid').removeClass('is-invalid');
                $('#editItemForm').find('.invalid-feedback').remove();

                // Validate each required field
                requiredFields.forEach(fieldId => {
                    const field = $(`#${fieldId}`);
                    if (!field.val()) {
                        field.addClass('is-invalid');
                        field.after(`<div class="invalid-feedback">Tidak boleh kosong</div>`);
                        isValid = false;
                    }
                });

                return isValid;
            }

            // Save edited item
            $('#saveEditItem').click(function() {
                if (!validateEditForm()) {
                    return; // Don't proceed if validation fails
                }

                var index = $('#editIndex').val();
                var updatedRow = {
                    kodeMaster: $('#editKodeMaster').val(),
                    partName: $('#editPartName').val(),
                    uom: $('#editUom').val(),
                    partNumber: $('#editPartNumber').val(),
                    brand: $('#editBrand').val(),
                    gen: $('#editGen').val(),
                    model: $('#editModel').val(),
                    compartement: $('#editCompartement').val(),
                    fffC: $('#editFffC').val(),
                    planMatStatus: $('#editPlanMatStatus').val(),
                    mrpType: $('#editMrpType').val(),
                    scrap: $('#editScrap').val(),
                    matType: $('#editMatType').val(),
                    matGroup: $('#editMatGroup').val(),
                    valuationStatus: $('#editValuationStatus').val(),
                    purchasingGroup: $('#editPurchasingGroup').val(),
                    serialNumber: $('#editSerialNumber').val()
                };
                
                // Update the table row
                $table.bootstrapTable('updateRow', {
                    index: index,
                    row: updatedRow
                });
                
                // Close the modal
                var editModal = bootstrap.Modal.getInstance(document.getElementById('editItemModal'));
                editModal.hide();
            });


            function validateItem() {
                var errorValidate = []

                if(iPartName.val() == "") {
                    errorValidate.push({
                        field: "Part Name",
                        message: "tidak boleh kosong"
                    })
                }
                if(iUom.val() == "") {
                    errorValidate.push({
                        field: "UoM",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPartNumber.val() == "") {
                    errorValidate.push({
                        field: "Part Number",
                        message: "tidak boleh kosong"
                    })
                }
                if(iBrand.val() == "") {
                    errorValidate.push({
                        field: "Brand",
                        message: "tidak boleh kosong"
                    })
                }
                if(iGen.val() == "") {
                    errorValidate.push({
                        field: "Gen",
                        message: "tidak boleh kosong"
                    })
                }
                if(iModel.val() == "") {
                    errorValidate.push({
                        field: "Model",
                        message: "tidak boleh kosong"
                    })
                }
                if(iCompartemen.val() == "") {
                    errorValidate.push({
                        field: "Compartement",
                        message: "tidak boleh kosong"
                    })
                }
                if(iFff.val() == "") {
                    errorValidate.push({
                        field: "FFF Class",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPlanMat.val() == "") {
                    errorValidate.push({
                        field: "Plan material",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMrp.val() == "") {
                    errorValidate.push({
                        field: "MRP",
                        message: "tidak boleh kosong"
                    })
                }
                if(iScrap.val() == "") {
                    errorValidate.push({
                        field: "Scrap",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMatType.val() == "") {
                    errorValidate.push({
                        field: "Material type",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMatType.val() == "") {
                    errorValidate.push({
                        field: "Material Type",
                        message: "tidak boleh kosong"
                    })
                }
                if(iVal.val() == "") {
                    errorValidate.push({
                        field: "Valuation status",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPG.val() == "") {
                    errorValidate.push({
                        field: "Purchasing Group",
                        message: "tidak boleh kosong"
                    })
                }
                if(iSerialNum.val() == "") {
                    errorValidate.push({
                        field: "Serial Number",
                        message: "tidak boleh kosong"
                    })
                }
                return errorValidate
            }

            function validateForm() {
                var errorValidate = []
                
                if(idCataloging.val() == ""){
                    errorValidate.push({
                        field: "Request cataloging",
                        message: "Harus dipilih"
                    })
                }
                if(iApproval.val() == ""){
                    errorValidate.push({
                        field: "Request approval",
                        message: "Harus dipilih"
                    })
                }
                if(iSite.val() == ""){
                    errorValidate.push({
                        field: "Site",
                        message: "Harus dipilih"
                    })
                }
                if(iPlant.val() == ""){
                    errorValidate.push({
                        field: "Kode Plants",
                        message: "Harus dipilih"
                    })
                }
                if($table.bootstrapTable('getData').length < 1) {
                    errorValidate.push({
                        field: "Item",
                        message: "minimal harus ada 1"
                    })
                }

                return errorValidate
            }

            $buttonTambah.click(function (e) {
                e.preventDefault()
                var errorValidate = validateItem()
                
                var msg = "";
                if(errorValidate.length > 0) {
                    for (var listErr of errorValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi item',
                        html: msg,
                    }).then((result) => {
                    })
                } else {
                    $table.bootstrapTable('append', {
                        kodeMaster: iKodeMaster.val(),
                        partName: iPartName.val(),
                        uom: iUom.val(),
                        partNumber: iPartNumber.val(),
                        brand: iBrand.val(),
                        gen: iGen.val(),
                        model: iModel.val(),
                        compartement: iCompartemen.val(),
                        fffC: iFff.val(),
                        planMatStatus: iPlanMat.val(),
                        mrpType: iMrp.val(),
                        scrap: iScrap.val(),
                        matType: iMatType.val(),
                        matGroup: iMatGroup.val(),
                        valuationStatus: iVal.val(),
                        purchasingGroup: iPG.val(),
                        serialNumber: iSerialNum.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                }
            })

            $buttonReset.click(function (e) {
                e.preventDefault()
                iPartName.val("")
                iUom.val("")
                iPartNumber.val("")
                iBrand.val("")
                iGen.val("")
                iModel.val("")
                iCompartemen.val("")
                iFff.val("")
                iPlanMat.val("")
                iMrp.val("")
                iScrap.val("")
                iMatType.val("")
                iMatGroup.val("")
                iVal.val("")
                iPG.val("")
                iSerialNum.val("")
            });

            btnSubmitRequestMaster.click(function(e) {
                e.preventDefault();

                var errValidate = validateForm()
                if(errValidate.length > 0) {
                    var msg = ""
                    for (var listErr of errValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi',
                        html: msg,
                    }).then((result) => {
                    })
                } else {
                    var dataReq = {
                        formName: dataRequestMaster.formName,
                        noDoc: noDoc.text(),
                        tglDoc: formatTgl(),
                        site: iSite.val(),
                        disetujuiOleh: iApproval.val(),
                        cataloging: idCataloging.val(),
                        kodePlant: iPlant.val(),
                    }
                    let formData = new FormData();
                    formData.append('item',JSON.stringify(dataRequestMaster.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    showLoading();
                    axios.post('/bss-form/log/add-request-master', formData, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        showLoading()
                        console.log(response.data)
                        Swal.fire({
                                icon: 'success',
                                title: 'Request sukses direkam dengan no dokumen:',
                                text: response.data.data.no_doc,
                            }).then((result) => {
                                window.location.href = `/bss-form/log/request-master`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                        stopLoading()
                    })
                    .finally(function() {
                        stopLoading()
                    });
                }
                
            })
        })
    </script>
@endsection
