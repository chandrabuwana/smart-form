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
                    @if(Helper::isGrantPermission('create-form-transmission'))
                        <div class="d-flex align-items-center">
                            <a href="{{ route('bss-form.plant-transmission.form') }}">
                                <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                    New Form
                                </button>
                            </a>
                        </div>
                    @endif

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
                                    @if(Helper::isGrantPermission('detail-data-transmission'))
                                        <th data-field="action" data-formatter="actionFormatter" >Actions</th>
                                    @endif
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
            return '<a class="btn btn-primary btn-action" href="/bss-form/plant-transmission/dashboard/detail/' + row.id + '">detail</a>';
        }

        function fetchFormsData(params) {
            var url = `<?= route('bss-form.plant-transmission.get-data-dashboard') ?>`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

    </script>
@endsection
