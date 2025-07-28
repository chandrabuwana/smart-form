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
                    @if($isShowDetail)
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
                    @endif
                    <form action="{{ route('she.air-minum.store') }}" method="POST" id="airMinumForm">
                        @csrf
                        @if($isShowDetail)
                        <!-- Export and Back buttons for detail view -->
                        <div class="row mb-3">
                            <div class="col-12 text-end">
                                <a href="{{ route('she.air-minum.dashboard') }}" class="btn btn-secondary">Back</a>
                                @if($isShowDetail && isset($record->approval_status) && $record->approval_status == 'approved')
                                    <a href="{{ route('she.air-minum.export', $maintenanceRecord->id) }}" class="btn btn-primary">
                                        <i class="fas fa-file-export"></i> Export
                                    </a>
                                @endif
                            </div>
                        </div>
                        <fieldset disabled>
                        @endif
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site_name" class="ms-0">Nama Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site_name', $maintenanceRecord->site_name ?? null, $isShowDetail, true, 'site_name', 'form-control') !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Dept./Section</label>
                                        {!! \Modules\SmartForm\helpers\DepartmentHelper::renderDepartmentSelect(
                                            'department',
                                            $maintenanceRecord->department ?? '',
                                            $isShowDetail,
                                            true,
                                            'department',
                                            'form-control'
                                        ) !!}
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
                                            <td class="border text-center">{{ $index + 1 }}</td>
                                            <td class="border">{{ $item['label'] }}</td>
                                            <td class="text-center border">
                                                <div class="form-check d-inline">
                                                    <input class="form-check-input" type="radio" 
                                                        name="{{ $item['name'] }}" value="1" 
                                                        {{ $isShowDetail && $maintenanceRecord->{$item['name']} ? 'checked' : '' }}
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                            <td class="text-center border">
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
                                                    <select name="inspector_1_name" id="inspector_1_name" class="form-control text-center select2" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }} required>
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
                                                        <select name="inspector_1_status" class="form-control text-center" disabled>
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
                                                    <select name="inspector_2_name" id="inspector_2_name" class="form-control text-center select2" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
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
                                                        <select name="inspector_2_status" class="form-control text-center" disabled>
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
                                                    <select name="inspector_3_name" id="inspector_3_name" class="form-control text-center select2" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
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
                                                        <select name="inspector_3_status" class="form-control text-center" disabled>
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
                                                    <select name="acknowledged_by_name" id="acknowledged_by_name" class="form-control text-center select2" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
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
                                                        <select name="acknowledged_status" class="form-control text-center" disabled>
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
                                        <!-- Buttons moved to top of form -->
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
                        @if($isShowDetail)
                        </fieldset>
                        @endif
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
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
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
    
    // Handle inspector selection
    $('#inspector_1_name').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var nik = selectedOption.data('nik');
        $('#inspector_1_nik').val(nik);
    });
    
    $('#inspector_2_name').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var nik = selectedOption.data('nik');
        $('#inspector_2_nik').val(nik);
    });
    
    $('#inspector_3_name').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var nik = selectedOption.data('nik');
        $('#inspector_3_nik').val(nik);
    });
    
    $('#acknowledged_by_name').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var nik = selectedOption.data('nik');
        $('#acknowledged_by_nik').val(nik);
    });
    
    // Only set up form submission if not in detail view
    @if(!$isShowDetail)
    // Handle form submission
    var form = $('#airMinumForm');
    var submitBtn = form.find('button[type="submit"]');
    
    form.on("submit", function(e) {
        e.preventDefault();
        
        // Disable the submit button to prevent multiple submissions
        submitBtn.prop("disabled", true);
        
        // Collect form data
        var formData = $(this).serialize();
        
        // Submit form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        window.location.href = "{{ route('she.air-minum.dashboard') }}";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    });
                    submitBtn.prop("disabled", false);
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = 'An error occurred while submitting the form.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorList = '<ul>';
                    $.each(errors, function(key, value) {
                        errorList += '<li>' + value + '</li>';
                    });
                    errorList += '</ul>';
                    errorMessage += errorList;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessage,
                    confirmButtonColor: '#3085d6'
                });
                
                submitBtn.prop("disabled", false);
            }
        });
    });
    @endif
    
    // Initialize Select2
    $(function() {
        $('#inspector_1_name, #inspector_2_name, #inspector_3_name, #acknowledged_by_name').select2({
            placeholder: '-- Pilih Nama --',
            width: '100%'
        });
    });
});
</script>
@endsection