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
            left: 40px;
            top: 20px;
        }

        .feedback-parent {
            height: 800px;
            overflow-y: auto;
        }

        #pdf_container {
            background: #ccc;
            text-align: center;
            display: none;
            padding: 5px;
            /*height: 820px;
            overflow: auto;*/
        }

        .input-text {
            border: 1px solid #d2d6da !important;
            border-color: rgb(188, 188, 188);
            padding-left: 0.4rem !important;
            padding-right: 0.4rem !important;
        }

        .col-feedback {
            position: sticky !important;
            top: 10px !important;
            z-index: 1000 !important;
        }

        .feedback-popover .popover-body {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Detail Dokumen Mutu</h6>
                    </div>
                </div>
                <div class="card-body pb-2">
                    <div class="row justify-content-between mb-5 px-3 line-progress" style="z-index: 10; position: relative;">
                        <div class="d-flex flex-column align-items-center" style="width: fit-content;">
                            <div class="bg-success rounded px-5 py-3 text-white" style="width: fit-content;">
                                <i class="fas fa-check-circle fa-xl me-1"></i>
                                <h5 class="text-white mb-0 d-inline">Pembuatan</h5>
                            </div>
                        </div>

                        @if(in_array('verifikasi', $jenisValidators))
                            <div class="d-flex flex-column align-items-center" style="width: fit-content;">
                                @if($validateIndex >= 1)
                                    <div class="bg-success  rounded px-5 py-3 text-white" style="width: fit-content;">
                                        <i class="fas fa-check-circle fa-xl me-1"></i>
                                        <h5 class="text-white mb-0 d-inline">Pemeriksaan</h5>
                                    </div>
                                @else
                                    <div class="{{ $doco->status == 'Ditolak' ? 'bg-danger' : 'bg-warning' }}  rounded px-5 py-3 text-white" style="width: fit-content;">
                                        <i class="fas {{ $doco->status == 'Ditolak' ? 'fa-exclamation' : 'fa-spinner' }} fa-xl me-1"></i>
                                        <h5 class="text-white mb-0 d-inline">Pemeriksaan</h5>
                                    </div>
                                @endif

                                <div class="d-flex align-items-center mt-2">
                                    @if(isset($catatanValidates[0]))
                                        <span class="badge bg-warning" style="cursor: pointer; width: fit-content;"
                                            data-bs-toggle="popover" title="Catatan"
                                            data-bs-placement="bottom" data-bs-content="{{ $catatanValidates[0] }}"
                                            data-bs-html="true" data-bs-trigger="focus">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <small class="text-white">Catatan</small>
                                        </span>
                                    @endif

                                    <div class="mx-1"></div>

                                    @if(isset($overdues['verifikasi']))
                                        <span class="badge bg-danger" style="cursor: pointer; width: fit-content;"
                                            onclick="showModalOverdue('Verifikasi')">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <small class="text-white">Overdue</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if(in_array('validasi', $jenisValidators))
                            <div class="d-flex flex-column align-items-center" style="width: fit-content;">
                                @if($validateIndex >= 2)
                                    <div class="bg-success  rounded px-5 py-3 text-white" style="width: fit-content;">
                                        <i class="fas fa-check-circle fa-xl me-1"></i>
                                        <h5 class="text-white mb-0 d-inline">Validasi</h5>
                                    </div>
                                @else
                                    <div class="{{ $doco->status == 'Ditolak' ? 'bg-danger' : 'bg-warning' }}  rounded px-5 py-3 text-white" style="width: fit-content;">
                                        <i class="fas {{ $doco->status == 'Ditolak' ? 'fa-exclamation' : 'fa-spinner' }} fa-xl me-1"></i>
                                        <h5 class="text-white mb-0 d-inline">Validasi</h5>
                                    </div>
                                @endif

                                @if(isset($catatanValidates[1]))
                                    <span class="badge bg-warning mt-2" style="cursor: pointer;"
                                        data-bs-toggle="popover" title="Catatan"
                                        data-bs-placement="bottom" data-bs-content="{{ $catatanValidates[1] }}"
                                        data-bs-html="true" data-bs-trigger="focus">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <small class="text-white">Catatan</small>
                                    </span>
                                @endif

                                <div class="mx-1"></div>

                                @if(isset($overdues['validasi']))
                                    <span class="badge bg-danger" style="cursor: pointer; width: fit-content;"
                                        onclick="showModalOverdue('Validasi')">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <small class="text-white">Overdue</small>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4 col-md-8">
                        <h5 class="mb-0">
                            <span class="me-1">No Versi :</span>

                            <div class="btn-group">
                                <button type="button" class="btn bg-gradient-dark btn-sm {!! count($versions) > 1 ? 'dropdown-toggle' : '' !!} mb-0"
                                    {!! count($versions) > 1 ? 'data-bs-toggle="dropdown" aria-expanded="false"' : '' !!}>
                                    {{ $lastVersion->no_versi }}
                                </button>

                                @if(count($versions) > 1)
                                    <ul class="dropdown-menu shadow">
                                        @foreach($versions as $v)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('dokumen-mutu.detail-riwayat', ['id' => $doco->id]) . '?v=' . $v->no_versi }}">
                                                    Versi {{ $v->no_versi }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            {{-- <span class="badge bg-gradient-dark ms-1">{{ $lastVersion->no_versi }}</span> --}}
                        </h5>

                        @if($feedbacks->count() > 0 && $doco->nik_pemohon == $userId && in_array($doco->status, ['Belum Validasi', 'Sedang Validasi', 'Terdapat Feedback']) && $isLastVersion)
                            <button type="button" class="btn bg-gradient-primary mb-0"
                                onclick="showRevisiModal()">
                                Buat Revisi
                            </button>
                        @endif
                    </div>

                    @if( $doco->status == 'Ditolak' && !empty($doco->keterangan_status) )
                        <p class="fw-bold mb-1">Keterangan Penolakan :</p>
                        <p class="mb-5"> {!! nl2br($doco->keterangan_status) !!} </p>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            {{-- <iframe src="{{ $doco->file_converted_path }}" width="100%" frameborder="0"></iframe> --}}
                            <div id="pdf_container"></div>
                        </div>

                        <div class="col-md-4">
                            <div class="col-feedback">
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
    <div class="modal fade" id="modalRevisi" aria-hidden="true" aria-labelledby="modalRevisiLabel"
        tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title" id="modalRevisiLabel">Buat Revisi Pengajuan</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('dokumen-mutu.revisi.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_pengajuan" value="{{ $doco->id }}">
                        <input type="hidden" name="id_versi" value="{{ $lastVersion->id }}">

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Dokumen Terbaru</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" class="form-control input-text" id="dokumenTerbaru" name="dokumenTerbaru" accept="application/pdf" required>
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

    @foreach($overdues as $type => $values)
        <div class="modal fade" id="modalOverdue{{ ucfirst($type) }}" aria-hidden="true" aria-labelledby="modalOverdue{{ ucfirst($type) }}"
            tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col">
                                <h5 class="modal-title" id="modalOverdue{{ ucfirst($type) }}">Detail Overdue</h5>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Validator</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deviasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($values as $item)
                                        <tr>
                                            <td width="25%">{{ $item->NamaKaryawan }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td width="10%">{{ \App\Helper::formatDurationAgoFS($item->deviasi_sec) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
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
        $( function() {
            $('body').popover({
                selector: '[data-bs-toggle="popover"]',
                trigger: 'focus'
            });

            $('#modalRevisi button[type="submit"]').on('click', function(e) {
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
            })
        });

        const ID = `{{ $doco->id }}`;
        let pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';
        let pdfDoc = null;
        let scale = 1;
        let resolution = 1;
        const ID_VERSI = `{{ $lastVersion->id }}`;

        function LoadPdfFromUrl(url) {
            pdfjsLib.getDocument({ data: atob(url) }).promise.then(function (pdfDoc_) {
                pdfDoc = pdfDoc_;
                let pdf_container = document.getElementById("pdf_container");
                pdf_container.style.display = "block";

                for (let i = 1; i <= pdfDoc.numPages; i++) {
                    RenderPage(pdf_container, i);
                }
            });
        }

        function showModalOverdue(type) {
            $(`#modalOverdue${type}`).modal('show');
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

        function addMarker(feedback) {
            const marker = `
                <div data-bs-toggle="popover" id="marker-feedback-${feedback.id}"
                    title="${feedback.NamaKaryawan}" data-bs-content="${feedback.keterangan}"
                    data-bs-html="true" data-bs-custom-class="feedback-popover"
                    data-bs-trigger="focus" tabindex="0">
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

        function loadFeedback() {
            $('#loader-feedback').removeClass('d-none').addClass('d-flex');

            $.ajax({
                url: `/doco/riwayat-pengajuan/validasi/${ID}/feedbacks?id_versi=${ID_VERSI}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    $('#loader-feedback').addClass('d-none').removeClass('d-flex');

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
                                <div class="pb-3 rounded bg-dark text-white shadow mb-3">
                                    <div class="px-4 pt-3">
                                        <div class="d-flex justify-content-between mb-3">
                                            <a href="javascript:scrollToNote('${ item.id }');" class="text-white">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>

                                            <small>${item.created_at}</small>
                                        </div>

                                        <div class="d-flex align-items-center text-lg" style="line-height: 1.2;">
                                            <i class="fas fa-user me-3 fa-lg"></i>
                                            <span class="font-weight-bold">${item.NamaKaryawan}</span>
                                        </div>
                                    </div>

                                    <div style="max-height: 300px; overflow-y: auto; font-size: 0.9rem !important;" class="px-4 pt-2 mt-3">
                                        <p class="mb-0" style="line-height: 1.4; text-align: justify;">
                                            ${item.keterangan}
                                        </p>
                                    </div>
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

        function scrollToNote(id) {
            $('html, body').animate({
                scrollTop: $(`#marker-feedback-${id}`).offset().top
            });

            setTimeout( () => {
                $(`#marker-feedback-${id}`).trigger('focus');
            }, 1_200);
        }

        function secureConfidential() {
            // prevent right click
            document.addEventListener('contextmenu', (e) => e.preventDefault());

            // prevent inspect shortcut
            document.addEventListener('keydown', (e) => {
                if (
                    e.key === 'F12' ||
                    (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                    (e.ctrlKey && e.key === 'U')
                ) {
                    e.preventDefault();
                }
            });

            // prevent issue inspect element
            let start = Date.now();
            debugger;
            if (Date.now() - start > 100) {
                window.location.href = '/doco/riwayat-pengajuan';
            }

        }

        function showRevisiModal() {
            $('#modalRevisi').modal('show');
        }

        // secureConfidential();
        LoadPdfFromUrl('{{ $doco->file_converted_path }}');
    </script>
@endsection
