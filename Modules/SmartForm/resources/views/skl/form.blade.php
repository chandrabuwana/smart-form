@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link href="{{ asset('master/css/app-baf8d111.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="{{ asset('master/js/app-e576488e.js') }}"></script> --}}
    {{-- @vite('resources/css/app.css') --}}
    <style>
        /* .form-control {
            border: 1px solid;
            padding: 4px;
        } */
        /* .form-control:focus {
            border: 1px solid;
        } */
        .ml-16px {
            margin-left: 16px;
        }
        .mb-8px {
            margin-bottom: 8px;
        }
        .display-block {
            display: block;
        }
        .m-0 {
            margin: 0;
        }
        .text-right {
            text-align: right;
        }
        .input-text {

            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
        }
        .input-text:focus {
            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
        }
        .reset-border {
            border: 0;
        }
        .w-full {
            width: 100%
        }
        .collapse {
            visibility: visible;
        }
        .mouse-click {
            cursor: pointer;
        }
    </style>

@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <form class="card my-4" method="POST" action="{{ route('bss-skl.store') }}" id="form-skl">
                @csrf

                <input type="hidden" name="noDok" value="BSS-FRM-ICGS-034">
                <input type="hidden" name="revisi" value="001">
                <input type="hidden" name="catatan" value="">

                <div class="d-none" id="form-karyawan">
                </div>

                <div class="d-none" id="form-pekerjaan">
                </div>

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Form Surat Kesepakatan Lembur
                        </h6>
                    </div>
                </div>

                <div class="card-body my-1">
                    <div class="row gx-4 mb-4">
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <p class="mb-1">
                                    No. Dok : <span id="requestor" class="fw-bold ms-1">BSS-FRM-ICGS-034</span>
                                </p>
                                <p class="mb-0">
                                    Revisi : <span id="requestor" class="fw-bold ms-1">001</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Departement</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputDepartement" name="inputDepartement">
                                        <option value="">-- Pilih Departement --</option>
                                        @foreach($departements as $item)
                                            <option value="{{ $item->KodeDP }}">{{ $item->NamaDepartement }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Site</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputSite" name="inputSite">
                                        <option value="">-- Pilih Site --</option>
                                        <option value="AGM">AGM</option>
                                        <option value="TAJ">TAJ</option>
                                        <option value="MBL">MBL MINING</option>
                                        <option value="MBL-HAULING">MBL HAULING</option>
                                        <option value="BSSR">BSSR</option>
                                        <option value="MSJ">MSJ</option>
                                        <option value="TDM">TDM</option>
                                        <option value="MAS">MAS</option>
                                        <option value="PMSS">PMSS</option>
                                        <option value="BRAM">BRAM</option>
                                        <option value="MME">MME</option>
                                        <option value="CDI">CDI</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Tanggal Pelaksanaan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" class="input-text w-full" id="inputTanggal" name="tglPelaksanaan" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Shift</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputShift" name="inputShift" required>
                                        <option value="">-- Pilih Shift --</option>
                                        <option value="DS">DS</option>
                                        <option value="NS">NS</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Lembur Hari ke-7</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-check ps-0 align-items-end">
                                        <input class="form-check-input" type="checkbox" name="hariKeTujuh" value="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-end mt-4 mb-3">
                        <p class="mb-0">
                            Bersama ini kami sampaikan surat perintah lembur atas nama karyawan kami :
                        </p>

                        <button class="btn btn-primary btn-xs uploadBtn mb-0"
                            type="button" onclick="showModalTambahKaryawan()">
                            <i class="fas fa-plus"></i>
                            Tambah
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="table-karyawan" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" rowspan="2" class="align-middle">
                                        No
                                    </th>
                                    <th rowspan="2" class="align-middle">
                                        NIK
                                    </th>
                                    <th rowspan="2" class="align-middle">
                                        Nama Karyawan
                                    </th>
                                    <th rowspan="2" class="align-middle">
                                        Jabatan
                                    </th>
                                    <th colspan="3" class="text-center">
                                        Jam Lembur
                                    </th>
                                    <th rowspan="2" width="5%"></th>
                                </tr>
                                <tr>
                                    <th>
                                        Dari
                                    </th>
                                    <th>
                                        Sampai
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-end mt-4 mb-3">
                        <p class="mb-0">
                            Adapun pekerjaan yang dibutuhkan :
                        </p>

                        <button class="btn btn-primary btn-xs uploadBtn mb-0"
                            type="button" onclick="showModalTambahPekerjaan()">
                            <i class="fas fa-plus"></i>
                            Tambah
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="table-pekerjaan" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        No
                                    </th>
                                    <th>
                                        Kategori Pekerjaan
                                    </th>
                                    <th>
                                        Detail Pekerjaan
                                    </th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <small class="mb-0 mt-2">
                        <i>*Note : Jika ada pekerjaan diluar dari ketentuan di atas, silakan centang keterangan BA dibawah ini</i>
                    </small>

                    <div class="form-check mt-4 mb-2 ps-0">
                        <input class="form-check-input" type="checkbox" name="baPekerjaan" value="true" id="baPekerjaan">
                        <label class="custom-control-label" for="customCheck1">BA Pekerjaan Diluar Standar</label>
                    </div>

                    <div id="form-ba-pekerjaan" class="d-none">
                        <div class="input-group input-group-static">
                            <label>Adapun pekerjaan yang dibutuhkan :</label>
                            <textarea name="baDetailPekerjaan" class="form-control" rows="3"></textarea>
                        </div>

                        <h2 class="fw-bold mt-4 mb-2 fs-5">Remark (Analisa SEFTO) :</h2>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Strategy</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoStrategy" name="seftoStrategy" placeholder="--- Sefto Strategy ---">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Economy</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoEconomy" name="seftoEconomy" placeholder="--- Sefto Economy ---">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Financial</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoFinancial" name="seftoFinancial" placeholder="--- Sefto Financial ---">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Technology</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoTechnology" name="seftoTechnology" placeholder="--- Sefto Technology ---">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Operational</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoOperational" name="seftoOperational" placeholder="--- Sefto Operational ---">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 mb-2">
                        Diketahui dan Disetujui Oleh :
                    </p>

                    <div class="table-responsive">
                        <table id="table-approver" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">
                                    </th>
                                    <th>
                                        Jabatan
                                    </th>
                                    <th>
                                        Atasan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Dibuat Oleh
                                    </td>
                                    <td>
                                        Atasan Langsung
                                    </td>
                                    <td>
                                        {{ session('username') }}
                                    </td>
                                </tr>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitForm">
                            <i class="fas fa-save"></i>
                            Submit Form
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Tambah Karyawan --}}
    <div class="modal fade" id="modalTambahKaryawan" role="dialog" aria-labelledby="modalTambahKaryawanLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header px-4">
                    <h5 class="modal-title" id="modalTambahKaryawanLabel">Form Tambah Karyawan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-tambah-karyawan">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Karyawan</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select input-text w-full" aria-label="Pilih Karyawan" id="inputKaryawan" name="inputKaryawan" required>
                                    <option value="">-- Pilih Karyawan --</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Jam Mulai</label>
                            </div>
                            <div class="col-md-8">
                                <input type="time" class="input-text w-full" name="jamMulai" id="inputJamMulai" placeholder="HH.MM" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Jam Selesai</label>
                            </div>
                            <div class="col-md-8">
                                <input type="time" class="input-text w-full" name="jamSelesai" id="inputJamSelesai" placeholder="HH.MM" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Total Jam</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="input-text w-full" name="totalJam" id="totalJam" readonly>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary btn-xs uploadBtn mb-0" type="submit" id="btnTambahKaryawan">
                                <i class="fas fa-save"></i>
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Pekerjaan --}}
    <div class="modal fade" id="modalTambahPekerjaan" role="dialog" aria-labelledby="modalTambahPekerjaanLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header px-4">
                    <h5 class="modal-title" id="modalTambahPekerjaanLabel">Form Tambah Pekerjaan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-tambah-pekerjaan">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Kategori</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select input-text w-full" aria-label="Pilih Kategori" id="inputPekerjaan" name="inputPekerjaan" required>
                                    <option value="">-- Pilih Kategori --</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Detail</label>
                            </div>
                            <div class="col-md-8">
                                <textarea rows="4" class="input-text w-full" name="detailPekerjaan" required></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary btn-xs uploadBtn mb-0" type="submit" id="btnTambahPekerjaan">
                                <i class="fas fa-save"></i>
                                Tambah
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @if(session('err'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                html: `{{ session('err') }}`,
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <script>
        const karyawans = [];
        const pekerjaans = [];
        let optionKaryawan = [];
        let optionKategoriPekerjaan = [];
        let optionApprover = [];

        $( function() {
            $departement = $('#inputDepartement');
            $site = $('#inputSite');
            $shift = $('#inputShift');
            $inputKaryawan = $('#inputKaryawan');
            $inputJamMulai = $('#inputJamMulai');
            $inputJamSelesai = $('#inputJamSelesai');
            $inputPekerjaan = $('#inputPekerjaan');

            function fetchOptionKaryawan() {
                if( !$departement.val() || !$site.val() ) return;

                if( $('#inputKaryawan').data('select2') ) {
                    $('#inputKaryawan').select2('destroy');
                }

                const query = $.param({
                    KodeDP: $departement.val(),
                    KodeST: $site.val()
                });

                $.ajax({
                    url: `{{ route('bss-skl.get-karyawan') }}?${query}`,
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'thrownError',
                            html: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    },
                    success: function(response) {
                        optionKaryawan = response;
                        let options = `<option value="">-- Pilih Karyawan --</option>`;

                        response.forEach( (item) => {
                            options += `<option value="${item.id}">${item.text}</option>`;
                        });

                        $('#inputKaryawan').html(options);
                        $('#inputKaryawan').select2({
                            width: '100%',
                            dropdownParent: $('#modalTambahKaryawan'),
                            matcher: function(params, data) {
                                const keyword = (params.term ?? '').toLowerCase()
                                const name = data.text.toLowerCase()

                                if( name.indexOf(keyword) > -1 || data.id.indexOf(keyword) > -1 ) {
                                    return data;
                                }

                                // console.log('PARAMS', params);
                                // console.log('TEST', data);
                                return false;
                                // return false;
                            }
                        });
                    }
                });
            }

            function fetchOptionKategoriPekerjaan() {
                if( !$departement.val() ) return;

                if( $('#inputPekerjaan').data('select2') ) {
                    $('#inputPekerjaan').select2('destroy');
                }

                const query = $.param({
                    KodeDP: $departement.val(),
                });

                $.ajax({
                    url: `{{ route('bss-skl.get-kategori-pekerjaan') }}?${query}`,
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'thrownError',
                            html: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    },
                    success: function(response) {
                        optionKategoriPekerjaan = response;
                        let options = `<option value="">-- Pilih Kategori --</option>`;

                        response.forEach( (item) => {
                            options += `<option value="${item.id}">${item.text}</option>`;
                        });

                        $('#inputPekerjaan').html(options);
                        $('#inputPekerjaan').select2({
                            width: '100%',
                            dropdownParent: $('#modalTambahPekerjaan')
                        });
                    }
                });
            }

            function fetchOptionApprover() {
                if( !$departement.val() || !$site.val() ) return;

                const query = $.param({
                    KodeDP: $departement.val(),
                    KodeST: $site.val()
                });

                $.ajax({
                    url: `{{ route('bss-skl.get-approver') }}?${query}`,
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    dataType: 'json',
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'thrownError',
                            html: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    },
                    success: function(response) {
                        let tbody = '<tr>' + $('#table-approver tbody tr:nth-child(1)').html() + '</tr>';
                        optionApprover = response;

                        response.forEach( (item, key) => {
                            let optionAtasan = '';

                            item.option_atasan.forEach( (option) => {
                                optionAtasan += `<option value="${option.Nik}">${option.Nama}</option>`;
                            });

                            tbody += `
                                <tr>
                                    <td>
                                        <input type="hidden" name="subjectAtasan[]" value="${item.subject}">
                                        ${item.subject}
                                    </td>
                                    <td>
                                        <input type="hidden" name="jabatanAtasan[]" value="${item.jabatan}">
                                        <div class="d-flex align-items-center">
                                            <span class="jabatanAtasan">${item.jabatan}</span>
                                            <div class="form-check ps-0 align-items-end ms-3">
                                                <input class="form-check-input" type="checkbox" name="check_represent[${ key }]" value="true" onchange="toggleBackupAtasan('${item.jabatan}')">
                                                <label class="custom-control-label mb-0">diwakilkan</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-select input-text" aria-label="Pilih Atasan" id="inputAtasan" name="inputAtasan[]" required>
                                            <option value="">-- Pilih Atasan --</option>
                                            ${optionAtasan}
                                        </select>
                                    </td>
                                </tr>
                            `;
                        });

                        $('#table-approver tbody').html(`${tbody}<tr></tr>`);
                    }
                });
            }

            $departement.change( () => {
                fetchOptionKaryawan();
                fetchOptionKategoriPekerjaan();
                fetchOptionApprover();
            });

            $site.change( () => {
                fetchOptionKaryawan();
                fetchOptionApprover();
            });

            $('#baPekerjaan').change( function() {
                const checked = $('#baPekerjaan:checked').length > 0;
                if(checked) {
                    $('[name=baDetailPekerjaan]').attr('required', true);
                    $('#form-ba-pekerjaan').removeClass('d-none');
                } else {
                    $('#form-ba-pekerjaan').addClass('d-none');
                    $('[name=baDetailPekerjaan]').removeAttr('required');
                }
            });

            $('#modalTambahKaryawan').on('hidden.bs.modal', function() {
                $inputKaryawan.val(null).trigger('change');
                $('#form-tambah-karyawan')[0].reset();
            });

            $('#modalTambahPekerjaan').on('hidden.bs.modal', function() {
                $inputPekerjaan.val(null).trigger('change');
                $('#form-tambah-pekerjaan')[0].reset();
            });

            function onJamChange() {
                if( !$inputJamMulai.val() || !$inputJamSelesai.val() ) {
                    return;
                }

                const splitJamMulai = $inputJamMulai.val().split(':');
                const jamMulaiInMinute = (Number(splitJamMulai[0]) * 60) + Number(splitJamMulai[1]);

                const splitJamSelesai = $inputJamSelesai.val().split(':');
                const jamSelesaiInMinute = (Number(splitJamSelesai[0]) * 60) + Number(splitJamSelesai[1]);
                const totalJam = (jamSelesaiInMinute - jamMulaiInMinute) / 60;

                if(jamSelesaiInMinute < jamMulaiInMinute) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: 'Jam selesai tidak boleh sebelum jam mulai',
                        confirmButtonText: 'OK'
                    });

                    $inputJamSelesai.val('');
                    return;

                } else if(totalJam > 3) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: 'Total jam lembur tidak boleh lebih dari 3 jam',
                        confirmButtonText: 'OK'
                    });

                    $inputJamSelesai.val('');
                    return;
                }

                const totalInMinute = (jamSelesaiInMinute - jamMulaiInMinute) / 60;
                const totalHour = Math.round(totalInMinute * 10) / 10;
                const splitTotalHour = totalHour.toString().split('.');

                $('#totalJam').val(`${splitTotalHour[0]} jam${ splitTotalHour[1] ? `, ${splitTotalHour[1] * 6} menit` : '' }`);
            }

            $('#inputJamMulai').change(onJamChange);
            $('#inputJamSelesai').change(onJamChange);

            $('#form-tambah-karyawan').submit( function(e) {
                e.preventDefault();
                const formData = $('#form-tambah-karyawan').serializeArray();

                const payload = {};
                formData.forEach( (item) => payload[ item.name ] = item.value);

                const selectedOption = optionKaryawan.filter( (item) => item.id == payload.inputKaryawan);
                if(selectedOption.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: 'Terjadi kesalahan, karyawan yang di pilih tidak ditemukan',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                payload.nama = selectedOption[0].text;
                payload.jabatan = selectedOption[0].jabatan;

                karyawans.push(payload);
                mountTableKaryawan();
                checkCatatanPengajuan();
                $('#modalTambahKaryawan').modal('hide');
            });

            $('#form-tambah-pekerjaan').submit( function(e) {
                e.preventDefault();
                const formData = $('#form-tambah-pekerjaan').serializeArray();

                const payload = {};
                formData.forEach( (item) => payload[ item.name ] = item.value);

                const selectedOption = optionKategoriPekerjaan.filter( (item) => item.id == payload.inputPekerjaan);
                if(selectedOption.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: 'Terjadi kesalahan, pekerjaan yang di pilih tidak ditemukan',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                payload.kategori = selectedOption[0].text;
                pekerjaans.push(payload);
                mountTablePekerjaan();
                $('#modalTambahPekerjaan').modal('hide');
            });

            $('#form-skl').submit( function(e) {
                if(karyawans.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: 'Harap input karyawan terlebih dahulu',
                        confirmButtonText: 'OK'
                    });
                    e.preventDefault();
                    return;
                }

                const isBaPekerjaan = $('#baPekerjaan:checked').length > 0;
                if(!isBaPekerjaan && pekerjaans.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: 'Harap input detail pekerjaan terlebih dahulu',
                        confirmButtonText: 'OK'
                    });
                    e.preventDefault();
                    return;
                }
            });
        });

        function toggleBackupAtasan(jabatan) {
            optionApprover.forEach( (item, key) => {
                if(item.jabatan == jabatan) {
                    const $tr = $(`#table-approver tbody tr:nth-child(${key + 2})`);
                    const represented = $tr.find('[name*=check_represent]').is(':checked');
                    const optionFiltered = represented ? item.option_backup : item.option_atasan;

                    let optionAtasan = '<option value="">-- Pilih Atasan --</option>';
                    optionFiltered.forEach( (option) => {
                        optionAtasan += `<option value="${option.Nik}">${option.Nama}</option>`;
                    });

                    $tr.find('[name*=inputAtasan]').html(optionAtasan);

                    /*jabatan = jabatan == 'Kabag. Departemen' && represented ? 'Kasi. Departemen' : jabatan;
                    $tr.find('td:nth-child(2) .jabatanAtasan').html(jabatan);
                    $tr.find('td:nth-child(2) [name*=jabatanAtasan]').val(jabatan);*/
                }
            });
        }

        function showModalTambahKaryawan() {
            if( !$('#inputDepartement').val() || !$('#inputSite').val() ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    html: 'Harap pilih departement dan site terlebih dahulu',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $('#modalTambahKaryawan').modal('show');
        }

        function showModalTambahPekerjaan() {
            if( !$('#inputDepartement').val() ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    html: 'Harap pilih departement terlebih dahulu',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $('#modalTambahPekerjaan').modal('show');
        }

        function deleteKaryawan(index) {
            karyawans.splice(index, 1);
            mountTableKaryawan();
            checkCatatanPengajuan();
        }

        function checkCatatanPengajuan() {
            $('[name=catatan]').val('');

            karyawans.forEach( (item, index) => {
                const d = (new Date());
                const splitJamMulai = item.jamMulai.split(':');
                const deviasiPengajuan = d - (new Date(d.getFullYear(), d.getMonth(), d.getDate(), splitJamMulai[0], splitJamMulai[1]));
                const deviasiInHour = (deviasiPengajuan / 1000) / 3600;
                console.log('TESTT RANN', deviasiInHour);

                if(deviasiInHour < 3) {
                    $('[name=catatan]').val('Pengajuan lembur ini diajukan tidak sesuai dengan prosedur');
                }
            });
        }

        function mountTableKaryawan() {
            let inputHiddenKaryawan = '';

            let tbody = '';
            karyawans.forEach( (item, index) => {
                inputHiddenKaryawan += `<input type="hidden" name="nikKaryawan[]" value="${item.inputKaryawan}">`;
                inputHiddenKaryawan += `<input type="hidden" name="jamMulai[]" value="${item.jamMulai}">`;
                inputHiddenKaryawan += `<input type="hidden" name="jamSelesai[]" value="${item.jamSelesai}">`;
                inputHiddenKaryawan += `<input type="hidden" name="totalJam[]" value="${item.totalJam}">`;

                tbody += `
                    <tr>
                        <td>
                            ${ index + 1 }
                        </td>
                        <td>
                            ${ item.inputKaryawan }
                        </td>
                        <td>
                            ${ item.nama }
                        </td>
                        <td>
                            ${ item.jabatan }
                        </td>
                        <td>
                            ${ item.jamMulai }
                        </td>
                        <td>
                            ${ item.jamSelesai }
                        </td>
                        <td>
                            ${ item.totalJam }
                        </td>
                        <td>
                            <button class="btn btn-danger btn-xs uploadBtn mb-0 px-3 py-2" type="button" onclick="deleteKaryawan('${index}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            $('#form-karyawan').html(inputHiddenKaryawan);

            tbody += '<tr></tr>';
            $('#table-karyawan tbody').html(tbody);
        }

        function deletePekerjaan(index) {
            pekerjaans.splice(index, 1);
            mountTablePekerjaan();
        }

        function mountTablePekerjaan() {
            let inputHiddenPekerjaan = '';
            let tbody = '';

            pekerjaans.forEach( (item, index) => {
                inputHiddenPekerjaan += `<input type="hidden" name="kategoriPekerjaan[]" value="${item.inputPekerjaan}">`;
                inputHiddenPekerjaan += `<input type="hidden" name="detailPekerjaan[]" value="${item.detailPekerjaan}">`;

                tbody += `
                    <tr>
                        <td>
                            ${ index + 1 }
                        </td>
                        <td>
                            ${ item.kategori }
                        </td>
                        <td>
                            ${ item.detailPekerjaan }
                        </td>
                        <td>
                            <button class="btn btn-danger btn-xs uploadBtn mb-0 px-3 py-2" type="button" onclick="deletePekerjaan('${index}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            $('#form-pekerjaan').html(inputHiddenPekerjaan);

            tbody += '<tr></tr>';
            $('#table-pekerjaan tbody').html(tbody);
        }
    </script>
@endsection
