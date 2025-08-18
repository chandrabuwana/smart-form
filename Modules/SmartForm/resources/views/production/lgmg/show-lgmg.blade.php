@extends('master.master_page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                        <span class="alert-icon align-middle"><i class="fas fa-check-circle"></i></span>
                        <span class="alert-text">{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                        <span class="alert-icon align-middle"><i class="fas fa-exclamation-circle"></i></span>
                        <span class="alert-text">{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                <div class="card">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Form P2H UNIT CMT - LGMG</h6>
                        </div>
                    </div>

                    <form id="formXCMG900" method="POST">
                        @csrf
                        <div class="mx-3">
                            <input type="hidden" name="lgmg_id" id="lgmg_id" value="{{ $data->id }}">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nama_operator" class="ms-0">Nama Operator</label>
                                        <input disabled type="text" class="form-control" id="nama_operator" value="{{ $data->nama_operator }}" name="nama_operator" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <tr>
                                        <td>Shift</td>
                                        <td>
                                            {!! \Modules\SmartForm\helpers\ShiftHelper::renderShiftSelect('shift', $data->shift ?? null, false, true, 'shift', 'form-select form-select-sm input-text') !!}
                                        </td>
                                    </tr>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nrp" class="ms-0">NRP</label>
                                        <input disabled type="text" class="form-control" id="nrp" name="nrp" value="{{ $data->nrp }}"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="fuel_awal" class="ms-0">FUEL AWAL</label>
                                        <input disabled type="number" step="0.01" min="0" class="form-control" value="{{ $data->fuel_awal }}" id="fuel_awal" name="fuel_awal" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="fuel_akhir" class="ms-0">FUEL AKHIR</label>
                                        <input disabled type="number" step="0.01" min="0" class="form-control" value="{{ $data->fuel_akhir }}" id="fuel_akhir" name="fuel_akhir" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="tanggal" class="ms-0">TANGGAL</label>
                                        <input disabled type="date" class="form-control" value="{{ $data->tanggal }}" id="tanggal" name="tanggal" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="no_unit" class="ms-0">NO UNIT</label>
                                        <input disabled type="text" class="form-control" id="no_unit" name="no_unit" value="{{ $data->no_unit }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="km_star" class="ms-0">KM STAR</label>
                                        <input disabled type="number" value="{{ $data->km_star }}" step="0.01" min="0" class="form-control" id="km_star" name="km_star" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="km_akhir" class="ms-0">KM AKHIR</label>
                                        <input disabled type="number" step="0.01" value="{{ $data->km_akhir }}" min="0" class="form-control" id="km_akhir" name="km_akhir" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hm_star" class="ms-0">HM STAR</label>
                                        <input disabled type="number" step="0.01" min="0" value="{{ $data->hm_star }}" class="form-control" id="hm_star" name="hm_star" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hm_akhir" class="ms-0">HM AKHIR</label>
                                        <input disabled type="number" step="0.01" min="0" class="form-control" value="{{ $data->hm_akhir }}" id="hm_akhir" name="hm_akhir" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                            </div>

                            @foreach($pertanyaan as $category => $items)
                                <div class="mb-1" style="padding:1rem">
                                    <div style="background-color:orange;">
                                        <label class="form-label" style="color:white">{{ str_replace('_', ' ', strtoupper($category)) }}</label>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="card col-md-12 was-validated">
                                            <table class="w-full">
                                                <tbody>
                                                    @foreach($items as $index => $question)
                                                        <tr>
                                                            <td style="width:2%">{{ $loop->iteration }}.</td>
                                                            <td style="width:50%; white-space: pre-line;">{{ $question->pertanyaan }}</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input disabled class="form-check-input" type="radio" id="q{{ $question->id }}_Ya" name="q{{ $question->id }}" value="Ya"
                                                                        {{ $lgmg_detail->where('pertanyaan_id', $question->id)->first() && $lgmg_detail->where('pertanyaan_id', $question->id)->first()->jawaban == 'Ya' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="q{{ $question->id }}_Ya">Awal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input disabled class="form-check-input" type="radio" id="q{{ $question->id }}_Tidak" name="q{{ $question->id }}" value="Tidak"
                                                                        {{ $lgmg_detail->where('pertanyaan_id', $question->id)->first() && $lgmg_detail->where('pertanyaan_id', $question->id)->first()->jawaban == 'Tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="q{{ $question->id }}_Tidak">Akhir</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <input type="hidden" name="pertanyaan_id[]" value="{{ $question->id }}">
                                                        <input type="hidden" name="q{{ $question->id }}_category" id="q{{ $question->id }}_category" value="{{ $question->category }}">
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mb-1" style="padding:1rem">
                                <div style="background-color:orange;">
                                    <label class="form-label" style="color:white">KETERANGAN</label>
                                </div>
                                <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                        <table class="w-full">
                                            <tbody>
                                                @php
                                                    $keterangan = json_decode($lgmg_detail->first()->keterangan ?? '[]');
                                                @endphp
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <tr>
                                                        <td>
                                                            <div class="input-group input-group-static mb-3">
                                                                <label for="keterangan{{ $i }}" class="ms-0">Keterangan {{ $i }}</label>
                                                                <input disabled type="text" class="form-control" id="keterangan{{ $i }}" name="keterangan{{ $i }}" value="{{ $keterangan[$i - 1] ?? '' }}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diisi_oleh" class="ms-0">Diisi Oleh</label>
                                        <select disabled name="diisi_oleh" id="diisi_oleh" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            {{-- @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}" {{ $data->diisi_oleh == $user->nik ? 'selected' : '' }}>{{ $user->nama }}</option>
                                            @endforeach --}}
                                            @foreach($approvalList as $user)
                                                <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $data->diisi_oleh == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="checked_by" class="ms-0">Diperiksa Oleh</label>
                                        <select disabled name="checked_by" id="checked_by" class="form-control" required>
                                            <option value="">-- Pilih Checker --</option>
                                            {{-- @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}" {{ $data->checked_by == $user->nik ? 'selected' : '' }}>{{ $user->nama }}</option>
                                            @endforeach --}}
                                            @foreach($approvalList as $user)
                                                <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $data->checked_by == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="catatan_rm" class="ms-0">Catatan RM</label>
                                        <textarea disabled name="catatan_rm" id="catatan_rm" class="form-control">{{ $data->catatan_rm }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @for ($i = 0; $i < 2; $i++)
                                    @if ($i == 0)
                                        @if ($data->status[$i] == 'rejected')
                                            <div class="col-6 ty">
                                                <img src="{{ asset('img/rejected.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($data->status[$i] == 'approved')
                                            <div class="col-6 ty">
                                                <img src="{{ asset('img/checked.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($data->status[$i] == null)
                                            <div class="col-6 ty">

                                            </div>
                                        @endif
                                    @else
                                        @if ($data->status[$i] == 'rejected')
                                            <div class="col-6 ty">
                                                <img src="{{ asset('img/rejected.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($data->status[$i] == 'approved')
                                            <div class="col-6 ty">
                                                <img src="{{ asset('img/validated.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($data->status[$i] == null)
                                            <div class="col-6 ty">

                                            </div>
                                        @endif
                                    @endif
                                @endfor

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-actions">
                                        @if ($nik == $data->checked_by || $nik == $data->diisi_oleh)
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

                                        {{-- {{dd($data->status)}} --}}
                                        @if (collect($data->status)->contains(fn($s) => $s === 'rejected'))
                                            @if ($nik == $data->creator)
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="resetApproval('{{ $data->doc_num }}')">
                                                    <i class="fas fa-undo"></i> Reset
                                                </button>
                                            @endif
                                        @endif

                                        <a href="{{ route('lgmg.dashboard') }}"
                                            class="btn btn-secondary btn-sm">Cancel</a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .accordion {
            width: 100%;

            margin: auto;
        }

        .accordion-item {
            border: 1px solid #ddd;
            margin-bottom: 5px;
            border-radius: 5px;
            overflow: hidden;
        }

        .accordion-header {
            background: #E91E63;
            color: white;
            padding: 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            border: none;
            text-align: left;
            width: 100%;
            outline: none;
        }

        .accordion-content {
            display: none;
            padding: 15px;
            background: #f1f1f1;
        }

        .active {
            display: block;
        }

        .form-container {
            display: flex;
            align-items: center;
            margin: 10px;
            gap: 120px;

        }

        th,
        td {
            vertical-align: middle;
            text-align: center;
            font-size: 12px;
        }

        td[rowspan] {
            vertical-align: middle !important;
            text-align: center;

        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid black !important;
        }

        .form-actions {
            justify-content: flex-end;
            display: flex;
            gap: 10px;
            margin-top: 10px;

        }

        .bg-success {
            background-color: #a6000b !important;
        }



        .custom-checkbox {
            width: 20px;
            height: 20px;
            transform: scale(1.5);
            cursor: pointer;
        }
    </style>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#shift').select2({
                disabled: true
            });

            $(function() {
                $('#diisi_oleh, #checked_by').select2({
                    placeholder: '-- Pilih --',
                    width: '100%',
                    ajax: {
                        url: '{{ route('lgmg.approval.list') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return { search: params.term };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.nama,
                                        text: item.nama + ' (' + item.nik + ')',
                                        nik: item.nik
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });
            });
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

                axios.post("{{ route('lgmg.approve') }}", {
                    _token: "{{ csrf_token() }}",
                    doc_num: docNumber,

                    checked: nik == "{{ $data->diisi_oleh }}" ? 'approved' : status[0],
                    validated: nik == "{{ $data->checked_by }}" ? 'approved' : status[1],

                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        alert(data.message);
                        window.location.href = "{{ route('lgmg.dashboard') }}";
                        // location.reload();
                    } else {
                        alert('Gagal Approve data.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                });
            });


            document.getElementById("btn900Reject").addEventListener("click", function() {
                let docNumber = this.getAttribute("data-doc");
                let status = JSON.parse(this.getAttribute('data-status'));
                let nik = this.getAttribute("data-nik");

                axios.post("{{ route('lgmg.reject') }}", {
                    _token: "{{ csrf_token() }}",
                    doc_num: docNumber,
                    checked: nik == "{{ $data->diisi_oleh }}" ? 'rejected' : status[0],
                    validated: nik == "{{ $data->checked_by }}" ? 'rejected' : status[1],
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        alert(data.message);
                        window.location.href = "{{ route('lgmg.dashboard') }}";
                        // location.reload();
                    } else {
                        alert('Gagal Reject data.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                });
            });
        })

        function resetApproval(id) {
            if (confirm('Are you sure you want to reset this Approval?')) {
                axios.post('{{ route('lgmg.reset', ['id' => 'ID']) }}'.replace('ID', id))
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
