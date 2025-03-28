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
                    <form id="maintenanceForm" method="POST" action="{{ route('she-p3k.submit') }}" class="form">
                        @csrf
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
                                                <th class="border">Dibuat Oleh Pengawas</th>
                                                <th class="border">Tanda Tangan</th>
                                                <th class="border">Tanggal</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="created_by" class="form-control text-center" required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Pengawas --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" {{ $isShowDetail && $record->created_by == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }} ({{ $user->nik }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center border">
                                                    <div class="form-check d-inline">
                                                        <input class="form-check-input" type="checkbox" 
                                                            name="inspector_1_signature" value="1"
                                                            {{ $isShowDetail && $record->inspector_1_signature ? 'checked' : '' }}
                                                            {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                    </div>
                                                </td>
                                                <td class="border">
                                                    <input type="date" name="inspection_date" class="form-control text-center" 
                                                        value="{{ $isShowDetail ? $record->inspection_date : now()->format('Y-m-d') }}"
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Dibuat Oleh Pengawas</th>
                                                <th class="border">Tanda Tangan</th>
                                                <th class="border">Tanggal</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="inspector_2" class="form-control text-center" required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Pengawas --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" {{ $isShowDetail && $record->inspector_1 == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }} ({{ $user->nik }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center border">
                                                    <div class="form-check d-inline">
                                                        <input class="form-check-input" type="checkbox" 
                                                            name="inspector_2_signature" value="1"
                                                            {{ $isShowDetail && $record->inspector_2_signature ? 'checked' : '' }}
                                                            {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                    </div>
                                                </td>
                                                <td class="border">
                                                    <input type="date" name="inspector_2_date" class="form-control text-center" 
                                                        value="{{ $isShowDetail ? $record->inspector_2_date : now()->format('Y-m-d') }}"
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="border">Diperiksa Oleh Supervisor</th>
                                                <th class="border">Tanda Tangan</th>
                                                <th class="border">Tanggal</th>
                                            </tr>
                                            <tr>
                                                <td class="border">
                                                    <select name="acknowledged_by" class="form-control text-center" required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Supervisor --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" {{ $isShowDetail && $maintenanceRecord->acknowledged_by == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }} ({{ $user->nik }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border text-center">
                                                    <div class="form-check d-inline">
                                                        <input class="form-check-input" type="checkbox" 
                                                            name="acknowledged_by_signature" value="1"
                                                            {{ $isShowDetail && $record->acknowledged_by_signature ? 'checked' : '' }}
                                                            {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                    </div>
                                                </td>
                                                <td class="border">
                                                    <input type="date" name="acknowledged_date" class="form-control text-center" 
                                                        value="{{ $isShowDetail ? $record->acknowledged_date : now()->format('Y-m-d') }}"
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
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
                                            <div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
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
    });
    </script>
@endsection
