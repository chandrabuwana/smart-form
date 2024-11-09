@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Transmission Test</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center ms-3">
                        <a href="{{ route('bss-form.plant-transmission.form') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>

                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-3 row mb-3">
                        <div class="col-6 col-md-3 ps-0">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterMachine">Machine Number / Serial No</label>
                                <input style="width: 100%" id="filterMachine" class="form-control" name="filterMachine" placeholder="--- Cari Machine Number atau Serial No ---">
                            </div>
                        </div>

                        <div class="col-6 col-md-3 ps-0">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterJobsite">Jobsite</label>
                                <input style="width: 100%" id="filterJobsite" class="form-control" name="filterJobsite" placeholder="--- Cari Jobsite ---">
                            </div>
                        </div>

                        <div class="col-6 col-md-3 ps-0">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterCheckdate">Check Date</label>
                                <input style="width: 100%" id="filterCheckdate" class="form-control" name="filterCheckdate" placeholder="--- Cari Check Date ---">
                            </div>
                        </div>

                        <div class="ps-0">
                            <button class="btn btn-primary ms-auto filter-btn" id="btnFilterSubmit" onclick="applyFilter(this)">
                                Filter
                            </button>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnClearFilter" onclick="clearFilter(this)">
                                Clear Filter
                            </button>
                            <button class="btn btn-success ms-auto filter-btn" id="btnDownloadReport" onclick="downloadReport(this)">
                                Download Report
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="no_doc">
                            <thead>
                                <tr>
                                    <th data-field="machine_number" data-align="left" data-halign="text-center" data-sortable="true">
                                        Machine Number
                                    </th>
                                    <th data-field="machine_model" data-align="center" data-halign="center">
                                        Machine Model
                                    </th>
                                    <th data-field="machine_serial_no" data-align="center" data-halign="center">
                                        Machine Serial No
                                    </th>
                                    <th data-field="machine_smr" data-align="left" data-halign="center">
                                        Machine SMR / HM
                                    </th>
                                    <th data-field="jobsite" data-align="left" data-halign="center">
                                        Jobsite
                                    </th>
                                    <th data-field="checkdate" data-align="center" data-sortable="true">
                                        Check Date
                                    </th>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        var $table = $("#list-form");

        const filter = {
            machine: '',
            jobsite: '',
            checkdate: ''
        }

        $('#filterMachine').change( function(e) {
            filter.machine = e.target.value;
        });

        $('#filterJobsite').change( function(e) {
            filter.jobsite = e.target.value;
        });

        $('#filterCheckdate').change( function(e) {
            filter.checkdate = e.target.value;
        });

        function applyFilter(e) {
            $table.bootstrapTable('refresh')
        }

        function clearFilter(e) {
            filter.machine = null
            $('#filterMachine').val('');

            filter.jobsite = null
            $('#filterJobsite').val('');

            filter.checkdate = null
            $('#filterCheckdate').val('');

            $table.bootstrapTable('refresh')
        }

        function actionFormatter(value, row, index) {
            return '<a class="btn btn-primary btn-action" href="/bss-form/plant-transmission/dashboard/detail/' + row.id + '">detail</a>';
        }

        function fetchFormsData(params) {
            if(filter.machine) params.data.machine = filter.machine;
            if(filter.jobsite) params.data.jobsite = filter.jobsite;
            if(filter.checkdate) params.data.checkdate = filter.checkdate;

            var url = `<?= route('bss-form.plant-transmission.get-data-dashboard') ?>`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

        function downloadReport() {
            location.href = `{{ route('bss-form.plant-transmission.download') }}?` + (new URLSearchParams(filter)).toString();
        }

    </script>
@endsection
