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
                        <h6 class="text-white text-capitalize ps-3">Nomor Induk Dokumen</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterTanggal">Tanggal</label>
                                <input type="date" class="form-control" name="filterTanggal" id="filterTanggal" />
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
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Kadaluarsa">Kadaluarsa</option>
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

                        <div class="col-6 col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterKeyword">Cari No Dokumen / Pemohon</label>
                                <input type="text" class="form-control" name="filterKeyword" id="filterKeyword" placeholder="-- No Dokumen / Pemohon --" />
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
                                    <th data-field="NamaPembuat" data-align="center" data-halign="center" >
                                        Pembuat
                                    </th>
                                    <th data-field="kode_site" data-align="center" data-halign="center" >
                                        Site
                                    </th>
                                    <th data-field="tgl_terbit" data-align="left" data-halign="center">
                                        Tanggal
                                    </th>
                                    <th data-field="jenis_dokumen" data-align="left" data-halign="center">
                                        Jenis Dokumen
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
    <div class="modal fade" id="modalDetail" aria-hidden="true" aria-labelledby="modalDetailLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="modalDetailLabel">Detail Nomor Induk</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>

                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col">
                                        <hr class="horizontal dark my-sm-1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="noDokumen">No. Dokumen</label>
                                                    <input type="text" class="form-control" id="noDokumen" placeholder="No. Dokumen" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="site">Site</label>
                                                    <input type="text" class="form-control" id="site" placeholder="Site" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="jenisDokumen">Jenis Dokumen</label>
                                                    <input type="text" class="form-control" id="jenisDokumen" placeholder="Jenis Dokumen" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="pembuat">Pembuat</label>
                                                    <input type="text" class="form-control" id="pembuat" placeholder="Pembuat" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="judulDokumen">Judul Dokumen</label>
                                                    <input type="text" class="form-control" id="judulDokumen" placeholder="Judul Dokumen" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="status">Status</label>
                                                    <input type="text" class="form-control" id="status" placeholder="Status" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="revisi">No Revisi</label>
                                                    <input type="text" class="form-control" id="revisi" placeholder="No Revisi" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="keterangan-kadaluarsa">Keterangan Kadaluarsa</label>
                                                    <input type="text" class="form-control" id="keterangan-kadaluarsa" placeholder="Keterangan Kadaluarsa" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($isDownloadDoco)
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="#" class="btn bg-gradient-dark btn-action text-white mb-0" download id="btn-download-doc">
                                            <i class="fas fa-cloud-download-alt fa-lg me-1"></i> Download Dokumen
                                        </a>
                                    </div>
                                @endif

                                <div id="pdf_container"></div>
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

        var $table = $("#list-form");
        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
        var btnClearFilter = document.getElementById("btnClearFilter")
        var filterTanggal = document.getElementById("filterTanggal")
        var filterSite = document.getElementById("filterSite")
        var filterDepartement = document.getElementById("filterDepartement")
        var filterStatus = document.getElementById("filterStatus")
        var filterJenisDokumen = document.getElementById("filterJenisDokumen")
        var filterKeyword = document.getElementById("filterKeyword")

        var additonalQuery = {
            tanggal: null,
            site: null,
            departement: null,
            status: null,
            jenis_dokumen: null,
            keyword: null
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
            additonalQuery.keyword = null;

            filterDepartement.value = '';
            filterSite.value = '';
            filterStatus.value = '';
            filterTanggal.value = '';
            filterJenisDokumen.value = '';
            filterKeyword.value = '';

            $table.bootstrapTable('refresh')
        })
        btnFilterSubmit.addEventListener("click", function(e) {
            var searchQuery = {
                tanggal: filterTanggal.value == '' ? null : c.value,
                site: filterSite.value == '' ? null : filterSite.value,
                departement: filterDepartement.value == '' ? null : filterDepartement.value,
                status: filterStatus.value == '' ? null : filterStatus.value,
                jenis_dokumen: filterJenisDokumen.value == '' ? null : filterJenisDokumen.value,
                keyword: filterKeyword.value == '' ? null : filterKeyword.value,
            }
            additonalQuery = searchQuery;
            $table.bootstrapTable('refresh')
        })

        function actionFormatter(value, row, index) {
            const url = `{{ route('bss-skl.detail') }}`;
            // return '<a href="' + url + '?NoForm=' + row.NoForm + '"><button class="btn btn-primary btn-action text-white">detail</button></a>';
            return `<a href="javascript:detailNomorInduk('${ row.id }');"><button class="btn btn-primary btn-action text-white">detail</button></a>`;
        }

        function detailNomorInduk(id) {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: `{{ route('dokumen-mutu.nomor-induk-dokumen.detail') }}?id=${id}`,
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
                        $('#noDokumen').val(response.no_dokumen);
                        $('#site').val(response.NamaST);
                        $('#jenisDokumen').val(response.jenis_dokumen);
                        $('#pembuat').val(response.NamaKaryawan);
                        $('#judulDokumen').val(response.judul_dokumen);
                        $('#status').val(response.status);
                        // $('#iframepdf').attr('src', response.file_converted_path);
                        $('#btn-download-doc').attr('href', response.file_path);

                        if(response.no_revisi) {
                            $('#revisi').parent().removeClass('d-none');
                            $('#revisi').val(response.no_revisi);
                        } else {
                            $('#revisi').parent().addClass('d-none');
                        }

                        if(response.keterangan_kadaluarsa) {
                            $('#keterangan-kadaluarsa').parent().removeClass('d-none');
                            $('#keterangan-kadaluarsa').val(response.keterangan_kadaluarsa);
                        } else {
                            $('#keterangan-kadaluarsa').parent().addClass('d-none');
                        }

                        LoadPdfFromUrl(response.file_converted_path);
                        $('#modalDetail').modal("show");
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

        function statusFormatter(value, row, index) {
            var formatData = ''
            if(value == 'Aktif') {
                formatData = `<span class="text-success fw-bold">Aktif</span>`
            } else if(value == 'Kadaluarsa') {
                formatData = '<span class="text-danger fw-bold">Kadaluarsa</span>'
            }

            return formatData;
        }


        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = `{{ route('dokumen-mutu.nomor-induk-dokumen.fetch') }}`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                console.log('TEST', res)
                params.success(res)
            })
        }

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
