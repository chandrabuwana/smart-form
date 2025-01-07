@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <style>
        /* .form-control {
            border: 1px solid;
            padding: 4px;
        }
        .form-control:focus {
            border: 1px solid;
        } */
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

        .input-text {
            border: 1px solid #d2d6da !important;
            border-color: rgb(188, 188, 188);
            padding-left: 0.4rem !important;
            padding-right: 0.4rem !important;
        }

        #pdf_container {
            background: #ccc;
            text-align: center;
            display: none;
            padding: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Riwayat Pengajuan</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterTanggal">Tanggal</label>
                                <input type="date" class="form-control" name="filterTanggal" id="filterTanggal">
                                </input>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterSite">Site</label>
                                <select class="form-control form-select" name="filterSite" id="filterSite" required>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterDepartement">Departement</label>
                                <select class="form-control form-select" name="filterDepartement" id="filterDepartement">
                                    <option value="">-- Filter Departement --</option>
                                    @foreach($departements as $item)
                                        <option value="{{ $item->KodeDP }}">{{ $item->Nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterStatus">Status</label>
                                <select class="form-control form-select" name="filterStatus" id="filterStatus" required>
                                    <option value="" selected>-- Filter Status --</option>
                                    <option value="Belum Validasi">Belum Validasi</option>
                                    <option value="Sedang Validasi">Sedang Validasi</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterJenisDokumen">Jenis Dokumen</label>
                                <select class="form-control form-select" name="filterJenisDokumen" id="filterJenisDokumen" required>
                                    <option value="" selected>-- Filter Jenis Dokumen --</option>
                                    <option value="SOP">Standart Operating Procedur</option>
                                    <option value="STD">Standart</option>
                                    <option value="WI">Working Instruction</option>
                                    <option value="FRM">Form</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterJenisPengajuan">Jenis Pengajuan</label>
                                <select class="form-control form-select" name="filterJenisPengajuan" id="filterJenisPengajuan" required>
                                    <option value="" selected>-- Filter Jenis Pengajuan --</option>
                                    <option value="Pembuatan">Pembuatan</option>
                                    <option value="Revisi">Revisi</option>
                                    <option value="Penghapusan">Penghapusan</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <button class="btn btn-primary ms-auto filter-btn me-2" id="btnFilterSubmit">
                                    Filter
                                </button>
                                <button class="btn btn-primary ms-auto filter-btn" id="btnClearFilter">
                                    Clear Filter
                                </button>
                            </div>

                            {{-- <a class="btn btn-success ms-auto filter-btn" href="javascript:;" id="download-excel">
                                Download Excel
                            </a> --}}
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server" data-filter-control="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-show-export="false" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="no_dokumen" data-align="left" data-halign="text-center"
                                        data-sortable="true">
                                        No. Dokumen
                                    </th>
                                    <th data-field="NamaDepartement" data-align="center" data-halign="center" >
                                        Departement
                                    </th>
                                    <th data-field="kode_site" data-align="center" data-halign="center" >
                                        Site
                                    </th>
                                    <th data-field="tgl_pengajuan" data-align="left" data-halign="center">
                                        Tanggal
                                    </th>
                                    <th data-field="jenis_pengajuan" data-align="left" data-halign="center">
                                        Jenis Pengajuan
                                    </th>
                                    <th data-field="status" data-align="center"
                                        data-halign="center" data-sortable="true" data-formatter="statusFormatter">
                                        Status
                                    </th>
                                    <th data-field="action" data-formatter="actionFormatter">
                                        Actions
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
    <div class="modal fade" id="modalDetailPenghapusan" aria-hidden="true" aria-labelledby="modalDetailPenghapusanLabel"
        tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title" id="modalDetailPenghapusanLabel">Detail Penghapusan</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="row mb-2 align-items-center">
                        <div class="col-md-3">
                            <label class="ms-0 fs-6 font-weight-bold">
                                No Dokumen
                            </label>
                        </div>
                        <div class="col-md-1">
                            <span class="font-weight-bold">:</span>
                        </div>
                        <div class="col-md-8">
                            <span class="fs-6" id="no_dokumen"></span>
                        </div>
                    </div>

                    <div class="row mb-2 align-items-center">
                        <div class="col-md-3">
                            <label class="ms-0 fs-6 font-weight-bold">
                                Status
                            </label>
                        </div>
                        <div class="col-md-1">
                            <span class="font-weight-bold">:</span>
                        </div>
                        <div class="col-md-8" id="status">
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-md-3">
                            <label class="ms-0 fs-6 font-weight-bold">
                                Alasan Penghapusan
                            </label>
                        </div>
                        <div class="col-md-1">
                            <span class="font-weight-bold">:</span>
                        </div>
                        <div class="col-md-8">
                            <span id="alasan_pengajuan" class="fs-6"></span>
                        </div>
                    </div>

                    <div id="pdf_container"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalValidasiPenghapusan" aria-hidden="true" aria-labelledby="modalValidasiPenghapusanLabel"
        tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title" id="modalValidasiPenghapusanLabel">Validasi Penghapusan</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('dokumen-mutu.validasi.penghapusan') }}" method="post">
                        <input type="hidden" name="id_pengajuan_dokumen">
                        @csrf

                        <div class="row mb-3 align-items-start">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Status</label>
                            </div>
                            <div class="col-md-8 d-flex flex-column">
                                <div class="form-check ps-0">
                                    <input class="form-check-input" type="radio" name="statusValidasiPenghapusan" id="statusValidasiPenghapusanReject" value="0">
                                    <label class="custom-control-label" for="statusValidasiPenghapusanReject">Tidak Setuju</label>
                                </div>

                                <div class="form-check ps-0">
                                    <input class="form-check-input" type="radio" name="statusValidasiPenghapusan" id="statusValidasiPenghapusanAcc" value="1">
                                    <label class="custom-control-label" for="statusValidasiPenghapusanAcc">Setuju</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Keterangan</label>
                            </div>
                            <div class="col-md-8">
                                <textarea rows="3" class="form-control input-text" name="keterangan" id="keterangan" placeholder="--- Masukkan Keterangan ---" required></textarea>
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

    <script type="text/javascript">
        let pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';
        let pdfDoc = null;
        let scale = 1;
        let resolution = 1;

        $( function() {
            $('#modalValidasiPenghapusan button[type="submit"]').on('click', function(e) {
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
        })

        var $table = $("#list-form");
        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
        var btnClearFilter = document.getElementById("btnClearFilter")
        var filterTanggal = document.getElementById("filterTanggal")
        var filterSite = document.getElementById("filterSite")
        var filterDepartement = document.getElementById("filterDepartement")
        var filterStatus = document.getElementById("filterStatus")
        var filterJenisDokumen = document.getElementById("filterJenisDokumen")
        var filterJenisPengajuan = document.getElementById("filterJenisPengajuan")
        var additonalQuery = {
            tanggal: null,
            site: null,
            departement: null,
            status: null,
            jenis_dokumen: null,
            jenis_pengajuan: null,
        }

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

        btnClearFilter.addEventListener("click", function(e) {
            additonalQuery.departement = null;
            additonalQuery.site = null;
            additonalQuery.status = null;
            additonalQuery.tanggal = null;
            additonalQuery.jenis_dokumen = null;
            additonalQuery.jenis_pengajuan = null;

            filterDepartement.value = '';
            filterSite.value = '';
            filterStatus.value = '';
            filterTanggal.value = '';
            filterJenisDokumen.value = '';
            filterJenisPengajuan.value = '';

            $table.bootstrapTable('refresh')
        })
        btnFilterSubmit.addEventListener("click", function(e) {
            var searchQuery = {
                tanggal: filterTanggal.value == '' ? null : c.value,
                site: filterSite.value == '' ? null : filterSite.value,
                departement: filterDepartement.value == '' ? null : filterDepartement.value,
                status: filterStatus.value == '' ? null : filterStatus.value,
                jenis_dokumen: filterJenisDokumen.value == '' ? null : filterJenisDokumen.value,
                jenis_pengajuan: filterJenisPengajuan.value == '' ? null : filterJenisPengajuan.value,
            }
            additonalQuery = searchQuery;
            $table.bootstrapTable('refresh')
        })

        function actionFormatter(value, row, index) {
            let action;

            if(row.jenis_pengajuan == 'Penghapusan') {
                action = `<a href="javascript:detailPenghapusan('${ row.id }');"><button class="btn btn-primary btn-action text-white">detail</button></a>`;

                if(row.is_validate) {
                    action += `
                        <a href="javascript:showModalApprovePenghapusan('${ row.id }');"><button class="btn btn-success btn-action text-white ms-2">Validasi</button></a>
                    `;
                }

            } else {
                const url = `/doco/riwayat-pengajuan/detail/${row.id}`;
                // return '<a href="' + url + '?NoForm=' + row.NoForm + '"><button class="btn btn-primary btn-action text-white">detail</button></a>';
                action = `<a href="${url}"><button class="btn btn-primary btn-action text-white">detail</button></a>`;

                if(row.is_validate) {
                    const urlValidasi = `/doco/riwayat-pengajuan/validasi/${row.id}`;
                    action += `
                        <a href="${urlValidasi}"><button class="btn btn-success btn-action text-white ms-2">Validasi</button></a>
                    `;
                }
            }

            return action;
        }

        function statusFormatter(value, row, index) {
            var formatData = ''
            if(value == 'Belum Validasi') {
                formatData = `<span class="text-dark fw-bold">Belum Validasi</span>`
            } else if(value == 'Sedang Validasi') {
                formatData = '<span class="text-warning fw-bold">Sedang Validasi</span>'
            } else if(value == 'Terdapat Feedback') {
                formatData = '<span class="text-warning fw-bold">Terdapat Feedback</span>'
            } else if(value == 'Disetujui') {
                formatData = '<span class="text-success fw-bold">Disetujui</span>'
            } else if(value == 'Dibatalkan Oleh Sistem') {
                formatData = '<span class="text-danger fw-bold">Dibatalkan Oleh Sistem</span>'
            } else if(value == 'Ditolak') {
                formatData = '<span class="text-danger fw-bold">Ditolak</span>'
            }

            return formatData;
        }

        function detailPenghapusan(id) {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: `{{ route('dokumen-mutu.fetch-detail-riwayat') }}?id=${id}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    Swal.close();

                    if( Object.keys(response).length == 0 ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `Terjadi kesalahan, data tidak ditemukan`,
                        });

                    } else {
                        $('#modalDetailPenghapusan #no_dokumen').html(response.no_dokumen);
                        $('#modalDetailPenghapusan #alasan_pengajuan').html(response.alasan_pengajuan);

                        let classStatus = '';

                        switch(response.status) {
                            case 'Disetujui':
                                classStatus = 'success';
                                break;

                            case 'Sedang Validasi':
                                classStatus = 'warning';
                                break;

                            case 'Ditolak':
                            case 'Dibatalkan Oleh Sistem':
                                classStatus = 'danger';
                                break;

                            default:
                                classStatus = 'dark';
                        }

                        LoadPdfFromUrl(response.file_converted_path);
                        $('#modalDetailPenghapusan #status').html(`<span class="text-${classStatus} font-weight-bold fs-6">${response.status}</span>`);
                        $('#modalDetailPenghapusan').modal("show");
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
                }
            });
        }

        function showModalApprovePenghapusan(id) {
            $('#modalValidasiPenghapusan [name=id_pengajuan_dokumen]').val(id);
            $('#modalValidasiPenghapusan').modal('show');
        }

        $('#modalValidasiPenghapusan').on('hide.bs.modal', function() {
            $('#modalValidasiPenghapusan [name=statusValidasiPenghapusan]:checked').prop('checked', false);
            $('#modalValidasiPenghapusan [name=keterangan]').val('');
        });

        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = `{{ route('dokumen-mutu.riwayat-pengajuan.fetch') }}`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
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

            document.addEventListener("keyup", function (e) {
                var keyCode = e.keyCode ? e.keyCode : e.which ;
                if (keyCode == 44) {
                    alert('DETECTED!');
                    return false;
                }
            });
        }

        // secureConfidential();

        $('#filterSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterSite').parent(),
            placeholder: '--- Cari Site ---',
            ajax: {
                url: "/helper/site",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        query: params.term, // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response.data
                    };
                },
                cache: true
            }
        });

    </script>
@endsection
