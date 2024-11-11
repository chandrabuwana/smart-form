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
                        <h6 class="text-white text-capitalize ps-3">Dashboard Under Carriage Inspection</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center ms-3">
                        <a href="{{ route('bss-form.undercarriage.form') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>

                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-3 row mb-3">
                        <div class="col-6 col-md-3 ps-0">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterSN">S/N Unit</label>
                                <input style="width: 100%" id="filterSN" class="form-control" name="filterSN" placeholder="--- Cari S/N Unit ---">
                            </div>
                        </div>

                        <div class="col-6 col-md-3 ps-0">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterWorkOperation">Work Operation</label>
                                <input style="width: 100%" id="filterWorkOperation" class="form-control" name="filterWorkOperation" placeholder="--- Cari Work Operation ---">
                            </div>
                        </div>

                        <div class="col-6 col-md-3 ps-0">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterInspectiondate">Inspection Date</label>
                                <input style="width: 100%" id="filterInspectiondate" class="form-control" name="filterInspectiondate" placeholder="--- Cari Inspection Date ---">
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
                                    <th data-field="document_no" data-align="left" data-halign="text-center" data-sortable="true">
                                        No. Dokumen
                                    </th>
                                    <th data-field="unit_model" data-align="center" data-halign="center">
                                        Unit Model
                                    </th>
                                    <th data-field="unit_sn" data-align="center" data-halign="center">
                                        S/N Unit
                                    </th>
                                    <th data-field="unit_smr_hm" data-align="left" data-halign="center">
                                        Unit SMR / HM
                                    </th>
                                    <th data-field="work_operation" data-align="left" data-halign="center">
                                        Work Operation
                                    </th>
                                    <th data-field="inspection_date" data-align="center" data-sortable="true">
                                        Inspection Date
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
            sn: '',
            work_operation: '',
            inspection_date: ''
        }

        $('#filterSN').change( function(e) {
            filter.sn = e.target.value;
        });

        $('#filterWorkOperation').change( function(e) {
            filter.work_operation = e.target.value;
        });

        $('#filterInspectiondate').change( function(e) {
            filter.inspection_date = e.target.value;
        });

        function applyFilter(e) {
            $table.bootstrapTable('refresh')
        }

        function clearFilter(e) {
            filter.sn = null
            $('#filterSN').val('');

            filter.work_operation = null
            $('#filterWorkOperation').val('');

            filter.inspection_date = null
            $('#filterInspectiondate').val('');

            $table.bootstrapTable('refresh')
        }

        function actionFormatter(value, row, index) {
            return '<a href="/bss-form/under-carriage/dashboard/detail/' + row.id + '" class="btn btn-primary btn-action">detail</a>';
        }

        function fetchFormsData(params) {
            if(filter.sn) params.data.sn = filter.sn;
            if(filter.work_operation) params.data.work_operation = filter.work_operation;
            if(filter.inspection_date) params.data.inspection_date = filter.inspection_date;

            var url = `{{ route('bss-form.undercarriage.get-data-dashboard') }}`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

        function downloadReport() {
            location.href = `{{ route('bss-form.undercarriage.download') }}?` + (new URLSearchParams(filter)).toString();
        }

    </script>
@endsection
