@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 32px;
            padding: 8px 0px;
        }
        .select2-dropdown.select2-dropdown--below {
            max-height: 300px;
            overflow-x: scroll;
            overflow-y: auto;
        }
        .select2-container--open .select2-selection.select2-selection--single, .select2-container--focus .select2-selection.select2-selection--single {
            border-bottom: 1px solid #D81B60;
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
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Pemakaian Solar</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('bss-form.log.form-pemakaian-solar') }}">
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
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="no_doc">
                            <thead>
                                <tr>
                                    <th data-field="no_doc" data-align="left" data-halign="text-center">
                                        No. Document
                                    </th>
                                    <th data-field="tgldibuat" data-align="center" data-halign="center">Date</th>
                                    <th data-field="dibuat_oleh" data-align="center" data-halign="center">Dibuat oleh</th>
                                    <th data-field="fuel" data-align="left" data-halign="center">No Fuel Station</th>
                                    <th data-field="total" data-align="left" data-halign="center">Total Pemakaian</th>
                                    <th data-field="approval" data-align="left" data-halign="center">Approval</th>
                                    <th data-field="is_active" data-align="left" data-formatter="statusActive" data-halign="text-center" data-sortable="true">Is Active?</th>
                                    <th data-field="status" data-align="left" data-formatter="statusFormater" data-halign="text-center" data-sortable="true">Status</th>
                                    <th data-field="action" data-formatter="actionFormatter" >Actions</th>
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
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
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

        function actionFormatter(value, row, index) {
            var btn = '<a type="button" class="btn btn-secondary btn-sm me-1" style="--bs-btn-font-size: .60rem;" href="/bss-form/log/get-pemakaian-solar-detail?no_doc=' + row.no_doc + '">Lihat</a>';
            if(row.status = "Need Approval" || row.status == null) {
                if(row.dibuat_oleh == users_nik && (row.editable == 0 || row.editable == null)) {
                    btn = btn + '<a type="button" class="btn btn-info btn-sm me-1" style="--bs-btn-font-size: .60rem;" href="/bss-form/log/edit-pemakaian-solar?no_doc=' + row.no_doc + '">Edit</a>'
                         + '<a class="btn btn-primary btn-action btn-sm" style="--bs-btn-font-size: .60rem;" href="/bss-form/log/pdf-pemakaian-solar?no_doc=' + row.no_doc + '">Pdf</a>'
                         + '<a class="btn btn-danger btn-action btn-sm me-1" style="--bs-btn-font-size: .60rem;" href="/bss-form/log/delete-pemakaian-solar?no_doc=' + row.no_doc + '">Delete</a>';
                }
            }
            return btn;
        }

        function fetchFormsData(params) {
            if(filter.nik) params.data.nik = filter.nik
            if(filter.status) params.data.status = filter.status
            if(filter.department) params.data.department = filter.department
            console.log("filter : ", filter)

            var url = '/bss-form/log/get-pemakaian-solar-data'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
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
        function statusActive(value, row, index) {
            if (value == 1) {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-success btn-sm" disabled>Active</button>`
            } else if (value == 0) {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-secondary btn-sm" disabled>Deleted</button>`
            } else {
                return `<button type="button" style="--bs-btn-font-size: .60rem;" class="btn btn-success btn-sm" disabled>Yes</button>`
            }
        }
    </script>
@endsection
