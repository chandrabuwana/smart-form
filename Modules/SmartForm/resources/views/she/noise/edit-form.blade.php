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
                        <h6 class="text-white text-capitalize ps-3">Edit Kebisingan / Noise Survey</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <form action="{{ route('she.noise.form.update', $record->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $record->id }}">
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Site Name</label>
                                        <select class="form-control" id="site_name" name="site_name" required>
                                            <option value="">-- Pilih Site --</option>
                                            @foreach(\Modules\SmartForm\helpers\SiteHelper::getAllSites() as $code => $name)
                                                <option value="{{ strtoupper($code) }}" 
                                                    {{ strtolower($record->site_name) == strtolower($code) ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                            <option value="BSS" 
                                                {{ strtolower($record->site_name) == 'bss' ? 'selected' : '' }}>
                                                BSS
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Department</label>
                                        <select class="form-control" id="department" name="department" required>
                                            <option value="">-- Pilih Departemen --</option>
                                            @foreach(\Modules\SmartForm\helpers\DepartmentHelper::getAllDepartments() as $code => $name)
                                                <option value="{{ $code }}" {{ $record->department == $code ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Shift</label>
                                        {!! \Modules\SmartForm\helpers\ShiftHelper::renderShiftSelect('shift', $record->shift, false) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Work Location</label>
                                        <input type="text" name="work_location" class="form-control" 
                                            value="{{ $record->work_location }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Jumlah Inspektor</label>
                                        <input type="number" name="inspector_count" class="form-control" 
                                            value="{{ $record->inspector_count }}" min="1" step="1" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Risk Level Table -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-light border">
                                                    <th>TINGKAT RISIKO</th>
                                                    <th>POTENSI RISIKO</th>
                                                    <th>Waktu Pemaparan</th>
                                                    <th>TINDAKAN PERBAIKAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-danger border">
                                                    <td class="border">Risiko Kritikal</td>
                                                    <td class="border">> 110 dB</td>
                                                    <td class="border">Maksimal 28,12 Detik</td>
                                                    <td class="border">Gunakan EARMUFF, Jaga Jarak 10-30 Meter dari titik kebisingan</td>
                                                </tr>
                                                <tr class="table-warning border">
                                                    <td class="border">Resiko Tinggi</td>
                                                    <td class="border">90-100 dB</td>
                                                    <td class="border">Maksimal 30 Menit</td>
                                                    <td class="border">Gunakan Earplug dan Jaga Jarak dari kebisingan 1- - 30 Meter</td>
                                                </tr>
                                                <tr class="table-info border">
                                                    <td class="border">Resiko Sedang</td>
                                                    <td class="border">85-90 dB</td>
                                                    <td class="border">Maksimal 2 Jam</td>
                                                    <td class="border">Gunakan Earplug</td>
                                                </tr>
                                                <tr class="table-success border">
                                                    <td class="border">Resiko Rendah</td>
                                                    <td class="border">< 85 dB</td>
                                                    <td class="border">Maksimal 8 Jam</td>
                                                    <td class="border">Identifikasi Kebisingan</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Activities Table -->
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
                                                        @php
                                                            $activityData = null;
                                                            if (isset($record->activities)) {
                                                                foreach ($record->activities as $act) {
                                                                    if ($act['name'] == $activity) {
                                                                        $activityData = $act;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        <input type="number" step="0.1" min="0" class="form-control activity-actual" 
                                                            name="activities[{{ $index }}][actual]" 
                                                            value="{{ $activityData ? $activityData['actual'] : '' }}">
                                                        <input type="hidden" name="activities[{{ $index }}][name]" 
                                                            value="{{ $activity }}">
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                name="activities[{{ $index }}][status]" value="below_nab" 
                                                                {{ $activityData && isset($activityData['status']) && $activityData['status'] == 'below_nab' ? 'checked' : '' }}>
                                                            <label class="form-check-label">< NAB</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                name="activities[{{ $index }}][status]" value="above_nab"
                                                                {{ $activityData && isset($activityData['status']) && $activityData['status'] == 'above_nab' ? 'checked' : '' }}>
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
                                                        @php
                                                            $areaData = null;
                                                            if (isset($record->work_areas)) {
                                                                foreach ($record->work_areas as $wa) {
                                                                    if ($wa['name'] == $area) {
                                                                        $areaData = $wa;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        <input type="number" step="0.1" min="0" class="form-control area-actual" 
                                                            name="work_areas[{{ $index }}][actual]" 
                                                            value="{{ $areaData ? $areaData['actual'] : '' }}">
                                                        <input type="hidden" name="work_areas[{{ $index }}][name]" 
                                                            value="{{ $area }}">
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                name="work_areas[{{ $index }}][status]" value="below_nab" 
                                                                {{ $areaData && isset($areaData['status']) && $areaData['status'] == 'below_nab' ? 'checked' : '' }}>
                                                            <label class="form-check-label">< NAB</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                name="work_areas[{{ $index }}][status]" value="above_nab"
                                                                {{ $areaData && isset($areaData['status']) && $areaData['status'] == 'above_nab' ? 'checked' : '' }}>
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
                                        <textarea class="form-control" name="findings_description" rows="4">{{ $record->findings_description }}</textarea>
                                    </div>
                                </div>
                            </div>

                             <!-- Inspector Information -->
                             <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Diinspeksi Oleh</label>
                                        <input type="text" name="inspected_by_name" class="form-control" 
                                            placeholder="Nama Lengkap"
                                            value="{{ $record->inspected_by_name }}" required>

                                        <input type="hidden" name="inspected_by_nik" value="{{ $record->inspected_by_nik }}" required>
                                    </div>
                                    <div class="input-group input-group-static mb-3">
                                        <label>Tanggal Inspeksi</label>
                                        <input type="date" name="inspection_date" class="form-control" 
                                            value="{{ $record->inspection_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Mengetahui</label>
                                        <select name="acknowledged_by_name" id="acknowledged_by_select" class="form-control text-left" required>
                                            <option value="">-- Pilih Pengawas --</option>
                                            @foreach($approvalList as $user)
                                                <option value="{{ $user->nama }}" 
                                                    data-nik="{{ $user->nik }}"
                                                    {{ $record->acknowledged_by_name == $user->nama ? 'selected' : '' }}>
                                                    {{ $user->nama }} ({{ $user->nik }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="acknowledged_by_nik" id="acknowledged_by_nik" value="{{ $record->acknowledged_by_nik }}" required>
                                    </div>
                                    <div class="input-group input-group-static mb-3">
                                        <label>Tanggal Mengetahui</label>
                                        <input type="date" name="acknowledgment_date" class="form-control" 
                                            value="{{ $record->acknowledgment_date }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Footer -->
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('she.noise.dashboard') }}" class="btn btn-secondary">Back</a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary">Update</button>
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

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle acknowledged_by_nik population when supervisor is selected
        document.getElementById('acknowledged_by_select').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const nik = selectedOption.getAttribute('data-nik');
            document.getElementById('acknowledged_by_nik').value = nik || '';
        });

        // Auto-update status based on actual values
        document.querySelectorAll('.activity-actual, .area-actual').forEach(function(input) {
            input.addEventListener('change', function() {
                const row = this.closest('tr');
                const belowNabRadio = row.querySelector('input[value="below_nab"]');
                const aboveNabRadio = row.querySelector('input[value="above_nab"]');
                
                if (parseFloat(this.value) > 85) {
                    aboveNabRadio.checked = true;
                } else {
                    belowNabRadio.checked = true;
                }
            });
        });
    });

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
                        text: 'Form updated successfully'
                    }).then((result) => {
                        window.location.href = '{{ route("she.noise.dashboard") }}';
                    });
                },
                error: function(xhr) {
                    var message = 'An error occurred while updating the form.';
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
