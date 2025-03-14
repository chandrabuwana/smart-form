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
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Registrasi Supplier</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                <div class="row card-header"
                        style="margin : 10px;border-radius: 10px; background-color: rgba(209, 209, 209, 0.301); color:white !important;">
                        <div class="row">
                            <div class="col">
                                <h6 class="card-title">Filter</h6>
                                <hr class="horizontal dark my-sm-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERSTATUS" class="ms-0">Status </label>
                                            <select class="form-control status" name="FILTERSTATUS" id="FILTERSTATUS">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERNAMAVENDOR" class="ms-0">Nama Vendor </label>
                                            <select class="form-control namavendor" name="FILTERNAMAVENDOR" id="FILTERNAMAVENDOR">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERKOTA" class="ms-0">Kota </label>
                                            <select class="form-control kota" name="FILTERKOTA" id="FILTERKOTA">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary ms-auto uploadBtn"
                                            onclick="dataListFormSupplierSearchGenerate(this);">
                                            <i class="fa fa-filter"> Search</i> </button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center ms-3">
                        <a href="{{ route('bss-form.sm.form-registrasi-supplier') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="dataListFormRegisSupplier" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server" data-query-params="dataListFormSupplierParamsGenerate"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="id" data-align="left" data-halign="text-center" data-sortable="true">Unik ID</th>
                                    <th data-field="nama_vendor" data-align="left" data-halign="text-center" data-sortable="true">Nama Supplier</th>
                                    <th data-field="status" data-align="left" data-formatter="statusFormater" data-halign="text-center" data-sortable="true">Status</th>
                                    <th data-field="no_npwp" data-align="left" data-halign="text-center" data-sortable="true">No NPWP</th>
                                    <th data-field="bidang_usaha" data-align="left" data-halign="text-center" data-sortable="true">Bidang Usaha</th>
                                    <th data-field="kota" data-align="left" data-halign="text-center" data-sortable="true">Kota</th>
                                    <!-- <th data-field="action" data-formatter="actionFormatter" >Actions</th> -->
                                    <th data-field="action" data-formatter="dataListFormSupplierActionFormater" >Actions</th>
                                     
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script type="text/javascript">
        var $table = $("#list-data");

        var additonalQuery = {
            tanggal: null,
            nama: null
        }

        btnClearFilter.addEventListener("click", function(e) {

        })
        
        function debounce (func, wait){
            let timeout;
            
            return function executedFunction(...args) {
                var later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };

                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        };        
        
        function dataListFormSupplierParamsGenerate(params) {

            params.search = {
                'FILTERSTATUS': $('#FILTERSTATUS').val(),
                'FILTERNAMAVENDOR': $('#FILTERNAMAVENDOR').val(),
                'FILTERKOTA': $('#FILTERKOTA').val()
            };

            if (params.sort == undefined) {
                return {
                    limit: params.limit,
                    offset: params.offset,
                    search: params.search
                }
            }
            return params;
        }

        function myFunction() {
            if(!confirm("Yakin ingin menghapus data ini?"))
            event.preventDefault();
        }

        // <a class="btn btn-info btn-action btn-sm me-1" href="/bss-form/sm/edit-registrasi-supplier/${row.id}">Edit</a>
        // <a class="btn btn-danger btn-action btn-sm" onclick="return myFunction();" href="/bss-form/sm/delete-supplier/${row.id}">Delete</a>
        function actionFormatter(value, row, index) {
            return `
                <a class="btn btn-primary btn-action btn-sm" href="/bss-form/sm/pdf-registrasi-supplier/${row.id}">Pdf</a>
            `;
        }

        function dataListFormSupplierActionFormater(value, row, index) {
            let data = `
                    <button onclick="RedirectViewPica(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i> View
                    </a></button>
                `
            if (row.nik == $("#UserLoginNIK").val() && (row.approval != "approved")) {
                data += `<button onclick="redirectToAddStepPica(this)"><a class="like" title="Like">
                        <i class="fa fa-plus"></i> Step
                    </a></button>`
            }
            return data;
        }

        function statusFormater(value, row, index) {
            if (value == "STEP NOT SET") {
                return `<button type="button" class="btn btn-primary btn-sm">Step Not Yet</button>`
            } else if (value == 'NEED APPROVAL') {
                return `<button type="button" class="btn btn-warning btn-sm">${value}</button>`
            } else if (value == 'APPROVED') {
                return `<button type="button" class="btn btn-danger btn-sm">${value}</button>`
            } else if (value == 'REJECT') {
                return `<button type="button" class="btn btn-danger btn-sm">${value}</button>`
            } else {
                return `<button type="button" class="btn btn-secondary btn-sm">???</button>`
            }
        }

        function dataListFormRegisSupplierGenerateData(params) {
            var url = '/helper/data-regis-supplier'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = '/bss-form/sm/list-supplier'
            // console.log(params.data)
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function dataListFormSupplierSearchGenerate(obj) {
            $('#dataListFormRegisSupplier').bootstrapTable('refresh');
            $("#dataListFormRegisSupplier").bootstrapTable("uncheckAll");
        }
    </script>
@endsection
