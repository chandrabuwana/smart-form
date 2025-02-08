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
                    <form method="POST" id="inspectionForm">
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
                                            value="{{ $isShowDetail ? $record->area_pic : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <!-- Checklist Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 5%">No</th>
                                            <th class="text-center" style="width: 50%">Pemeriksaan</th>
                                            <th class="text-center" colspan="2" style="width: 25%">Kondisi</th>
                                            <th class="text-center" style="width: 20%">Tindakan</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th class="text-center">Ya</th>
                                            <th class="text-center">Tidak</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $checklistItems = [
                                                'Pengawas melakukan validasi P2H fleet coal getting',
                                                'Operator sudah mendapatkan edukasi coal quality',
                                                'Kebersihan Track shoe Excavator',
                                                'Teeth Bucket dalam kondisi baik/normal',
                                                'Tidak ada kebocoran oli/solar unit',
                                                'Kebersihan bak unit hauler',
                                                'Tidak ada potensi komponen unit hauler terlepas',
                                                'Batubara ter expose',
                                                'Cleaning batubara menggunakan cutting edge',
                                                'Cleaning area offset roof dan floor min 1 meter',
                                                'Batubara sudah di cleaning',
                                                'Size batubara sesuai keinginan customer',
                                                [
                                                    'title' => 'Kebersihan Front Loading',
                                                    'subitems' => [
                                                        'a. tanah',
                                                        'b. lumpur',
                                                        'c. parting',
                                                        'd. sampah'
                                                    ]
                                                ],
                                                'Drainase area loading point',
                                                'Penanganan parting (penanganan batas dan pengerjaan pada siang hari)',
                                                'penerangan pada malam hari',
                                                'Pengukuran data roof dan floor'
                                            ];
                                        @endphp

                                        @foreach($checklistItems as $index => $item)
                                            @if(is_array($item))
                                                <!-- Parent item -->
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item['title'] }}</td>
                                                    <td colspan="3"></td>
                                                </tr>
                                                <!-- Subitems -->
                                                @foreach($item['subitems'] as $subitem)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $subitem }}</td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="radio" 
                                                                    name="checklist[{{ $index }}][{{ $loop->index }}]" value="1"
                                                                    {{ $isShowDetail && isset($record->checklist_items[$index][$loop->index]) && $record->checklist_items[$index][$loop->index] == 1 ? 'checked' : '' }}
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input" type="radio" 
                                                                    name="checklist[{{ $index }}][{{ $loop->index }}]" value="0"
                                                                    {{ $isShowDetail && isset($record->checklist_items[$index][$loop->index]) && $record->checklist_items[$index][$loop->index] == 0 ? 'checked' : '' }}
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" 
                                                                name="notes[{{ $index }}][{{ $loop->index }}]"
                                                                value="{{ $isShowDetail && isset($record->checklist_items[$index][$loop->index]['notes']) ? $record->checklist_items[$index][$loop->index]['notes'] : '' }}"
                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item }}</td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" 
                                                                name="checklist[{{ $index }}]" value="1"
                                                                {{ $isShowDetail && isset($record->checklist_items[$index]) && $record->checklist_items[$index] == 1 ? 'checked' : '' }}
                                                                {{ $isShowDetail ? 'disabled' : '' }} required>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" 
                                                                name="checklist[{{ $index }}]" value="0"
                                                                {{ $isShowDetail && isset($record->checklist_items[$index]) && $record->checklist_items[$index] == 0 ? 'checked' : '' }}
                                                                {{ $isShowDetail ? 'disabled' : '' }} required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" 
                                                            name="notes[{{ $index }}]"
                                                            value="{{ $isShowDetail && isset($record->checklist_items[$index]['notes']) ? $record->checklist_items[$index]['notes'] : '' }}"
                                                            {{ $isShowDetail ? 'disabled' : '' }}>
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
                                    <h6>Dibuat oleh,</h6>
                                    <p class="mb-1">Production Foreman</p>
                                    <div class="mb-3">
                                        <input type="text" name="created_by" class="form-control" 
                                            placeholder="Nama Lengkap"
                                            value="{{ $isShowDetail ? $record->created_by : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }} required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Diketahui oleh,</h6>
                                    <p class="mb-1">Production Supervisor</p>
                                    <div class="mb-3">
                                        <input type="text" name="acknowledged_by" class="form-control" 
                                            placeholder="Nama Lengkap"
                                            value="{{ $isShowDetail ? $record->acknowledged_by : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }} required>
                                    </div>
                                </div>
                            </div>

                            @if(!$isShowDetail)
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Kembali</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                            @endif
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
    <script>
    $(function() {
        var form = $("form");
        var submitBtn = form.find('button[type="submit"]');

        form.submit(function(e) {
            e.preventDefault();
            submitBtn.prop('disabled', true);

            var formData = new FormData(this);
            
            axios.post('{{ route("she.coal.store") }}', formData)
                .then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("she.coal.dashboard") }}';
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