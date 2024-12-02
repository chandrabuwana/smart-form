@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .display-block {
            display: contents !important;
        }

        .select2-dropdown {
            overflow: scroll;
            height: 300px;
        }

        .custom-width-1 {
            width: 90%;
            /* Example width, adjust as needed */
        }


        .close-button-why {
            position: absolute;
            top: 0;
            right: 0;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background-color: black;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate(50%, -50%);
        }

        .close-button-why:hover {
            background-color: darkred;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            /* Menyesuaikan dengan form-control di Bootstrap 5 */
        }

        /* Menyesuaikan tinggi baris teks dalam pilihan */
        .select2-container--bootstrap-5 .select2-selection__rendered {
            line-height: calc(1.5em + .75rem + 2px);
        }

        .scrollable-div {
            width: 100%;
            height: 400px;
            overflow: auto;
            position: relative;
        }

        fieldset {
            border: 2px solid #ddd;
            /* Border for the fieldset */
            padding: 1.5em;
            /* Padding inside the fieldset */
            margin-bottom: 1.5em;
            /* Margin below the fieldset */
            position: relative;
            /* Position relative to handle absolute positioned legend */
        }

        legend {
            font-size: 1.25em;
            /* Font size for the legend */
            font-weight: bold;
            /* Make the legend text bold */
            padding: 0 10px;
            /* Padding to give some space on left and right */
            background-color: white;
            /* Background color to match the page's background */
            position: absolute;
            /* Position the legend absolutely */
            top: -1em;
            /* Move it up above the border */
            left: 10px;
            /* Adjust left position */
        }

        .zoomable-content {
            transform-origin: 0 0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form Induksi Karyawan</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Pelapor : {{ $dataMaster->created_by }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="row" id="tabel_tambah">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="input-group input-group-static my-3">
                                        <label for="pc_thn" class="ms-0">Nomor Document </label>
                                        <select class="form-control" name="pc_thn" id="pc_thn" disabled required>
                                            <option value="">-- {{ $dataMaster->nodocpph }} --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-static my-3">
                                        <label for="pc_thn" class="ms-0">Tahun </label>
                                        <select class="form-control" name="pc_thn" id="pc_thn" disabled required>
                                            <option value="">-- {{ $dataMaster->tahun }} --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-3">
                                        <label for="pc_bln" class="ms-0">Bulan </label>
                                        <select class="form-control" name="pc_bln" id="pc_bln" disabled required>
                                            <option value="">-- {{ $dataMaster->nama_bulan }} --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-3">
                                        <label for="pc_site" class="ms-0">Site </label>
                                        <select class="form-control site" name="pc_site" id="pc_site" disabled>
                                            <option value="">-- {{ $dataMaster->tsite }} --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark my-sm-4">
                        <div class="row" id="tabel_list_karyawan">
                            <div class="row" style="padding-left: 0px !important;">
                                <div class="col" style="padding-left: 0px !important;">
                                    <input type="hidden" name="nodocpph" value="{{ $dataMaster->nodocpph }}"
                                        id="nodocpph">
                                    <fieldset class="color-fieldset form-horizontal">
                                        <legend class="color-legend">
                                            <span>Daftar dokument yang sudah terupload</span>
                                        </legend>
                                        <div class="form-horizontal">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="input-group input-group-static mb-4">
                                                        <label for="FILTERNAMAVENDOR">Vendor</label>
                                                        <input type="text" class="form-control" id="FILTERNAMAVENDOR"
                                                            name="FILTERNAMAVENDOR" onkeypress="refreshTable()"
                                                            placeholder=" -- Masukkan Nama Vendor -- ">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static mb-4">
                                                        <label for="FILTERNPWPVENDOR">NPWP / NIK</label>
                                                        <input type="text" class="form-control" id="FILTERNPWPVENDOR"
                                                            onkeypress="refreshTable()" name="FILTERNPWPVENDOR"
                                                            placeholder=" -- Masukkan NPWP -- ">
                                                    </div>
                                                </div>
                                            </div>


                                            <table id="tableListOfDocumentUploaded" data-toggle="table"
                                                data-ajax="tableListOfDocumentUploadedGenerateData"
                                                data-query-params="tableListOfDocumentUploadedParamsGenerate"
                                                data-side-pagination="server" data-page-list="[10, 25, 50, 100, all]"
                                                data-sortable="true" data-content-type="application/json"
                                                data-data-type="json" data-pagination="true" data-unique-id="id">
                                                <thead>
                                                    <tr>
                                                        <th data-field="nama_file" data-halign="center"
                                                            data-sortable="true">
                                                            Nama Document</th>
                                                        <th data-field="npwp" data-halign="center" data-sortable="true">
                                                            NPWP</th>
                                                        <th data-halign="center" data-align="center"
                                                            data-formatter="FormaterActionDocumentUploaded">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-between">
                            <div class="col-md-3">
                                <button class="btn btn-primary ms-auto back-button-by-history">
                                    <i class="fas fa-back"></i>
                                    Back Page</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modal')
    <div class="modal fade" id="ModalUpdateDocument" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Update Document</h5>
                            <p id="ProblemHeader"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <div class="card-body">
                                <input type="hidden" name="data_code" id="data_code">
                                <input type="hidden" name="data_iden" id="data_iden">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static my-4">
                                            <label for="pc_document_update" class="ms-0">Upload Data ZIP </label>
                                            <input type="file" class="form-control" name="pc_document_update"
                                                id="pc_document_update" />
                                            <small id="fileError" style="color:red; display:none;">Please upload a valid
                                                PDF file.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                    style="margin : 20px" onclick="updatedDataDocument()">
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        var MateriTambahanInputData_Obj_datas = [];

        function updatedDataDocument() {
            let isValid = true;
            let dataKirim = new FormData();

            let fileInput = $('#pc_document_update')[0].files[0]; // Get the file from input

            if (!fileInput) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silakan pilih file untuk diunggah!',
                });
                isValid = false;
            } else if (fileInput.name.split('.').pop() !== 'pdf') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'File harus berformat .pdf!',
                });
                isValid = false;
            }

            if (!isValid) {
                return false;
            }

            dataKirim.append('code', $('#data_code').val());
            dataKirim.append('iden', $('#data_iden').val());
            dataKirim.append('pdf', fileInput);

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/fat/pph/update-document-potongan",
                data: dataKirim,
                processData: false, // Important for file upload
                contentType: false, // Important for file upload
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: "success",
                            title: "Done",
                        });
                        $('#ModalUpdateDocument').modal("hide");
                        $('#pc_document_update').val('');
                        $('#fileError').hide();
                        $("#data_code").val("");
                        $("#data_iden").val("");
                        $('#tableListOfDocumentUploaded').bootstrapTable('refresh');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.data,
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: thrownError,
                        confirmButtonText: 'OK'
                    });
                }
            })
        }

        function refreshTable() {
            $('#tableListOfDocumentUploaded').bootstrapTable('refresh');
            $("#tableListOfDocumentUploaded").bootstrapTable("uncheckAll");
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#pc_document_update').on('change', function() {
                var fileInput = $('#pc_document_update')[0];
                var fileError = $('#fileError');
                var file = fileInput.files[0];

                if (file) {
                    var fileName = file.name;
                    var fileSize = file.size / 1024 / 1024; // file size in MB
                    var fileExtension = fileName.split('.').pop().toLowerCase();

                    if (fileExtension !== 'pdf') { // Adjust max file size if needed (e.g., 5MB)
                        fileError.show();
                        $('#pc_document_update').val(''); // Clear the input
                    } else {
                        fileError.hide();
                    }
                }
            });
        });

        function tableListOfDocumentUploadedParamsGenerate(params) {

            params.search = {
                'FILTERNPWPVENDOR': $('#FILTERNPWPVENDOR').val(),
                'FILTERNAMAVENDOR': $('#FILTERNAMAVENDOR').val(),
                'FILTERNODOC': $('#nodocpph').val()
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

        function tableListOfDocumentUploadedGenerateData(params) {
            var url = '/bss-form/fat/pph/lst-fat-doc-list-uploaded'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

        function FormaterActionDocumentUploaded(value, row, index) {
            return `
                    <a class="like" href="javascript:void(0)" onclick="ccccc(this)" title="Like">
                        <i class="fa fa-eye"></i> View
                    </a> 
                    <a class="like" href="javascript:void(0)" onclick="openModalUpdateDocument(this)" title="Like">
                        <i class="fa fa-pen"></i> Update
                    </a>
                    <a class="like" href="javascript:void(0)" onclick="DeletedDataDocumentUploaded(this)" title="Like">
                        <i class="fa fa-trash"></i> Hapus
                    </a> 
                `
        }

        function openModalUpdateDocument(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            let getUniqId = $('#tableListOfDocumentUploaded').bootstrapTable('getData')[indexDt];

            $('#ModalUpdateDocument').modal("show");
            $("#data_code").val(getUniqId.nodocpph);
            $("#data_iden").val(getUniqId.id);
        }

        function DeletedDataDocumentUploaded(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            let getUniqId = $('#tableListOfDocumentUploaded').bootstrapTable('getData')[indexDt];

            let dataKirim = {
                code: getUniqId.nodocpph,
                iden: getUniqId.id
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/fat/pph/hapus-document-potongan",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: "Document di non Activekan",
                        })
                        $('#tableListOfDocumentUploaded').bootstrapTable('refresh');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error While Deleted Data',
                            html: message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            })
        }

        function UpdateDataUser(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            let getUniqId = $('#tableListOfDocumentUploaded').bootstrapTable('getData')[indexDt];

            let dataKirim = {
                code: getUniqId.nodocpph,
                iden: getUniqId.id
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/fat/pph/update-document-potongan",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: "Document Telah Terupdate",
                        })
                        $('#tableListOfDocumentUploaded').bootstrapTable('refresh');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error While Deleted Data',
                            html: message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            })
        }
    </script>
@endsection
