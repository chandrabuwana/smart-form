@extends('master.master_page')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                <span class="alert-icon align-middle"><i class="fas fa-check-circle"></i></span>
                <span class="alert-text">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                <span class="alert-icon align-middle"><i class="fas fa-exclamation-circle"></i></span>
                <span class="alert-text">{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                <span class="alert-icon align-middle"><i class="fas fa-exclamation-circle"></i></span>
                <span class="alert-text">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
            </div>
            @endif

            <div class="card">
                <!-- Header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Inspeksi Eyewash</h6>
                </div>
            </div>
                <div class="card-body px-0 pb-2">
                    <form action="{{ route('she-inspeksi.submit') }}" method="POST" id="maintenanceForm">
                        @csrf
                        <div class="mx-3">
                            <!-- Date and Location -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Tanggal</label>
                                        <input type="text" name="inspection_date" class="form-control datepicker" required
                                            value="{{ $isShowDetail ? $maintenanceRecord->inspection_date : now()->format('Y-m-d') }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Lokasi</label>
                                        <input type="text" name="location" class="form-control" required
                                            value="{{ $isShowDetail ? $maintenanceRecord->location : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <!-- Inspection Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2" class="text-center">Bulan</th>
                                            <th colspan="8" class="text-center">Item Pemeriksaan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Kondisi Tangki</th>
                                            <th class="text-center">Penutup Tangki</th>
                                            <th class="text-center">Warna Air</th>
                                            <th class="text-center">Bau Air</th>
                                            <th class="text-center">Volume Air</th>
                                            <th class="text-center">Kebersihan Tangki</th>
                                            <th class="text-center">Fungsi EyeWash</th>
                                            <th class="text-center">Paraf</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $months = [
                                                'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
                                                'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
                                            ];
                                            $conditions = ['Baik', 'Rusak'];
                                            $waterColors = ['Jernih', 'Keruh'];
                                            $waterSmells = ['Tidak bau', 'Bau'];
                                            $volumes = ['Penuh', 'Kurang', 'Kosong'];
                                            $cleanConditions = ['Bersih', 'Kotor'];
                                        @endphp

                                        @foreach($months as $index => $month)
                                        @php
                                            $monthData = $isShowDetail ? ($maintenanceRecord->monthly_data[$month] ?? null) : null;
                                        @endphp
                                        <tr>
                                            <td class="text-center align-middle border">{{ $index + 1 }}</td>
                                            <td class="align-middle border">{{ $month }}</td>
                                            <td class="border">
                                                <select name="kondisi_tangki_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['kondisi_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border">
                                                <select name="penutup_tangki_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['penutup_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border">
                                                <select name="warna_air_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($waterColors as $color)
                                                        <option value="{{ $color }}" {{ $monthData && $monthData['warna_air'] == $color ? 'selected' : '' }}>
                                                            {{ $color }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border">
                                                <select name="bau_air_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($waterSmells as $smell)
                                                        <option value="{{ $smell }}" {{ $monthData && $monthData['bau_air'] == $smell ? 'selected' : '' }}>
                                                            {{ $smell }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border">
                                                <select name="volume_air_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($volumes as $volume)
                                                        <option value="{{ $volume }}" {{ $monthData && $monthData['volume_air'] == $volume ? 'selected' : '' }}>
                                                            {{ $volume }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border">
                                                <select name="kebersihan_tangki_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($cleanConditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['kebersihan_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border">
                                                <select name="fungsi_eyewash_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['fungsi_eyewash'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle text-center border">
                                                <input type="checkbox" name="paraf_{{ $month }}" {{ $isShowDetail ? 'disabled' : '' }} {{ $monthData && $monthData['paraf'] ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Notes -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group input-group-static">
                                        <label>Catatan</label>
                                        <textarea name="notes" class="form-control" rows="3" {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $maintenanceRecord->notes : '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Signature Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr class="text-center">
                                                <th class="border">Dibuat Oleh Hygiene</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <input type="text" name="hygiene_name" class="form-control text-center" 
                                                    placeholder="Nama Lengkap"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->hygiene_name : session('username') }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} required>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="hygiene_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->hygiene_nik : session('user_id') }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} required>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($maintenanceRecord->hygiene_signed_at))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime($maintenanceRecord->hygiene_signed_at)) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="hygiene_signed_at" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}" required>
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $maintenanceRecord->hygiene_status == 'approved' ? 'success' : ($maintenanceRecord->hygiene_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->hygiene_status) }}
                                                        </span>
                                                    @else
                                                        <select name="hygiene_status" class="form-control text-center" disabled>
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Diperiksa Oleh Supervisor</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="supervisor_name" id="supervisor_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Supervisor --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->supervisor_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="supervisor_nik" id="supervisor_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->supervisor_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($maintenanceRecord->supervisor_signed_at))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime($maintenanceRecord->supervisor_signed_at)) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="supervisor_signed_at" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $maintenanceRecord->supervisor_status == 'approved' ? 'success' : ($maintenanceRecord->supervisor_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->supervisor_status) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Disetujui Oleh DH</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="dh_name" id="dh_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Department Head --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->dh_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="dh_nik" id="dh_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->dh_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($maintenanceRecord->dh_signed_at))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime($maintenanceRecord->dh_signed_at)) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="dh_signed_at" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $maintenanceRecord->dh_status == 'approved' ? 'success' : ($maintenanceRecord->dh_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->dh_status) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Disetujui Oleh DH Terkait</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="dh_terkait_name" id="dh_terkait_name" class="form-control text-center select2" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="dh_terkait_nik" id="dh_terkait_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->dh_terkait_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($maintenanceRecord->dh_terkait_signed_at))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime($maintenanceRecord->dh_terkait_signed_at)) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="dh_terkait_signed_at" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $maintenanceRecord->dh_terkait_status == 'approved' ? 'success' : ($maintenanceRecord->dh_terkait_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->dh_terkait_status) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit/Back Buttons -->
                            <div class="row">
                                <div class="col-12 text-end">
                                @if($isShowDetail && isset($record->approval_status) && $record->approval_status == 'approved')
                                        <a href="{{ route('she-inspeksi.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('she-inspeksi.form.export', ['id' => $maintenanceRecord->id]) }}" class="btn btn-primary">
                                            <i class="fas fa-file-export"></i> Export
                                        </a>
                                    @else
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('she-inspeksi.dashboard') }}" class="btn btn-secondary">Back</a>
                                            </div>
                                            @if(!$isShowDetail)
                                                <div>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .table th {
            background-color: #4472C4;
            color: white;
        }
        .notes {
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
    $(function() {
        // Initialize datepicker
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
        
        // Handle form submission
        var form = $("#maintenanceForm");
        var submitBtn = form.find('button[type="submit"]');
        
        form.submit(function(e) {
            e.preventDefault();
            submitBtn.prop('disabled', true);
            
            var formData = new FormData(this);
            
            axios.post('{{ route("she-inspeksi.submit") }}', formData)
                .then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("she-inspeksi.dashboard") }}';
                            }
                        });
                    }
                })
                .catch(function(error) {
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
                })
                .finally(function() {
                    submitBtn.prop('disabled', false);
                });
        });

        // Handle NIK auto-fill for Supervisor - exactly like P3K
        $('#supervisor_name').on('change', function() {
            var nik = $(this).find('option:selected').data('nik');
            $('#supervisor_nik').val(nik);
        });

        // Handle NIK auto-fill for DH - exactly like P3K
        $('#dh_name').on('change', function() {
            var nik = $(this).find('option:selected').data('nik');
            $('#dh_nik').val(nik);
        });

        // Handle NIK auto-fill for DH Terkait - exactly like P3K
        $('#dh_terkait_name').on('change', function() {
            var nik = $(this).find('option:selected').data('nik');
            $('#dh_terkait_nik').val(nik);
        });

        // Initialize Select2 for dh_terkait_name
        $('#dh_terkait_name').select2({
            placeholder: '-- Pilih DH Terkait --',
            width: '100%',
            ajax: {
                url: '{{ route("approval.list") }}',
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
        $('#dh_name').select2({
            placeholder: '-- Pilih DH --',
            width: '100%',
            ajax: {
                url: '{{ route("approval.list") }}',
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
        $('#supervisor_name').select2({
            placeholder: '-- Pilih Supervisor --',
            width: '100%',
            ajax: {
                url: '{{ route("approval.list") }}',
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
    </script>
@endsection
