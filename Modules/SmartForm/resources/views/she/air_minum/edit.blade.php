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
                        <h6 class="text-white text-capitalize ps-3">Edit Inspeksi Air Minum</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <!-- Approval Status Tracking Section -->
                    <div class="mx-3 mb-4">
                        <div class="card bg-light">
                            <div class="card-header bg-light p-3">
                                <h6 class="mb-0">Status Approval</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        @php
                                            $statusClass = 'bg-secondary';
                                            $statusText = 'Pending';
                                            
                                            if ($maintenanceRecord->approval_status == 'approved') {
                                                $statusClass = 'bg-success';
                                                $statusText = 'Approved';
                                            } elseif ($maintenanceRecord->approval_status == 'rejected') {
                                                $statusClass = 'bg-danger';
                                                $statusText = 'Rejected';
                                            } elseif ($maintenanceRecord->approval_status == 'in_progress') {
                                                $statusClass = 'bg-info';
                                                $statusText = 'In Progress';
                                            }
                                        @endphp
                                        <h5>Status: <span class="badge {{ $statusClass }}">{{ $statusText }}</span></h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="progress-container">
                                            <span class="progress-badge">Approval Progress</span>
                                            @php
                                                $totalSteps = 4; // Inspector 1, Inspector 2, Inspector 3, Acknowledger
                                                $completedSteps = 0;
                                                
                                                if ($maintenanceRecord->inspector_1_status == 'approved') $completedSteps++;
                                                if ($maintenanceRecord->inspector_2_status == 'approved') $completedSteps++;
                                                if ($maintenanceRecord->inspector_3_status == 'approved') $completedSteps++;
                                                if ($maintenanceRecord->acknowledged_status == 'approved') $completedSteps++;
                                                
                                                $progressPercentage = ($completedSteps / $totalSteps) * 100;
                                            @endphp
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-success" role="progressbar" 
                                                     aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" 
                                                     aria-valuemax="100" style="width: {{ $progressPercentage }}%;">
                                                </div>
                                            </div>
                                            <span class="progress-value">{{ $completedSteps }} of {{ $totalSteps }} approvals completed</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between flex-wrap">
                                            <div class="approval-step">
                                                <span class="badge {{ $maintenanceRecord->inspector_1_status == 'approved' ? 'bg-success' : 'bg-secondary' }} mb-1">
                                                    Inspector 1
                                                </span>
                                                <small class="d-block">{{ $maintenanceRecord->inspector_1_name }}</small>
                                                <small class="d-block">{{ $maintenanceRecord->inspector_1_date ?? 'Pending' }}</small>
                                            </div>
                                            <div class="approval-step">
                                                <span class="badge {{ $maintenanceRecord->inspector_2_status == 'approved' ? 'bg-success' : 'bg-secondary' }} mb-1">
                                                    Inspector 2
                                                </span>
                                                <small class="d-block">{{ $maintenanceRecord->inspector_2_name }}</small>
                                                <small class="d-block">{{ $maintenanceRecord->inspector_2_date ?? 'Pending' }}</small>
                                            </div>
                                            <div class="approval-step">
                                                <span class="badge {{ $maintenanceRecord->inspector_3_status == 'approved' ? 'bg-success' : 'bg-secondary' }} mb-1">
                                                    Inspector 3
                                                </span>
                                                <small class="d-block">{{ $maintenanceRecord->inspector_3_name }}</small>
                                                <small class="d-block">{{ $maintenanceRecord->inspector_3_date ?? 'Pending' }}</small>
                                            </div>
                                            <div class="approval-step">
                                                <span class="badge {{ $maintenanceRecord->acknowledged_status == 'approved' ? 'bg-success' : 'bg-secondary' }} mb-1">
                                                    Acknowledged
                                                </span>
                                                <small class="d-block">{{ $maintenanceRecord->acknowledged_by_name }}</small>
                                                <small class="d-block">{{ $maintenanceRecord->acknowledged_date ?? 'Pending' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="airMinumForm" method="POST" action="{{ route('she.air-minum.form.update', $maintenanceRecord->id) }}">
                        @csrf
                        <input type="hidden" name="inspection_date" value="{{ $maintenanceRecord->inspection_date }}">
                        <input type="hidden" name="id" value="{{ $maintenanceRecord->id }}">
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site_name" class="ms-0">Nama Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site_name', $maintenanceRecord->site_name ?? null, !$isShowDetail, true, 'site_name', 'form-control') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="department" class="ms-0">Dept./Section</label>
                                        {!! \Modules\SmartForm\helpers\DepartmentHelper::renderDepartmentSelect(
                                            'department',
                                            $maintenanceRecord->department ?? '',
                                            !$isShowDetail,
                                            true,
                                            'department',
                                            'form-control'
                                        ) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="shift" class="ms-0">Shift</label>
                                        {!! \Modules\SmartForm\helpers\ShiftHelper::renderShiftSelect('shift', $maintenanceRecord->shift, false) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="work_location" class="ms-0">Lokasi Kerja</label>
                                        <input type="text" class="form-control" id="work_location" name="work_location" value="{{ $maintenanceRecord->work_location }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="inspector_count" class="ms-0">Jumlah Inspektor</label>
                                        <input type="number" class="form-control" id="inspector_count" name="inspector_count" value="{{ $maintenanceRecord->inspector_count }}" min="1" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="inspection_date" class="ms-0">Tanggal Inspeksi</label>
                                        <input type="date" class="form-control datepicker" id="inspection_date" name="inspection_date" value="{{ \Carbon\Carbon::parse($maintenanceRecord->inspection_date)->format('Y-m-d') }}" required>
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
                                            <th width="5%">No</th>
                                            <th width="65%">Item</th>
                                            <th width="15%" class="text-center">Ya</th>
                                            <th width="15%" class="text-center">Tidak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Area kerja bersih dan rapi</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_work_area_clean" value="1" {{ $maintenanceRecord->is_work_area_clean ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_work_area_clean" value="0" {{ !$maintenanceRecord->is_work_area_clean ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Terdapat barang berserakan</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="has_scattered_items" value="1" {{ $maintenanceRecord->has_scattered_items ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="has_scattered_items" value="0" {{ !$maintenanceRecord->has_scattered_items ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Tersedia tempat sampah</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="has_trash_bin" value="1" {{ $maintenanceRecord->has_trash_bin ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="has_trash_bin" value="0" {{ !$maintenanceRecord->has_trash_bin ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Terdapat sampah berserakan</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="has_scattered_trash" value="1" {{ $maintenanceRecord->has_scattered_trash ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="has_scattered_trash" value="0" {{ !$maintenanceRecord->has_scattered_trash ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Tersedia gudang penyimpanan</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="has_storage_warehouse" value="1" {{ $maintenanceRecord->has_storage_warehouse ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="has_storage_warehouse" value="0" {{ !$maintenanceRecord->has_storage_warehouse ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Filter air diganti secara berkala</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_water_filter_regularly_changed" value="1" {{ $maintenanceRecord->is_water_filter_regularly_changed ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_water_filter_regularly_changed" value="0" {{ !$maintenanceRecord->is_water_filter_regularly_changed ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Tandon air dibersihkan</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_water_reservoir_cleaned" value="1" {{ $maintenanceRecord->is_water_reservoir_cleaned ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_water_reservoir_cleaned" value="0" {{ !$maintenanceRecord->is_water_reservoir_cleaned ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Distribusi/pengemasan bersih</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_distribution_packing_clean" value="1" {{ $maintenanceRecord->is_distribution_packing_clean ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_distribution_packing_clean" value="0" {{ !$maintenanceRecord->is_distribution_packing_clean ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Kualitas air diperiksa per triwulan</td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_water_quality_checked_quarterly" value="1" {{ $maintenanceRecord->is_water_quality_checked_quarterly ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="is_water_quality_checked_quarterly" value="0" {{ !$maintenanceRecord->is_water_quality_checked_quarterly ? 'checked' : '' }} required>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Inspectors Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr class="text-center">
                                                <th class="border">Diinspeksi Oleh</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="inspector_1_name" id="inspector_1_name" class="form-control text-center" required>
                                                        <option value="">-- Pilih Inspektor --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $maintenanceRecord->inspector_1_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="inspector_1_nik" id="inspector_1_nik" class="form-control text-center" value="{{ $maintenanceRecord->inspector_1_nik }}" readonly required>
                                                </td>
                                                <td class="border">
                                                    <input type="date" name="inspector_1_date" class="form-control text-center" value="{{ \Carbon\Carbon::parse($maintenanceRecord->inspector_1_date)->format('Y-m-d') }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="inspector_2_name" id="inspector_2_name" class="form-control text-center">
                                                        <option value="">-- Pilih Inspektor --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $maintenanceRecord->inspector_2_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="inspector_2_nik" id="inspector_2_nik" class="form-control text-center" value="{{ $maintenanceRecord->inspector_2_nik }}" readonly required>
                                                </td>
                                                <td class="border">
                                                    <input type="date" name="inspector_2_date" class="form-control text-center" value="{{ $maintenanceRecord->inspector_2_date ? \Carbon\Carbon::parse($maintenanceRecord->inspector_2_date)->format('Y-m-d') : '' }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="inspector_3_name" id="inspector_3_name" class="form-control text-center">
                                                        <option value="">-- Pilih Inspektor --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $maintenanceRecord->inspector_3_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="inspector_3_nik" id="inspector_3_nik" class="form-control text-center" value="{{ $maintenanceRecord->inspector_3_nik }}" readonly required>
                                                </td>
                                                <td class="border">
                                                    <input type="date" name="inspector_3_date" class="form-control text-center" value="{{ $maintenanceRecord->inspector_3_date ? \Carbon\Carbon::parse($maintenanceRecord->inspector_3_date)->format('Y-m-d') : '' }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="acknowledged_by_name" id="acknowledged_by_name" class="form-control text-center" required>
                                                        <option value="">-- Pilih Inspektor --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $maintenanceRecord->acknowledged_by_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="acknowledged_by_nik" id="acknowledged_by_nik" class="form-control text-center" value="{{ $maintenanceRecord->acknowledged_by_nik }}" readonly required>
                                                </td>
                                                <td class="border">
                                                    <input type="date" name="acknowledged_date" class="form-control text-center" value="{{ \Carbon\Carbon::parse($maintenanceRecord->acknowledged_date)->format('Y-m-d') }}" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit/Back Buttons -->
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('she.air-minum.dashboard') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" id="submitBtn" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Update Data
                                    </button>
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
    .form-control:disabled {
        background-color: #f8f9fa;
        opacity: 1;
    }
    .form-control[readonly] {
        background-color: #f8f9fa;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .progress-container {
        width: 100%;
        margin-bottom: 20px;
    }
    .progress-badge {
        color: #888;
        font-size: 0.8rem;
        margin-bottom: 5px;
        display: block;
    }
    .progress {
        height: 8px;
        margin-bottom: 5px;
        overflow: hidden;
        background-color: #e9ecef;
        border-radius: 0.25rem;
    }
    .progress-bar {
        height: 8px;
    }
    .progress-value {
        font-size: 0.75rem;
        color: #888;
    }
    .approval-step {
        text-align: center;
        padding: 10px;
        min-width: 120px;
        border-radius: 5px;
        background-color: #f8f9fa;
        margin: 5px;
    }
    .approval-step small {
        color: #6c757d;
    }
    .signature-pad {
        width: 100%;
        height: 150px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }
    .signature-pad canvas {
        width: 100%;
        height: 100%;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Helper function to format dates properly
        function formatDate(dateString) {
            if (!dateString) return '';
            
            // Remove extra colon before AM/PM if present
            dateString = dateString.replace(':AM', ' AM').replace(':PM', ' PM');
            
            try {
                // Try to parse the date
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return ''; // Invalid date
                
                // Format as YYYY-MM-DD for date input
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            } catch (e) {
                console.error('Error parsing date:', e);
                return '';
            }
        }
        
        // Format all date inputs
        $('input[type="date"]').each(function() {
            const originalValue = $(this).val();
            if (originalValue) {
                const formattedDate = formatDate(originalValue);
                $(this).val(formattedDate);
            }
        });
        
        // Initialize datepicker
        if ($.fn.datepicker) {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        }
        
        // Handle inspector selection changes to populate NIK fields
        $('#inspector_1_name').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            $('#inspector_1_nik').val(selectedOption.data('nik'));
        });
        
        $('#inspector_2_name').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            $('#inspector_2_nik').val(selectedOption.data('nik'));
        });
        
        $('#inspector_3_name').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            $('#inspector_3_nik').val(selectedOption.data('nik'));
        });
        
        $('#acknowledged_by_name').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            $('#acknowledged_by_nik').val(selectedOption.data('nik'));
        });
        
        
        // Form submission handling
        const form = $("#airMinumForm");
        const submitBtn = $("#submitBtn");
        
        form.on("submit", function(e) {
            e.preventDefault();
            
            // Disable submit button to prevent multiple submissions
            submitBtn.prop("disabled", true);
            submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
            
            // Convert checkbox values to boolean
            $('input[type="checkbox"]').each(function() {
                const name = $(this).attr('name');
                const isChecked = $(this).is(':checked');
                $(`<input type="hidden" name="${name}" value="${isChecked ? 1 : 0}">`).appendTo(form);
            });
            
            // Submit form via AJAX
            $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: form.serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil diperbarui',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.href = "{{ route('she.air-minum.dashboard') }}";
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan saat memperbarui data',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        submitBtn.prop("disabled", false);
                        submitBtn.html('Simpan');
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Terjadi kesalahan saat memperbarui data';
                    
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        } else if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                    }
                    
                    Swal.fire({
                        title: 'Gagal!',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    
                    submitBtn.prop("disabled", false);
                    submitBtn.html('Simpan');
                }
            });
        });
    });
</script>
<script>
    $(function() {
        $('#inspector_1_name').select2({
            width: '100%',
            placeholder: '-- Pilih Inspektor --',
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
        })
        $('#inspector_2_name').select2({
            width: '100%',
            placeholder: '-- Pilih Inspektor --',
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
        })
        $('#inspector_3_name').select2({
            width: '100%',
            placeholder: '-- Pilih Inspektor --',
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
        })
        $('#acknowledged_by_name').select2({
            width: '100%',
            placeholder: '-- Pilih Mengetahui --',
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
        })
    });
</script>
@endsection
