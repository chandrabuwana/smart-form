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
                        <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Checklist Coal Getting (Zero Contamination)</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <form method="POST" id="inspectionForm" action="{{ route('prod.coal.store') }}">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label>Tanggal</label>
                                        <input type="date" name="inspection_date" class="form-control" required
                                            value="{{ $isShowDetail ? $record->inspection_date : now()->format('Y-m-d') }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label>Lokasi</label>
                                        <input type="text" name="location" class="form-control" required
                                            value="{{ $isShowDetail ? $record->location : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label>Penanggung jawab area</label>
                                        <input type="text" name="area_pic" class="form-control" required
                                            value="{{ $isShowDetail ? $record->area_pic : session('username') }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
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
                                                    <td class="text-center border">{{ $index + 1 }}</td>
                                                    <td class="border">{{ $item['title'] }}</td>
                                                    <td colspan="2"></td>
                                                    <td></td>
                                                </tr>
                                                @foreach($item['subitems'] as $subIndex => $subitem)
                                                    <tr>
                                                        <td class="border"></td>
                                                        <td style="padding-left: 20px;" class="border">{{ $subitem }}</td>
                                                        <td class="text-center border">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="radio" name="checklist[{{ $index }}][{{ $subIndex }}]" value="1" 
                                                                    {{ isset($record->checklist_items[$index][$subIndex]['value']) && $record->checklist_items[$index][$subIndex]['value'] == '1' ? 'checked' : '' }}
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td class="text-center border">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="radio" name="checklist[{{ $index }}][{{ $subIndex }}]" value="0"
                                                                    {{ isset($record->checklist_items[$index][$subIndex]['value']) && $record->checklist_items[$index][$subIndex]['value'] == '0' ? 'checked' : '' }}
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td class="border">
                                                            <input type="text" class="form-control" name="notes[{{ $index }}][{{ $subIndex }}]" 
                                                                value="{{ isset($record->checklist_items[$index][$subIndex]['notes']) ? $record->checklist_items[$index][$subIndex]['notes'] : '' }}"
                                                                {{ $isShowDetail ? 'readonly' : '' }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- Regular item -->
                                                <tr>
                                                    <td class="text-center border">{{ $index + 1 }}</td>
                                                    <td class="border">{{ $item }}</td>
                                                    <td class="text-center border">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="checklist[{{ $index }}]" value="1"
                                                                {{ isset($record->checklist_items[$index]['value']) && $record->checklist_items[$index]['value'] == '1' ? 'checked' : '' }}
                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td class="text-center border">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="checklist[{{ $index }}]" value="0"
                                                                {{ isset($record->checklist_items[$index]['value']) && $record->checklist_items[$index]['value'] == '0' ? 'checked' : '' }}
                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td class="border">
                                                        <input type="text" class="form-control" name="notes[{{ $index }}]" 
                                                            value="{{ isset($record->checklist_items[$index]['notes']) ? $record->checklist_items[$index]['notes'] : '' }}"
                                                            {{ $isShowDetail ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Signatures -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h6>Dibuat oleh</h6>
                                    
                                    <div class="mb-3">
                                        <input type="text" name="created_by_name" class="form-control" 
                                            placeholder="Nama Lengkap"
                                            value="{{ $isShowDetail ? $record->created_by_name : session('username') }}"
                                            {{ $isShowDetail ? 'disabled' : '' }} required>
                                    </div>
                                    <input type="hidden" name="created_by_nik" value="{{ $isShowDetail ? $record->created_by_nik : session('user_id') }}" required>
                                    <p class="mb-1">Production Foreman</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Diketahui oleh</h6>
                                    
                                    <div class="mb-3">
                                        <select name="acknowledged_by_name" id="acknowledged_by_name" class="form-control text-left" required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $isShowDetail && $record->acknowledged_by_name == $user->nama ? 'selected' : '' }}>
                                                {{ $user->nama }} ({{ $user->nik }})
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="acknowledged_by_nik" value="{{ $record->acknowledged_by_nik ?? '' }}">
                                    <p class="mb-1">Production Supervisor</p>
                                </div>
                            </div>

                            <!-- Submit/Back Buttons -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    @if($isShowDetail)
                                        <a href="{{ route('prod.coal.dashboard') }}" class="btn btn-secondary">Back</a>
                                        @if(isset($record->approval_status) && $record->approval_status == 'approved')
                                            <a href="{{ route('prod.coal.export', ['id' => $record->id]) }}" class="btn btn-primary">
                                                <i class="fas fa-file-export"></i> Export
                                            </a>
                                        @endif
                                    @else
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('prod.coal.dashboard') }}" class="btn btn-secondary">Back</a>
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

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<style>
    .form-check-input {
        cursor: pointer;
    }
    .table > :not(caption) > * > * {
        padding: 0.5rem;
    }
</style>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
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
        });
    </script>
    <script>
    $(function() {
        // Handle supervisor selection
        $('select[name="acknowledged_by_name"]').change(function() {
            var selectedText = $(this).find('option:selected').text();
            var match = selectedText.match(/\(([^)]+)\)/);
            var nik = match ? match[1] : '';
            $('input[name="acknowledged_by_nik"]').val(nik);
        });

        // Trigger change on load if there's a value
        if ($('select[name="acknowledged_by_name"]').val()) {
            $('select[name="acknowledged_by_name"]').trigger('change');
        }

        // Form submission
        var form = $("#inspectionForm");
        var submitBtn = form.find('button[type="submit"]');

        form.submit(function(e) {
            e.preventDefault();
            submitBtn.prop('disabled', true);

            Swal.fire({
                title: 'Submit Form?',
                text: 'Do you want to submit this form?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    
                    axios.post(form.attr('action'), formData)
                        .then(function(response) {
                            if (response.data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.data.message
                                }).then(() => {
                                    window.location.href = '{{ route("prod.coal.dashboard") }}';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.data.message || 'Something went wrong'
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
                } else {
                    submitBtn.prop('disabled', false);
                }
            });
        });
    });
    </script>
@endsection