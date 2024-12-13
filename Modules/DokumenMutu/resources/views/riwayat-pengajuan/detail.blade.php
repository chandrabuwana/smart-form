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

        .feedback-parent {
            height: 800px;
            overflow-y: auto;
        }

        #pdf_container {
            background: #ccc;
            text-align: center;
            display: none;
            padding: 5px;
            height: 820px;
            overflow: auto;
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
                        <div class="bg-success rounded px-5 py-3 text-white" style="width: fit-content;">
                            <i class="fas fa-check-circle fa-xl me-1"></i>
                            <h5 class="text-white mb-0 d-inline">Pembuatan</h5>
                        </div>

                        <div class="{{ $validateIndex >= 1 ? 'bg-success' : 'bg-warning' }}  rounded px-5 py-3 text-white" style="width: fit-content;">
                            <i class="fas {{ $validateIndex >= 1 ? 'fa-check-circle' : 'fa-spinner' }} fa-xl me-1"></i>
                            <h5 class="text-white mb-0 d-inline">Pemeriksaan</h5>
                        </div>

                        <div class="{{ $validateIndex >= 2 ? 'bg-success' : 'bg-warning' }}  rounded px-5 py-3 text-white" style="width: fit-content;">
                            <i class="fas {{ $validateIndex >= 2 ? 'fa-check-circle' : 'fa-spinner' }} fa-xl me-1"></i>
                            <h5 class="text-white mb-0 d-inline">Validasi</h5>
                        </div>
                    </div>

                    <h5 class="mb-3">
                        No Versi :
                        <span class="badge bg-gradient-dark ms-1">{{ $lastVersion->no_versi }}</span>
                    </h5>

                    <div class="row">
                        <div class="col-md-8">
                            <div id="pdf_container"></div>
                        </div>

                        <div class="col-md-4">
                            @if($feedbacks->count() == 0)
                                <div class="d-flex flex-column justify-content-center align-items-center pt-5">
                                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3em;"></i>
                                    <p class="mb-0 mt-3">Belum Ada Feedback</p>
                                </div>

                            @else
                                <div class="feedback-parent">
                                    @foreach($feedbacks as $feedback)
                                        <div class="px-4 pt-2 pb-3 rounded bg-dark text-white shadow">
                                            <div class="text-end mb-2">
                                                <small>{{ date('Y/m/d H:i', strtotime($feedback->created_at)) }}</small>
                                            </div>

                                            <div class="d-flex align-items-center text-lg" style="line-height: 1.2;">
                                                <i class="fas fa-user me-3 fa-lg"></i>
                                                <span class="font-weight-bold">{{ $feedback->NamaKaryawan }}</span>
                                            </div>

                                            <p class="mb-0 mt-3" style="line-height: 1.4; text-align: justify;">
                                                {!! nl2br($feedback->keterangan) !!}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>

    <script>
        let pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';
        let pdfDoc = null;
        let scale = 1;
        let resolution = 1;

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

        secureConfidential();
        LoadPdfFromUrl('{{ $doco->file_path }}');
    </script>
@endsection
