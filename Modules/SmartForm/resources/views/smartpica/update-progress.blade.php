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

        .wrap-text {
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
                                    <th data-field="status" data-align="center" data-formatter="statusFormaterStepSolution"
                                        data-halign="center" data-sortable="true">
                                        Status
                                    </th>
                                    <th data-field="action" data-align="center" data-halign="center">Action</th>
                                    <th data-field="note_step" data-align="left" data-halign="center" class="wrap-text">Step
                                        Solution</th>
                                    <th data-field="ap_tod" data-align="center" data-halign="center">AP/TOD</th>
                                    <th data-field="100%" data-align="center" data-formatter="targetFormaterDefault" data-halign="center">Target</th>
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
                <input type="hidden" name="targetMaster" id="targetMaster" value="">
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
                                    <div id="divKeteranganReject">
                                        <h4>Keterangan Reject</h4><span id="idKeteranganReject"></span>
                                    </div>
                                    <button onclick="OpenModalAddProgress()" class="btn btn-primary ms-auto uploadBtn">
                                        Add Progress</button>
                                </div>
                                <br>
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
                                            <input type="text" id="progress" name="progress" class="form-control"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
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

    <div class="modal fade" id="ModalRejectReason" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
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
                        <input type="hidden" id="RaasonIDOBJECT">
                        <div class="card border" style="">
                            <div class="card-body">
                                <h5 class="card-title">Reason Reject</h5>
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
                                    style="margin : 20px" onclick="AcceptanceChange(0, 2)">
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
        const inputField = document.getElementById('angkaInput');

        if (inputField) {
            inputField.addEventListener('input', function() {
                // Mengganti karakter yang bukan angka dengan string kosong
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }

        function targetFormaterDefault(value, row, index) {
            return "100%"; // Mengembalikan "100$" sebagai default
        }

        function statusFormaterStepSolution(value, row, index) {
            if (value == "NEED APPROVE") {
                return `<button type="button" class="btn btn-info btn-sm">NEED APPROVE</button>`
            } else if (value == 'NOT YET') {
                return `<button type="button" class="btn btn-secondary btn-sm">${value}</button>`
            } else if (value == 'REJECT BY PIC') {
                return `<button type="button" class="btn btn-danger btn-sm">${value}</button>`
            } else if (value == 'CLOSE') {
                return `<button type="button" class="btn btn-success btn-sm">${value}</button>`
            } else if (value == 'ON PROGRESS') {
                return `<button type="button" class="btn btn-warning btn-sm">${value}</button>`
            } else if (value == 'REVISION') {
                return `<button type="button" class="btn btn-warning btn-sm">${value}</button>`
            } else {
                return `<button type="button" class="btn btn-secondary btn-sm">?</button>`
            }
        }

        function dataTableDateFormater(value, row, index) {
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var t = new Date(value);
            return t.getDate() + '-' + monthNames[t.getMonth()] + '-' + t.getFullYear();

        }

        function RedirectViewPica(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            window.location.href = "/smart-pica/view-data-detail-pica/" + $('#dataListFormPica').bootstrapTable('getData')[
                    indexDt]
                .nodocpica
        }

        function dataListUpdateProgressActionFormater(value, row, index) {
            console.log(row)
            if (row.acceptance == 0) {
                return `
                     <button onclick="RedirectViewPica(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i> View
                    </a></button>
                    <button onclick="AcceptanceChange(${row.id}, 1)"><a class="like"  title="Like">
                        <i class="fa fa-check"></i>
                    </a> Accept </button>
                    <button onclick="modalOpenRejectReason(${row.id})"><a class="like"  title="Like">
                        <i class="fa fa-circle-xmark"></i>
                    </a> Reject </button>
                `
            } else if (row.acceptance == 1) {
                return `<button onclick="RedirectViewPica(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i> View
                    </a></button>
                    <button onclick="OpenModalHistory(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i>
                    </a>Update Progress</button>`
            } else if (row.acceptance == 9) {
                return `<button onclick="RedirectViewPica(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i> View
                    </a></button>
                <button disabled><a class="like"  title="Like">
                    </a>Close</button>`
            } else {
                return `<button onclick="RedirectViewPica(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i> View
                    </a></button> <button disabled ><a class="like"  title="Like">
                    </a>Rejected</button>`
            }
        }

        function modalOpenRejectReason(id) {
            $('#RaasonIDOBJECT').val(id);
            $('#ModalRejectReason').modal("show");
        }

        function AcceptanceChange(id, bol) {

            let dataKirim = {};

            if (id == 0) {
                let reason = $('#reasonRejected').val();
                if (reason == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Mohon isikan alasan melakukan rejecting',
                    });
                    return false;
                }

                dataKirim = {
                    id: $('#RaasonIDOBJECT').val(),
                    hasil: bol,
                    reason: reason
                }
            } else {
                dataKirim = {
                    id: id,
                    hasil: bol,
                    reason: ''
                }
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "change-acceptance",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            $('#dataListUpdateProgress').bootstrapTable('refresh');
                            $('#ModalRejectReason').modal("hide");
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError)
                }
            })


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
            window.location.href = "/smart-pica/view-data-detail-pica/" + $('#dataListUpdateProgress').bootstrapTable(
                    'getData')[
                    indexDt]
                .nodocpica
        }

        function dataListUpdateProgressSearchGenerate(obj) {
            $('#dataListUpdateProgress').bootstrapTable('refresh');
            $("#dataListUpdateProgress").bootstrapTable("uncheckAll");
        }

        function dataListUpdateProgressGenerateData(params) {
            var url = '/helper/data-update-progress'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
    <script type="text/javascript">
        function OpenModalHistory(obj) {
            $('#divKeteranganReject').addClass("d-none");
            let indexDt = $(obj).closest('tr').data('index');
            let dataObject = $('#dataListUpdateProgress').bootstrapTable('getData')[indexDt];
            $('#positionWhy').val(dataObject.position_why)
            $('#identityWhy').val(dataObject.identity_why)
            $('#nodocpica').val(dataObject.nodocpica)
            $('#idMaster').val(dataObject.id_master)
            $('#nikMaster').val(dataObject.nik_master)
            $('#idSolution').val(dataObject.id)
            // $('#targetMaster').val(dataObject.target_master)
            $('#targetMaster').val(100)
            $('#idKeteranganReject').html(dataObject.keterangan_reject)
            if (dataObject.status == "REVISION") {
                $('#divKeteranganReject').removeClass("d-none");
            }
            $('#dataListHistoryProgress').bootstrapTable('refresh');
            $('#updateProgressHistory').modal("show");
        }

        function OpenModalAddProgress(obj) {

            $('#ModalAddProgress').modal("show");
        }

        function dataListHistoryProgressActionFormater(value, row, index) {
            if (row.status_reject == 1) {
                return `
                    <button onclick="deleteDataProgress(this)"><a class="like"  title="Like">
                        <i class="fa fa-trash"></i> Delete Data
                    </a></button> `
            } else {
                return `
                    <button onclick="openFileCCP(this)"><a class="like"  title="Like">
                        <i class="fa fa-file-import"> CCP</i>
                    </a></button>
                `
            }
        }

        function deleteDataProgress(obj) {
            let indexDt = $(obj).closest('tr').data('index');
            let dataObject = $('#dataListHistoryProgress').bootstrapTable('getData')[indexDt];
            Swal.fire({
                title: "Hapus Data Progress?",
                showCancelButton: true,
                confirmButtonText: "Close Task",
            }).then((result) => {
                if (result.isConfirmed) {
                    submitDataDelete(dataObject);
                }
            });
        }

        function submitDataDelete(dataKirim) {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "deleted-progress-history-transaction",
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
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError)
                }
            })

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
            var targetMaster = $('#targetMaster').val().trim();

            // Validation
            var isValid = true;
            var googleDrivePattern = /^(https?:\/\/)?([\w\-]+(\.[\w\-]+)+)([\/\w\-\._~:?#[\]@!$&'()*+,;=]*)?$/;

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
                    text: 'CCP Link harus berupa link',
                });
            } else if (progress === "") {
                isValid = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Progress harus diisi.',
                });
            }

            if (parseInt(progress, 10) > parseInt(targetMaster, 10)) {
                isValid = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Progress tidak boleh melebihi angka target yaitu ' + targetMaster,
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
                    idSolution: idSolution,
                    last: false
                };
                if (parseInt(progress, 10) == parseInt(targetMaster, 10)) {
                    Swal.fire({
                        title: "Apakah Pekerjaan sudah selesai?",
                        showCancelButton: true,
                        confirmButtonText: "Close Task",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            dataKirim.last = true;
                            updateProgress(dataKirim)
                        }
                    });
                } else {
                    updateProgress(dataKirim)
                }


            }
        }


        function updateProgress(dataKirim) {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "add-progress-history-transaction",
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
                            $('#dataListUpdateProgress').bootstrapTable('refresh');
                            $('#ModalAddProgress').modal("hide");
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError)
                }
            })
        }
    </script>
@endsection
