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

            <div class="card">
                <!-- Card Header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Inspeksi Air Minum</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <form action="{{ route('she.air-minum.store') }}" method="POST">
                        @csrf
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site_name" class="ms-0">Nama Site</label>
                                        <select class="form-control" id="site_name" name="site_name" required {{ $isShowDetail ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Site --</option>
                                            @foreach(['agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj'] as $site)
                                                <option value="{{ $site }}" {{ $isShowDetail && strtolower($maintenanceRecord->site_name) == $site ? 'selected' : '' }}>
                                                    {{ strtoupper($site) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Dept./Section</label>
                                        <input type="text" name="department" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->department : 'SHE' }}" 
                                            required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Shift</label>
                                        <input type="text" name="shift" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->shift : 'DS' }}" 
                                            required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Lokasi Kerja</label>
                                        <input type="text" name="work_location" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->work_location : '' }}" 
                                            required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Jumlah Inspektor</label>
                                        <input type="number" name="inspector_count" class="form-control" 
                                            value="{{ $isShowDetail ? $maintenanceRecord->inspector_count : '1' }}" 
                                            required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <!-- Inspection Checklist -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th colspan="4" class="text-center">INSPEKSI CATERING CHECKLIST</th>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <th>HAL UNTUK DIPERIKSA</th>
                                            <th>Y</th>
                                            <th>N</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $checkItems = [
                                                ['name' => 'is_work_area_clean', 'label' => 'Apakah area kerja kebersihannya terjaga?'],
                                                ['name' => 'has_scattered_items', 'label' => 'Apakah banyak barang yang berserakan?'],
                                                ['name' => 'has_trash_bin', 'label' => 'Apakah ada tempat sampah?'],
                                                ['name' => 'has_scattered_trash', 'label' => 'Apakah ada sampah berserakan?'],
                                                ['name' => 'has_storage_warehouse', 'label' => 'Apakah ada gudang penyimpanan barang?'],
                                                ['name' => 'is_water_filter_regularly_changed', 'label' => 'Apakah filtrasi pengolahan air minum/ air bersih rutin diganti?'],
                                                ['name' => 'is_water_reservoir_cleaned', 'label' => 'Apakah tempat tampungan air rutin dikuras?'],
                                                ['name' => 'is_distribution_packing_clean', 'label' => 'Apakah tempat packing distribusi air terjaga kebersihan dan kerapiannya?'],
                                                ['name' => 'is_water_quality_checked_quarterly', 'label' => 'Apakah pengecekan kualitas air minum/ air bersih rutin dilakukan setiap per 3 bulan sekali?']
                                            ];
                                        @endphp

                                        @foreach($checkItems as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['label'] }}</td>
                                            <td class="text-center">
                                                <div class="form-check d-inline">
                                                    <input class="form-check-input" type="radio" 
                                                        name="{{ $item['name'] }}" value="1" 
                                                        {{ $isShowDetail && $maintenanceRecord->{$item['name']} ? 'checked' : '' }}
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-inline">
                                                    <input class="form-check-input" type="radio" 
                                                        name="{{ $item['name'] }}" value="0" 
                                                        {{ $isShowDetail && !$maintenanceRecord->{$item['name']} ? 'checked' : '' }}
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Score Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6>SCORE PENERIMAAN</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td class="bg-danger text-white text-center">Very Poor</td>
                                                <td class="bg-warning text-center">Poor</td>
                                                <td class="bg-success text-center">Good</td>
                                                <td class="bg-info text-white text-center">Excellent</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">1-2</td>
                                                <td class="text-center">3-5</td>
                                                <td class="text-center">6-8</td>
                                                <td class="text-center">9-10</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Signature Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Diinspeksi Oleh</th>
                                                <th>Tanda Tangan</th>
                                                <th>Tanggal</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="inspector_1" class="form-control" 
                                                        value="{{ $isShowDetail ? $maintenanceRecord->inspector_1 : '' }}"
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="text" name="inspector_1_signature" class="form-control" 
                                                        value="{{ $isShowDetail ? $maintenanceRecord->inspector_1_signature : '' }}"
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="date" name="inspection_date" class="form-control" 
                                                        value="{{ $isShowDetail ? $maintenanceRecord->inspection_date : now()->format('Y-m-d') }}"
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Mengetahui</th>
                                                <th>Tanda Tangan</th>
                                                <th>Tanggal</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="acknowledged_by" class="form-control" 
                                                        value="{{ $isShowDetail ? $maintenanceRecord->acknowledged_by : '' }}"
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="text" name="acknowledged_by_signature" class="form-control" 
                                                        value="{{ $isShowDetail ? $maintenanceRecord->acknowledged_by_signature : '' }}"
                                                        required {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="date" name="acknowledged_date" class="form-control" 
                                                        value="{{ $isShowDetail ? $maintenanceRecord->acknowledged_date : now()->format('Y-m-d') }}"
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
                                        <a href="{{ route('she.air-minum.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('she.air-minum.export', $maintenanceRecord->id) }}" class="btn btn-primary">
                                            <i class="fas fa-file-export"></i> Export
                                        </a>
                                    @else
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('she.air-minum.dashboard') }}" class="btn btn-secondary">Back</a>
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
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .form-check-input[type="radio"] {
        margin-top: 0;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
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
        
        axios.post('{{ route("she.air-minum.store") }}', formData)
            .then(function(response) {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("she.air-minum.dashboard") }}';
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