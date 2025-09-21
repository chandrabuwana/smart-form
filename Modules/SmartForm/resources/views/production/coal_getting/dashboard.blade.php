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
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Dashboard Inspeksi Coal Getting</h6>
                </div>
            </div>
            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card">
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
                    <div class="card">
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
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-map-marker-alt text-info fa-2x"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Locations</p>
                                    <h4 class="mb-0">{{ $statistics->locations_count }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Need Attention</p>
                                    <h4 class="mb-0">{{ $statistics->need_attention }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="card-body px-0 pb-2">
                <div class="d-flex align-items-center mx-3">
                    <a href="{{ route('prod.coal.form') }}">
                        <button class="btn btn-primary ms-auto uploadBtn">
                            New Form
                        </button>
                    </a>
                </div>
                <h4 class="mx-3">Filter Data</h4>
                <div class="mx-4 row">
                    <form action="{{ route('prod.coal.dashboard') }}" method="GET" id="filterForm">
                    <div class="row align-items-center">
                        <div class="col-md-2 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label>Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ $filters['search'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="location" class="ms-0">Location</label>
                                <select class="form-control" id="location" name="location">
                                    <option value="">All Locations</option>
                                    @if(isset($filter_options) && !empty($filter_options->locations))
                                        @foreach($filter_options->locations as $location)
                                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                                {{ $location }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="start_date" class="ms-0">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                    value="{{ $start_date ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="end_date" class="ms-0">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                    value="{{ $end_date ?? '' }}">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Area PIC</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created By</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Inspection Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($records->count() > 0)
                                    @foreach($records as $record)
                                        <tr>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $record->doc_number }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $record->location }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $record->area_pic }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $record->created_by_name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @php
                                                        try {
                                                            $date = new DateTime($record->inspection_date);
                                                            echo $date->format('d M Y');
                                                        } catch (Exception $e) {
                                                            echo $record->inspection_date;
                                                        }
                                                    @endphp
                                                </p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-{{ $record->approval_status === 'need approval' ? 'warning' : ($record->approval_status === 'approved' ? 'info' : 'danger') }}">
                                                    {{ $record->approval_status }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('prod.coal.form', ['id' => $record->id]) }}" class="btn btn-primary btn-sm d-inline-flex align-items-center justify-content-center">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>
                                                @php
                                                    $user = Auth::user();
                                                @endphp
                                                @if($record->approval_status === 'need approval' && trim($record->acknowledged_by_nik) === trim($user->username))
                                                    <button type="button" class="btn btn-success btn-sm d-inline-flex align-items-center justify-content-center" onclick="updateStatus({{ $record->id }}, 'approved')">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center" onclick="updateStatus({{ $record->id }}, 'reject')">
                                                        <i class="fas fa-times me-1"></i> Reject
                                                    </button>
                                                @endif
                                                @if(trim($record->created_by_nik) === trim($user->username) && $record->approval_status === 'need approval')
                                                    <a href="{{ route('prod.coal.form.edit', ['id' => $record->id]) }}" class="btn btn-info btn-sm d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>
                                                    
                                                    <button type="button" class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center btn-delete" data-id="{{ $record->id }}">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No records found</td>
                                    </tr>
                                @endif
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
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
<script>
$(document).ready(function() {
    // Clear filter button
    $('#btnClearFilter').click(function() {
        window.location.href = '{{ route("prod.coal.dashboard") }}';
    });

    // Initialize date pickers
    flatpickr("#start_date", {
        dateFormat: "Y-m-d"
    });
    flatpickr("#end_date", {
        dateFormat: "Y-m-d"
    });
});

function updateStatus(id, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to ${status} this document?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{ route('prod.coal.update-status') }}", {
                id: id,
                status: status
            })
            .then(function (response) {
                if (response.data.success) {
                    Swal.fire('Success!', response.data.message, 'success')
                    .then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error!', response.data.message, 'error');
                }
            })
            .catch(function (error) {
                Swal.fire('Error!', error.response.data.message || 'Something went wrong', 'error');
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle delete button click
    $('.btn-delete').on('click', function() {
        const recordId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be marked as inactive.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send delete request
                axios.post('{{ route("prod.coal.delete") }}', {
                    id: recordId
                })
                .then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.data.message
                        }).then(() => {
                            // Reload the page to reflect changes
                            window.location.reload();
                        });
                    }
                })
                .catch(function(error) {
                    let errorMessage = 'An error occurred while deleting the record';
                    
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
        });
    });
});
</script>
@endsection