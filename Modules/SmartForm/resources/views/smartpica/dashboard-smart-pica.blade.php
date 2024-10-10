@extends('master.master_page')

@section('custom-css')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css"> --}}
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table/dist/bootstrap-table.min.css">
    <style>
        .fixed-table-container {
            position: relative;
        }

        .fixed-table-header {
            overflow: hidden;
        }

        .fixed-table-body {
            overflow-x: auto;
        }

        .table td {
            word-wrap: break-word;
            /* Allows long words to be broken and wrap onto the next line */
            white-space: normal;
            /* Allows the text to wrap */
        }

        .table th {
            white-space: nowrap;
            /* Prevents header text from wrapping */
        }

        .wrap-text {
            width: 40vw;
            word-wrap: break-word;
            /* Allows long words to be broken and wrap onto the next line */
            white-space: normal;
            /* Allows the text to wrap */
        }

        .select2-container--bootstrap5 .select2-selection--single {
            color: gray;
            /* Ensures text is black */
        }

        .select2-results__option {
            color: gray;
            /* Ensures dropdown options are black */
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Smart PICA</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row px-3 mb-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Step Not Net ACC
                                                    </p>
                                                    <h2 class="fw-bolder">{{ $dataCharts['Not Yet ACC']['count'] }}</h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div
                                                        class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                        <i class="fas fa-calendar-alt text-lg opacity-10"
                                                            aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Reject By PIC
                                                    </p>
                                                    <h2 class="fw-bolder">{{ $dataCharts['Reject By PIC']['count'] }}</h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div
                                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                                        <i class="fas fa-times-circle text-lg opacity-10"
                                                            aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">On Progress</p>
                                                    <h2 class="fw-bolder">{{ $dataCharts['On Progress']['count'] }}</h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div
                                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                        <i class="fas fa-clock text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Closed</p>
                                                    <h2 class="fw-bolder">{{ $dataCharts['Closed']['count'] }}</h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div
                                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                        <i class="fas fa-check-circle text-lg opacity-10"
                                                            aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow border">
                                <div class="card-header px-2 py-3">
                                    <h6 class="text-capitalize ps-3">Perbandingan Status</h6>
                                </div>
                                <div class="card-body p-3">
                                    <canvas id="chart-status" class="chart-canvas" height="300px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark my-sm-3">
                    <div class="row card-header"
                        style="margin : 10px;border-radius: 10px; background-color: rgba(209, 209, 209, 0.301); color:white !important;">
                        <div class="row">
                            <div class="col">
                                <h6 class="card-title">Filter</h6>
                                <hr class="horizontal dark my-sm-1">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERNIK" class="ms-0">NIK</label>
                                            <select class="form-control s2lea" name="FILTERNIK" id="FILTERNIK"
                                                required></select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERDEPARTMENT" class="ms-0">Department </label>
                                            <select class="form-control dept" name="FILTERDEPARTMENT" id="FILTERDEPARTMENT">
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERSITE" class="ms-0">Site </label>
                                            <select class="form-control site" name="FILTERSITE" id="FILTERSITE">
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="FILTERTANGGAL" class="">Tanggal</label>
                                            <div class="input-group input-group-static my-2">
                                                <input class="form-control due-date-picker" type="text"
                                                    placeholder="DD/MM/YYYY" name="FILTERTANGGAL" required
                                                    id="FILTERTANGGAL">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary ms-auto uploadBtn"
                                            onclick="dataListFormPicaSearchGenerate(this);">
                                            <i class="fa fa-filter"> Search</i> </button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <a href="{{ route('add-smart-pica') }}"><button class="btn btn-primary ms-auto uploadBtn">
                                Add PICA</button></a>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="dataListFormPica" data-toggle="table" data-ajax="dataListFormPicaGenerateData"
                            data-query-params="dataListFormPicaParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, 'all']" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodocpica">
                            <thead>
                                <tr>
                                    <th data-field="nodocpica" data-align="left" data-halign="text-center"
                                        data-sortable="true">No. Document
                                    </th>
                                    <th data-field="status" data-formatter="statusFormater" data-align="center"
                                        data-halign="center" data-sortable="true">Status
                                    </th>
                                    <th data-field="tahun_bulan" data-align="center" data-halign="center">Date</th>
                                    <th data-field="site" data-align="center" data-halign="center">Site</th>
                                    <th data-field="kp_name" data-align="left" data-halign="center">Kategori</th>
                                    <th data-field="problem" data-align="left" data-halign="center" class="wrap-text">
                                        Problem</th>
                                    {{-- <th data-field="lea_name" data-align="left" data-halign="center">KPI</th> --}}
                                    <th data-halign="center" data-align="center" data-fixed="true"
                                        data-formatter="dataListFormPicaActionFormater">Action
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Solution Dashboard</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row card-header"
                        style="margin : 10px;border-radius: 10px; background-color: rgba(209, 209, 209, 0.301); color:white !important;">
                        <div class="row">
                            <div class="col">
                                <h6 class="card-title">Filter</h6>
                                <hr class="horizontal dark my-sm-1">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERNIKSOLUTION" class="ms-0">NIK</label>
                                            <select class="form-control s2lea" name="FILTERNIKSOLUTION"
                                                id="FILTERNIKSOLUTION" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERDEPARTMENTSOLUTION" class="ms-0">Department </label>
                                            <select class="form-control dept" name="FILTERDEPARTMENTSOLUTION"
                                                id="FILTERDEPARTMENTSOLUTION">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERSITESOLUTION" class="ms-0">Site </label>
                                            <select class="form-control site" name="FILTERSITESOLUTION"
                                                id="FILTERSITESOLUTION">
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="FILTERTANGGAL" class="">Tanggal</label>
                                            <div class="input-group input-group-static my-2">
                                                <input class="form-control due-date-picker" type="text"
                                                    placeholder="DD/MM/YYYY" name="FILTERTANGGAL" required
                                                    id="FILTERTANGGAL">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary ms-auto uploadBtn"
                                            onclick="dataListFormDashboardHistoryProgress(this);">
                                            <i class="fa fa-filter"> Search</i> </button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="dataListHistoryDashboard" data-toggle="table"
                            data-ajax="dataListHistoryDashboardGenerateData"
                            data-query-params="dataListHistoryDashboardParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodocpica">
                            <thead>
                                <tr>
                                    <th data-field="nodocpica" data-align="left" data-halign="text-center"
                                        data-sortable="true">No. Document
                                    </th>
                                    <th data-field="status" data-align="center"
                                        data-formatter="statusFormaterStepSolution" data-halign="center"
                                        data-sortable="true">
                                        Status
                                    </th>
                                    <th data-field="pic" data-align="center" data-halign="center">PIC</th>
                                    <th data-field="note_step" data-align="left" data-halign="center" class="wrap-text">
                                        Step Solution</th>
                                    <th data-field="ap_tod" data-align="center" data-halign="center">AP/TOD</th>
                                    <th data-field="target_master" data-align="center" data-halign="center">Target</th>
                                    <th data-field="due_date" data-align="left" data-formatter="dataTableDateFormater"
                                        data-halign="center">Due Date</th>
                                    <th data-field="progress" data-align="center" data-halign="center">Progress</th>
                                    <th data-halign="center" data-align="center"
                                        data-formatter="dataListHistoryDashboardActionFormater">Action
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="updateProgressHistory" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <input type="hidden" name="positionWhy" id="positionWhy" value="">
                <input type="hidden" name="identityWhy" id="identityWhy" value="">
                <input type="hidden" name="nodocpica" id="nodocpica" value="">
                <input type="hidden" name="idMaster" id="idMaster" value="">
                <input type="hidden" name="nikMaster" id="nikMaster" value="">
                <input type="hidden" name="idSolution" id="idSolution" value="">
                <input type="hidden" name="targetMaster" id="targetMaster" value="">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">View History Progress</h5>
                            <p id="ProblemHeader"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <div class="card-body">
                                <br>
                                <div class="table-responsive p-0">
                                    <table id="dataListHistoryProgress" data-toggle="table"
                                        data-ajax="dataListHistoryProgressGenerateData"
                                        data-query-params="dataListHistoryProgressParamsGenerate"
                                        data-side-pagination="server" data-page-list="[10, 25, 50, 100, all]"
                                        data-sortable="true" data-content-type="application/json" data-data-type="json"
                                        data-pagination="true" data-unique-id="id">
                                        <thead>
                                            <tr>
                                                <th data-field="note_progress" data-align="left" data-halign="center"
                                                    data-sortable="true">Catatan
                                                </th>
                                                <th data-field="progress" data-align="center" data-halign="center">
                                                    Progress</th>
                                                <th data-field="created_at" data-formatter="dataTableDateFormater"
                                                    data-align="center" data-halign="center">Updated At
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://unpkg.com/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js">
    </script>
    <script type="text/javascript">
        var elChartStatus = document.getElementById("chart-status").getContext("2d");

        function formatSelectingAfterSelectNIK(repo) {
            $("#nNama").val(repo.name);
            $("#nDept").val(repo.dept);

            return repo.text;
        }



        function initializeSelect2NIK(elementId) {
            $(elementId).select2({
                theme: 'bootstrap5', // Menggunakan tema Bootstrap 5
                dropdownParent: $(elementId).closest('.select-div'),
                placeholder: '--- Cari/Pilih NIK ---',
                ajax: {
                    url: "/bss-form/induksi-karyawan/helper-data-nik",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            query: params.term
                        }; // search term
                    },
                    processResults: function(response) {
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                },
                templateSelection: formatSelectingAfterSelectNIK
            });
        }

        initializeSelect2NIK('#FILTERNIK');
        initializeSelect2NIK('#FILTERNIKSOLUTION');

        function initializeSelect2Department(elementId) {
            $(elementId).select2({
                theme: 'bootstrap5', // Menggunakan tema Bootstrap 5
                dropdownParent: $(elementId).closest('.input-group'),
                placeholder: '--- Cari Department ---',
                ajax: {
                    url: "/helper/department",
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
                    cache: true
                }
            });
        }

        // Initialize for both elements
        initializeSelect2Department('#FILTERDEPARTMENT');
        initializeSelect2Department('#FILTERDEPARTMENTSOLUTION');



        function initializeSelect2Site(elementId) {
            $(elementId).select2({
                theme: 'bootstrap5', // Menggunakan tema Bootstrap 5
                dropdownParent: $(elementId).closest('.input-group'),
                placeholder: '--- Cari Site ---',
                ajax: {
                    url: "/helper/site",
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
                    cache: true
                }
            });
        }

        // Initialize for both elements
        initializeSelect2Site('#FILTERSITE');
        initializeSelect2Site('#FILTERSITESOLUTION');

        new Chart(elChartStatus, {
            type: "pie",
            data: {
                labels: ['Not Yet ACC', 'Reject By PIC', 'On Progress', 'Closed'],
                datasets: [{
                    label: "Projects",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 2,
                    hoverOffset: 4,
                    backgroundColor: ['#49a3f1', '#EF5350', '#FFA726', '#66BB6A'],
                    data: [
                        {{ $dataCharts['Not Yet ACC']['percentage'] }},
                        {{ $dataCharts['Reject By PIC']['percentage'] }},
                        {{ $dataCharts['On Progress']['percentage'] }},
                        {{ $dataCharts['Closed']['percentage'] }}
                    ],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(item) {
                                return item.label + ' : ' + item.parsed + '%';
                            }
                        }
                    }
                },
            },
        });

        function dataTableDateFormater(value, row, index) {
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];
            var t = new Date(value);
            return t.getDate() + ' ' + monthNames[t.getMonth()] + ' ' + t.getFullYear();

        }

        function statusFormater(value, row, index) {
            if (value == "STEP NOT SET") {
                return `<button type="button" class="btn btn-primary btn-sm">Step Not Yet</button>`
            } else if (value == 'NOT ANY PROGRESS') {
                return `<button type="button" class="btn btn-warning btn-sm">${value}</button>`
            } else if (value == 'ALL TASK REJECTED BY PIC') {
                return `<button type="button" class="btn btn-danger btn-sm">${value}</button>`
            } else if (value == 'ALL REJECT BY APPROVER') {
                return `<button type="button" class="btn btn-danger btn-sm">${value}</button>`
            } else if (value == 'PICA CLOSED') {
                return `<button type="button" class="btn btn-danger btn-sm">${value}</button>`
            } else if (value == 'ON PROGRESS') {
                return `<button type="button" class="btn btn-warning btn-sm">${value}</button>`
            } else {
                return `<button type="button" class="btn btn-secondary btn-sm">?</button>`
            }
        }

        function dataListFormPicaActionFormater(value, row, index) {
            let data = `
                    <button onclick="RedirectViewPica(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i> View
                    </a></button>
                `
            if (row.status == "STEP NOT SET") {
                data += `<button onclick="redirectToAddStepPica(this)"><a class="like" title="Like">
                        <i class="fa fa-plus"></i> Step
                    </a></button>`
            }
            return data;
        }

        function redirectToAddStepPica(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            window.location.href = "/smart-pica/create-step/" + $('#dataListFormPica').bootstrapTable('getData')[indexDt]
                .nodocpica;
        }

        function dataListFormPicaParamsGenerate(params) {

            params.search = {
                'FILTERNIK': $('#FILTERNIK').val(),
                'FILTERDEPARTMENT': $('#FILTERDEPARTMENT').val(),
                'FILTERSITE': $('#FILTERSITE').val()
                // 'FILTERTANGGAL': $('#FILTERTANGGAL').val(),
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

        function RedirectViewPica(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            window.location.href = "/smart-pica/view-data-detail-pica/" + $('#dataListFormPica').bootstrapTable('getData')[
                    indexDt]
                .nodocpica
        }

        function dataListFormPicaSearchGenerate(obj) {
            $('#dataListFormPica').bootstrapTable('refresh');
            $("#dataListFormPica").bootstrapTable("uncheckAll");
        }

        function dataListFormPicaGenerateData(params) {
            var url = '/helper/data-pica'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
    <script type="text/javascript">
        function dataListFormDashboardHistoryProgress(obj) {
            $('#dataListHistoryDashboard').bootstrapTable('refresh');
            $("#dataListHistoryDashboard").bootstrapTable("uncheckAll");
        }

        function dataListHistoryDashboardParamsGenerate(params) {

            params.search = {
                'FILTERNIKSOLUTION': $('#FILTERNIKSOLUTION').val(),
                'FILTERDEPARTMENTSOLUTION': $('#FILTERDEPARTMENTSOLUTION').val(),
                'FILTERSITESOLUTION': $('#FILTERSITESOLUTION').val(),
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

        function OpenModalHistory(obj) {
            $('#divKeteranganReject').addClass("d-none");
            let indexDt = $(obj).closest('tr').data('index');
            let dataObject = $('#dataListHistoryDashboard').bootstrapTable('getData')[indexDt];
            console.log(dataObject)
            $('#positionWhy').val(dataObject.position_why)
            $('#identityWhy').val(dataObject.identity_why)
            $('#nodocpica').val(dataObject.nodocpica)
            $('#idMaster').val(dataObject.id_master)
            $('#nikMaster').val(dataObject.nik_master)
            $('#idSolution').val(dataObject.id)
            $('#targetMaster').val(dataObject.target_master)
            $('#idKeteranganReject').html(dataObject.keterangan_reject)
            if (dataObject.status == "REVISION") {
                $('#divKeteranganReject').removeClass("d-none");
            }
            $('#dataListHistoryProgress').bootstrapTable('refresh');
            $('#updateProgressHistory').modal("show");
        }

        function dataListHistoryDashboardSearchGenerate(obj) {
            $('#dataListHistoryDashboard').bootstrapTable('refresh');
            $("#dataListHistoryDashboard").bootstrapTable("uncheckAll");
        }

        function dataListHistoryDashboardGenerateData(params) {
            var url = '/helper/data-dashboard-history-progress'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

        function statusFormaterStepSolution(value, row, index) {
            if (value == "NEED APPROVE") {
                return `<button type="button" class="btn btn-info btn-sm">NEED APPROVE</button>`
            } else if (value == 'NOT YET') {
                return `<button type="button" class="btn btn-secondary btn-sm">${value}</button>`
            } else if (value == 'REJECT BY PIC') {
                return `<button type="button" class="btn btn-danger btn-sm">${value}</button>`
            } else if (value == 'CLOSE') {
                return `<button type="button" class="btn btn-success btn-sm">${value}</button>`
            } else if (value == 'ON PROGRESS') {
                return `<button type="button" class="btn btn-warning btn-sm">${value}</button>`
            } else if (value == 'REVISION') {
                return `<button type="button" class="btn btn-warning btn-sm">${value}</button>`
            } else {
                return `<button type="button" class="btn btn-secondary btn-sm">?</button>`
            }
        }

        function dataListHistoryDashboardActionFormater(value, row, index) {
            return ` <button onclick="OpenModalHistory(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i>
                    </a>View</button>`
        }

        function dataListHistoryProgressParamsGenerate(params) {

            params.search = {
                'IDSOLUTION': $("#idSolution").val(),
                'NODOCPICA': $("#nodocpica").val(),
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

        function dataListHistoryProgressSearchGenerate(obj) {
            $('#dataListHistoryProgress').bootstrapTable('refresh');
            $("#dataListHistoryProgress").bootstrapTable("uncheckAll");
        }

        function dataListHistoryProgressGenerateData(params) {
            var url = '/helper/data-history-progress'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
@endsection
