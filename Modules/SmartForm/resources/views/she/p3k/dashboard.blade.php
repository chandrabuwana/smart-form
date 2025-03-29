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
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Inspeksi P3K</h6>
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
                                        <i class="fas fa-medkit text-warning fa-2x"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Need Restock</p>
                                        <h4 class="mb-0">{{ $statistics->need_restock }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center mx-3">
                        <a href="{{ route('she-p3k.form') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <form action="{{ route('she-p3k.dashboard') }}" method="GET" id="filterForm">
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
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}" {{ ($filters['location'] ?? '') == $location ? 'selected' : '' }}>
                                                {{ $location }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static mb-4 position-relative">
                                    <label for="start_date" class="ms-0">Start Date</label>
                                    <input type="text" class="form-control" id="start_date" name="start_date" 
                                        value="{{ $filters['start_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static mb-4 position-relative">
                                    <label for="end_date" class="ms-0">End Date</label>
                                    <input type="text" class="form-control" id="end_date" name="end_date" 
                                        value="{{ $filters['end_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group input-group-static mb-4 position-relative">
                                    <label for="approval_status" class="ms-0">Approval Status</label>
                                    <select class="form-control" id="approval_status" name="approval_status">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ ($filters['approval_status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ ($filters['approval_status'] ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="approved" {{ ($filters['approval_status'] ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ ($filters['approval_status'] ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="inspector_1" {{ ($filters['approval_status'] ?? '') == 'inspector_1' ? 'selected' : '' }}>Inspector 1 Approved</option>
                                        <option value="inspector_2" {{ ($filters['approval_status'] ?? '') == 'inspector_2' ? 'selected' : '' }}>Inspector 2 Approved</option>
                                        <option value="supervisor" {{ ($filters['approval_status'] ?? '') == 'supervisor' ? 'selected' : '' }}>Supervisor Approved</option>
                                        <option value="dh" {{ ($filters['approval_status'] ?? '') == 'dh' ? 'selected' : '' }}>DH Approved</option>
                                    </select>
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Dokumen</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat Oleh</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Approval Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $index => $record)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                  {{ $record->formatted_date }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                  {{ $record->doc_number }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                  {{ $record->location }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                  {{ $record->created_by }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <span class="badge badge-sm bg-gradient-{{ $record->need_restock ? 'warning' : 'success' }}">
                                                    {{ $record->need_restock ? 'Need Restock' : 'Complete' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                @php
                                                    $statusClass = 'secondary';
                                                    switch($record->approval_status) {
                                                        case 'pending':
                                                            $statusClass = 'secondary';
                                                            break;
                                                        case 'in_progress':
                                                            $statusClass = 'info';
                                                            break;
                                                        case 'approved':
                                                            $statusClass = 'success';
                                                            break;
                                                        case 'rejected':
                                                            $statusClass = 'danger';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="badge badge-sm bg-gradient-{{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $record->approval_status)) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('she-p3k.form', ['id' => $record->id]) }}" class="btn btn-primary btn-action text-white">
                                              <i class="fas fa-eye"></i> Detail
                                            </a>
                                            
                                            @if(session('username') && session('username') == $record->created_by)
                                                @if(in_array($record->approval_status, ['pending', 'rejected']))
                                                    <button type="button" class="btn btn-danger btn-action text-white delete-record" data-id="{{ $record->id }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                @endif
                                            @endif
                                            
                                            @if(session('user_id') && in_array(session('user_id'), [$record->inspector_1_nik, $record->inspector_2_nik, $record->supervisor_nik, $record->dh_nik, $record->she_nik]))
                                                @php
                                                    $role = '';
                                                    $canApprove = false;
                                                    
                                                    if(session('user_id') == $record->inspector_1_nik) {
                                                        $role = 'inspector_1';
                                                        $canApprove = true;
                                                    }
                                                    elseif(session('user_id') == $record->inspector_2_nik) {
                                                        $role = 'inspector_2';
                                                        $canApprove = $record->inspector_1_status == 'approved';
                                                    }
                                                    elseif(session('user_id') == $record->supervisor_nik) {
                                                        $role = 'supervisor';
                                                        $canApprove = $record->inspector_1_status == 'approved' && $record->inspector_2_status == 'approved';
                                                    }
                                                    elseif(session('user_id') == $record->dh_nik) {
                                                        $role = 'dh';
                                                        $canApprove = $record->supervisor_status == 'approved';
                                                    }
                                                    elseif(session('user_id') == $record->she_nik) {
                                                        $role = 'she';
                                                        $canApprove = $record->dh_status == 'approved';
                                                    }
                                                @endphp
                                                @if($record->{$role.'_status'} == 'pending' && $canApprove)
                                                <a href="{{ route('she-p3k.approve', ['id' => $record->id, 'role' => $role]) }}" 
                                                   class="btn btn-success btn-action text-white">
                                                  <i class="fas fa-check"></i> Approve
                                                </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mx-3 mt-3">
                            {{ $records->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(function() {
    const filterForm = $('#filterForm');
    const btnFilterSubmit = $('#btnFilterSubmit');
    const btnClearFilter = $('#btnClearFilter');
    
    // Initialize date pickers
    flatpickr("#start_date", {
        dateFormat: "Y-m-d"
    });
    flatpickr("#end_date", {
        dateFormat: "Y-m-d"
    });

    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    // Handle filter submission
    filterForm.on('submit', function(e) {
        e.preventDefault();
        
        // Validate date range before submitting
        var startDate = $('input[name="start_date"]').val();
        var endDate = $('input[name="end_date"]').val();
        
        if (startDate && endDate && startDate > endDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                text: 'End date must be after start date'
            });
            return false;
        }

        // Create URL with only non-empty parameters
        const formData = new FormData(this);
        const params = new URLSearchParams();
        
        for (const [key, value] of formData.entries()) {
            if (value.trim() !== '') {
                params.append(key, value);
            }
        }
        
        // Redirect to the filtered URL
        const baseUrl = '{{ route("she-p3k.dashboard") }}';
        const queryString = params.toString();
        window.location.href = queryString ? `${baseUrl}?${queryString}` : baseUrl;
    });
    
    // Handle clear filter
    btnClearFilter.click(function(e) {
        e.preventDefault();
        $('#start_date').val('');
        $('#end_date').val('');
        $('#location').val('');
        $('#approval_status').val('');
        $('#search').val('');
        // Redirect to the base URL without any parameters
        window.location.href = '{{ route("she-p3k.dashboard") }}';
    });

    // Handle delete button
    $('.delete-record').click(function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        
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
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("she-p3k.delete", ["id" => ":id"]) }}'.replace(':id', id);
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Handle edit button
    $('.btn-edit').click(function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        window.location.href = url;
    });

    // Handle export button
    $('.btn-export').click(function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        window.location.href = url;
    });

    // Date range validation on change
    $('input[name="end_date"]').change(function() {
        var startDate = $('input[name="start_date"]').val();
        var endDate = $(this).val();
        
        if (startDate && endDate && startDate > endDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                text: 'End date must be after start date'
            });
            $(this).val('');
        }
    });

    // Show success message if exists
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // Show error message if exists
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});
</script>
@endsection