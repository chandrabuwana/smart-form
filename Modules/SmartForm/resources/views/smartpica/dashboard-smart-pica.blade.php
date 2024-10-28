@extends('master.master_page')

@section('custom-css')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css"> --}}
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table/dist/bootstrap-table.min.css">
    <style>
        .gj-datepicker button {
            display: none !important;
        }

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
                                    <div class="col-md-4">
                                        <div class="input-group select-div input-group-static my-2">
                                            <label for="FILTERDEPARTMENT" class="ms-0">Department </label>
                                            <select class="form-control dept" name="FILTERDEPARTMENT" id="FILTERDEPARTMENT">
                                            </select>
                                        </div>
                                    </div>
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
                                    <input type="hidden" name="id_user_login" id="UserLoginNIK"
                                        value="{{ session('user_id') }}">
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

    <div class="modal fade" id="stepSolutionChangePIC" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="id_master" id="id_master" value="">
                <input type="hidden" name="nodocpica" id="nodocpica" value="">
                <input type="hidden" name="nikMaster" id="nikMaster" value="">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">FORM Step Solution</h5>
                            <p id="ProblemHeader"></p>

                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div id="content-modal-view-step">
                    <div class="row" style="margin: 10px">
                        <div class="col">
                            <div class="card border" style="">
                                <div class="card-body">
                                    <h5 class="card-title">Edit Solution</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="input-group input-group-static  my-1">
                                                <label for="pc_action" class="ms-0">Action</label>
                                                <select class="form-control" name="pc_action" id="pc_action" disabled>
                                                    <option value="">-- Pilih Action --</option>
                                                    <option value="ca">Corrective</option>
                                                    <option value="pa">Preventive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static  my-1">
                                                <label for="pc_aktual" class="ms-0">Note Step</label>
                                                <input class="form-control" type="text" inputmode="decimal"
                                                    placeholder="Masukkan note untuk PIC" value="${e.note_step}"
                                                    name="pc_aktual" id="pc_aktual" disabled>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="input-group input-group-static  my-1">
                                                <label class="ms-0" for="pc_ap_pica">AP/TOD</label>
                                                <select class="form-control" name="pc_ap_pica" id="pc_ap_pica">
                                                    <option value="ap">AP</option>
                                                    <option value="tod">TOD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static my-1">
                                                <label for="dicID" class="ms-0">Department in Charge
                                                    (DIC)</label>
                                                <select class="form-control dept" name="dicID" id="dicID">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static my-1">
                                                <label for="picID" class="">Person In Charge (PIC)</label>
                                                <select class="form-control picIDHuman" name="picID" id="picID">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="DueDate" class="">Due Date
                                                (PIC)</label>
                                            <div class="input-group input-group-static d-flex">
                                                <input class="form-control due-date-picker" type="text"
                                                    placeholder="DD/MM/YYYY" name="DueDate" required id="DueDate">
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark my-sm-3">
                                    <div class="row">
                                        <div class="col-md-4" style="">
                                            <div class="input-group input-group-static my-4">
                                                <label for="atasan_ID" class="">Atasan
                                                    (PIC)</label>
                                                <select class="form-control picIDAtasan" name="atasan_ID"
                                                    id="atasan_ID"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark my-sm-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="tensi">Status</label>
                                                <button class="form-control-button  btn-primary btn"
                                                    type="button">REJECTED BY PIC</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="alasan">Alasan</label>
                                                <button class="form-control-button  btn-info btn" id="alasanDiv" type="button">karena
                                                    lapas</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark my-sm-3">

                <div class="row" style="margin:10px">
                    <div class="col text-end">
                        <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDocumentData"
                            onclick="SubmitChangePICSolution()">
                            <i class="fas fa-save"></i>
                            Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js">
    </script>
    <script type="text/javascript">
        $('.due-date-picker').each(function() {
            $(this).datepicker({
                uiLibrary: 'bootstrap5', // or 'bootstrap5' if you're using Bootstrap 5
                format: 'dd mmmm yyyy',
                weekStartDay: 0,
            })
        });

        function initializeSelect2(elementId, placeholderText, ajaxUrl, dataDepartmentId) {
            $('#' + elementId).select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                dropdownParent: $('#' + elementId).closest('.input-group'),
                placeholder: placeholderText,
                width: '100%',
                ajax: ajaxUrl ? {
                    url: ajaxUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            query: params.term, // search term
                            dataDepartment: $('#' + dataDepartmentId).val()
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                } : null
            });
        }
        $(document).ready(function() {
            initializeSelect2('picID', '--- Pilih PIC ---', "/helper/karyawan", 'dicID');
            initializeSelect2('atasan_ID', '--- Pilih Atasan PIC ---', "/helper/karyawan", 'dicID');

        });
    </script>
    <script type="text/javascript">
        var elChartStatus = document.getElementById("chart-status").getContext("2d");

        function formatSelectingAfterSelectNIK(repo) {
            $("#nNama").val(repo.name);
            $("#nDept").val(repo.dept);

            return repo.text;
        }

        function formatDate(dateString) {
            let dateParts = dateString.split('-');
            if (dateParts[2].length === 1) {
                dateParts[2] = '0' + dateParts[2];
            }
            let date = new Date(`${dateParts[0]}-${dateParts[1]}-${dateParts[2]}`);
            let options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return date.toLocaleDateString('en-GB', options);
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

        function initializeSelect2Department(elementId, textPlaceHolder) {
            $(elementId).select2({
                theme: 'bootstrap5', // Menggunakan tema Bootstrap 5
                dropdownParent: $(elementId).closest('.input-group'),
                placeholder: textPlaceHolder,
                width: '100%',
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
        initializeSelect2Department('#FILTERDEPARTMENT', '--- Cari Department ---');
        initializeSelect2Department('#FILTERDEPARTMENTSOLUTION', '--- Cari Department ---');


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
            } else if (value == 'NEED APPROVE BY OD') {
                return `<button type="button" class="btn btn-warning btn-sm">${value}</button>`
            } else if (value == 'NEED REVISION') {
                return `<button type="button" class="btn btn-danger btn-sm">${value}</button>`
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
            if (row.nik == $("#UserLoginNIK").val() && (row.approval != "approved")) {
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
            let dataHtml = ` <button onclick="OpenModalHistory(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i>
                    </a>View</button>`
            if (row.nik_master == $("#UserLoginNIK").val() && (row.acceptance == 2)) {
                dataHtml += ` <button onclick="openModalChangePIC(this)"><a class="like"  title="Like">
                        <i class="fa fa-pen"></i>
                    </a>Change PIC</button>`
            }
            return dataHtml;
        }

        function openModalChangePIC(obj) {
            let indexDt = $(obj).closest('tr').data('index');
            let dataObj = $('#dataListHistoryDashboard').bootstrapTable('getData')[indexDt];

            console.log(dataObj);
            initializeSelect2Department('#dicID', `--- ${dataObj.dic} ---`);
            initializeSelect2('picID', `--- ${dataObj.pic} ---`, "/helper/karyawan", 'dicID');
            initializeSelect2('atasan_ID', `--- ${dataObj.approver} ---`, "/helper/karyawan", 'dicID');

            $("#pc_action").val(dataObj.action);
            $("#pc_aktual").val(dataObj.note_step);
            $("#pc_ap_pica").val(dataObj.ap_tod);
            $("#dicID").val(dataObj.dic).trigger('change');
            $("#DueDate").val(formatDate(dataObj.due_date));
            $("#id").val(dataObj.id);
            $("#id_master").val(dataObj.id_master);
            $("#nodocpica").val(dataObj.nodocpica);
            $("#nikMaster").val(dataObj.nik_master);
            if(dataObj.acceptance_reason){
                $("#alasanDiv").html(dataObj.acceptance_reason);
            }else{
                $("#alasanDiv").html("-");
            }
            $("#stepSolutionChangePIC").modal("show");
        }

        function SubmitChangePICSolution() {
            let dataKirim = {
                action: $("#pc_action").val(),
                note: $("#pc_aktual").val(),
                ap_pica: $("#pc_ap_pica").val(),
                dic: $("#dicID").val(),
                pic: $("#picID").val(),
                atasan: $("#atasan_ID").val(),
                duedate: $("#DueDate").val(),
                id: $("#id").val(),
                id_master: $("#id_master").val(),
                nodocpica: $("#nodocpica").val(),
                nikMaster: $("#nikMaster").val()
            };


            for (let key in dataKirim) {
                if (!dataKirim[key]) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Tidak Lengkap',
                        text: `Field ${key} wajib diisi. Silakan lengkapi semua data.`
                    });
                    return false; // Hentikan fungsi jika ada nilai yang kosong
                }
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "change-pic-solution",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            $("#stepSolutionChangePIC").modal("hide");
                            $('#dataListHistoryDashboard').bootstrapTable('refresh');
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: `Error 00003`,
                            html: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: `Error 00002`,
                        html: message,
                        confirmButtonText: 'OK'
                    });
                }
            })

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
