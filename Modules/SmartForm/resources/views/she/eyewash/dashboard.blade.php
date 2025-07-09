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
                    <h6 class="text-white text-capitalize ps-3">Dashboard Inspeksi Eyewash</h6>
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
                    <a href="{{ route('she-inspeksi.form') }}">
                        <button class="btn btn-primary ms-auto uploadBtn">
                            New Form
                        </button>
                    </a>
                </div>
                <h4 class="mx-3">Filter Data</h4>
                <div class="mx-4 row">
                    <form action="{{ route('she-inspeksi.dashboard') }}" method="GET" id="filterForm">
                    <div class="row align-items-center">
                        <div class="col-md-2 mb-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label>Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ $filters['search'] }}">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Month</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tank Condition</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created By</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($records->count() > 0)
                                    @foreach($records as $record)
                                        @php
                                            $monthlyData = json_decode($record->monthly_data, true);
                                            $currentMonth = array_key_first($monthlyData);
                                            $currentData = $monthlyData[$currentMonth] ?? null;
                                        @endphp
                                        <tr>
                                            <td class="align-middle text-sm">{{ $record->doc_number }}</td>
                                            <td class="align-middle text-sm">{{ $record->location }}</td>
                                            <td class="align-middle text-sm">{{ $currentMonth ?? '-' }}</td>
                                            <td class="align-middle text-sm">
                                                @if($currentData)
                                                    <span class="badge badge-sm bg-{{ $currentData['kondisi_tangki'] == 'Baik' ? 'success' : 'danger' }}">
                                                        {{ $currentData['kondisi_tangki'] }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="align-middle text-sm">
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <i class="fas fa-user text-primary me-2"></i>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $record->created_by ?? 'N/A' }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-sm">{{ $record->formatted_date }}</td>
                                            <td class="align-middle text-sm">
                                                @if($record->approval_status == 'approved')
                                                    <span class="badge badge-sm bg-success">Approved</span>
                                                @elseif($record->approval_status == 'rejected')
                                                    <span class="badge badge-sm bg-danger">Rejected</span>
                                                @elseif($record->approval_status == 'pending')
                                                    <span class="badge badge-sm bg-warning">Pending</span>
                                                @elseif($record->approval_status == 'in_progress')
                                                    <span class="badge badge-sm bg-info">In Progress</span>
                                                    <div class="mt-1">
                                                        @if($record->hygiene_status == 'approved')
                                                            <span class="badge badge-sm bg-success">Hygiene ✓</span>
                                                        @endif
                                                        
                                                        @if($record->supervisor_status == 'approved')
                                                            <span class="badge badge-sm bg-success">Supervisor ✓</span>
                                                        @endif
                                                        
                                                        @if($record->dh_status == 'approved')
                                                            <span class="badge badge-sm bg-success">DH ✓</span>
                                                        @endif
                                                        
                                                        @if($record->hygiene_status == 'pending' && $record->approval_status == 'in_progress')
                                                            <span class="badge badge-sm bg-warning">Awaiting Hygiene</span>
                                                        @elseif($record->supervisor_status == 'pending' && $record->hygiene_status == 'approved')
                                                            <span class="badge badge-sm bg-warning">Awaiting Supervisor</span>
                                                        @elseif($record->dh_status == 'pending' && $record->supervisor_status == 'approved')
                                                            <span class="badge badge-sm bg-warning">Awaiting DH</span>
                                                        @elseif($record->dh_terkait_status == 'pending' && $record->dh_status == 'approved')
                                                            <span class="badge badge-sm bg-warning">Awaiting DH Terkait</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex gap-1">
                                                    <!-- Detail button -->
                                                    <a href="{{ route('she-inspeksi.form', ['id' => $record->id]) }}" class="btn btn-primary btn-sm btn-action text-white">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    
                                                    <!-- Edit button - only for creator and pending/rejected status -->
                                                    @if($record->created_by == $username && ($record->approval_status == 'pending' || $record->approval_status == 'rejected'))
                                                    <a href="{{ route('she-inspeksi.edit', ['id' => $record->id]) }}" class="btn btn-warning btn-sm btn-action text-white">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    @endif
                                                    
                                                    <!-- Delete button - only for creator and pending/rejected status -->
                                                    @if($record->created_by == $username && ($record->approval_status == 'pending' || $record->approval_status == 'rejected'))
                                                    <button type="button" class="btn btn-danger btn-sm btn-action delete-record" data-id="{{ $record->id }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                    @endif
                                                    
                                                    <!-- Export button -->
                                                    <a href="{{ route('she-inspeksi.form.export', ['id' => $record->id]) }}" class="btn btn-info btn-sm btn-action text-white">
                                                        <i class="fas fa-file-export"></i> Export
                                                    </a>
                                                    
                                                    <!-- Approval buttons based on role and status -->
                                                    @if($record->approval_status != 'approved')
                                                        <!-- Hygiene approval - first approval -->
                                                        @if($record->hygiene_status == 'pending' && $record->hygiene_nik == session('user_id'))
                                                            <button type="button" class="btn btn-success btn-sm approve-record" 
                                                                    data-id="{{ $record->id }}" data-role="hygiene">
                                                                <i class="fas fa-check"></i> Approve (Hygiene)
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm reject-record" 
                                                                    data-id="{{ $record->id }}" data-role="hygiene">
                                                                <i class="fas fa-times"></i> Reject
                                                            </button>
                                                        <!-- Supervisor approval - second approval -->
                                                        @elseif($record->hygiene_status == 'approved' && $record->supervisor_status == 'pending' && $record->supervisor_nik == session('user_id'))
                                                            <button type="button" class="btn btn-success btn-sm approve-record" 
                                                                    data-id="{{ $record->id }}" data-role="supervisor">
                                                                <i class="fas fa-check"></i> Approve (Supervisor)
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm reject-record" 
                                                                    data-id="{{ $record->id }}" data-role="supervisor">
                                                                <i class="fas fa-times"></i> Reject
                                                            </button>
                                                        <!-- DH approval - third approval -->
                                                        @elseif($record->supervisor_status == 'approved' && $record->dh_status == 'pending' && $record->dh_nik == session('user_id'))
                                                            <button type="button" class="btn btn-success btn-sm approve-record" 
                                                                    data-id="{{ $record->id }}" data-role="dh">
                                                                <i class="fas fa-check"></i> Approve (DH)
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm reject-record" 
                                                                    data-id="{{ $record->id }}" data-role="dh">
                                                                <i class="fas fa-times"></i> Reject
                                                            </button>
                                                        <!-- DH Terkait approval - final approval -->
                                                        @elseif($record->dh_status == 'approved' && $record->dh_terkait_status == 'pending' && $record->dh_terkait_nik == session('user_id'))
                                                            <button type="button" class="btn btn-success btn-sm approve-record" 
                                                                    data-id="{{ $record->id }}" data-role="dh_terkait">
                                                                <i class="fas fa-check"></i> Approve (DH Terkait)
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm reject-record" 
                                                                    data-id="{{ $record->id }}" data-role="dh_terkait">
                                                                <i class="fas fa-times"></i> Reject
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">No records found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 pt-4">
                        {{ $records->links() }}
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
$(function() {
    const filterForm = $('#filterForm');
    const btnFilterSubmit = $('#btnFilterSubmit');
    const btnClearFilter = $('#btnClearFilter');
    
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
        const baseUrl = '{{ route("she-inspeksi.dashboard") }}';
        const queryString = params.toString();
        window.location.href = queryString ? `${baseUrl}?${queryString}` : baseUrl;
    });
    
    // Handle clear filter
    btnClearFilter.click(function(e) {
        e.preventDefault();
        // Redirect to the base URL without any parameters
        window.location.href = '{{ route("she-inspeksi.dashboard") }}';
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
    
    // Handle delete record
    $('.delete-record').click(function() {
        const recordId = $(this).data('id');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("bss-form/she-inspeksi/delete") }}/' + recordId;
                form.style.display = 'none';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
    
    // Handle approve record
    $('.approve-record').click(function() {
        const recordId = $(this).data('id');
        const role = $(this).data('role');
        
        Swal.fire({
            title: 'Konfirmasi Approval',
            text: "Apakah Anda yakin ingin menyetujui data ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("bss-form/she-inspeksi/approve") }}/' + recordId;
                form.style.display = 'none';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const roleField = document.createElement('input');
                roleField.type = 'hidden';
                roleField.name = 'role';
                roleField.value = role;
                
                form.appendChild(csrfToken);
                form.appendChild(roleField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
    
    // Handle reject record
    $('.reject-record').click(function() {
        const recordId = $(this).data('id');
        const role = $(this).data('role');
        
        Swal.fire({
            title: 'Alasan Penolakan',
            input: 'textarea',
            inputLabel: 'Masukkan alasan penolakan',
            inputPlaceholder: 'Ketik alasan penolakan di sini...',
            inputAttributes: {
                'aria-label': 'Ketik alasan penolakan di sini',
                'required': 'true'
            },
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Tolak',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan penolakan harus diisi!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("bss-form/she-inspeksi/reject") }}/' + recordId;
                form.style.display = 'none';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const roleField = document.createElement('input');
                roleField.type = 'hidden';
                roleField.name = 'role';
                roleField.value = role;
                
                const reasonField = document.createElement('input');
                reasonField.type = 'hidden';
                reasonField.name = 'reason';
                reasonField.value = result.value;
                
                form.appendChild(csrfToken);
                form.appendChild(roleField);
                form.appendChild(reasonField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
</script>
@endsection
