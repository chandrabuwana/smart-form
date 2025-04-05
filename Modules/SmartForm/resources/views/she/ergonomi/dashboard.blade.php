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
                    <h6 class="text-white text-capitalize ps-3">Dashboard Ergonomi Assessment</h6>
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
                                    <i class="fas fa-users text-info fa-2x"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Total Employees</p>
                                    <h4 class="mb-0">{{ $statistics->total_employees }}</h4>
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
                    <a href="{{ route('she.ergonomi.form') }}">
                        <button class="btn btn-primary ms-auto uploadBtn">
                            New Form
                        </button>
                    </a>
                </div>
                <h4 class="mx-3">Filter Data</h4>
                <div class="mx-4 row">
                    <form action="{{ route('she.ergonomi.dashboard') }}" method="GET" id="filterForm">
                    <div class="row align-items-center">
                        <div class="col-md-2 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label>Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Search by employee name or job position" value="{{ $filters['search'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="reviewer_name" class="ms-0">Reviewer</label>
                                <select class="form-control" id="reviewer_name" name="reviewer_name">
                                    <option value="">All Reviewers</option>
                                    @foreach($filter_options->reviewers ?? [] as $reviewer)
                                        <option value="{{ $reviewer }}" {{ isset($filters['reviewer_name']) && $filters['reviewer_name'] == $reviewer ? 'selected' : '' }}>
                                            {{ $reviewer }}
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employee Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Job Position</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Reviewer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Employee</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Evaluation Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $record)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $record->employee_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->job_position }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->reviewer_name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->total_employee }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->evaluation_date }}</p>
                                    </td>
                                    <td>
                                        @if($record->approval_status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($record->approval_status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                        
                                        <!-- Detailed approval status tooltip -->
                                        <button type="button" class="btn btn-link btn-sm p-0 ms-1" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-html="true" 
                                                title="<div class='text-start'>
                                                    <strong>Reviewer:</strong> {{ $record->reviewer_status ?? 'pending' }}<br>
                                                    <strong>Paramedic:</strong> {{ $record->paramedic_status ?? 'pending' }}<br>
                                                    <strong>Doctor:</strong> {{ $record->doctor_status ?? 'pending' }}<br>
                                                    <strong>Dept Head:</strong> {{ $record->dept_head_status ?? 'pending' }}
                                                </div>">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route('she.ergonomi.form', ['id' => $record->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Edit button - only show for records that haven't been approved and were created by the current user -->
                                        @if(isset($record->employee_name) && $record->employee_name == session('username') && (!isset($record->approval_status) || $record->approval_status != 'approved'))
                                        <a href="{{ route('she.ergonomi.edit', ['id' => $record->id]) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                        
                                        <!-- Delete button - only show for records that haven't been approved and were created by the current user -->
                                        @if(isset($record->employee_name) && $record->employee_name == session('username') && (!isset($record->approval_status) || $record->approval_status == 'pending' || $record->approval_status == 'rejected'))
                                        <button type="button" class="btn btn-danger btn-sm delete-record" data-id="{{ $record->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                        
                                        <!-- Approval buttons - only show for records that are pending and the current user is an approver -->
                                        @if($record->approval_status != 'approved' && $record->approval_status != 'rejected')
                                            <!-- Reviewer approval button -->
                                            @if(session('user_id') == $record->reviewer_nik && $record->reviewer_status != 'approved')
                                                <button type="button" class="btn btn-success btn-sm approve-btn" data-id="{{ $record->id }}" data-role="reviewer">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm reject-btn" data-id="{{ $record->id }}" data-role="reviewer">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Paramedic approval button -->
                                            @if(session('user_id') == $record->paramedic_nik && $record->paramedic_status != 'approved' && $record->reviewer_status == 'approved')
                                                <button type="button" class="btn btn-success btn-sm approve-btn" data-id="{{ $record->id }}" data-role="paramedic">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm reject-btn" data-id="{{ $record->id }}" data-role="paramedic">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Doctor approval button -->
                                            @if(session('user_id') == $record->doctor_nik && $record->doctor_status != 'approved' && $record->reviewer_status == 'approved' && $record->paramedic_status == 'approved')
                                                <button type="button" class="btn btn-success btn-sm approve-btn" data-id="{{ $record->id }}" data-role="doctor">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm reject-btn" data-id="{{ $record->id }}" data-role="doctor">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- Department Head approval button -->
                                            @if(session('user_id') == $record->dept_head_nik && $record->dept_head_status != 'approved' && $record->reviewer_status == 'approved' && $record->paramedic_status == 'approved' && $record->doctor_status == 'approved')
                                                <button type="button" class="btn btn-success btn-sm approve-btn" data-id="{{ $record->id }}" data-role="dept_head">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm reject-btn" data-id="{{ $record->id }}" data-role="dept_head">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                html: true
            });
        });
        
        // Clear filter functionality
        document.getElementById('btnClearFilter').addEventListener('click', function() {
            window.location.href = '{{ route("she.ergonomi.dashboard") }}';
        });

        // Delete record functionality
        document.querySelectorAll('.delete-record').forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-id');
                
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
                        // Create the delete URL with the record ID
                        const deleteUrl = '{{ url("bss-form/she-ergonomi/delete") }}/' + recordId;
                        
                        // Send delete request
                        fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    // Reload the page
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'There was a problem with the delete operation.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
        
        // Approval and rejection functionality
        document.querySelectorAll('.approve-btn, .reject-btn').forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-id');
                const role = this.getAttribute('data-role');
                const approvalStatus = this.classList.contains('approve-btn') ? 'approved' : 'rejected';
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, ' + (approvalStatus == 'approved' ? 'approve' : 'reject') + ' it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create the approval URL with the record ID and role
                        const approvalUrl = '{{ url("bss-form/she-ergonomi/approve") }}/' + recordId + '/' + role;
                        
                        // Send approval request
                        fetch(approvalUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                approval_status: approvalStatus
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    (approvalStatus == 'approved' ? 'Approved' : 'Rejected') + '!',
                                    data.message,
                                    (approvalStatus == 'approved' ? 'success' : 'error')
                                ).then(() => {
                                    // Reload the page
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'There was a problem with the approval operation.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });
</script>
@endsection