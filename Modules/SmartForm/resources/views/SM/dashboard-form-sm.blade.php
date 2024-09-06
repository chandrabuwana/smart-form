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
                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData" data-side-pagination="server"
                            data-query-params="dataListFormPicaParamsGenerate"
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
                                    <th data-field="total_price_idr" data-align="center"
                                        data-halign="center">Total Price (IDR)
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        var users_nik = {{ Illuminate\Support\Js::from($nik_session) }}
        function actionFormatter(value, row, index) {
            var btn = '<a href="/bss-form/sm/get-form-detail?no_doc=' + row.no_doc + '"><i class="fa fa-info-circle fixed-plugin-button-nav cursor-pointer"></i></a>';
            if(row.status < 1 ) {
                if(row.requested_by == users_nik) {
                    btn = btn + '<a href="/bss-form/sm/edit-form-asset-request?no_doc=' + row.no_doc + '"><i class="fa fa-edit fixed-plugin-button-nav cursor-pointer"></i></a>';
                }
            }
            return btn;
        }

        function statusFormatter(value, row, index) {
            console.log(value)
            var status = "";
            if(value == 0 || value == null) {
                status = "Draft"
            }
            if(value == 1) {
                status = "Validated"
            }
            if(value == 2) {
                status = "Diproses" // approveby SM
            }
            if(value == 3) {
                status = "Done"
            }

            return status;
        }

        function fetchFormsData(params) {
            var url = '/bss-form/sm/get-forms-data'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function dataListFormPicaParamsGenerate(params) {

            params.search = {
                'CARNAME': "",
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
    </script>
@endsection
