@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf_viewer.min.css" rel="stylesheet" type="text/css" />

    <style>
        .filter-btn {
            display: inline;
            width: auto
        }
        .position-relative {
            position: relative;
        }
        .position-absolute {
            position: absolute;
        }
        .suggestion {
            position: absolute;
            top: 100%;
            max-height: 100px;
            width: 100%;
            /* background-color: rgba(39, 39, 38, 0.192); */
            overflow-y: auto;
            z-index: 99;
            color: black;
            border: 1px solid rgba(85, 83, 83, 0.534);
            border-radius: 4px 4px 4px 4px;
        }
        .suggestion-child {
            cursor: pointer;
            font-size: 12px;
            padding: 2px 4px;
            border-bottom: 1px solid rgba(85, 83, 83, 0.534);
        }
        .text-light {
            color: #f0f2f5;
        }

        .select2-container {
            border-bottom: 1px solid rgba(85, 83, 83, 0.534) !important;
            padding-top: 8.5px !important;
        }

        .line-progress::before {
            content: '';
            width: 85%;
            height: 10px;
            background-color: black;
            position: absolute;
            z-index: -1;
            top: 20px;
        }

        #pdf_container {
            background: #ccc;
            text-align: center;
            display: none;
            padding: 5px;
        }

        .input-text {
            border: 1px solid #d2d6da !important;
            border-color: rgb(188, 188, 188);
            padding-left: 0.4rem !important;
            padding-right: 0.4rem !important;
        }

        #modalApprove .modal-dialog {
            --bs-modal-width: 700px !important;
        }

        #backdrop-keterangan {
            display: none;
            position: fixed;
            z-index: 997 !important;
            width: 100%;
            height: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.2);
            cursor: not-allowed !important;
        }

        #backdrop-keterangan.is-show {
            display: block !important;
        }

        body.editor-enabled #pdf_container {
            position: relative;
            cursor: pointer !important;
            z-index: 999 !important;
        }

        body.editor-enabled #action-editor {
            position: relative;
            z-index: 999 !important;
        }

        .col-feedback {
            position: sticky !important;
            top: 10px !important;
            z-index: 1000 !important;
        }

        #btn-action-editor {
            position: sticky !important;
            top: 10px;
            z-index: 1000 !important;
        }

        #modalAddKomentar {
            z-index: 1090 !important;
        }

        body.editor-enabled .swal2-container {
            z-index: 1100 !important;
        }
    </style>
@endsection

@section('content')
    <div id="backdrop-keterangan"></div>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Validasi Dokumen Mutu</h6>
                    </div>
                </div>
                <div class="card-body pb-2">
                    <div class="row justify-content-between mb-5 px-3 line-progress" style="z-index: 10; position: relative;">
                        <div class="bg-success rounded px-5 py-3 text-white" style="width: fit-content;">
                            <i class="fas fa-check-circle fa-xl me-1"></i>
                            <h5 class="text-white mb-0 d-inline">Pembuatan</h5>
                        </div>

                        <div class="{{ $validateIndex >= 1 ? 'bg-success' : 'bg-warning' }} rounded px-5 py-3 text-white" style="width: fit-content;">
                            <i class="fas {{ $validateIndex >= 1 ? 'fa-check-circle' : 'fa-spinner' }} fa-xl me-1"></i>
                            <h5 class="text-white mb-0 d-inline">Pemeriksaan</h5>
                        </div>

                        <div class="{{ $validateIndex >= 2 ? 'bg-success' : 'bg-warning' }} rounded px-5 py-3 text-white" style="width: fit-content;">
                            <i class="fas {{ $validateIndex >= 2 ? 'fa-check-circle' : 'fa-spinner' }} fa-xl me-1"></i>
                            <h5 class="text-white mb-0 d-inline">Validasi</h5>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 topbar-editor">
                        <h5 class="me-3 mb-0">
                            No Versi :
                            <span class="badge bg-gradient-dark ms-1">{{ $lastVersion->no_versi }}</span>
                        </h5>

                        <a href="{{ $doco->file_path }}" class="btn bg-gradient-dark btn-action text-white mb-0" download>
                            <i class="fas fa-cloud-download-alt fa-lg me-1"></i> Download Dokumen
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-8 position-relative">
                            <div id="pdf_container"></div>
                        </div>

                        <div class="col-md-4" style="z-index: 1000;">
                            <div class="col-feedback">
                                <div id="btn-action-editor" class="d-none">
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn bg-gradient-danger btn-action text-white mb-0" onclick="disableKeteranganMode()">
                                            <i class="fas fa-times-circle fa-lg me-2"></i> Tutup
                                        </button>

                                        <button type="button" class="btn bg-gradient-success btn-action text-white mb-0 ms-3" onclick="saveKeterangan()"
                                            id="btn-action-save" disabled>
                                            <i class="fas fa-check-circle fa-lg me-2"></i> Simpan
                                        </button>
                                    </div>
                                </div>

                                @if($isValidate)
                                    <div class="row justify-content-end" id="btn-action-validate">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-danger btn-action text-white w-100"
                                                onclick="rejectPengajuan('{{ $doco->id }}')">
                                                Tolak
                                            </button>
                                        </div>

                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary btn-action text-white w-100"
                                                onclick="enableKeteranganMode()">
                                                Catatan
                                            </button>
                                        </div>

                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-success btn-action text-white w-100"
                                                onclick="showApproveModal()">
                                                Setujui
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <div id="loader-feedback" class="d-none justify-content-center mt-3">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>

                                <div class="feedback-parent mt-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modalApprove" aria-hidden="true" aria-labelledby="modalApproveLabel"
        tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title" id="modalApproveLabel">Setujui Validasi</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('dokumen-mutu.validasi.approved', ['id' => $doco->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nik_validator" value="{{ session('user_id') }}">
                        <input type="hidden" name="id" value="{{ $doco->id }}">
                        <input type="hidden" name="validator_type" value="{{ $validator_type }}">

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Dokumen Tervalidasi</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" class="form-control input-text" id="dokumenTervalidasi" name="dokumenTervalidasi" accept="application/pdf" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Catatan</label>
                            </div>
                            <div class="col-md-8">
                                <textarea rows="3" class="form-control input-text" id="catatan" name="catatan"
                                    placeholder="--- Tambahkan Catatan (jika ada) ---" maxlength="250"></textarea>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary ms-auto uploadBtn">
                                <i class="fas fa-save"></i>
                                Submit Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddKomentar" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="modalAddKomentarLabel"
        tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title" id="modalAddKomentarLabel">Tambah Komentar Validasi</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <form id="form-add-komentar" method="POST">
                        @csrf
                        <input type="hidden" name="vertical">
                        <input type="hidden" name="horizontal">

                        <div class="mb-4 px-2">
                            <label class="d-block mb-2 ms-0 fs-6">Keterangan</label>
                            <textarea rows="4" class="form-control input-text" id="keterangan" name="keterangan"
                                placeholder="--- Masukkan Keterangan ---" maxlength="250"></textarea>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary ms-auto uploadBtn">
                                <i class="fas fa-save"></i>
                                Submit Form
                            </button>
                        </div>
                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `{{ session('error') }}`,
            });
        </script>

    @elseif(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Yeay!',
                text: `{{ session('success') }}`,
            });
        </script>
    @endif

    <script>
        const ID = `{{ $doco->id }}`;
        const ID_VERSI = `{{ $lastVersion->id }}`;
        const namaKaryawan = `{{ $tKaryawan->Nama }}`;

        $( function() {
            $('body').popover({
                selector: '[data-bs-toggle="popover"]'
            });

            $('#modalAddKomentar').on('hide.bs.modal', function() {
                $('#modalAddKomentar [name=vertical]').val('');
                $('#modalAddKomentar [name=horizontal]').val('');
                $('#modalAddKomentar [name=keterangan]').val('');
            });

            $('#modalApprove button[type="submit"]').on('click', function(e) {
                const $form = $(this).closest('form')
                const isFormValid = $form.length > 0 && $form[0].checkValidity()

                if(isFormValid) {
                    $(this).attr('disabled', true);
                    Swal.fire({
                        title: 'Loading...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $form.submit();
                }
            });
        });

        let pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';
        let pdfDoc = null;
        let scale = 1;
        let resolution = 1;
        let komentars = [];

        function LoadPdfFromUrl(url) {
            pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
                pdfDoc = pdfDoc_;
                let pdf_container = document.getElementById("pdf_container");
                pdf_container.style.display = "block";

                for (let i = 1; i <= pdfDoc.numPages; i++) {
                    RenderPage(pdf_container, i);
                }
            });
        }

        function RenderPage(pdf_container, num) {
            pdfDoc.getPage(num).then(function (page) {
                let canvas = document.createElement('canvas');
                canvas.id = 'pdf-' + num;
                ctx = canvas.getContext('2d');
                pdf_container.appendChild(canvas);

                let spacer = document.createElement("div");
                spacer.style.height = "20px";
                pdf_container.appendChild(spacer);

                let viewport = page.getViewport({ scale: scale });
                canvas.height = resolution * viewport.height;
                canvas.width = resolution * viewport.width;

                let renderContext = {
                    canvasContext: ctx,
                    viewport: viewport,
                    transform: [resolution, 0, 0, resolution, 0, 0]
                };
                page.render(renderContext);
            });
        }

        LoadPdfFromUrl(`{!! $doco->file_path !!}`);

        function loadFeedback() {
            $('#loader-feedback').removeClass('d-none').addClass('d-flex');

            $.ajax({
                url: `/doco/riwayat-pengajuan/validasi/${ID}/feedbacks`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    $('#loader-feedback').addClass('d-none').removeClass('d-flex');
                    $('.marker').remove();

                    if(response.length == 0) {
                        $('.feedback-parent').html(`
                            <div class="d-flex flex-column justify-content-center align-items-center pt-5 mt-3">
                                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3em;"></i>
                                <p class="mb-0 mt-3">Belum Ada Feedback</p>
                            </div>
                        `);

                    } else {
                        $('.feedback-parent').html('');
                        let feedbackEls = '';

                        response.forEach( (item) => {
                            addMarker(item);

                            feedbackEls += `
                                <div class="px-4 pt-2 pb-3 rounded bg-dark text-white shadow mb-3">
                                    <div class="text-end mb-2">
                                        <small>${item.created_at}</small>
                                    </div>

                                    <div class="d-flex align-items-center text-lg" style="line-height: 1.2;">
                                        <i class="fas fa-user me-3 fa-lg"></i>
                                        <span class="font-weight-bold">${item.NamaKaryawan}</span>
                                    </div>

                                    <p class="mb-0 mt-3" style="line-height: 1.4; text-align: justify;">
                                        ${item.keterangan}
                                    </p>
                                </div>
                            `;
                        });

                        $('.feedback-parent').html(feedbackEls);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(thrownError);
                    $('#loader-feedback').addClass('d-none').removeClass('d-flex');

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `Terjadi kesalahan tidak terduga`,
                    });
                }
            });
        }

        loadFeedback();

        function showApproveModal() {
            $('#modalApprove').modal('show');
        }

        function rejectPengajuan(id) {
            Swal.fire({
                icon: "warning",
                title: "Apakah yakin ingin menolak pengajuan?",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#d33"

            }).then(function(result) {
                if(result.isConfirmed) {
                    location.href = `/doco/riwayat-pengajuan/validasi/${id}/reject`;
                }
            });
        }

        function enableKeteranganMode() {
            $('body').addClass('editor-enabled');
            $('#btn-action-validate').addClass('d-none');
            $('#btn-action-editor').removeClass('d-none');
            $('#backdrop-keterangan').addClass('is-show');
        }

        function disableKeteranganMode() {
            if(komentars.length > 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Apakah yakin ingin menolak pengajuan?",
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal",
                    cancelButtonColor: "#3085d6",
                    confirmButtonColor: "#d33"

                }).then(function(result) {
                    if(result.isConfirmed) {
                        $('.marker.draft').remove();

                        $('body').removeClass('editor-enabled');
                        $('#btn-action-validate').removeClass('d-none');
                        $('#btn-action-editor').addClass('d-none');
                        $('#backdrop-keterangan').removeClass('is-show');
                    }
                });

            } else {
                $('body').removeClass('editor-enabled');
                $('#btn-action-validate').removeClass('d-none');
                $('#btn-action-editor').addClass('d-none');
                $('#backdrop-keterangan').removeClass('is-show');
            }
        }

        function addMarker(feedback, isDraft = false) {
            const marker = `
                <div class="marker ${ isDraft ? 'draft' : '' }" data-bs-toggle="popover"
                    data-bs-trigger="hover"
                    title="${feedback.NamaKaryawan}" data-bs-html="${feedback.keterangan}">
                    <i class="fas fa-comment-dots fa-xl"></i>
                </div>
            `;

            const vertical = ((screen.height / 100) * feedback.vertical) - 20;
            const horizontal = ((screen.width / 100) * feedback.horizontal) - 20;

            $('body').append(
                $(marker).css({
                    color: 'white',
                    display: 'flex',
                    cursor: 'pointer',
                    alignItems: 'center',
                    justifyContent: 'center',
                    borderRadius: '100%',
                    position: 'absolute',
                    zIndex: '1000',
                    top: vertical + 'px',
                    left: horizontal + 'px',
                    height: '35px',
                    width: '35px',
                    background: '#000000'
                })
            );
        }

        $('#pdf_container').click( function(e) {
            const isEnabled = $('body').hasClass('editor-enabled');
            const isCanvas = $(e.target).prop('tagName') == 'CANVAS';

            if(isEnabled && isCanvas) {
                $('#form-add-komentar [name=vertical]').val( (e.pageY / screen.height) * 100 );
                $('#form-add-komentar [name=horizontal]').val( (e.pageX / screen.width) * 100 );
                $('#modalAddKomentar').modal('show');
            }
        });

        $('#form-add-komentar button[type=submit]').click( function(e) {
            e.preventDefault();
            keterangan = $('#form-add-komentar [name=keterangan]').val();

            if(keterangan) {
                const komentar = {
                    NamaKaryawan: namaKaryawan,
                    vertical: $('#form-add-komentar [name=vertical]').val(),
                    horizontal: $('#form-add-komentar [name=horizontal]').val(),
                    keterangan
                }

                komentars.push(komentar);
                addMarker(komentar, true);

                $('#modalAddKomentar').modal('hide');
                $('#btn-action-save').prop('disabled', false);
            }
        });

        function saveKeterangan() {
            if(komentars.length > 0) {
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: `/doco/riwayat-pengajuan/validasi/${ID}/add-komentar`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        id: ID,
                        id_versi: ID_VERSI,
                        komentars
                    }),
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();

                        if(response.code == 200) {
                            komentars = [];
                            loadFeedback();
                            disableKeteranganMode();

                            Swal.fire({
                                icon: 'success',
                                title: 'Yeay!',
                                text: response.message,
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(thrownError);
                        Swal.close();

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `Terjadi kesalahan tidak terduga`,
                        });
                    },
                    finally: function() {
                        $('#btn-action-save').prop('disabled', true);
                    }
                });
            }
        }
    </script>
@endsection
