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
    }
    .box {
        width: 20px;
        height: 20px;
        display: inline-block;
        border-radius: 4px;
    }
    .grey {
        background-color:rgb(134, 132, 132);
    }

    .green {
        background-color: #4CAF50;
    }

    .blue {
        background-color: #0000FF;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Request Fuel</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                    <div class="d-flex align-items-center ms-3">
                        <a href="{{ route('bss-form.log.form-fuel') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>

                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterNik">NIK Requestor</label>
                                <select style="width: 100%" id="filterNik" name="filterNik"></select>
                                </input>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterStatus">Status Request</label>
                                <select style="width: 100%" id="filterStatus" name="filterStatus"></select>
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
                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="status me-2">
                                <label>Status data :</label>
                            </div>
                            <div class="status me-2">
                                <span class="box green"></span> Yes
                            </div>
                            <div class="status me-2">
                                <span class="box grey"></span> Deleted
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="no" data-align="left" data-halign="text-center" data-sortable="true">No Kupon</th>
                                    <th data-field="id" data-align="left" data-halign="text-center" data-sortable="true">ID</th>
                                    <th data-field="nama" data-align="left" data-halign="text-center" data-sortable="true">Nama</th>
                                    <th data-field="dibuat_oleh" data-align="left" data-halign="text-center" data-sortable="true">NIK</th>
                                    <!-- <th data-field="jabatan" data-align="left" data-halign="text-center" data-sortable="true">Jabatan</th> -->
                                    <th data-field="departemen" data-align="left" data-halign="text-center" data-sortable="true">Departemen</th>
                                    <th data-field="tanggal" data-align="left" data-halign="text-center" data-sortable="true">Tanggal</th>
                                    <th data-field="no_lambung" data-align="left" data-halign="text-center" data-sortable="true">No Lambung</th>
                                    <th data-field="is_active" data-align="left" data-formatter="statusFormater" data-halign="text-center" data-sortable="true">Is Active?</th>
                                    <!-- <th data-field="jenis_kendaraan" data-align="left" data-halign="text-center" data-sortable="true">Jenis Kendaraan</th> -->
                                    <th data-field="action" data-formatter="actionFormatter" >Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- END LIST REQUEST MASTER -->
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

        $('#filterStatus').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterStatus').closest('.input-group'),
            placeholder: '--- Pilih Status ---',
            data: [
                {"id": "", "text": "--- Pilih Status ---"},
                {"id": "Need Approval", "text": "Need Approval"},
                {"id": "Approved", "text": "Approved"},
                {"id": "Rejected", "text": "Rejected"},
            ]
        });

        function statusFormater(value, row, index) {
            if (value == 1) {
                return `<button type="button" class="btn btn-success btn-sm" disabled>Yes</button>`
            } else if (value == 2) {
                return `<button type="button" class="btn btn-secondary btn-sm" disabled>Deleted</button>`
            } else {
                return `<button type="button" class="btn btn-info btn-sm" disabled>?</button>`
            }
        }

        function applyFilter(e) {
            $("#list-form").bootstrapTable('refresh')
        }

        function clearFilter(e) {
            filter = {
                nik: null,
                status: null,
            }
            $("#list-form").bootstrapTable('refresh')
        }
// =================

        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
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

        function fetchFormsData(params) {
            if(filter.nik) params.data.nik = filter.nik
            if(filter.status) params.data.status = filter.status
            console.log("filter : ", filter)

            var url = '/bss-form/log/list-fuel'
            // params.data = {...params.data, ...additonalQuery}
            // console.log(params.data)
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        
        function myFunction() {
            if(!confirm("Yakin ingin menghapus data ini?"))
            event.preventDefault();
        }

        // <a class="btn btn-info btn-action btn-sm me-1" href="/bss-form/LOG/edit-fuel/${row.id}">Edit</a>
        // <a class="btn btn-danger btn-action btn-sm" onclick="return myFunction();" href="/bss-form/LOG/delete-fuel/${row.id}">Delete</a>
        function actionFormatter(value, row, index) {
            var btn = '<a type="button" class="btn btn-secondary btn-sm me-1" href="/bss-form/log/get-request-fuel-detail?id=' + row.id + '">Lihat</a>';
            if(row.dibuat_oleh == users_nik && (row.editable == 0 || row.editable == null)) {
                btn = btn + '<a type="button" class="btn btn-info btn-sm me-1" href="/bss-form/log/edit-req-fuel?id=' + row.id + '">Edit</a>'
                     + '<a class="btn btn-primary btn-action btn-sm me-1" href="/bss-form/log/pdf-fuel?id=' + row.id + '">Pdf</a>'
                     + '<a class="btn btn-danger btn-action btn-sm me-1" href="/bss-form/log/delete-fuel?id=' + row.id + '">Delete</a>';
            }
            
            return btn;
        }

    </script>
@endsection
