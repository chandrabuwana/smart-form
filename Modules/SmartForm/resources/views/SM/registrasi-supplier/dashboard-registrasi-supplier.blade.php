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
    .status {
        display: flex;
        gap: 10px;
        align-items: center;
        font-family: Arial, sans-serif;
        padding: 3px;
        font-size: 12px;
    }
    .box {
        width: 20px;
        height: 20px;
        display: inline-block;
        border-radius: 4px;
        font-size: 12px;
    }
    .grey {
        background-color:rgb(134, 132, 132);
    }

    .green {
        background-color: #4CAF50;
    }

    .red {
        background-color:rgb(255, 38, 0);
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
                    <div style="margin : 10px;">
                        <a href="{{ route('bss-form.sm.form-registrasi-supplier') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>

                    <div class="row card-header" style="margin : 10px;border-radius: 10px; background-color: rgba(209, 209, 209, 0.301); color:black !important;">
                        <h4>Filter Data</h4>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterNik">NIK Requestor</label>
                                <select style="width: 100%" id="filterNik" name="filterNik"></select>
                                </input>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterSite">Site</label>
                                <select style="width: 100%" id="filterSite" name="filterSite"></select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="start_date" class="ms-0">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                    value="{{ $start_date ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="end_date" class="ms-0">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                    value="{{ $end_date ?? '' }}">
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnFilterSubmit" onclick="applyFilter(this)">
                                Filter
                            </button>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnClearFilter" onclick="clearFilter(this)">
                                Clear Filter
                            </button>
                        </div>
                    </div>

                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="status me-2">
                                <label>Status :</label>
                            </div>
                            <div class="status me-2">
                                <span class="box grey"></span> Need Approval
                            </div>
                            <div class="status me-2">
                                <span class="box green"></span> Approved
                            </div>
                            <div class="status me-2">
                                <span class="box red"></span> Rejected
                            </div>
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
                                    <th data-field="diisi_oleh" data-align="left" data-halign="text-center" data-sortable="true">Dibuat_oleh</th>
                                    <th data-field="nama_vendor" data-align="left" data-halign="text-center" data-sortable="true">Nama Supplier</th>
                                    <!-- <th data-field="no_npwp" data-align="left" data-halign="text-center" data-sortable="true">No NPWP</th> -->
                                    <!-- <th data-field="bidang_usaha" data-align="left" data-halign="text-center" data-sortable="true">Bidang Usaha</th> -->
                                    <th data-field="disetujui_oleh" data-align="left" data-halign="text-center" data-sortable="true">Approved By</th>
                                    <th data-field="is_active" data-align="left" data-formatter="statusActive" data-halign="text-center" data-sortable="true">Is Active?</th>
                                    <th data-field="status" data-align="left" data-formatter="statusFormater" data-halign="text-center" data-sortable="true">Status</th>
                                    <th data-field="action" data-formatter="actionFormatter" >Actions</th>
                                    <!-- <th data-field="action" data-formatter="dataListFormSupplierActionFormater" >Actions</th> -->
                                     
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
        var users_nik = {{ Illuminate\Support\Js::from($nik_session) }}
        var $table = $("#list-data");
        var filter = {
            nik: null,
            status: null,
        }

        $('#filterNik').on("select2:select", function (e) { 
            filter.nik = e.params.data.id
        });
        $('#filterStatus').on("select2:select", function (e) {
            filter.status = e.params.data.id
        });

        $('#filterNik').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5',
            dropdownParent: $('#filterNik').closest('.input-group'),
            placeholder: '--- Cari Nama ---',
            ajax: {
                url: "/helper/karyawan",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        query: params.term, // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response.data
                    };
                },
                cache: true,
            },
            templateResult: function (data) {
                console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        });

        $('#filterSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterSite').closest('.input-group'),
            placeholder: '--- Pilih Site ---',
            data: [
                {"id": "", "text": "--- Pilih Site ---"}
            ]
        });

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
            var btn = '<a type="button" class="btn btn-secondary btn-sm me-1" style="--bs-btn-font-size: .60rem;" href="/bss-form/sm/get-supplier-detail?id=' + row.id + '">Lihat</a>';
            if(row.diisi_oleh == users_nik && (row.editable == 0 || row.editable == null)) {
                 btn = btn + '<a type="button" class="btn btn-info btn-sm me-1" style="--bs-btn-font-size: .60rem;" href="/bss-form/sm/edit-supplier?id=' + row.id + '">Edit</a>'
                     + '<a class="btn btn-primary btn-action btn-sm me-1" style="--bs-btn-font-size: .60rem;" href="/bss-form/sm/pdf-registrasi-supplier?id=' + row.id + '">Pdf</a>'
                     + '<a class="btn btn-danger btn-action btn-sm me-1" style="--bs-btn-font-size: .60rem;" href="/bss-form/sm/delete-supplier?id=' + row.id + '">Delete</a>';
            }
            return btn;
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

        function statusActive(value, row, index) {
            if (value == 1) {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-success btn-sm" disabled>Active</button>`
            } else if (value == 2) {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-secondary btn-sm" disabled>Deleted</button>`
            } else {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-success btn-sm" disabled>Yes</button>`
            }
        }

        function statusFormater(value, row, index) {
            if (value == 1) {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-success btn-sm" disabled>Approved</button>`
            } else if (value == 2) {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-danger btn-sm" disabled>Rejected</button>`
            } else {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-secondary btn-sm" disabled>Need Approval</button>`
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
