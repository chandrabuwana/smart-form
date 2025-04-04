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
                    <h6 class="text-white text-capitalize ps-3">Dashboard Inspeksi Air Minum</h6>
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
                                    <h4 class="mb-0">{{ $statistics->locations_count }}</h4>
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
                    <a href="{{ route('she.air-minum.form') }}">
                        <button class="btn btn-primary ms-auto uploadBtn">
                            New Form
                        </button>
                    </a>
                </div>
                <h4 class="mx-3">Filter Data</h4>
                <div class="mx-4 row">
                    <form action="{{ route('she.air-minum.dashboard') }}" method="GET" id="filterForm">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Score</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Conclusion</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
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
                                                <h6 class="mb-0 text-sm">{{ $record->doc_number }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->work_location }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->inspector_1_name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->score }}/9</p>
                                    </td>
                                    <td>
                                        @php
                                            $conclusionClass = match($record->conclusion) {
                                                'Excellent' => 'bg-info',
                                                'Good' => 'bg-success',
                                                'Poor' => 'bg-warning',
                                                'Very Poor' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $conclusionClass }}">{{ $record->conclusion }}</span>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->formatted_date }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                @php
                                                    $statusClass = 'bg-secondary';
                                                    $statusText = 'Pending';
                                                    
                                                    if ($record->approval_status == 'approved') {
                                                        $statusClass = 'bg-success';
                                                        $statusText = 'Approved';
                                                    } elseif ($record->approval_status == 'rejected') {
                                                        $statusClass = 'bg-danger';
                                                        $statusText = 'Rejected';
                                                    } elseif ($record->approval_status == 'in_progress') {
                                                        $statusClass = 'bg-info';
                                                        $statusText = 'In Progress';
                                                    }
                                                @endphp
                                                <span class="badge badge-sm {{ $statusClass }}">{{ $statusText }}</span>
                                                
                                                <div class="mt-1">
                                                    @if($record->inspector_1_status == 'approved')
                                                        <span class="badge badge-sm bg-gradient-success">Inspector 1</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-secondary">Inspector 1</span>
                                                    @endif
                                                    
                                                    @if($record->inspector_2_status == 'approved')
                                                        <span class="badge badge-sm bg-gradient-success">Inspector 2</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-secondary">Inspector 2</span>
                                                    @endif
                                                    
                                                    @if($record->inspector_3_status == 'approved')
                                                        <span class="badge badge-sm bg-gradient-success">Inspector 3</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-secondary">Inspector 3</span>
                                                    @endif
                                                    
                                                    @if($record->acknowledged_status == 'approved')
                                                        <span class="badge badge-sm bg-gradient-success">Acknowledged</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-secondary">Acknowledged</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('she.air-minum.form', ['id' => $record->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Edit button - only show for records with pending or rejected status -->
                                        @if($record->approval_status == 'pending' || $record->approval_status == 'rejected')
                                        <a href="{{ route('she.air-minum.form', ['id' => $record->id, 'edit' => true]) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                        
                                        <!-- Delete button - only show for records with pending or rejected status and created by current user -->
                                        @if(session('username') && ($record->approval_status == 'pending' || $record->approval_status == 'rejected'))
                                        <button type="button" class="btn btn-danger btn-sm delete-record" data-id="{{ $record->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                        
                                        <!-- Approval buttons - only show for users who are assigned as inspectors or acknowledger -->
                                        @if(session('user_id') && in_array(session('user_id'), [$record->inspector_1_nik, $record->inspector_2_nik, $record->inspector_3_nik, $record->acknowledged_by_nik]))
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
                                                elseif(session('user_id') == $record->inspector_3_nik) {
                                                    $role = 'inspector_3';
                                                    $canApprove = $record->inspector_1_status == 'approved' && $record->inspector_2_status == 'approved';
                                                }
                                                elseif(session('user_id') == $record->acknowledged_by_nik) {
                                                    $role = 'acknowledged_by';
                                                    $canApprove = $record->inspector_1_status == 'approved' && 
                                                                 $record->inspector_2_status == 'approved' && 
                                                                 $record->inspector_3_status == 'approved';
                                                }
                                            @endphp
                                            @if($record->{$role.'_status'} == 'pending' && $canApprove)
                                            <a href="{{ route('she.air-minum.approve', ['id' => $record->id, 'role' => $role]) }}" 
                                               class="btn btn-success btn-sm text-white">
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
        // Handle delete button click
        $('.delete-record').on('click', function() {
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
                    // Send delete request
                    $.ajax({
                        url: "{{ route('she.air-minum.delete', '') }}/" + recordId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    // Reload page
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan pada sistem';
                            
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                title: 'Gagal!',
                                text: errorMessage,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
        
        // Clear filter button
        $('#btnClearFilter').on('click', function() {
            $('input[name="search"]').val('');
            $('select[name="work_location"]').val('');
            $('input[name="start_date"]').val('');
            $('input[name="end_date"]').val('');
            $('#filterForm').submit();
        });
    });
</script>
@endsection