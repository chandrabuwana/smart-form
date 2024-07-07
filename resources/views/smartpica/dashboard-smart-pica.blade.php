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
                        <h6 class="text-white text-capitalize ps-3">Smart PICA</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="/add-smart-pica"><button
                                class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA">
                                Add PICA</button></a>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="dataListFormMobilisasi" data-toggle="table"
                            data-ajax="dataListFormMobilisasiGenerateData"
                            data-query-params="dataListFormMobilisasiParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodoc">
                            <thead>
                                <tr>
                                    <th data-field="id" data-align="left" data-halign="text-center" data-sortable="true">ID
                                    </th>
                                    <th data-field="nodoc" data-align="left" data-halign="center" data-sortable="true">No.
                                        Dokumen
                                    </th>
                                    <!-- <th data-field="eqpMdl" data-align="left" data-halign="center">Equipment Model</th> -->
                                    <th data-field="brand" data-align="left" data-halign="center">Brand</th>
                                    <!-- <th data-field="type" data-align="left" data-halign="center">Type</th> -->
                                    <th data-field="noLmbng" data-align="left" data-halign="center">No. Lambung</th>
                                    <th data-field="qty" data-align="right" data-halign="center">Qty</th>
                                    <th data-field="startDate" data-formatter="dataTableDateFormater" data-align="center"
                                        data-halign="center" data-sortable="true">Start Date</th>
                                    <th data-halign="center" data-align="center"
                                        data-formatter="dataListFormMobilisasiActionFormater">Action
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


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script type="text/javascript">
        function dataTableDateFormater(value, row, index) {
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var t = new Date(value);
            return t.getDate() + '-' + monthNames[t.getMonth()] + '-' + t.getFullYear();

        }

        function dataListFormMobilisasiActionFormater(value, row, index) {
            return `
                    <a class="like" onclick="PrintPdfFormMobilisasi(this)" title="Like">
                        <i class="fa fa-file-text"> PDF</i>
                    </a>
                `
        }

        function dataListFormMobilisasiParamsGenerate(params) {

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

        function dataListFormMobilisasiSearchGenerate(obj) {
            $('#dataListFormMobilisasi').bootstrapTable('refresh');
            $("#dataListFormMobilisasi").bootstrapTable("uncheckAll");
        }

        function dataListFormMobilisasiGenerateData(params) {
            var url = '/picsedit/get-data-list-form-mobilisasi'
            $.get(url + '?' + $.param(params.data)).then(function(res) {

                params.success(JSON.parse(res))
            })
        }
    </script>
@endsection
