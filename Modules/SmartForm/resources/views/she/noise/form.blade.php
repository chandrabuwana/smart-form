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

            <div class="card">
                <!-- Card Header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Kebisingan / Noise Survey</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <form action="{{ route('she.noise.store') }}" method="POST">
                        @csrf
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Site Name</label>
                                        <select class="form-control" id="site_name" name="site_name" required {{ $isShowDetail ? 'disabled' : '' }}>
                                            @foreach(['bss', 'agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj'] as $site)
                                                <option value="{{ strtoupper($site) }}" 
                                                    {{ $isShowDetail && strtolower($maintenanceRecord->site_name) == strtolower($site) ? 'selected' : 
                                                    (!$isShowDetail && isset($defaultValues['site_name']) && strtolower($defaultValues['site_name']) == strtolower($site) ? 'selected' : '') }}>
                                                    {{ strtoupper($site) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Department</label>
                                        <input type="text" name="department" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->department : ($defaultValues['department'] ?? '') }}" 
                                            >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Shift</label>
                                        <input type="text" name="shift" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->shift : ($defaultValues['shift'] ?? 'DS') }}" 
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Work Location</label>
                                        <input type="text" name="work_location" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->work_location : ($defaultValues['work_location'] ?? 'WORKSHOP') }}" 
                                            required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Jumlah Inspektor</label>
                                        <input type="number" name="inspector_count" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->inspector_count : ($defaultValues['inspector_count'] ?? 1) }}" 
                                            required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk Level Table -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th>TINGKAT RISIKO</th>
                                                    <th>POTENSI RISIKO</th>
                                                    <th>Waktu Pemaparan</th>
                                                    <th>TINDAKAN PERBAIKAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-danger">
                                                    <td>Risiko Kritikal</td>
                                                    <td>> 110 dB</td>
                                                    <td>Maksimal 28,12 Detik</td>
                                                    <td>Gunakan EARMUFF, Jaga Jarak 10-30 Meter dari titik kebisingan</td>
                                                </tr>
                                                <tr class="table-warning">
                                                    <td>Resiko Tinggi</td>
                                                    <td>90-100 dB</td>
                                                    <td>Maksimal 30 Menit</td>
                                                    <td>Gunakan Earplug dan Jaga Jarak dari kebisingan 1- - 30 Meter</td>
                                                </tr>
                                                <tr class="table-info">
                                                    <td>Resiko Sedang</td>
                                                    <td>85-90 dB</td>
                                                    <td>Maksimal 2 Jam</td>
                                                    <td>Gunakan Earplug</td>
                                                </tr>
                                                <tr class="table-success">
                                                    <td>Resiko Rendah</td>
                                                    <td>< 85 dB</td>
                                                    <td>Maksimal 8 Jam</td>
                                                    <td>Identifikasi Kebisingan</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Noise Measurement Table -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th>No</th>
                                                    <th>HAL UNTUK DIPERIKSA</th>
                                                    <th>STD</th>
                                                    <th>ACTUAL</th>
                                                    <th colspan="2">Keterangan*</th>
                                                </tr>
                                                <tr class="bg-warning">
                                                    <th colspan="6" class="text-white">Aktifitas Pekerjaan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $defaultActivities = [
                                                        'Pekerjaan Pengelasan',
                                                        'Pekerjaan Melakukan Gerinda',
                                                        'Pekerjan Hammering',
                                                        'Pekerjaan Drilling',
                                                        'Pekerjaan Infrasturktur',
                                                        'Etc.'
                                                    ];
                                                @endphp

                                                @foreach($defaultActivities as $index => $activity)
                                                <tr class="activity-row">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="activity-name">{{ $activity }}</td>
                                                    <td>< 85-100</td>
                                                    <td>
                                                        @if($isShowDetail)
                                                            {{ $maintenanceRecord->activities[$activity]['actual'] != 0 ? $maintenanceRecord->activities[$activity]['actual'] : '' ?? '-' }}
                                                        @else
                                                            <input type="number" step="0.1" class="form-control activity-actual" 
                                                                name="activities[{{ $index }}][actual]">
                                                            <input type="hidden" name="activities[{{ $index }}][name]" 
                                                                value="{{ $activity }}">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                name="activities[{{ $index }}][status]" value="below_nab" 
                                                                {{ $isShowDetail ? ($maintenanceRecord->activities[$activity]['status'] ?? '') === 'below_nab' ? 'checked' : '' : '' }}
                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                            <label class="form-check-label">< NAB</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                name="activities[{{ $index }}][status]" value="above_nab"
                                                                {{ $isShowDetail ? ($maintenanceRecord->activities[$activity]['status'] ?? '') === 'above_nab' ? 'checked' : '' : '' }}
                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                            <label class="form-check-label">> NAB</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Work Area Table -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th>No</th>
                                                    <th>HAL UNTUK DIPERIKSA</th>
                                                    <th>STD</th>
                                                    <th>ACTUAL</th>
                                                    <th colspan="2">Keterangan*</th>
                                                </tr>
                                                <tr class="bg-warning">
                                                    <th colspan="6" class="text-white">Area Kerja</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $defaultWorkAreas = [
                                                        'Area Lubricant',
                                                        'Area Workshop Tyre',
                                                        'Area Warehouse',
                                                        'Area Office',
                                                        'Area Parking',
                                                        'Area Maintenance',
                                                        'Area Production'
                                                    ];
                                                @endphp

                                                @foreach($defaultWorkAreas as $index => $area)
                                                <tr class="area-row">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="area-name">{{ $area }}</td>
                                                    <td>< 85-100</td>
                                                    <td>
                                                        @if($isShowDetail)
                                                            @php
                                                                $workAreasData = $maintenanceRecord->work_areas;
                                                                $areaData = collect($workAreasData)->firstWhere('name', $area);
                                                            @endphp
                                                            {{ isset($areaData['actual']) && $areaData['actual'] != 0 ? $areaData['actual'] : ''  }}
                                                        @else
                                                            <input type="number" step="0.1" class="form-control area-actual" 
                                                                name="work_areas[{{ $index }}][actual]">
                                                            <input type="hidden" name="work_areas[{{ $index }}][name]" 
                                                                value="{{ $area }}">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                name="work_areas[{{ $index }}][status]" value="below_nab"
                                                                @if($isShowDetail)
                                                                    {{ ($areaData['status'] ?? '') === 'below_nab' ? 'checked' : '' }}
                                                                    disabled
                                                                @endif>
                                                            <label class="form-check-label">< NAB</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                name="work_areas[{{ $index }}][status]" value="above_nab"
                                                                @if($isShowDetail)
                                                                    {{ ($areaData['status'] ?? '') === 'above_nab' ? 'checked' : '' }}
                                                                    disabled
                                                                @endif>
                                                            <label class="form-check-label">> NAB</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Findings Description -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Deskripsi Temuan</label>
                                        <textarea class="form-control" name="findings_description" rows="4" 
                                            {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $maintenanceRecord->findings_description : '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Footer -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Diinspeksi Oleh</label>
                                        <input type="text" name="inspected_by" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->inspected_by : '' }}" 
                                            required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                    <div class="input-group input-group-static mb-3">
                                        <label>Tanggal Inspeksi</label>
                                        <input type="date" name="inspection_date" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->inspection_date : now()->format('Y-m-d') }}" 
                                            required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                    <div class="form-check mb-3 ps-0">
                                        <input class="form-check-input" type="checkbox" name="inspected_signature" value="1"
                                            {{ $isShowDetail ? ($maintenanceRecord->inspected_signature ? 'checked' : '') : '' }}
                                            {{ $isShowDetail ? 'disabled' : '' }} required>
                                        <label class="form-check-label">
                                            Signed by Inspector
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Mengetahui</label>
                                        <input type="text" name="acknowledged_by" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->acknowledged_by : '' }}" 
                                            required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                    <div class="input-group input-group-static mb-3">
                                        <label>Tanggal Mengetahui</label>
                                        <input type="date" name="acknowledgment_date" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->acknowledgment_date : now()->format('Y-m-d') }}" 
                                            required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                    <div class="form-check mb-3 ps-0">
                                        <input class="form-check-input" type="checkbox" name="acknowledged_signature" value="1"
                                            {{ $isShowDetail ? ($maintenanceRecord->acknowledged_signature ? 'checked' : '') : '' }}
                                            {{ $isShowDetail ? 'disabled' : '' }} required>
                                        <label class="form-check-label">
                                            Signed by Acknowledger
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    @if($isShowDetail)
                                        <a href="{{ route('she.noise.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('she.noise.export', $maintenanceRecord->id) }}" class="btn btn-primary">
                                            <i class="material-icons">download</i> Export
                                        </a>
                                    @else
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('she.noise.dashboard') }}" class="btn btn-secondary">Back</a>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
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
<style>
    .table th {
        font-weight: 600;
    }
    .table td {
        vertical-align: middle;
    }
    .form-check {
        margin: 0;
    }
    .form-check-input {
        margin-top: 0.2rem;
    }
</style>
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    // Form submission handling
    $('form').on('submit', function(e) {
        e.preventDefault();

        // Create FormData object
        var formData = new FormData(this);

        // Remove existing activities array if any
        formData.delete('activities');

        // Get activities data
        var activities = [];
        $('.activity-row').each(function(index) {
            var row = $(this);
            var activity = {
                name: row.find('.activity-name').text().trim(),
                actual: parseFloat(row.find('input[name^="activities"][name$="[actual]"]').val()) || 0,
                status: row.find('input[name^="activities"][name$="[status]"]:checked').val() || ''
            };
            activities.push(activity);
        });

        // Get work areas data
        var workAreas = [];
        $('.area-row').each(function(index) {
            var row = $(this);
            var area = {
                name: row.find('.area-name').text().trim(),
                actual: parseFloat(row.find('input[name^="work_areas"][name$="[actual]"]').val()) || 0,
                status: row.find('input[name^="work_areas"][name$="[status]"]:checked').val() || ''
            };
            workAreas.push(area);
        });

        // Convert form data to object
        var formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });

        // Add activities and work_areas
        formObject.activities = activities;
        formObject.work_areas = workAreas;

        // Send AJAX request
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formObject,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Form saved successfully'
                }).then((result) => {
                    window.location.href = '{{ route("she.noise.dashboard") }}';
                });
            },
            error: function(xhr) {
                var message = 'An error occurred while saving the form.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            }
        });
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Date validation
    $('#inspection_date, #acknowledgment_date').change(function() {
        var inspectionDate = $('#inspection_date').val();
        var acknowledgmentDate = $('#acknowledgment_date').val();

        if (inspectionDate && acknowledgmentDate && inspectionDate > acknowledgmentDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date',
                text: 'Acknowledgment date must be after inspection date'
            });
            $(this).val('');
        }
    });
});
</script>
@endsection