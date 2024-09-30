@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .table th[data-field="note_progress"] {
            width: 1000px;
            text-align: center;
        }

        .table td {
            word-wrap: break-word;
            /* Allows long words to be broken and wrap onto the next line */
            white-space: normal;
            /* Allows the text to wrap */
        }

        .table th {
            white-space: nowrap;
            /* Prevents header text from wrapping */
        }

        .wrap-text-solution {
            width: 10vw;
            word-wrap: break-word;
            /* Allows long words to be broken and wrap onto the next line */
            white-space: normal;
            /* Allows the text to wrap */
        }

        .wrap-text-problem {
            width: 20vw;
            word-wrap: break-word;
            /* Allows long words to be broken and wrap onto the next line */
            white-space: normal;
            /* Allows the text to wrap */
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
                        <table id="dataListApprovementStep" data-toggle="table"
                            data-ajax="dataListApprovementStepGenerateData"
                            data-query-params="dataListApprovementStepParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodocpica">
                            <thead>
                                <tr>
                                    <th data-field="nodocpica" data-align="left" data-halign="text-center"
                                        data-sortable="true">No. Document
                                    </th>
                                    <th data-field="why" data-align="center" data-halign="center" data-sortable="true"
                                        class="wrap-text-problem">
                                        Permasalahan
                                    </th>
                                    <th data-field="action" data-align="center" data-halign="center">Action</th>
                                    <th data-field="note_step" data-align="left" class="wrap-text-solution"
                                        data-halign="center">Step
                                        Solutionsss</th>
                                    <th data-field="ap_tod" data-align="center" data-halign="center">AP/TOD</th>
                                    <th data-field="pic" data-align="center" data-halign="center">PIC</th>
                                    <th data-field="due_date" data-align="left" data-formatter="dataTableDateFormater"
                                        data-halign="center">Due Date</th>
                                    <th data-field="status_approve" data-align="center" data-halign="center"
                                        data-formatter="dataTableStatusFormater" data-halign="center">Status Approvement
                                    </th>
                                    <th data-halign="center" data-align="center"
                                        data-formatter="dataListApprovementStepActionFormater">Action
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
                                <div class="d-flex align-items-end" id="rejectButton">
                                    <button onclick="ApproveTaskAndCloseTask(true)"
                                        class="btn btn-primary ms-2 uploadBtn">
                                        APPROVE</button>
                                    <button onclick="openModalRejectClosingTask()" class="btn btn-primary ms-2 uploadBtn">
                                        REJECT</button>
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
                                                {{-- <th data-field="id" data-align="center" data-halign="text-center"
                                                    data-sortable="true">ID Solution
                                                </th> --}}
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

    <div class="modal fade" id="ModalRejectReason" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Reject Reason</h5>
                            <p id="ProblemHeader"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <input type="hidden" id="RaasonIDOBJECT">
                        <div class="card border" style="">
                            <div class="card-body">
                                <h5 class="card-title">Reject Reason</h5>
                                <span id="solutionSpan"></span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static my-4">
                                            <label for="reasonRejected">Alasan Melakukan Reject</label>
                                            <textarea class="form-control" placeholder=" -- Masukkan Alasan -- " rows="2" id="reasonRejected"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                    style="margin : 20px" onclick="ApproveTaskAndCloseTask(false)">
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

        function dataTableStatusFormater(value, row, index) {
            if (value == 0) {
                return `<button type="button" class="btn btn-warning btn-sm">Close Need Approve</button>`
            } else if (value == 1) {
                return `<button type="button" class="btn btn-success btn-sm">Close</button>`
            } else {
                return `<button type="button" class="btn btn-primary btn-sm">Reject</button>`
            }
        }

        function dataListApprovementStepActionFormater(value, row, index) {
            return `
                    <button onclick="OpenModalHistory(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i>
                    </a> Check</button>
                `
        }

        function dataListApprovementStepParamsGenerate(params) {

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
            window.location.href = "/smart-pica/view-data-detail-pica/" + $('#dataListApprovementStep').bootstrapTable(
                    'getData')[
                    indexDt]
                .nodocpica
        }

        function dataListApprovementStepSearchGenerate(obj) {
            $('#dataListApprovementStep').bootstrapTable('refresh');
            $("#dataListApprovementStep").bootstrapTable("uncheckAll");
        }

        function dataListApprovementStepGenerateData(params) {
            var url = '/helper/data-approvement-step-pica'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
    <script type="text/javascript">
        function OpenModalHistory(obj) {
            let indexDt = $(obj).closest('tr').data('index');
            let dataObject = $('#dataListApprovementStep').bootstrapTable('getData')[indexDt]
            $('#rejectButton').removeClass("d-none");
            $('#positionWhy').val(dataObject.position_why)
            $('#identityWhy').val(dataObject.identity_why)
            $('#nodocpica').val(dataObject.nodocpica)
            $('#idMaster').val(dataObject.id_master)
            $('#nikMaster').val(dataObject.nik_master)
            $('#idSolution').val(dataObject.id)
            $('#dataListHistoryProgress').bootstrapTable('refresh');
            if (dataObject.status_approve != 0) {
                $('#rejectButton').addClass("d-none");
            }
            $('#updateProgressHistory').modal("show");
        }

        function openModalRejectClosingTask() {
            $('#updateProgressHistory').modal("hide");
            $('#ModalRejectReason').modal("show");
        }

        function ApproveTaskAndCloseTask(obj) {
            if (obj) {
                Swal.fire({
                    title: "Apakah anda ingin close task ?",
                    showCancelButton: true,
                    confirmButtonText: "Close Task",
                }).then((result) => {
                    if (result.isConfirmed) {
                        let dataKirim = {
                            id: $('#idSolution').val(),
                            hasil: true,
                            keterangan: ""
                        }
                        kirimDataVerifikasiClosingTask(dataKirim)
                    }
                });
            } else {
                let dataAlasan = $('#reasonRejected').val();

                if (dataAlasan == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Isikan alasan reject',
                    });
                    return false
                }

                Swal.fire({
                    title: "Apakah anda REJECT Closing task ?",
                    showCancelButton: true,
                    confirmButtonText: "REJECT Closing",
                }).then((result) => {
                    if (result.isConfirmed) {
                        let dataKirim = {
                            id: $('#idSolution').val(),
                            hasil: false,
                            keterangan: dataAlasan
                        }
                        kirimDataVerifikasiClosingTask(dataKirim)
                    }
                });
            }

        }

        function kirimDataVerifikasiClosingTask(dataKirim) {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "approve-task-closing",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            $('#dataListHistoryProgress').bootstrapTable('refresh');
                            $('#ModalAddProgress').modal("hide");
                            $('#positionWhy').val("")
                            $('#identityWhy').val("")
                            $('#nodocpica').val("")
                            $('#idMaster').val("")
                            $('#nikMaster').val("")
                            $('#idSolution').val("")
                            $('#reasonRejected').val("");
                            $('#updateProgressHistory').modal("hide");
                            $('#ModalRejectReason').modal("hide");
                            $('#dataListApprovementStep').bootstrapTable('refresh');
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError)
                }
            })
        }

        function dataListHistoryProgressActionFormater(value, row, index) {
            return `
                    <button onclick="openFileCCP(this)"><a class="like"  title="Like">
                        <i class="fa fa-file-import"> CCP</i>
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
            var url = '/helper/data-history-progress'
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
