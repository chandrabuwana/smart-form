@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        .table th {
            background-color: #4472C4;
            color: white;
        }
        .notes {
            font-size: 0.875rem;
        }
    </style>
@endsection

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

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                <span class="alert-icon align-middle"><i class="fas fa-exclamation-circle"></i></span>
                <span class="alert-text">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
            </div>
            @endif

            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Inspeksi P3K</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    @if($isShowDetail && isset($record->approval_status))
                    <div class="mx-3 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <h5 class="mb-0">Status Persetujuan</h5>
                                @php
                                    $statusClass = 'secondary';
                                    $statusText = 'Pending';
                                    
                                    switch($record->approval_status) {
                                        case 'pending':
                                            $statusClass = 'secondary';
                                            $statusText = 'Menunggu Persetujuan';
                                            break;
                                        case 'in_progress':
                                            $statusClass = 'info';
                                            $statusText = 'Dalam Proses Persetujuan';
                                            break;
                                        case 'approved':
                                            $statusClass = 'success';
                                            $statusText = 'Disetujui';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'danger';
                                            $statusText = 'Ditolak';
                                            break;
                                    }
                                @endphp
                                <div class="alert alert-{{ $statusClass }} text-white mt-3">
                                    <strong>{{ $statusText }}</strong>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="badge bg-{{ $record->inspector_1_status == 'approved' ? 'success' : ($record->inspector_1_status == 'rejected' ? 'danger' : 'secondary') }} p-2">
                                                    <i class="fas fa-{{ $record->inspector_1_status == 'approved' ? 'check' : ($record->inspector_1_status == 'rejected' ? 'times' : 'clock') }}"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Pengawas 1</h6>
                                                <p class="text-sm mb-0">{{ $record->inspector_1_name ?: 'Belum diisi' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="badge bg-{{ $record->inspector_2_status == 'approved' ? 'success' : ($record->inspector_2_status == 'rejected' ? 'danger' : 'secondary') }} p-2">
                                                    <i class="fas fa-{{ $record->inspector_2_status == 'approved' ? 'check' : ($record->inspector_2_status == 'rejected' ? 'times' : 'clock') }}"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Pengawas 2</h6>
                                                <p class="text-sm mb-0">{{ $record->inspector_2_name ?: 'Belum diisi' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="badge bg-{{ $record->supervisor_status == 'approved' ? 'success' : ($record->supervisor_status == 'rejected' ? 'danger' : 'secondary') }} p-2">
                                                    <i class="fas fa-{{ $record->supervisor_status == 'approved' ? 'check' : ($record->supervisor_status == 'rejected' ? 'times' : 'clock') }}"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Supervisor</h6>
                                                <p class="text-sm mb-0">{{ $record->supervisor_name ?: 'Belum diisi' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="badge bg-{{ $record->dh_status == 'approved' ? 'success' : ($record->dh_status == 'rejected' ? 'danger' : 'secondary') }} p-2">
                                                    <i class="fas fa-{{ $record->dh_status == 'approved' ? 'check' : ($record->dh_status == 'rejected' ? 'times' : 'clock') }}"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Department Head</h6>
                                                <p class="text-sm mb-0">{{ $record->dh_name ?: 'Belum diisi' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="badge bg-{{ $record->she_status == 'approved' ? 'success' : ($record->she_status == 'rejected' ? 'danger' : 'secondary') }} p-2">
                                                    <i class="fas fa-{{ $record->she_status == 'approved' ? 'check' : ($record->she_status == 'rejected' ? 'times' : 'clock') }}"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">SHE</h6>
                                                <p class="text-sm mb-0">{{ $record->she_name ?: 'Belum diisi' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <form id="maintenanceForm" method="POST" action="{{ route('she-p3k.submit') }}" class="form">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ session('username') }}">
                        <div class="mx-3">
                            <!-- Date and Location -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Tanggal</label>
                                        <input type="date" name="inspection_date" class="form-control" required
                                            value="{{ $isShowDetail ? $record->inspection_date : now()->format('Y-m-d') }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Lokasi P3K</label>
                                        <input type="text" name="location" class="form-control" required
                                            value="{{ $isShowDetail ? $record->location : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <!-- Items Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center bg-secondary">No</th>
                                            <th class="text-center bg-secondary">Item P3K</th>
                                            <th class="text-center bg-secondary">Qty</th>
                                            <th class="text-center bg-secondary">Sisa</th>
                                            <th class="text-center bg-secondary">Keterangan</th>
                                            <th class="text-center bg-secondary" colspan="2">Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($p3kItems as $index => $item)
                                            @php
                                                $itemData = $isShowDetail ? ($record->items_data[$item['id']] ?? null) : null;
                                            @endphp
                                            <tr>
                                                <td class="text-center align-middle">{{ $index + 1 }}</td>
                                                <td class="align-middle">{{ $item['name'] }}</td>
                                                <td class="text-center align-middle">{{ $item['qty'] }}</td>
                                                <td class="align-middle">
                                                    <input type="number" name="qty_{{ $item['id'] }}" class="form-control"
                                                        value="{{ $itemData ? $itemData['current_qty'] : 0 }}"
                                                        min="0" 
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                                <td class="align-middle">
                                                    <input type="text" name="notes_{{ $item['id'] }}" class="form-control"
                                                        value="{{ $itemData ? $itemData['notes'] : '' }}"
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                                <td class="text-center align-middle" colspan="2">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="stock_{{ $item['id'] }}" class="form-check-input"
                                                            {{ $itemData && $itemData['in_stock'] ? 'checked' : '' }}
                                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-warning text-center">
                                        <strong>PASTIKAN SEMUA PERALATAN EMERGENCY TERPENUHI</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Signatures -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr class="text-center">
                                                <th class="border">Dibuat Oleh Pengawas 1</th>
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
                                                    value="{{ $isShowDetail ? $record->inspector_1_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($record->inspector_1_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->inspector_1_date)))) }}" disabled>
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
                                                        <span class="badge bg-{{ $record->inspector_1_status == 'approved' ? 'success' : ($record->inspector_1_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($record->inspector_1_status) }}
                                                        </span>
                                                    @else
                                                        <select name="inspector_1_status" class="form-control" disabled>
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Dibuat Oleh Pengawas 2</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="inspector_2_name" id="inspector_2_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
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
                                                    value="{{ $isShowDetail ? $record->inspector_2_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($record->inspector_2_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->inspector_2_date)))) }}" disabled>
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
                                                        <span class="badge bg-{{ $record->inspector_2_status == 'approved' ? 'success' : ($record->inspector_2_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($record->inspector_2_status) }}
                                                        </span>
                                                    @else
                                                        <select name="inspector_2_status" class="form-control" disabled>
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Diperiksa Oleh Supervisor</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="supervisor_name" id="supervisor_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Supervisor --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->supervisor_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="supervisor_nik" id="supervisor_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $record->supervisor_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($record->supervisor_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->supervisor_date)))) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="supervisor_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $record->supervisor_status == 'approved' ? 'success' : ($record->supervisor_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($record->supervisor_status) }}
                                                        </span>
                                                    @else
                                                        <select name="supervisor_status" class="form-control" disabled>
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Disetujui Oleh Department Head</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="dh_name" id="dh_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Department Head --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->dh_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="dh_nik" id="dh_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $record->dh_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($record->dh_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->dh_date)))) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="dh_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $record->dh_status == 'approved' ? 'success' : ($record->dh_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($record->dh_status) }}
                                                        </span>
                                                    @else
                                                        <select name="dh_status" class="form-control" disabled>
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Disetujui Oleh SHE</th>
                                                <th class="border">NIK</th>
                                                <th class="border">Tanggal</th>
                                                <th class="border">Status</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="she_name" id="she_name" class="form-control text-center" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">-- Pilih SHE --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $maintenanceRecord->she_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="she_nik" id="she_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $isShowDetail ? $record->she_nik : '' }}"
                                                    {{ $isShowDetail ? 'disabled' : '' }} readonly>
                                                </td>
                                                <td class="border">
                                                    @if($isShowDetail)
                                                        @if(!empty($record->she_date))
                                                            <input type="text" class="form-control text-center" value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->she_date)))) }}" disabled>
                                                        @else
                                                            <input type="text" class="form-control text-center" value="" disabled>
                                                        @endif
                                                    @else
                                                        <input type="date" name="she_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    @if($isShowDetail)
                                                        <span class="badge bg-{{ $record->she_status == 'approved' ? 'success' : ($record->she_status == 'rejected' ? 'danger' : 'secondary') }}">
                                                            {{ ucfirst($record->she_status) }}
                                                        </span>
                                                    @else
                                                        <select name="she_status" class="form-control" disabled>
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
                                    @if($isShowDetail && isset($record->approval_status) && $record->approval_status == 'approved')
                                        <a href="{{ route('she-p3k.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('she-p3k.export', $record->id) }}" class="btn btn-primary">
                                            <i class="fas fa-file-export"></i> Export
                                        </a>
                                    @else
                                        <div class="row mt-4">
                                            <div class="col-12 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <a href="{{ route('she-p3k.dashboard') }}" class="btn btn-secondary">Back</a>
                                                </div>
                                                @if(!$isShowDetail)
                                                    <div>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
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

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('#inspector_2_name').select2({
                placeholder: '-- Pilih Pengawas --',
                width: '100%',
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
            $('#supervisor_name').select2({
                placeholder: '-- Pilih Supervisor --',
                width: '100%',
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
            $('#dh_name').select2({
                placeholder: '-- Pilih DH --',
                width: '100%',
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
            $('#she_name').select2({
                placeholder: '-- Pilih Pengawas --',
                width: '100%',
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
    <script>
    $(function() {
        var form = $("#maintenanceForm");
        var submitBtn = form.find('button[type="submit"]');

        form.submit(function(e) {
            e.preventDefault();
            submitBtn.prop('disabled', true);

            var formData = new FormData(this);
            
            axios.post('{{ route("she-p3k.submit") }}', formData)
                .then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("she-p3k.dashboard") }}';
                            }
                        });
                    }
                })
                .catch(function(error) {
                    let errorMessage = 'Terjadi kesalahan pada sistem';
                    
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
                })
                .finally(function() {
                    submitBtn.prop('disabled', false);
                });
        });

        $('#inspector_2_name').on('change', function() {
            var nik = $(this).find('option:selected').data('nik');
            $('#inspector_2_nik').val(nik);
        });

        $('#supervisor_name').on('change', function() {
            var nik = $(this).find('option:selected').data('nik');
            $('#supervisor_nik').val(nik);
        });

        $('#dh_name').on('change', function() {
            var nik = $(this).find('option:selected').data('nik');
            $('#dh_nik').val(nik);
        });

        $('#she_name').on('change', function() {
            var nik = $(this).find('option:selected').data('nik');
            $('#she_nik').val(nik);
        });
        $('#inspector_1_name').on('change', function() {
            var nik = $(this).find('option:selected').data('nik');
            $('#inspector_1_nik').val(nik);
        });
    });

     // Initialize Select2
     $(function() {
        $('#inspector_1_name, #inspector_2_name, #supervisor_name, #dh_name, #she_name').select2({
            placeholder: '-- Pilih Nama --',
            width: '100%'
        });
    });
    </script>
@endsection
