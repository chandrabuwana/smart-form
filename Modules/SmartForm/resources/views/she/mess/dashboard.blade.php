@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .stats-card {
        transition: all 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .filter-btn {
        display: inline;
        width: auto;
        margin-right: 8px;
    }
    .badge-ok {
        background-color: #4caf50;
        color: white;
    }
    .badge-not-ok {
        background-color: #f44335;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Dashboard Inspeksi Toilet, Mess dan Kantor</h6>
                </div>
            </div>
            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-file text-primary fa-2x"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Total Records</p>
                                    <h4 class="mb-0">{{ $records->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-calendar text-success fa-2x"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">This Month</p>
                                    <h4 class="mb-0">{{ $records->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-map-marker-alt text-info fa-2x"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Locations</p>
                                    <h4 class="mb-0">{{ $locations->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Issues Found</p>
                                    <h4 class="mb-0">{{ $records->filter(function($record) {
                                        $items = json_decode($record->checklist_items ?? '[]', true);
                                        return collect($items)->contains('condition', 'NOT OK');
                                    })->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body px-0 pb-2">
                <div class="d-flex align-items-center mx-3">
                    <a href="{{ route('she.mess.form') }}">
                        <button class="btn btn-primary ms-auto uploadBtn">
                            <i class="fas fa-plus"></i> New Form
                        </button>
                    </a>
                </div>

                <h4 class="mx-3">Filter Data</h4>
                <div class="mx-4 row">
                    <form action="{{ route('she.mess.dashboard') }}" method="GET" id="filterForm">
                        <div class="row align-items-center">
                            <div class="col-md-2 mb-3">
                                <div class="input-group input-group-static mb-4 position-relative">
                                    <label>Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search by doc number or location" value="{{ $filters['search'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static mb-4 position-relative">
                                    <label for="work_location" class="ms-0">Location</label>
                                    <select class="form-control" id="work_location" name="work_location">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}" {{ isset($filters['work_location']) && $filters['work_location'] == $location ? 'selected' : '' }}>
                                                {{ $location }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static mb-4 position-relative">
                                    <label for="start_date" class="ms-0">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" 
                                        value="{{ $filters['start_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static mb-4 position-relative">
                                    <label for="end_date" class="ms-0">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" 
                                        value="{{ $filters['end_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 d-flex justify-content-start">
                                <button type="submit" class="btn btn-primary filter-btn" id="btnFilterSubmit">
                                    Filter
                                </button>
                                <button type="button" class="btn btn-secondary filter-btn" id="btnClearFilter">
                                    Clear Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Records Table -->
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Dokumen</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Site</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Inspeksi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Persetujuan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $record->doc_number }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary text-xs font-weight-bold">
                                        @if($record->survey_date)
                                            {{ date('d M Y', strtotime($record->survey_date)) }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $record->work_location }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-secondary text-xs font-weight-bold">{{ strtoupper($record->site_name) }}</span>
                                </td>
                                <td class="align-middle">
                                    @php
                                        $items = json_decode($record->checklist_items ?? '[]', true);
                                        $hasIssues = collect($items)->contains('condition', 'NOT OK');
                                    @endphp
                                    <span class="badge {{ $hasIssues ? 'badge-not-ok' : 'badge-ok' }}">
                                        {{ $hasIssues ? 'Issues Found' : 'All OK' }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    @php
                                        $statusClass = 'secondary';
                                        $statusText = 'Pending';
                                        
                                        if ($record->approval_status == 'approved') {
                                            $statusClass = 'success';
                                            $statusText = 'Approved';
                                        } elseif ($record->approval_status == 'rejected') {
                                            $statusClass = 'danger';
                                            $statusText = 'Rejected';
                                        } elseif ($record->approval_status == 'in_progress') {
                                            $statusClass = 'info';
                                            $statusText = 'In Progress';
                                        }
                                    @endphp
                                    <span class="badge bg-gradient-{{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('she.mess.form', ['id' => $record->id]) }}" class="btn btn-primary btn-sm d-inline-flex align-items-center justify-content-center">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                    @if($record->doc_number)
                                    <a href="{{ route('she.mess.export', ['id' => $record->id]) }}" class="btn btn-secondary btn-sm d-inline-flex align-items-center justify-content-center">
                                        <i class="fas fa-download me-1"></i> Export
                                    </a>
                                    @endif
                                    
                                    @php
                                        $username = session('username');
                                        $user_id = session('user_id');
                                    @endphp
                                    
                                    @if($record->approval_status != 'approved')
                                        <!-- Inspector 1 Approval/Rejection Buttons -->
                                        @if($record->inspected_by_status != 'approved' && $record->inspected_by_status != 'rejected' && $record->inspected_by_nik == $user_id)
                                            <a href="{{ route('she.mess.approve', ['id' => $record->id, 'role' => 'inspector1']) }}" 
                                               class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </a>
                                            <a href="{{ route('she.mess.reject', ['id' => $record->id, 'role' => 'inspector1']) }}" 
                                               class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </a>
                                        @endif
                                        
                                        <!-- Inspector 2 Approval/Rejection Buttons -->
                                        @if($record->inspected_by_status == 'approved' && $record->inspected_by2_status != 'approved' && $record->inspected_by2_status != 'rejected' && $record->inspected_by2_nik == $user_id)
                                            <a href="{{ route('she.mess.approve', ['id' => $record->id, 'role' => 'inspector2']) }}" 
                                               class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </a>
                                            <a href="{{ route('she.mess.reject', ['id' => $record->id, 'role' => 'inspector2']) }}" 
                                               class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </a>
                                        @endif
                                        
                                        <!-- Inspector 3 Approval/Rejection Buttons -->
                                        @if($record->inspected_by2_status == 'approved' && $record->inspected_by3_status != 'approved' && $record->inspected_by3_status != 'rejected' && $record->inspected_by3_nik == $user_id)
                                            <a href="{{ route('she.mess.approve', ['id' => $record->id, 'role' => 'inspector3']) }}" 
                                               class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </a>
                                            <a href="{{ route('she.mess.reject', ['id' => $record->id, 'role' => 'inspector3']) }}" 
                                               class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </a>
                                        @endif
                                        
                                        <!-- Acknowledger Approval/Rejection Buttons -->
                                        @if($record->inspected_by3_status == 'approved' && $record->acknowledged_by_status != 'approved' && $record->acknowledged_by_status != 'rejected' && $record->acknowledged_by_nik == $user_id)
                                            <a href="{{ route('she.mess.approve', ['id' => $record->id, 'role' => 'acknowledger']) }}" 
                                               class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </a>
                                            <a href="{{ route('she.mess.reject', ['id' => $record->id, 'role' => 'acknowledger']) }}" 
                                               class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </a>
                                        @endif
                                        
                                        <!-- Delete Button - Only for pending/rejected status -->
                                        @if(($record->approval_status == 'pending' || $record->approval_status == 'rejected') && $record->inspected_by_nik == $user_id)
                                            <button type="button" class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center delete-record" 
                                                    data-id="{{ $record->id }}">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                            
                                            <!-- Edit Button - Only for pending/rejected status -->
                                            <a href="{{ route('she.mess.form.edit', ['id' => $record->id]) }}" 
                                               class="btn btn-warning btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize date pickers
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
    });

    // Clear filter functionality
    $('#btnClearFilter').click(function() {
        // Clear all form inputs
        $('#filterForm input[type="text"]').val('');
        $('#filterForm input[type="date"]').val('');
        $('#filterForm select').val('');
        
        // Submit the form
        $('#filterForm').submit();
    });

    // Show success message if exists
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    // Show error message if exists
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}'
        });
    @endif

    // Handle delete record button click
    $('.delete-record').on('click', function() {
        const recordId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send delete request
                $.ajax({
                    url: "{{ route('she.mess.delete') }}",
                    type: 'DELETE',
                    data: {
                        id: recordId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Record has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message || 'Failed to delete record.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the record.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@endsection