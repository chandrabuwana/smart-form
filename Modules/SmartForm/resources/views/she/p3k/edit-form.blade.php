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
                        <h6 class="text-white text-capitalize ps-3">Edit P3K Inspection Form</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <form id="maintenanceForm" method="POST" action="{{ route('she-p3k.update', ['id' => $record->id]) }}" class="form">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ $record->created_by }}">
                        <div class="mx-3">
                            <!-- Date and Location -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label for="inspection_date">Tanggal Inspeksi</label>
                                        <input type="date" name="inspection_date" id="inspection_date" class="form-control" 
                                            value="{{ date('Y-m-d', strtotime($record->inspection_date)) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label for="location">Lokasi</label>
                                        <input type="text" name="location" id="location" class="form-control" 
                                            value="{{ $record->location }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- P3K Items Table -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="mb-3">Peralatan P3K</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="border" width="5%">No</th>
                                                    <th class="border" width="35%">Nama Peralatan</th>
                                                    <th class="border" width="10%">Standar</th>
                                                    <th class="border" width="10%">Jumlah</th>
                                                    <th class="border" width="10%">Ada</th>
                                                    <th class="border" width="30%">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($p3kItems as $index => $item)
                                                <tr>
                                                    <td class="border text-center">{{ $index + 1 }}</td>
                                                    <td class="border">{{ $item['name'] }}</td>
                                                    <td class="border text-center">{{ $item['qty'] }}</td>
                                                    <td class="border">
                                                        <input type="number" name="qty_{{ $item['id'] }}" class="form-control text-center" 
                                                            value="{{ $record->items_data[$item['id']]['current_qty'] ?? 0 }}" min="0">
                                                    </td>
                                                    <td class="border text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="checkbox" name="stock_{{ $item['id'] }}" 
                                                                {{ isset($record->items_data[$item['id']]['in_stock']) && $record->items_data[$item['id']]['in_stock'] ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" name="notes_{{ $item['id'] }}" class="form-control" 
                                                            value="{{ $record->items_data[$item['id']]['notes'] ?? '' }}">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-warning text-center">
                                        <strong>PASTIKAN SEMUA PERALATAN EMERGENCY TERPENUHI</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Approval Information -->
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
                                                    <select name="inspector_1_name" id="inspector_1_name" class="form-control text-center">
                                                        <option value="">-- Pilih Pengawas --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $record->inspector_1_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="inspector_1_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $record->inspector_1_nik }}" required>
                                                </td>
                                                <td class="border">
                                                    @if(!empty($record->inspector_1_date))
                                                        <input type="date" name="inspector_1_date" class="form-control text-center" 
                                                            value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->inspector_1_date)))) }}" required>
                                                    @else
                                                        <input type="date" name="inspector_1_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}" required>
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    <select name="inspector_1_status" class="form-control">
                                                        <option value="pending" {{ $record->inspector_1_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ $record->inspector_1_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ $record->inspector_1_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
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
                                                    <select name="inspector_2_name" id="inspector_2_name" class="form-control text-center">
                                                        <option value="">-- Pilih Pengawas --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $record->inspector_2_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="inspector_2_nik" id="inspector_2_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $record->inspector_2_nik }}" readonly>
                                                </td>
                                                <td class="border">
                                                    @if(!empty($record->inspector_2_date))
                                                        <input type="date" name="inspector_2_date" class="form-control text-center" 
                                                            value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->inspector_2_date)))) }}">
                                                    @else
                                                        <input type="date" name="inspector_2_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    <select name="inspector_2_status" class="form-control">
                                                        <option value="pending" {{ $record->inspector_2_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ $record->inspector_2_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ $record->inspector_2_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
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
                                                    <select name="supervisor_name" id="supervisor_name" class="form-control text-center">
                                                        <option value="">-- Pilih Supervisor --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $record->supervisor_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="supervisor_nik" id="supervisor_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $record->supervisor_nik }}" readonly>
                                                </td>
                                                <td class="border">
                                                    @if(!empty($record->supervisor_date))
                                                        <input type="date" name="supervisor_date" class="form-control text-center" 
                                                            value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->supervisor_date)))) }}">
                                                    @else
                                                        <input type="date" name="supervisor_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    <select name="supervisor_status" class="form-control">
                                                        <option value="pending" {{ $record->supervisor_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ $record->supervisor_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ $record->supervisor_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
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
                                                    <select name="dh_name" id="dh_name" class="form-control text-center">
                                                        <option value="">-- Pilih Department Head --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $record->dh_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="dh_nik" id="dh_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $record->dh_nik }}" readonly>
                                                </td>
                                                <td class="border">
                                                    @if(!empty($record->dh_date))
                                                        <input type="date" name="dh_date" class="form-control text-center" 
                                                            value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->dh_date)))) }}">
                                                    @else
                                                        <input type="date" name="dh_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    <select name="dh_status" class="form-control">
                                                        <option value="pending" {{ $record->dh_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ $record->dh_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ $record->dh_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
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
                                                    <select name="she_name" id="she_name" class="form-control text-center">
                                                        <option value="">-- Pilih SHE --</option>
                                                        @foreach($approvalList as $user)
                                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $record->she_name == $user->nama ? 'selected' : '' }}>
                                                                {{ $user->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border">
                                                    <input type="text" name="she_nik" id="she_nik" class="form-control text-center" 
                                                    placeholder="NIK"
                                                    value="{{ $record->she_nik }}" readonly>
                                                </td>
                                                <td class="border">
                                                    @if(!empty($record->she_date))
                                                        <input type="date" name="she_date" class="form-control text-center" 
                                                            value="{{ date('Y-m-d', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $record->she_date)))) }}">
                                                    @else
                                                        <input type="date" name="she_date" class="form-control text-center" 
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    @endif
                                                </td>
                                                <td class="border text-center">
                                                    <select name="she_status" class="form-control">
                                                        <option value="pending" {{ $record->she_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ $record->she_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ $record->she_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit/Back Buttons -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="{{ route('she-p3k.dashboard') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update
                                    </button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Handle inspector 2 selection
            document.getElementById('inspector_2_name').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const nikField = document.getElementById('inspector_2_nik');
                
                if (selectedOption.value) {
                    nikField.value = selectedOption.getAttribute('data-nik');
                } else {
                    nikField.value = '';
                }
            });
            
            // Handle supervisor selection
            document.getElementById('supervisor_name').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const nikField = document.getElementById('supervisor_nik');
                
                if (selectedOption.value) {
                    nikField.value = selectedOption.getAttribute('data-nik');
                } else {
                    nikField.value = '';
                }
            });
            
            // Handle DH selection
            document.getElementById('dh_name').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const nikField = document.getElementById('dh_nik');
                
                if (selectedOption.value) {
                    nikField.value = selectedOption.getAttribute('data-nik');
                } else {
                    nikField.value = '';
                }
            });
            
            // Handle SHE selection
            document.getElementById('she_name').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const nikField = document.getElementById('she_nik');
                
                if (selectedOption.value) {
                    nikField.value = selectedOption.getAttribute('data-nik');
                } else {
                    nikField.value = '';
                }
            });
        });
    </script>

<script>
        $(function() {
            $('#inspector_1_name').select2({
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
@endsection
