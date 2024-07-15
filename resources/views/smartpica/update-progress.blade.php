@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .table th[data-field="note_progress"] {
            width: 1000px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Smart PICA Progress</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">

                    <div class="table-responsive p-0">
                        <table id="dataListUpdateProgress" data-toggle="table"
                            data-ajax="dataListUpdateProgressGenerateData"
                            data-query-params="dataListUpdateProgressParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodocpica">
                            <thead>
                                <tr>
                                    <th data-field="nodocpica" data-align="left" data-halign="text-center"
                                        data-sortable="true">No. Document
                                    </th>
                                    <th data-field="status" data-align="center" data-halign="center" data-sortable="true">Status
                                    </th>
                                    <th data-field="action" data-align="center" data-halign="center">Action</th>
                                    <th data-field="note_step" data-align="left" data-halign="center">Step Solution</th>
                                    <th data-field="ap_tod" data-align="center" data-halign="center">AP/TOD</th>
                                    <th data-field="due_date" data-align="left" data-formatter="dataTableDateFormater"
                                        data-halign="center">Due Date</th>
                                    <th data-field="progress" data-align="center" data-halign="center">Progress</th>
                                    <th data-halign="center" data-align="center"
                                        data-formatter="dataListUpdateProgressActionFormater">Action
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
                                <div class="d-flex align-items-center">
                                    <button onclick="OpenModalAddProgress()" class="btn btn-primary ms-auto uploadBtn">
                                        Add Progress</button>
                                </div>
                                <div class="table-responsive p-0">
                                    <table id="dataListHistoryProgress" data-toggle="table"
                                        data-ajax="dataListHistoryProgressGenerateData"
                                        data-query-params="dataListHistoryProgressParamsGenerate"
                                        data-side-pagination="server" data-page-list="[10, 25, 50, 100, all]"
                                        data-sortable="true" data-content-type="application/json" data-data-type="json"
                                        data-pagination="true" data-unique-id="id">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-align="center" data-halign="text-center"
                                                    data-sortable="true">ID Solution
                                                </th>
                                                <th data-field="note_progress" data-align="left" data-halign="center"
                                                    data-sortable="true">Catatan
                                                </th>
                                                <th data-field="progress" data-align="center" data-halign="center">
                                                    Progress</th>
                                                <th data-field="created_at" data-formatter="dataTableDateFormater"
                                                    data-align="left" data-halign="center">Updated At
                                                </th>
                                                <th data-halign="center" data-align="center"
                                                    data-formatter="dataListHistoryProgressActionFormater">Action
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="horizontal dark my-sm-3">

                <div class="row" style="margin:10px">
                    <div class="col text-end" id="masukkanButtonSubmit">

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalAddProgress" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Add Progress</h5>
                            <p id="ProblemHeader"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <div class="card-body">
                                <h5 class="card-title">Progress Pembenahan</h5>
                                <span id="solutionSpan"></span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static my-4">
                                            <label for="note_progress">Catatan Progress</label>
                                            <textarea class="form-control" placeholder="Masukkan Catatan" rows="2" id="note_progress"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static my-4">
                                            <label for="CCPLink" class="ms-0">CCP Link</label>
                                            <input class="form-control" type="text"
                                                placeholder="Masukkan note untuk PIC" name="CCPLink" required
                                                id="CCPLink">
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="input-group input-group-static my-4">
                                            <label for="progress" class="ms-0">Progress</label>
                                            <input class="form-control" type="text" placeholder="Persentase Progress"
                                                name="progress" required id="progress">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                    style="margin : 20px" onclick="SubmitAllDataAndRefreshDataTableHistory()">
                                    <i class="fas fa-save"></i>
                                    Save All Data</button>
                            </div>
                        </div>
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

        function dataListUpdateProgressActionFormater(value, row, index) {
            return `
                    <button onclick="OpenModalHistory(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye">View</i>
                    </a></button>
                `
        }

        function dataListUpdateProgressParamsGenerate(params) {

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

        function RedirectViewPica(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            window.location.href = "/view-data-detail-pica/" + $('#dataListUpdateProgress').bootstrapTable('getData')[
                    indexDt]
                .nodocpica
        }

        function dataListUpdateProgressSearchGenerate(obj) {
            $('#dataListUpdateProgress').bootstrapTable('refresh');
            $("#dataListUpdateProgress").bootstrapTable("uncheckAll");
        }

        function dataListUpdateProgressGenerateData(params) {
            var url = '/helper-data-update-progress'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
    <script type="text/javascript">
        function OpenModalHistory(obj) {
            let indexDt = $(obj).closest('tr').data('index');

            $('#positionWhy').val($('#dataListUpdateProgress').bootstrapTable('getData')[indexDt].position_why)
            $('#identityWhy').val($('#dataListUpdateProgress').bootstrapTable('getData')[indexDt].identity_why)
            $('#nodocpica').val($('#dataListUpdateProgress').bootstrapTable('getData')[indexDt].nodocpica)
            $('#idMaster').val($('#dataListUpdateProgress').bootstrapTable('getData')[indexDt].id_master)
            $('#nikMaster').val($('#dataListUpdateProgress').bootstrapTable('getData')[indexDt].nik_master)
            $('#idSolution').val($('#dataListUpdateProgress').bootstrapTable('getData')[indexDt].id)
            $('#dataListHistoryProgress').bootstrapTable('refresh');
            $('#updateProgressHistory').modal("show");
        }

        function OpenModalAddProgress(obj) {

            $('#ModalAddProgress').modal("show");
        }

        function dataListHistoryProgressActionFormater(value, row, index) {
            return `
                    <button onclick="openFileCCP(this)"><a class="like"  title="Like">
                        <i class="fa fa-file-import">View</i>
                    </a></button>
                `
        }

        function openFileCCP(obj) {
            let indexDt = $(obj).closest('tr').data('index');
            window.open($('#dataListHistoryProgress').bootstrapTable('getData')[indexDt].ccp);
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
            var url = '/helper-data-history-progress'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
    <script type="text/javascript">
        function SubmitAllDataAndRefreshDataTableHistory() {

            var noteProgress = $('#note_progress').val().trim();
            var ccpLink = $('#CCPLink').val().trim();
            var progress = $('#progress').val().trim();

            // Collecting hidden input data
            var positionWhy = $('#positionWhy').val().trim();
            var identityWhy = $('#identityWhy').val().trim();
            var nodocpica = $('#nodocpica').val().trim();
            var idMaster = $('#idMaster').val().trim();
            var nikMaster = $('#nikMaster').val().trim();
            var idSolution = $('#idSolution').val().trim();

            // Validation
            var isValid = true;
            var googleDrivePattern = /^https:\/\/drive\.google\.com\/.+$/;

            if (noteProgress === "") {
                isValid = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Catatan Progress harus diisi.',
                });
            } else if (ccpLink === "") {
                isValid = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'CCP Link harus diisi.',
                });
            } else if (!googleDrivePattern.test(ccpLink)) {
                isValid = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'CCP Link harus berupa link Google Drive yang valid.',
                });
            } else if (progress === "") {
                isValid = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Progress harus diisi.',
                });
            }

            if (isValid) {
                // If all fields are valid, create an object to store the data
                var dataKirim = {
                    noteProgress: noteProgress,
                    ccpLink: ccpLink,
                    progress: progress,
                    positionWhy: positionWhy,
                    identityWhy: identityWhy,
                    nodocpica: nodocpica,
                    idMaster: idMaster,
                    nikMaster: nikMaster,
                    idSolution: idSolution
                };

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/add-progress-history-transaction",
                    data: dataKirim,
                    dataType: 'json',
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                            }).then((result) => {
                                $('#note_progress').val('');
                                $('#CCPLink').val('');
                                $('#progress').val('');

                                // Reset hidden inputs
                                $('#dataListHistoryProgress').bootstrapTable('refresh');
                                $('#ModalAddProgress').modal("hide");
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError)
                    }
                })
            }
        }
    </script>
@endsection
