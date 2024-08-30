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
                    @if(Helper::isGrantPermission('create-form-under-carriage-inspection'))
                        <div class="d-flex align-items-center">
                            <a href="{{ route('bss-form.undercarriage.form') }}">
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
                                    @if(Helper::isGrantPermission('detail-data-under-carriage-inspection'))
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
            return '<a href="/bss-form/under-carriage/dashboard/detail/' + row.id + '" class="btn btn-primary btn-action">detail</a>';
        }

        function fetchFormsData(params) {
            var url = `{{ route('bss-form.undercarriage.get-data-dashboard') }}`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

    </script>
@endsection
