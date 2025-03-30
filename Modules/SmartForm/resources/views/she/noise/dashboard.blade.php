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
    .badge-above-nab {
        background-color: #f44335;
        color: white;
    }
    .badge-below-nab {
        background-color: #4caf50;
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
                    <h6 class="text-white text-capitalize ps-3">Dashboard Inspeksi Kebisingan</h6>
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
                                    <h4 class="mb-0">{{ $statistics->total_records }}</h4>
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
                                    <h4 class="mb-0">{{ $statistics->total_this_month }}</h4>
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
                                    <h4 class="mb-0">{{ count($filter_options->locations) }}</h4>
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
                                    <p class="text-sm mb-0 text-capitalize">High Risk</p>
                                    <h4 class="mb-0">{{ $statistics->high_risk_count }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="card-body px-0 pb-2">
                <div class="d-flex align-items-center mx-3">
                    <a href="{{ route('she.noise.form') }}">
                        <button class="btn btn-primary ms-auto uploadBtn">
                            New Form
                        </button>
                    </a>
                </div>
                <h4 class="mx-3">Filter Data</h4>
                <div class="mx-4 row">
                    <form action="{{ route('she.noise.dashboard') }}" method="GET" id="filterForm">
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
                                    @foreach($filter_options->locations as $location)
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
            </div>

            <!-- Data Table -->
            <div class="card">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Doc Number</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Location</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Inspector</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Risk Level</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status Approval</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $record)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $record->doc_number }}</h6>
                                                <!-- Debug info - remove after fixing -->
                                                @if(isset($record->inspected_by_nik))
                                                <small class="text-muted">NIK: {{ $record->inspected_by_nik }}</small>
                                                @else
                                                <small class="text-danger">inspected_by_nik not set</small>
                                                @endif
                                                @if(isset($user->userid))
                                                <small class="text-muted">User: {{ $user->userid }}</small>
                                                @else
                                                <small class="text-danger">user->userid not set</small>
                                                @endif
                                                <!-- End debug info -->
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->work_location }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->inspected_by_name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->risk_level ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        @php
                                            $activities = json_decode($record->activities);
                                            $hasAboveNAB = false;
                                            foreach ($activities as $activity) {
                                                if ($activity->status === 'above_nab') {
                                                    $hasAboveNAB = true;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <span class="badge {{ $hasAboveNAB ? 'badge-above-nab' : 'badge-below-nab' }}">
                                            {{ $hasAboveNAB ? 'Above NAB' : 'Below NAB' }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->formatted_date }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-{{ $record->approval_status === 'need approval' ? 'warning' : ($record->approval_status === 'approved' ? 'info' : 'danger') }}">
                                            {{ $record->approval_status }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('she.noise.view', ['id' => $record->id]) }}" class="btn btn-primary btn-sm d-inline-flex align-items-center justify-content-center">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        @php
                                            $user = Auth::user();
                                        @endphp
                                        @if($record->approval_status === 'need approval' && trim($record->acknowledged_by_nik) === trim($user->userid))
                                            <button type="button" class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center" onclick="updateStatus({{ $record->id }}, 'approved')">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center" onclick="updateStatus({{ $record->id }}, 'reject')">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        @endif
                                        @if($record->approval_status === 'reject' && isset($record->inspected_by_nik) && isset($user->userid) && trim($record->inspected_by_nik) === trim($user->userid))
                                            <a href="{{ route('she.noise.edit', ['id' => $record->id]) }}" class="btn btn-info btn-sm d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a> 
                                        @endif
                                        @if(isset($record->inspected_by_nik) && isset($user->userid) && trim($record->inspected_by_nik) === trim($user->userid))
                                        <button type="button" class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center btn-delete" data-id="{{ $record->id }}">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>  
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    // Clear filter button
    $('#btnClearFilter').click(function() {
        window.location.href = '{{ route("she.noise.dashboard") }}';
    });

    // Date range validation
    $('#start_date, #end_date').change(function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        if (startDate && endDate && startDate > endDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                text: 'End date must be after start date'
            });
            $(this).val('');
        }
    });
    
    // Delete button click handler
    $('.btn-delete').click(function() {
        var recordId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be deleted and cannot be recovered!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send delete request
                $.ajax({
                    url: '{{ route("she.noise.delete", ["id" => ":id"]) }}'.replace(':id', recordId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success'
                            }).then(() => {
                                // Reload the page to refresh the table
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to delete record',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        var message = 'An error occurred while deleting the record.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: message,
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

// Function to update approval status
function updateStatus(id, status) {
    const statusText = status === 'approved' ? 'approve' : 'reject';
    
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to ${statusText} this record?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: status === 'approved' ? '#28a745' : '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: `Yes, ${statusText} it!`
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("she.noise.update.status") }}',
                type: 'POST',
                data: {
                    id: id,
                    status: status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message || `Failed to ${statusText} record`,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    var message = `An error occurred while updating the record.`;
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: message,
                        icon: 'error'
                    });
                }
            });
        }
    });
}
</script>
@endsection