@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Inspeksi Toilet Mess Kantor</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                    <div class="d-flex align-items-center ms-3">
                        <a href="{{ route('create-wc') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="list-inspeksi" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server" data-page-list="[10, 25, 50, 100, all]"
                            data-sortable="true" data-content-type="application/json"
                            data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="no" data-align="left" data-halign="text-center" data-sortable="true">No</th>
                                    <th data-field="nama_site" data-align="left" data-halign="text-center" data-sortable="true">Nama Site</th>
                                    <th data-field="loker" data-align="left" data-halign="text-center" data-sortable="true">Lokasi Kerja</th>
                                    <th data-field="dept" data-align="left" data-halign="text-center" data-sortable="true">Dept</th>
                                    <th data-field="action" data-formatter="actionFormatter">Actions</th>
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
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script type="text/javascript">
        var $table = $("#list-inspeksi");
        var additonalQuery = {
            tanggal: null,
            nama: null
        }

        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = '/bss-form/wc/list'
            // console.log(params.data)
            $.get(url + '?' + $.param(params.data)).then(function (res) {
                res.data.rows = res.data.rows.map((row, index) => ({
                    ...row,
                    no: index + 1
                }));
                params.success(res.data);
            });
        }

        function actionFormatter(value, row, index) {
            return `
                <a href="/bss-form/wc/export-inspeksi/${row.id}" target="_blank" class="btn btn-primary btn-action btn-sm">
                    Pdf
                </a>
            `;
        }

    </script>
@endsection
