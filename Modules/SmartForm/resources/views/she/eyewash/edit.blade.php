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
                    <h6 class="text-white text-capitalize ps-3">Edit Inspeksi Eyewash</h6>
                </div>
            </div>
                <div class="card-body px-0 pb-2">
                    <form id="editForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $maintenanceRecord->id }}">
                        <div class="mx-3">
                            <!-- Date and Location -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Tanggal</label>
                                        <input type="date" name="inspection_date" class="form-control" required
                                            value="{{ $maintenanceRecord->inspection_date }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Lokasi</label>
                                        <input type="text" name="location" class="form-control" required
                                            value="{{ $maintenanceRecord->location }}">
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
                                            $monthData = $maintenanceRecord->monthly_data[$month] ?? null;
                                        @endphp
                                        <tr>
                                            <td class="text-center align-middle">{{ $index + 1 }}</td>
                                            <td class="align-middle">{{ $month }}</td>
                                            <td>
                                                <select name="kondisi_tangki_{{ $month }}" class="form-control form-select">
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['kondisi_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="penutup_tangki_{{ $month }}" class="form-control form-select">
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['penutup_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="warna_air_{{ $month }}" class="form-control form-select">
                                                    <option value="">Pilih</option>
                                                    @foreach($waterColors as $color)
                                                        <option value="{{ $color }}" {{ $monthData && $monthData['warna_air'] == $color ? 'selected' : '' }}>
                                                            {{ $color }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="bau_air_{{ $month }}" class="form-control form-select">
                                                    <option value="">Pilih</option>
                                                    @foreach($waterSmells as $smell)
                                                        <option value="{{ $smell }}" {{ $monthData && $monthData['bau_air'] == $smell ? 'selected' : '' }}>
                                                            {{ $smell }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="volume_air_{{ $month }}" class="form-control form-select">
                                                    <option value="">Pilih</option>
                                                    @foreach($volumes as $volume)
                                                        <option value="{{ $volume }}" {{ $monthData && $monthData['volume_air'] == $volume ? 'selected' : '' }}>
                                                            {{ $volume }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="kebersihan_tangki_{{ $month }}" class="form-control form-select">
                                                    <option value="">Pilih</option>
                                                    @foreach($cleanConditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['kebersihan_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="fungsi_eyewash_{{ $month }}" class="form-control form-select">
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['fungsi_eyewash'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                <input type="checkbox" name="paraf_{{ $month }}" {{ $monthData && $monthData['paraf'] ? 'checked' : '' }}>
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
                                        <textarea name="notes" class="form-control" rows="3">{{ $maintenanceRecord->notes }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Approval Information -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Informasi Persetujuan</h5>
                                        </div>
                                        <div class="card-body">
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
                                                        value="{{ $maintenanceRecord->hygiene_name }}" readonly>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" name="hygiene_nik" class="form-control text-center" 
                                                        placeholder="NIK"
                                                        value="{{ $maintenanceRecord->hygiene_nik }}" readonly>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" class="form-control text-center" 
                                                        value="{{ !empty($maintenanceRecord->hygiene_signed_at) ? date('Y-m-d', strtotime($maintenanceRecord->hygiene_signed_at)) : '' }}" readonly>
                                                    </td>
                                                    <td class="border text-center">
                                                        <span class="badge bg-{{ $maintenanceRecord->hygiene_status == 'approved' ? 'success' : ($maintenanceRecord->hygiene_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->hygiene_status) }}
                                                        </span>
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
                                                        <select name="supervisor_name" id="supervisor_name" class="form-control text-center">
                                                            <option value="">-- Pilih Supervisor --</option>
                                                            @foreach($approvalList as $user)
                                                                <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $maintenanceRecord->supervisor_name == $user->nama ? 'selected' : '' }}>
                                                                    {{ $user->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" name="supervisor_nik" id="supervisor_nik" class="form-control text-center" 
                                                        placeholder="NIK"
                                                        value="{{ $maintenanceRecord->supervisor_nik }}" readonly>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" class="form-control text-center" 
                                                        value="{{ !empty($maintenanceRecord->supervisor_signed_at) ? date('Y-m-d', strtotime($maintenanceRecord->supervisor_signed_at)) : '' }}" readonly>
                                                    </td>
                                                    <td class="border text-center">
                                                        <span class="badge bg-{{ $maintenanceRecord->supervisor_status == 'approved' ? 'success' : ($maintenanceRecord->supervisor_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->supervisor_status) }}
                                                        </span>
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
                                                        <select name="dh_name" id="dh_name" class="form-control text-center">
                                                            <option value="">-- Pilih Department Head --</option>
                                                            @foreach($approvalList as $user)
                                                                <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $maintenanceRecord->dh_name == $user->nama ? 'selected' : '' }}>
                                                                    {{ $user->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" name="dh_nik" id="dh_nik" class="form-control text-center" 
                                                        placeholder="NIK"
                                                        value="{{ $maintenanceRecord->dh_nik }}" readonly>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" class="form-control text-center" 
                                                        value="{{ !empty($maintenanceRecord->dh_signed_at) ? date('Y-m-d', strtotime($maintenanceRecord->dh_signed_at)) : '' }}" readonly>
                                                    </td>
                                                    <td class="border text-center">
                                                        <span class="badge bg-{{ $maintenanceRecord->dh_status == 'approved' ? 'success' : ($maintenanceRecord->dh_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->dh_status) }}
                                                        </span>
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
                                                        <select name="dh_terkait_name" id="dh_terkait_name" class="form-control text-center">
                                                            <option value="">-- Pilih DH Terkait --</option>
                                                            @foreach($approvalList as $user)
                                                                <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $maintenanceRecord->dh_terkait_name == $user->nama ? 'selected' : '' }}>
                                                                    {{ $user->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" name="dh_terkait_nik" id="dh_terkait_nik" class="form-control text-center" 
                                                        placeholder="NIK"
                                                        value="{{ $maintenanceRecord->dh_terkait_nik }}" readonly>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" class="form-control text-center" 
                                                        value="{{ !empty($maintenanceRecord->dh_terkait_signed_at) ? date('Y-m-d', strtotime($maintenanceRecord->dh_terkait_signed_at)) : '' }}" readonly>
                                                    </td>
                                                    <td class="border text-center">
                                                        <span class="badge bg-{{ $maintenanceRecord->dh_terkait_status == 'approved' ? 'success' : ($maintenanceRecord->dh_terkait_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->dh_terkait_status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit/Back Buttons -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('she-inspeksi.dashboard') }}" class="btn btn-secondary">Back</a>
                                            </div>
                                            <div>
                                                <button type="button" id="submitBtn" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
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
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle NIK auto-fill for Supervisor
            $('#supervisor_name').on('change', function() {
                var nik = $(this).find('option:selected').data('nik');
                $('#supervisor_nik').val(nik);
            });
            
            // Handle NIK auto-fill for DH
            $('#dh_name').on('change', function() {
                var nik = $(this).find('option:selected').data('nik');
                $('#dh_nik').val(nik);
            });
            
            // Handle NIK auto-fill for DH Terkait
            $('#dh_terkait_name').on('change', function() {
                var nik = $(this).find('option:selected').data('nik');
                $('#dh_terkait_nik').val(nik);
            });
            
            // Handle form submission
            $('#submitBtn').on('click', function(e) {
                e.preventDefault();
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form
                        submitForm();
                    }
                });
            });
            
            function submitForm() {
                // Get form data
                var formData = $('#editForm').serialize();
                
                // Submit form via AJAX
                $.ajax({
                    url: '{{ route('she-inspeksi.update') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                window.location.href = '{{ route('she-inspeksi.dashboard') }}';
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            title: 'Gagal!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    </script>

    <script>
         $(function() {
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
