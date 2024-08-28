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
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Timesheet</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('form-timesheet-produksi') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="id" data-align="left" data-halign="text-center"
                                        data-sortable="true">No. Document
                                    </th>
                                    <th data-field="driver" data-align="center" data-halign="center">Driver</th>
                                    <th data-field="site" data-align="center" data-halign="center">Site</th>
                                    <th data-field="tanggal" data-align="left" data-halign="center">Tanggal</th>
                                    <th data-field="shift" data-align="left" data-halign="center">Shift</th>
                                    <th data-field="no_unit" data-align="center">Nama & No unit
                                    </th>
                                    <th data-field="total_rit" data-align="center"
                                        data-halign="center" data-sortable="true">Total RIT
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

        function actionFormatter(value, row, index) {
            return '<button class="btn btn-primary btn-action"><a href="/bss-form/timesheet/detail?id=' + row.id + '">detail</a></button>';
        }

        function fetchFormsData(params) {
            var url = '/bss-form/timesheet/form'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

    </script>
@endsection
