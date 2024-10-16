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
            <div class="card my-4">
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
                                    No. Dok : <span class="fw-bold ms-1">BSS-FRM-ICGS-034</span>
                                </p>
                                <p class="mb-0">
                                    Revisi : <span class="fw-bold ms-1">001</span>
                                </p>
                                <p class="mb-0">
                                    No. Form : <span class="fw-bold ms-1">{{ $formMaster->NoForm }}</span>
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
                                        <option value="{{ $formMaster->KodeDepartement }}" selected disabled>{{ $formMaster->KodeDepartement }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Site</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputSite" name="inputSite">
                                        <option value="{{ $formMaster->KodeST }}" selected disabled>{{ $formMaster->KodeST }}</option>
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
                                    <input type="date" class="input-text w-full" id="inputTanggal" name="tglPelaksanaan" class="tanggalPelaksanaan"
                                        value="{{ $formMaster->TglPelaksanaan }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Shift</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputShift" name="inputShift" required>
                                        <option value="{{ $formMaster->Shift }}" selected disabled>{{ $formMaster->Shift }}</option>
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
                                        <input class="form-check-input" type="checkbox" name="hariKeTujuh" value="true" {{ $formMaster->HariKeTujuh == 1 ? 'checked' : '' }} disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!empty($formMaster->Catatan))
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="ms-0 fs-6">Catatan</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check ps-0 align-items-end">
                                            <span class="text-danger">* {{ $formMaster->Catatan }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <p class="mt-4 mb-3">
                        Bersama ini kami sampaikan surat perintah lembur atas nama karyawan kami :
                    </p>

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
                                    <th colspan="5" class="text-center">
                                        Jam Lembur
                                    </th>
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
                                    <th>
                                        Absensi
                                    </th>
                                    <th>
                                        Konversi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($formMaster->karyawans as $key => $karyawan)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $karyawan->NIK }}
                                        </td>
                                        <td>
                                            {{ $karyawan->Panggilan }}
                                        </td>
                                        <td>
                                            {{ $karyawan->NamaJabatan }}
                                        </td>
                                        <td>
                                            {{ $karyawan->JamMulai }}
                                        </td>
                                        <td>
                                            {{ $karyawan->JamSelesai }}
                                        </td>
                                        <td>
                                            {{ $karyawan->TotalJam }}
                                        </td>
                                        <td>
                                            {{ $karyawan->JamAbsensi }}
                                        </td>
                                        <td>
                                            {{ $karyawan->TotalKonversi }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="mt-4 mb-3">
                        Adapun pekerjaan yang dibutuhkan :
                    </p>

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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($formMaster->pekerjaans as $key => $pekerjaan)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $pekerjaan->KategoriPekerjaan }}
                                        </td>
                                        <td>
                                            {{ $pekerjaan->Detail }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>

                    <small class="mb-0 mt-2">
                        <i>*Note : Jika ada pekerjaan diluar dari ketentuan di atas, silakan centang keterangan BA dibawah ini</i>
                    </small>

                    <div class="form-check mt-4 mb-2 ps-0">
                        <input class="form-check-input mt-0" type="checkbox" name="baPekerjaan" value="true" id="baPekerjaan"
                            {{ !empty($formMaster->baPekerjaan) ? 'checked' : '' }} disabled>
                        <label class="custom-control-label mb-0" for="customCheck1">BA Pekerjaan Diluar Standar</label>
                    </div>

                    @if(!empty($formMaster->baPekerjaan))
                        <div class="input-group input-group-static">
                            <label>Adapun pekerjaan yang dibutuhkan :</label>
                            <textarea name="baDetailPekerjaan" class="form-control" rows="3" readonly>{{ $formMaster->baPekerjaan->Pekerjaan }}</textarea>
                        </div>

                        <h2 class="fw-bold mt-4 mb-2 fs-5">Remark (Analisa SEFTO) :</h2>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Strategy</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoStrategy" name="seftoStrategy" placeholder="--- Sefto Strategy ---"
                                            value="{{ $formMaster->baPekerjaan->Strategy }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Economy</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoEconomy" name="seftoEconomy" placeholder="--- Sefto Economy ---"
                                            value="{{ $formMaster->baPekerjaan->Economy }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Financial</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoFinancial" name="seftoFinancial" placeholder="--- Sefto Financial ---"
                                            value="{{ $formMaster->baPekerjaan->Financial }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Technology</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoTechnology" name="seftoTechnology" placeholder="--- Sefto Technology ---"
                                            value="{{ $formMaster->baPekerjaan->Technology }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="ms-0 mb-0 fs-6">Operational</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control input-text" id="seftoOperational" name="seftoOperational" placeholder="--- Sefto Operational ---"
                                            value="{{ $formMaster->baPekerjaan->Operational }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-5 align-items-end">
                        @foreach($formMaster->approvers as $key => $approver)
                            <div class="col-md-6 col-lg-3 col-xl-2 text-center">
                                <p class="mb-2">{{ $approver->NamaAtasan }}</p>

                                @if($approver->Status == 'Approved')
                                    <img src="{{ url('img/approved-stamp.png') }}" class="mx-auto" style="height: 50px;" alt="Approved">

                                @elseif($approver->Status == 'Rejected')
                                    <p class="mb-0 text-danger fw-bold d-flex align-items-center justify-content-center">
                                        Ditolak
                                        <a href="javascript:detailRejectModal('{{ $approver->DetailStatus }}');" class="badge bg-primary badge-circle text-white ms-2"
                                            data-bs-toggle="tooltip" title="Lihat Catatan Review">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </p>

                                @elseif($approver->NIK == session('user_id') && $lastProgressApproval == ($key - 1))
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="button" class="btn btn-danger btn-xs text-center px-3 py-2 me-2"
                                            data-bs-toggle="tooltip" title="Reject Pengisian Form" onclick="rejectForm('{{ $formMaster->NoForm }}', '{{ $approver->NIK }}')">
                                            <i class="fas fa-times"></i>
                                        </button>

                                        <button type="button" class="btn btn-success btn-xs text-center px-3 py-2"
                                            data-bs-toggle="tooltip" title="Approve Pengisian Form" onclick="approveForm('{{ $formMaster->NoForm }}', '{{ $approver->NIK }}')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>

                                @else
                                    <p class="mb-0 fw-bold d-flex align-items-center justify-content-center">
                                        &nbsp;
                                    </p>
                                @endif

                                <small class="mt-2 d-block"><i>{{ $approver->Jabatan }}</i></small>
                                @if($approver->Diwakilkan == 1)
                                    <small class="mt-2 d-block"><i>(Diwakilkan)</i></small>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <small class="d-block mt-4">* Dokumen ini resmi dan diakui oleh perusahaan</small>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRejectLabel">Reject Pengajuan Lembur</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="modal-body" id="formReject">
                    <input type="hidden" name="NoForm">
                    <input type="hidden" name="NIKAtasan">

                    <div class="input-group input-group-static mb-3">
                        <label for="Status">Status</label>
                        <select class="form-control" id="Status" name="Status">
                            <option value="Rejected" selected>Rejected</option>
                        </select>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label for="reason">Alasan</label>
                        <textarea rows="4" class="form-control" id="reason" name="Reason"></textarea>
                    </div>

                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitReject">
                            <i class="fas fa-save"></i>
                            Submit Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-reason-reject" tabindex="-1" role="dialog" aria-labelledby="modalReasonReject" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReasonReject">Catatan Review Approval</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div class="input-group input-group-static mb-3">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status-reject" value="Rejected" readonly />
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label for="reason">Alasan</label>
                        <textarea rows="4" class="form-control" id="reason-reject" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function approveForm(NoForm, NikAtasan) {
            const formData = `NoForm=${NoForm}&NIKAtasan=${NikAtasan}&Status=Approved`;
            axios.post(`{{ route('bss-skl.store-approval') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Berhasil approve pengajuan lembur!',

                }).then((result) => {
                    window.location.reload();
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal melakukan approve pengajuan lembur'
                });
            });
        }

        function rejectForm(NoForm, NikAtasan) {
            $('#formReject').trigger('reset');
            $('#formReject [name=NoForm]').val(NoForm);
            $('#formReject [name=NIKAtasan]').val(NikAtasan);
            $('#modal-reject').modal('show');
        }

        function detailRejectModal(reasonReject) {
            $('#reason-reject').val(reasonReject);
            $('#modal-reason-reject').modal('show');
        }

        $('#btnSubmitReject').click( function(e) {
            e.preventDefault();

            const formData = $('#formReject').serialize();
            axios.post(`{{ route('bss-skl.store-approval') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Berhasil reject pengajuan lembur!',

                }).then((result) => {
                    window.location.reload();
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal melakukan reject pengajuan lembur'
                });
            });
        });
    </script>
@endsection
