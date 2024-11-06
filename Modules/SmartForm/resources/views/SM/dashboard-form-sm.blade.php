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
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form SM</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('bss-form.sm.form-asset-request') }}">
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
                                <label for="filterDepartment">Department Requestor</label>
                                <select style="width: 100%" id="filterDepartment" name="filterDepartment">
                                    @foreach ($list_dept as $key => $item)
                                        <option value="{{$key}}">{{ $item }}</option>
                                    @endforeach
                                </select>
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
                                    <th data-field="date_doc" data-align="center" data-halign="center">Date</th>
                                    <th data-field="department" data-align="center" data-halign="center">Department</th>
                                    <th data-field="project" data-align="left" data-halign="center">Project</th>
                                    <th data-field="requested_by" data-align="center">
                                        Requested By
                                    </th>
                                    <th data-field="total_price_idr" data-align="center" data-halign="center" data-formatter="rupiahFormatter">Total Price (IDR)
                                    </th>
                                    <th data-field="status" data-formatter="statusFormatter" >Status</th>
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
            department: null,
        }

        $('#filterNik').on("select2:select", function (e) { 
            filter.nik = e.params.data.id
        });
        $('#filterStatus').on("select2:select", function (e) {
            filter.status = e.params.data.id
        });
        $('#filterDepartment').on("select2:select", function (e) { 
            filter.department = e.params.data.id
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
                {"id": 0, "text": "Draft"},
                {"id": 1, "text": "Validated"},
                {"id": 2, "text": "Done"},
                {"id": -1, "text": "Rejected"},
            ]
        });
        $('#filterDepartment').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterDepartment').closest('.input-group'),
            placeholder: '--- Pilih Department ---'
        });

        function applyFilter(e) {
            $("#list-form").bootstrapTable('refresh')
        }

        function clearFilter(e) {
            filter = {
                nik: null,
                status: null,
                department: null,
            }
            $("#list-form").bootstrapTable('refresh')
        }

        function actionFormatter(value, row, index) {
            var btn = '<a href="/bss-form/sm/get-form-detail?no_doc=' + row.no_doc + '"><i class="fa fa-info-circle fixed-plugin-button-nav cursor-pointer"></i></a>';
            if(row.status < 1 || row.status == null) {
                if(row.requested_by == users_nik && (row.editable == 0 || row.editable == null)) {
                    btn = btn + '<a href="/bss-form/sm/edit-form-asset-request?no_doc=' + row.no_doc + '"><i class="fa fa-edit fixed-plugin-button-nav cursor-pointer"></i></a>';
                }
            }
            return btn;
        }

        function rupiahFormatter(value, row, index) {
            return formatRupiah(parseFloat(value))
        }

        function formatRupiah(angka, prefix = 'Rp. ') {
            // Mengganti angka menjadi string dan menghapus karakter selain angka
            let numberString = angka.toString().replace(/[^,\d]/g, ''),
                split = numberString.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // Menambahkan titik jika ada ribuan
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

        function statusFormatter(value, row, index) {
            var status = "";
            if(value == 0 || value == null) {
                status = "Draft"
            }
            if(value == 1) {
                status = "Validated"
            }
            if(value == 2) {
                status = "Done" // approveby SM
            }
            if(value == 3) {
                status = "Rejected"
            }
            if(value == -1) {
                status = "Rejected"
            }

            return status;
        }

        function fetchFormsData(params) {
            if(filter.nik) params.data.nik = filter.nik
            if(filter.status) params.data.status = filter.status
            if(filter.department) params.data.department = filter.department
            console.log("filter : ", filter)

            var url = '/bss-form/sm/get-forms-data'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }
    </script>
@endsection
