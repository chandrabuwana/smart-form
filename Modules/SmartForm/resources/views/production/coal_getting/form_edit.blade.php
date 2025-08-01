@extends('master.master_page')

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
                        <h6 class="text-white text-capitalize ps-3">Edit Checklist Coal Getting (Zero Contamination)</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <form method="POST" id="inspectionForm" action="{{ route('prod.coal.form.update', ['id' => $record->id]) }}">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label>Tanggal</label>
                                        <input type="date" name="inspection_date" class="form-control" required
                                            value="{{ $record->inspection_date }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label>Lokasi</label>
                                        <input type="text" name="location" class="form-control" required
                                            value="{{ $record->location }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label>Penanggung jawab area</label>
                                        <input type="text" name="area_pic" class="form-control" required
                                            value="{{ $record->area_pic }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Checklist Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 5%; border: 1px solid #dee2e6;">No</th>
                                            <th class="text-center" style="width: 50%; border: 1px solid #dee2e6;">Pemeriksaan</th>
                                            <th class="text-center" colspan="2" style="width: 25%; border: 1px solid #dee2e6;">Kondisi</th>
                                            <th class="text-center" style="width: 20%; border: 1px solid #dee2e6;">Tindakan</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="border: 1px solid #dee2e6;"></th>
                                            <th class="text-center" style="border: 1px solid #dee2e6;">Ya</th>
                                            <th class="text-center" style="border: 1px solid #dee2e6;">Tidak</th>
                                            <th style="border: 1px solid #dee2e6;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($checklistItems as $index => $item)
                                            @if(is_array($item))
                                                <!-- Parent item with subitems -->
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item['title'] }}</td>
                                                    <td colspan="2"></td>
                                                    <td></td>
                                                </tr>
                                                @foreach($item['subitems'] as $subIndex => $subitem)
                                                    <tr>
                                                        <td></td>
                                                        <td style="padding-left: 20px;">{{ $subitem }}</td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="radio" name="checklist[{{ $index }}][{{ $subIndex }}]" value="1" 
                                                                    {{ isset($record->checklist_items[$index][$subIndex]['value']) && $record->checklist_items[$index][$subIndex]['value'] == '1' ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="radio" name="checklist[{{ $index }}][{{ $subIndex }}]" value="0"
                                                                    {{ isset($record->checklist_items[$index][$subIndex]['value']) && $record->checklist_items[$index][$subIndex]['value'] == '0' ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="notes[{{ $index }}][{{ $subIndex }}]" 
                                                                value="{{ isset($record->checklist_items[$index][$subIndex]['notes']) ? $record->checklist_items[$index][$subIndex]['notes'] : '' }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- Regular item -->
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item }}</td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="checklist[{{ $index }}]" value="1"
                                                                {{ isset($record->checklist_items[$index]['value']) && $record->checklist_items[$index]['value'] == '1' ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="checklist[{{ $index }}]" value="0"
                                                                {{ isset($record->checklist_items[$index]['value']) && $record->checklist_items[$index]['value'] == '0' ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="notes[{{ $index }}]"
                                                            value="{{ isset($record->checklist_items[$index]['notes']) ? $record->checklist_items[$index]['notes'] : '' }}">
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Signature Section -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Dibuat oleh</h6>
                                            <div class="mb-3">
                                                <select name="created_by_name" id="created_by_name" class="form-control text-center" required>
                                                    <option value="">-- Pilih Inspektor --</option>
                                                    @foreach($approvalList as $user)
                                                        <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $record->created_by_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }} ({{ $user->nik }})</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="created_by_nik" value="{{ $record->created_by_nik }}">
                                            </div>
                                            <p class="mb-1">Pengawas Lapangan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Diketahui oleh</h6>
                                            
                                            <div class="mb-3">
                                                <select name="acknowledged_by_name" id="acknowledged_by_name" class="form-control text-center" required>
                                                    <option value="">-- Pilih Inspektor --</option>
                                                    @foreach($approvalList as $user)
                                                        <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $record->acknowledged_by_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }} ({{ $user->nik }})</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="acknowledged_by_nik" value="{{ $record->acknowledged_by_nik }}">
                                            </div>
                                            <p class="mb-1">Production Supervisor</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <a href="{{ route('prod.coal.dashboard') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="button" id="submitBtn" class="btn btn-primary">Simpan</button>
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

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endsection

@section('custom-js')
    <script>
    $(function() {
        // Form submission
        $('#submitBtn').click(function() {
            // Disable button to prevent multiple submissions
            $(this).prop('disabled', true);
            
            // Show loading indicator
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we update your data.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Get form data
            var formData = $('#inspectionForm').serialize();
            
            // Send AJAX request
            $.ajax({
                url: $('#inspectionForm').attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Redirect to dashboard
                            window.location.href = "{{ route('prod.coal.dashboard') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        $('#submitBtn').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'An error occurred. Please try again.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = '';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                    $('#submitBtn').prop('disabled', false);
                }
            });
        });
    });
    </script>
    <script>
        $(function() {
            $('#acknowledged_by_name').select2({
                placeholder: '-- Pilih Pengawas --',
                width: '50%',
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
            });
            $('#created_by_name').select2({
                placeholder: '-- Pilih Pengawas --',
                width: '50%',
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
            });
        });
    </script>
@endsection
