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
            <form class="card my-4" method="POST" id="inspectionForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="inspeksi_id" value="{{ $data->id }}">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Form Inspeksi Toilet Mess Kantor</h6>
                        </div>
                    </div>

                    <div class="card-body my-1">
                        <div class="row gx-4">
                            <div class="col-auto my-auto ms-3">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="w-full">
                                    <td>
                                        <input type="text" class="input-text w-full" id="iKupon" name="iKupon" hidden>
                                    </td>
                                    <tr>
                                        <!-- <td>Date</td> -->
                                        <td><input type="text" class="input-text w-full" id="tglDoc" name="tglDoc" hidden></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Site</td>
                                        <td><input type="text" class="input-text w-full" id="nama_site" value="{{ $data->nama_site }}" name="nama_site" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Departemen</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dept" name="dept" disabled>
                                            <option value="" selected>-- Pilih Departemen --</option>
                                            <option value="SHE" {{ $data->dept == 'SHE' ? 'selected' : '' }}>SHE</option>
                                            <option value="GS" {{ $data->dept == 'GS' ? 'selected' : '' }}>GS</option>
                                        </select>
                                    </td>
                                    <tr>
                                        <td>Shift</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" value="{{ $data->shift }}" aria-label="Default select example" disabled id="shift" name="shift">
                                                <option value="" selected>-- Pilih Shift --</option>
                                                <option value="I" {{ $data->shift == 'I' ? 'selected' : '' }}>I</option>
                                                <option value="II" {{ $data->shift == 'II' ? 'selected' : '' }}>II</option>
                                                <option value="III" {{ $data->shift == 'III' ? 'selected' : '' }}>III</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- <td>NIK</td> -->
                                        <td hidden><input type="text" class="input-text w-full" id="i_nik" value="{{ session('user_id') }}" disabled></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 mb-4">
                                <table class="w-full">
                                    <tr>
                                        <td>Lokasi Kerja</td>
                                        <td><input type="text" class="input-text w-full" value="{{ $data->loker }}" id="loker" name="loker" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Inspektor</td>
                                        <td><input type="number" disabled onkeypress="return event.charCode >= 48" value="{{ $data->jml_ins }}" min="1" class="input-text w-half" id="jml_ins" name="jml_ins"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @foreach($questions as $category => $items)
                            <div class="mb-1" style="padding:1rem">
                                <label class="form-label">INSPEKSI {{ strtoupper($category) }} CHECKLIST</label>
                                <div style="background-color:orange;">
                                    <label class="form-label" style="color:white">HAL UNTUK DIPERIKSA - {{ strtoupper($category) }} (YA/TIDAK)</label>
                                </div>
                                <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                        <table class="w-full">
                                            @foreach($items as $index => $question)
                                                <tr>
                                                    <td style="width:2%">{{ $loop->iteration }}.</td>
                                                    <td style="width:50%; white-space: pre-line;">{{ $question->pertanyaan }}</td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input disabled class="form-check-input" type="radio" id="q{{ $question->ID }}_Ya" name="q{{ $question->ID }}" value="Ya"
                                                                {{ $question->jawaban == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="q{{ $question->ID }}_Ya">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input disabled class="form-check-input" type="radio" id="q{{ $question->ID }}_Tidak" name="q{{ $question->ID }}" value="Tidak"
                                                                {{ $question->jawaban == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="q{{ $question->ID }}_Tidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input disabled type="text" class="form-control" id="q{{ $question->ID }}_resiko" name="q{{ $question->ID }}_resiko"
                                                            value="{{ $question->resiko ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input disabled type="text" class="form-control" id="q{{ $question->ID }}_keterangan" name="q{{ $question->ID }}_keterangan"
                                                            value="{{ $question->keterangan ?? '' }}">
                                                    </td>
                                                    <input type="hidden" id="q{{ $question->ID }}_category" name="q{{ $question->ID }}_category" value="{{ $question->category }}">
                                                    <input type="hidden" id="q{{ $question->ID }}_pertanyaan" name="q{{ $question->ID }}_pertanyaan" value="{{ $question->ID }}">
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="row">
                            <div class="col-12">
                                <div class="form-actions">
                                    @if ($nik == $data->checked_by || $nik == $data->validated_by)
                                        <button class="btn btn-primary btn-sm" id="btn900Approve"
                                            data-doc="{{ $data->doc_num }}"
                                            data-status='@json($data->status)'
                                            data-nik="{{ $nik }}">
                                            <i class="fas fa-check"></i> Approve
                                        </button>

                                        <button class="btn btn-warning btn-sm" id="btn900Reject"
                                            data-doc="{{ $data->doc_num }}"
                                            data-status='@json($data->status)'
                                            data-nik="{{ $nik }}">
                                            <i class="fas fa-close"></i> Reject
                                        </button>
                                    @endif

                                    @if (collect($data->status)->contains(fn($s) => $s === 'rejected'))
                                        @if ($nik == $data->creator)
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="resetApproval('{{ $data->doc_num }}')">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                        @endif
                                    @endif

                                    <a href="{{ route('dashboard-wc') }}"
                                        class="btn btn-secondary btn-sm">Cancel</a>
                                </div>

                            </div>
                        </div>
                    </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dibuat_oleh').select2();
            $('#diperiksa').select2();
        });
        document.addEventListener("DOMContentLoaded", function() {
            const headers = document.querySelectorAll(".accordion-header");

            headers.forEach(header => {
                header.addEventListener("click", function() {
                    const content = this.nextElementSibling;


                    document.querySelectorAll(".accordion-content").forEach(item => {
                        if (item !== content) {
                            item.classList.remove("active");
                            item.style.display = "none";
                        }
                    });


                    if (content.classList.contains("active")) {
                        content.classList.remove("active");
                        content.style.display = "none";
                    } else {
                        content.classList.add("active");
                        content.style.display = "block";
                    }
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById("btn900Approve").addEventListener("click", function() {
                let docNumber = this.getAttribute("data-doc");
                let status = JSON.parse(this.getAttribute('data-status'));

                let nik = this.getAttribute("data-nik");

                axios.post("{{ route('wc-approve') }}", {
                        _token: "{{ csrf_token() }}",
                        doc_num: docNumber,

                        checked: nik == "{{ $data->checked_by }}" ? 'approved' : status[0],
                        validated: nik == "{{ $data->validated_by }}" ? 'approved' : status[1],

                    })
                    .then(response => {
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('dashboard-wc') }}';
                                }
                            });
                        }
                    })
                    .catch(error => {
                        let errorMessage = 'Terjadi kesalahan pada sistem';
                        console.log("Error respons:", error.response);

                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join(
                                    '\n');
                            } else if (error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
            });


            document.getElementById("btn900Reject").addEventListener("click", function() {
                let docNumber = this.getAttribute("data-doc");
                let status = JSON.parse(this.getAttribute('data-status'));
                let nik = this.getAttribute("data-nik");

                axios.post("{{ route('wc-reject') }}", {
                        _token: "{{ csrf_token() }}",
                        doc_num: docNumber,
                        checked: nik == "{{ $data->checked_by }}" ? 'rejected' : status[0],
                        validated: nik == "{{ $data->validated_by }}" ? 'rejected' : status[1],
                    })
                    .then(response => {
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('dashboard-wc') }}';
                                }
                            });
                        }
                    })
                    .catch(error => {
                        let errorMessage = 'Terjadi kesalahan pada sistem';
                        console.log("Error respons:", error.response);

                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join(
                                    '\n');
                            } else if (error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
            });


        });

        function resetApproval(id) {
            if (confirm('Are you sure you want to reset this Approval?')) {
                axios.post('{{ route('wc-reset', ['id' => 'ID']) }}'.replace('ID', id))
                    .then(function(response) {
                        console.log('Response:', response);
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to reset the approval.'
                            });
                        }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        let errorMessage = 'Terjadi kesalahan pada sistem';
                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join('\n');
                            } else if (error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
            }
        }
    </script>
@endsection
