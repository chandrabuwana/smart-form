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
                        <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Inspeksi Air Minum</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <form action="{{ route('she.air-minum.store') }}" method="POST">
                        @csrf
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site_name" class="ms-0">Nama Site</label>
                                        <select class="form-control" id="site_name" name="site_name" required {{ $isShowDetail ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Site --</option>
                                            @foreach(\Modules\SmartForm\helpers\SiteHelper::getAllSites() as $code => $name)
                                                <option value="{{ strtoupper($code) }}" 
                                                    {{ $isShowDetail && strtolower($maintenanceRecord->site_name) == strtolower($code) ? 'selected' : 
                                                    (!$isShowDetail && isset($defaultValues['site_name']) && strtolower($defaultValues['site_name']) == strtolower($code) ? 'selected' : '') }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                            <option value="BSS" 
                                                {{ $isShowDetail && strtolower($maintenanceRecord->site_name) == 'bss' ? 'selected' : 
                                                (!$isShowDetail && isset($defaultValues['site_name']) && strtolower($defaultValues['site_name']) == 'bss' ? 'selected' : '') }}>
                                                BSS
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Dept./Section</label>
                                        <select class="form-control" name="department" id="department" {{ $isShowDetail ? 'disabled' : '' }} required>
                                            <option value="">-- Pilih Departemen --</option>
                                            @foreach(\Modules\SmartForm\helpers\DepartmentHelper::getAllDepartments() as $code => $name)
                                                <option value="{{ $code }}" {{ $isShowDetail && $maintenanceRecord->department == $code ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Shift</label>
                                        {!! \Modules\SmartForm\helpers\ShiftHelper::renderShiftSelect('shift', $isShowDetail ? $maintenanceRecord->shift : (isset($defaultValues['shift']) ? $defaultValues['shift'] : null), isset($isShowDetail) && $isShowDetail) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Lokasi Kerja</label>
                                        <input type="text" name="work_location" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->work_location : '' }}" 
                                            required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Jumlah Inspektor</label>
                                        <input type="number" name="inspector_count" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->inspector_count : '1' }}" 
                                            required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }} min="0" step="1">
                                    </div>
                                </div>
                            </div>

                            <!-- Inspection Checklist -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th colspan="4" class="text-center">INSPEKSI CATERING CHECKLIST</th>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <th>HAL UNTUK DIPERIKSA</th>
                                            <th>Y</th>
                                            <th>N</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $checkItems = [
                                                ['name' => 'is_work_area_clean', 'label' => 'Apakah area kerja kebersihannya terjaga?'],
                                                ['name' => 'has_scattered_items', 'label' => 'Apakah banyak barang yang berserakan?'],
                                                ['name' => 'has_trash_bin', 'label' => 'Apakah ada tempat sampah?'],
                                                ['name' => 'has_scattered_trash', 'label' => 'Apakah ada sampah berserakan?'],
                                                ['name' => 'has_storage_warehouse', 'label' => 'Apakah ada gudang penyimpanan barang?'],
                                                ['name' => 'is_water_filter_regularly_changed', 'label' => 'Apakah filtrasi pengolahan air minum/ air bersih rutin diganti?'],
                                                ['name' => 'is_water_reservoir_cleaned', 'label' => 'Apakah tempat tampungan air rutin dikuras?'],
                                                ['name' => 'is_distribution_packing_clean', 'label' => 'Apakah tempat packing distribusi air terjaga kebersihan dan kerapiannya?'],
                                                ['name' => 'is_water_quality_checked_quarterly', 'label' => 'Apakah pengecekan kualitas air minum/ air bersih rutin dilakukan setiap per 3 bulan sekali?']
                                            ];
                                        @endphp

                                        @foreach($checkItems as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['label'] }}</td>
                                            <td class="text-center">
                                                <div class="form-check d-inline">
                                                    <input class="form-check-input" type="radio" 
                                                        name="{{ $item['name'] }}" value="1" 
                                                        {{ $isShowDetail && $maintenanceRecord->{$item['name']} ? 'checked' : '' }}
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-inline">
                                                    <input class="form-check-input" type="radio" 
                                                        name="{{ $item['name'] }}" value="0" 
                                                        {{ $isShowDetail && !$maintenanceRecord->{$item['name']} ? 'checked' : '' }}
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Score Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6>SCORE PENERIMAAN</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td class="bg-danger text-white text-center">Very Poor</td>
                                                <td class="bg-warning text-center">Poor</td>
                                                <td class="bg-success text-center">Good</td>
                                                <td class="bg-info text-white text-center">Excellent</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">1-2</td>
                                                <td class="text-center">3-5</td>
                                                <td class="text-center">6-8</td>
                                                <td class="text-center">9-10</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Signature Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr class="text-center">
                                                <th class="border">Diinspeksi Oleh (Inspector 1)</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="inspector_1_name" id="inspector_1_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }} required>
                                                        <option value="">-- Pilih Inspektor 1 --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->inspector_1_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="inspector_1_nik" id="inspector_1_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->inspector_1_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($maintenanceRecord->inspector_1_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $maintenanceRecord->inspector_1_date)))) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="inspector_1_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}" required>
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $maintenanceRecord->inspector_1_status == 'approved' ? 'success' : ($maintenanceRecord->inspector_1_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->inspector_1_status ?? 'pending') }}
                                                        </span>
                                                    @else
                                                        <select name="inspector_1_status" class="form-control">
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Diinspeksi Oleh (Inspector 2)</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="inspector_2_name" id="inspector_2_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Inspektor 2 --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->inspector_2_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="inspector_2_nik" id="inspector_2_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->inspector_2_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($maintenanceRecord->inspector_2_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $maintenanceRecord->inspector_2_date)))) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="inspector_2_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $maintenanceRecord->inspector_2_status == 'approved' ? 'success' : ($maintenanceRecord->inspector_2_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->inspector_2_status ?? 'pending') }}
                                                        </span>
                                                    @else
                                                        <select name="inspector_2_status" class="form-control">
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Diinspeksi Oleh (Inspector 3)</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="inspector_3_name" id="inspector_3_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Inspektor 3 --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->inspector_3_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="inspector_3_nik" id="inspector_3_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->inspector_3_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($maintenanceRecord->inspector_3_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $maintenanceRecord->inspector_3_date)))) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="inspector_3_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $maintenanceRecord->inspector_3_status == 'approved' ? 'success' : ($maintenanceRecord->inspector_3_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->inspector_3_status ?? 'pending') }}
                                                        </span>
                                                    @else
                                                        <select name="inspector_3_status" class="form-control">
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Mengetahui</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="acknowledged_by_name" id="acknowledged_by_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Penanggung Jawab --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->acknowledged_by_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="acknowledged_by_nik" id="acknowledged_by_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $maintenanceRecord->acknowledged_by_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($maintenanceRecord->acknowledged_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $maintenanceRecord->acknowledged_date)))) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="acknowledged_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $maintenanceRecord->acknowledged_status == 'approved' ? 'success' : ($maintenanceRecord->acknowledged_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($maintenanceRecord->acknowledged_status ?? 'pending') }}
                                                        </span>
                                                    @else
                                                        <select name="acknowledged_status" class="form-control">
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
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
                                    @if($isShowDetail)
                                        <a href="{{ route('she.air-minum.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('she.air-minum.export', $maintenanceRecord->id) }}" class="btn btn-primary">
                                            <i class="fas fa-file-export"></i> Export
                                        </a>
                                    @else
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('she.air-minum.dashboard') }}" class="btn btn-secondary">Back</a>
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
    .table th, .table td {
        vertical-align: middle;
    }
    .form-check-input[type="radio"] {
        margin-top: 0;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    console.log('Document ready - initializing form handlers');
    
    // Initialize datepicker
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    }
    
    // Handle inspector selection and populate NIK fields
    $('#inspector_1_name').on('change', function() {
        console.log('Inspector 1 changed');
        const selectedOption = $(this).find('option:selected');
        const nik = selectedOption.data('nik') || '';
        console.log('Setting inspector 1 NIK to:', nik);
        $('#inspector_1_nik').val(nik);
    });
    
    $('#inspector_2_name').on('change', function() {
        console.log('Inspector 2 changed');
        const selectedOption = $(this).find('option:selected');
        const nik = selectedOption.data('nik') || '';
        console.log('Setting inspector 2 NIK to:', nik);
        $('#inspector_2_nik').val(nik);
    });
    
    $('#inspector_3_name').on('change', function() {
        console.log('Inspector 3 changed');
        const selectedOption = $(this).find('option:selected');
        const nik = selectedOption.data('nik') || '';
        console.log('Setting inspector 3 NIK to:', nik);
        $('#inspector_3_nik').val(nik);
    });
    
    $('#acknowledged_by_name').on('change', function() {
        console.log('Acknowledged by changed');
        const selectedOption = $(this).find('option:selected');
        const nik = selectedOption.data('nik') || '';
        console.log('Setting acknowledged NIK to:', nik);
        $('#acknowledged_by_nik').val(nik);
    });
    
    // Trigger change event to populate NIK fields on page load
    setTimeout(function() {
        $('#inspector_1_name').trigger('change');
        $('#inspector_2_name').trigger('change');
        $('#inspector_3_name').trigger('change');
        $('#acknowledged_by_name').trigger('change');
    }, 500);
    
    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Validate required fields
        $('input[required], select[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields'
            });
        }
    });
    
    // Handle form submission
    var form = $("form");
    var submitBtn = form.find('button[type="submit"]');
    
    form.on("submit", function(e) {
        e.preventDefault();
        
        // Disable the submit button to prevent multiple submissions
        submitBtn.prop("disabled", true);
        
        // Show loading indicator
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we submit your form',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Get form data
        var formData = new FormData(this);
        
        // Log form data for debugging
        console.log('Form action:', form.attr("action"));
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        // Submit the form using AJAX
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Success response:', response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: true
                    }).then(function() {
                        // Redirect to dashboard or detail page
                        if (response.id) {
                            window.location.href = "{{ route('she.air-minum.form') }}?id=" + response.id;
                        } else {
                            window.location.href = "{{ route('she.air-minum.dashboard') }}";
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'An error occurred while submitting the form.',
                        showConfirmButton: true
                    });
                    submitBtn.prop("disabled", false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error response:', xhr.responseText);
                let errorMessage = 'An error occurred while submitting the form.';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    showConfirmButton: true
                });
                submitBtn.prop("disabled", false);
            }
        });
    });
});
</script>
@endsection