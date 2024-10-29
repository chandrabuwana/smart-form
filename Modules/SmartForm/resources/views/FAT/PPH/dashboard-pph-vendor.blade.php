@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Master Upload Data Potongan</h6>
                    </div>
                </div>
                <div class="card-header"
                    style="margin : 10px;border-radius: 10px; background-color: rgba(209, 209, 209, 0.301); color:white !important;">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title">Filter</h6>
                            <hr class="horizontal dark my-sm-1">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="FILTERNIK">Vendor</label>
                                        <input type="text" class="form-control" id="FILTERNIK" name="FILTERNIK"
                                            maxlength="7" placeholder=" -- Masukkan NIK -- ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="FILTERNIKMENTOR">NPWP Vendor</label>
                                        <input type="text" class="form-control" id="FILTERNIKMENTOR"
                                            name="FILTERNIKMENTOR" maxlength="7" placeholder=" -- Masukkan NIK Mentor -- ">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="FILTERTANGGAL" class="">Tanggal</label>
                                        <div class="input-group input-group-static my-2">
                                            <input class="form-control due-date-picker" type="text"
                                                placeholder="DD/MM/YYYY" name="FILTERTANGGAL" required id="FILTERTANGGAL">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-2">
                                    <button class="btn btn-primary ms-auto uploadBtn"
                                        onclick="dataListMasterUploadDocumentSearchGenerate();">
                                        <i class="fa fa-filter"> Search</i> </button></a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center" style="margin:10px">
                        <div class="col-md-2">
                            <a href="{{ route('bss-dahboard-fat-pph-add') }}"><button
                                    class="btn btn-primary ms-auto uploadBtn">
                                    Upload Data Potongan Baru</button></a>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="dataListMasterBuktiPotongan" data-toggle="table"
                            data-ajax="dataListMasterBuktiPotonganGenerateData"
                            data-query-params="dataListMasterBuktiPotonganParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="nodocpph" data-align="center" data-halign="center">No. Doc.</th>
                                    <th data-field="jumlah" data-align="center" data-halign="center" data-formatter="JumlahFormaterMasterPPH">Jumlah</th>
                                    <th data-field="tsite" data-align="center" data-halign="center">Site</th>
                                    <th data-field="concat_bulan" data-align="center" data-halign="center">Bulan</th>
                                    <th data-halign="center" data-align="center"
                                        data-formatter="dataListMasterBuktiPotonganActionFormater">Action
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
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script type="text/javascript">
        $('#FILTERTANGGAL').datepicker({
            dateFormat: 'd MM yy',
            monthNames: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']
        });


        function dataTableDateFormater(value, row, index) {
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var t = new Date(value);
            return t.getDate() + '-' + monthNames[t.getMonth()] + '-' + t.getFullYear();

        }

        function JumlahFormaterMasterPPH(value, row, index) {
            return value + " Document";
        }

        function dataListMasterBuktiPotonganActionFormater(value, row, index) {

            let data = `
                    <button onclick="RedirectToDetail(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i> View
                    </a></button> 
                `
            return data;
        }

        function RedirectToDetail(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            window.location.href = "view-detail-master-potongan-pph/" + $('#dataListMasterBuktiPotongan').bootstrapTable(
                    'getData')[
                    indexDt]
                .nodocpph
        }

        function dataListMasterBuktiPotonganParamsGenerate(params) {

            params.search = {
                'FILTERNIK': $('#FILTERNIK').val(),
                'FILTERNAMA': $('#FILTERNAMA').val(),
                'FILTERTANGGAL': $('#FILTERTANGGAL').val(),
                'FILTERNIKMENTOR': $('#FILTERNIKMENTOR').val(),
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

        function dataListMasterUploadDocumentSearchGenerate() {
            $('#dataListMasterBuktiPotongan').bootstrapTable('refresh');
        }

        function dataListMasterBuktiPotonganGenerateData(params) {
            var url = 'lst-fat-doc-list-master'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
    <script type="text/javascript"></script>
@endsection
