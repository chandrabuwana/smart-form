@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }
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
                        <h6 class="text-white text-capitalize ps-3">Dashboard Inspeksi Catering</h6>
                    </div>
                </div>

                <div class="row g-3 m-3 mb-4">
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <i class="fas fa-file text-primary fa-2x"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Total Records</p>
                                        <h4 class="mb-0">{{ isset($records) ? $records->count() : 0 }}</h4>
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
                                        <h4 class="mb-0">{{ $recordsThisMonth ?? 0 }}</h4>
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
                                        <h4 class="mb-0">{{ isset($locations) ? $locations->count() : 0 }}</h4>
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
                                        <h4 class="mb-0">{{ isset($records) ? $records->filter(function($record) {
                                            return isset($record->status) && 
                                                (is_array($record->status) ?
                                                    in_array('rejected', $record->status) :
                                                    (is_string($record->status) && 
                                                        (
                                                            strpos($record->status, 'rejected') !== false ||
                                                            in_array('rejected', json_decode($record->status, true) ?: [])
                                                        )
                                                    )
                                                );
                                        })->count() : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center mx-3 mb-3">
                        <a href="{{ route('bss-form.she-048.form-inspeksi-catering') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                <i class="fas fa-plus"></i> New Form
                            </button>
                        </a>
                    </div>

                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <form action="{{ route('bss-form.she-048.inspeksi-catering.dashboard') }}" method="GET" id="filterForm">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label>Search</label>
                                        <input type="text" name="search" class="form-control" placeholder="Search by site name or location" value="{{ $filters['search'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="work_location" class="ms-0">Lokasi</label>
                                        <select class="form-control" id="work_location" name="work_location">
                                            <option value="">All Locations</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->lokasi_kerja }}" {{ isset($filters['work_location']) && $filters['work_location'] == $location->lokasi_kerja ? 'selected' : '' }}>
                                                    {{ $location->lokasi_kerja }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="start_date" class="ms-0">Tanggal Dibuat</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" 
                                            value="{{ $filters['start_date'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 d-flex justify-content-start">
                                    <button type="submit" class="btn btn-primary filter-btn" id="btnFilterSubmit">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <button type="button" class="btn btn-secondary filter-btn" id="btnClearFilter">
                                        <i class="fas fa-eraser me-1"></i> Clear Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive p-0 mx-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Site Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi Kerja</th>
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
                                                <h6 class="mb-0 text-sm">{{ $loop->iteration }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $record->nama_site }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $record->department }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $record->lokasi_kerja }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @php
                                            $statusClass = 'secondary';
                                            $statusText = 'Pending';
                                            
                                            if (isset($record->status)) {
                                                $statusArray = is_array($record->status) ? $record->status : json_decode($record->status, true);
                                                if (!is_array($statusArray)) {
                                                    $statusArray = [null, null, null];
                                                }
                                                
                                                if (in_array('rejected', $statusArray)) {
                                                    $statusClass = 'danger';
                                                    $statusText = 'Rejected';
                                                } elseif (in_array(null, $statusArray)) {
                                                    if (in_array('approved', $statusArray)) {
                                                        $statusClass = 'info';
                                                        $statusText = 'In Progress';
                                                    }
                                                } elseif (count(array_filter($statusArray, function($s) { return $s === 'approved'; })) === count($statusArray)) {
                                                    $statusClass = 'success';
                                                    $statusText = 'Approved';
                                                }
                                            }
                                        @endphp
                                        <span class="badge bg-gradient-{{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('bss-form.she-048.detail-inspeksi-catering', ['id' => $record->id]) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>

                                        @php
                                            $isApproved = isset($record->status) && is_array($record->status) && 
                                                count(array_filter($record->status, function($s) { return $s === 'approved'; })) === 3;
                                        @endphp

                                        @if($isApproved)
                                        <a href="{{ route('bss-form.she-048.pdf-inspeksi-catering', ['id' => $record->id]) }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-download"></i> Export
                                        </a>
                                        @endif
                                        
                                        @php
                                            $username = session('username');
                                            $user_id = session('user_id');
                                            
                                            // Debug statement to check values
                                            if (isset($record->diinspeksi_oleh_1)) {
                                                // Log::info("Record diinspeksi_oleh_1: " . $record->diinspeksi_oleh_1 . ", User ID: " . $user_id);
                                            }
                                            
                                            $isApproved = isset($record->status) && is_array($record->status) && 
                                                count(array_filter($record->status, function($s) { return $s === 'approved'; })) === 3;
                                            
                                            $isRejected = isset($record->status) && is_array($record->status) && in_array('rejected', $record->status);
                                            
                                            // More permissive condition that uses logical OR instead of checking exact match
                                            $isAdmin = in_array($user_id, ['1008491', '1008492', '1008493', '1008494', '1008526']);
                                            $isCreator = isset($record->diinspeksi_oleh_1) && $record->diinspeksi_oleh_1 == $user_id;
                                            
                                            $canEdit = ($isCreator || $isAdmin) && !$isApproved;
                                        @endphp

                                        @if(!$isApproved)
                                            <a href="{{ route('bss-form.she-048.edit-inspeksi-catering', ['id' => $record->id]) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-danger btn-sm" onclick="deleteInspeksiCatering({{ $record->id }})">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No records found</td>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function deleteInspeksiCatering(id) {
            console.log('Delete function called with ID:', id);
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        html: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    axios.post('{{ route("bss-form.she-048.delete-inspeksi-catering") }}', {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    })
                    .then(function(response) {
                        console.log('Response:', response.data);
                        
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.data.message
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.data.message || 'Terjadi kesalahan saat menghapus data.'
                            });
                        }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        console.error('Error response:', error.response?.data);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus data: ' + 
                                (error.response?.data?.message || error.message || 'Unknown error')
                        });
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#btnClearFilter').click(function() {
                $('#filterForm input[type="text"]').val('');
                $('#filterForm input[type="date"]').val('');
                $('#filterForm select').val('');
                
                $('#filterForm').submit();
            });

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}'
                });
            @endif
        });
    </script>
@endsection