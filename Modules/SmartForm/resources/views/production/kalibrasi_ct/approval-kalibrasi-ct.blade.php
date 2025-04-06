@extends('master.master_page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                            <span class="alert-icon align-middle"><i class="fas fa-check-circle"></i></span>
                            <span class="alert-text">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                            <span class="alert-icon align-middle"><i class="fas fa-exclamation-circle"></i></span>
                            <span class="alert-text">{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                        </div>
                    @endif
                    
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">    
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">{{ $isShowDetail ? 'Detail' : 'New' }} Form Kalibrasi CT</h6>
                        </div>
                    </div>

                        <!-- Card Header -->
                        <div class="card">
                            <form action="" id="kalibrasiForm" method="POST">
                            @csrf
                                @if ($isShowDetail && $record)
                                    <input type="hidden" name="id" value="{{ $record->id }}">
                                @endif
                                <div class="d-flex flex-column gap-2 p-0 mx-3 mt-3">
                                    <!-- Hauler Start -->
                                        <div>
                                            <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapseHauler" role="button" aria-expanded="false" aria-controls="collapseHauler">
                                                <h5 style="color: white;">Form Hauler</h5>
                                            </a>
                                            {{-- Isi Hauler --}}
                                            <div class="collapse {{ $isShowDetail ? 'show' : '' }} mt-2" id="collapseHauler">       
                                                <div class="card card-body">
                                                    <div class="mx-3 mb-2">
                                                        <h5>Basic Information</h5>
                                                    </div>
                                                    <div class="mx-3"> 
                                                    <!-- Basic Information -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="nama_operator_loader_hauler" class="ms-0">Nama Operator Loader</label>
                                                                    <input type="text" class="form-control" id="nama_operator_loader_hauler" name="nama_operator_loader_hauler" required
                                                                    value="{{ old('nama_operator_loader_hauler', $record->nama_operator_loader_hauler ?? '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="nomor_exca_hauler" class="ms-0">Nomor Exca</label>
                                                                    <input type="text" class="form-control" id="nomor_exca_hauler" name="nomor_exca_hauler" required
                                                                    value="{{ old('nomor_exca_hauler', $record->nomor_exca_hauler ?? '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="nama_disposal_hauler" class="ms-0">Nama Disposal</label>
                                                                    <input type="text" class="form-control" id="nama_disposal_hauler" name="nama_disposal_hauler" required
                                                                    value="{{ old('nama_disposal_hauler', $record->nama_disposal_hauler ?? '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jumlah_hauler_digunakan_hauler" class="ms-0">Jumlah Hauler Digunakan</label>
                                                                    <input type="number" class="form-control" id="jumlah_hauler_digunakan_hauler" name="jumlah_hauler_digunakan_hauler" required
                                                                    value="{{ old('jumlah_hauler_digunakan_hauler', $record->jumlah_hauler_digunakan_hauler ?? '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="tanggal_hauler" class="ms-0">Tanggal</label>
                                                                    <input type="date" class="form-control" id="tanggal_hauler" name="tanggal_hauler" required
                                                                    value="{{ old('tanggal_hauler', $record->tanggal_hauler ?? '') }}"
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="shift_hauler" class="ms-0">Shift</label>
                                                                    <select name="shift_hauler" class="form-control" {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        {!! $shift_hauler !!}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_hauler" class="ms-0">Alat Support</label>
                                                                    <input type="text" class="form-control" id="alat_support_hauler" name="alat_support_hauler" required
                                                                        value="{{ old('alat_support_hauler', $record->alat_support_hauler ?? '') }}" 
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="material_hauler" class="ms-0">Material</label>
                                                                    <input type="text" class="form-control" id="material_hauler" name="material_hauler" required
                                                                        value="{{ old('material_hauler', $record->material_hauler ?? '') }}" 
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mx-3 mb-2">
                                                        <h5>Keterangan/Kondisi</h5>
                                                    </div>
                                                    <div class="mx-3"> 
                                                    <!-- Keterangan/Kondisi -->
                                                        <div class="row mb-3">
                                                            @for($i = 1; $i <= 3; $i++)
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="ket_front_hauler" class="ms-0">Front {{ $i }}</label>
                                                                    <input type="text" class="form-control" id="ket_front_hauler" name="ket_front_hauler_{{ $i }}" 
                                                                    value="{{ old('ket_front_hauler_'.$i, isset($record->ket_front_hauler[$i-1]) ? $record->ket_front_hauler[$i-1] : '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                            @endfor
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            @for($i = 1; $i <= 3; $i++)
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="ket_jalan_hauler" class="ms-0">Jalan {{ $i }}</label>
                                                                    <input type="text" class="form-control" id="ket_jalan_hauler" name="ket_jalan_hauler_{{ $i }}" 
                                                                    value="{{ old('ket_jalan_hauler_'.$i, isset($record->ket_jalan_hauler[$i-1]) ? $record->ket_jalan_hauler[$i-1] : '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                            @endfor
                                                        </div>

                                                        <div class="row mb-3">
                                                            @for($i = 1; $i <= 3; $i++)
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="ket_grade_hauler" class="ms-0">Grade Jalan {{ $i }}</label>
                                                                    <input type="text" class="form-control" id="ket_grade_hauler" name="ket_grade_hauler_{{ $i }}" 
                                                                    value="{{ old('ket_grade_hauler_'.$i, isset($record->ket_grade_hauler[$i-1]) ? $record->ket_grade_hauler[$i-1] : '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                            @endfor
                                                        </div>

                                                        <div class="row mb-3">
                                                            @for($i = 1; $i <= 3; $i++)
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="ket_disposal_hauler" class="ms-0">Disposal {{ $i }}</label>
                                                                    <input type="text" class="form-control" id="ket_disposal_hauler" name="ket_disposal_hauler_{{ $i }}" 
                                                                    value="{{ old('ket_disposal_hauler_'.$i, isset($record->ket_disposal_hauler[$i-1]) ? $record->ket_disposal_hauler[$i-1] : '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                            @endfor
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered">

                                                            <thead class="bg-success text-white">
                                                                <tr>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nomor DT/HD</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Operator</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Jarak Hauling (m)</th>
                                                                    <th colspan="2" class="text-center">Waktu Yang Dibutuhkan Untuk Menit</th>
                                                                    <th colspan="2" class="text-center">Cycle Time Hauler</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Jumlah Isian (Bucket)</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Antri + Manuver + siaga (1) + Pengisian Vessel</th>
                                                                    <th>Meninggalkan Front</th>
                                                                    <th>00:00:00</th>
                                                                    <th>0,00</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="8">
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <label for="no_loader_hauler" class="ms-0">No Loader</label>
                                                                                <input type="text" class="form-control" id="no_loader_hauler_1" name="no_loader_hauler_1" 
                                                                                    value="{{ old('no_loader_hauler.1', isset($record->no_loader_hauler[1]) ? $record->no_loader_hauler[1] : '') }}" 
                                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                @for($i = 1; $i <= 5; $i++)
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="nomor_dtht_hauler" name="nomor_dtht_hauler_{{ $i }}"
                                                                                value="{{ old('nomor_dtht_hauler_'.$i, isset($record->nomor_dtht_hauler[$i-1]) ? $record->nomor_dtht_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="nama_operator_hauler" name="nama_operator_hauler_{{ $i }}"
                                                                                value="{{ old('nama_operator_hauler_'.$i, isset($record->nama_operator_hauler[$i-1]) ? $record->nama_operator_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="jarak_hauling_hauler" name="jarak_hauling_hauler_{{ $i }}"
                                                                                value="{{ old('jarak_hauling_hauler_'.$i, isset($record->jarak_hauling_hauler[$i-1]) ? $record->jarak_hauling_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" min="00:00" max="59:59" class="form-control" step="1" id="waktu_antri_hauler" name="waktu_antri_hauler_{{ $i }}"
                                                                                value="{{ old('waktu_antri_hauler_'.$i, isset($record->waktu_antri_hauler[$i-1]) ? $record->waktu_antri_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" min="00:00" max="59:59" class="form-control" step="1" id="meninggalkan_front_hauler" name="meninggalkan_front_hauler_{{ $i }}"
                                                                                value="{{ old('meninggalkan_front_hauler_'.$i, isset($record->meninggalkan_front_hauler[$i-1]) ? $record->meninggalkan_front_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" class="form-control" id="cycle_timer_hauler" name="cycle_timer_hauler_{{ $i }}" value="{{ old('cycle_timer_hauler'.$i, isset($record->cycle_timer_hauler[$i-1]) ? $record->cycle_timer_hauler[$i-1] : '')}}" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="jumlah_bucket_hauler" name="jumlah_bucket_hauler_{{ $i }}"
                                                                                value="{{ old('jumlah_bucket_hauler_'.$i, isset($record->jumlah_bucket_hauler[$i-1]) ? $record->jumlah_bucket_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endfor

                                                                <tr>
                                                                    <td colspan="8">
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <label for="no_loader_hauler" class="ms-0">No Loader</label>
                                                                                <input type="text" class="form-control" id="no_loader_hauler_3" name="no_loader_hauler_3" 
                                                                                    value="{{ old('no_loader_hauler.3', isset($record->no_loader_hauler[3]) ? $record->no_loader_hauler[3] : '') }}" 
                                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                </tr>>
                                                                @for($i = 6; $i <= 10; $i++)
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="nomor_dtht_hauler" name="nomor_dtht_hauler_{{ $i }}"
                                                                                value="{{ old('nomor_dtht_hauler_'.$i, isset($record->nomor_dtht_hauler[$i-1]) ? $record->nomor_dtht_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="nama_operator_hauler" name="nama_operator_hauler_{{ $i }}"
                                                                                value="{{ old('nama_operator_hauler_'.$i, isset($record->nama_operator_hauler[$i-1]) ? $record->nama_operator_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="jarak_hauling_hauler" name="jarak_hauling_hauler_{{ $i }}"
                                                                                value="{{ old('jarak_hauling_hauler_'.$i, isset($record->jarak_hauling_hauler[$i-1]) ? $record->jarak_hauling_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" min="00:00" max="59:59" class="form-control" id="waktu_antri_hauler" name="waktu_antri_hauler_{{ $i }}"
                                                                                value="{{ old('waktu_antri_hauler_'.$i, isset($record->waktu_antri_hauler[$i-1]) ? $record->waktu_antri_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" min="00:00" max="59:59" class="form-control" id="meninggalkan_front_hauler" name="meninggalkan_front_hauler_{{ $i }}"
                                                                                value="{{ old('meninggalkan_front_hauler_'.$i, isset($record->meninggalkan_front_hauler[$i-1]) ? $record->meninggalkan_front_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" class="form-control" id="cycle_timer_hauler" name="cycle_timer_hauler_{{ $i }}" value="{{ old('cycle_timer_hauler'.$i, isset($record->cycle_timer_hauler[$i-1]) ? $record->cycle_timer_hauler[$i-1] : '')}}" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="jumlah_bucket_hauler" name="jumlah_bucket_hauler_{{ $i }}"
                                                                                value="{{ old('jumlah_bucket_hauler_'.$i, isset($record->jumlah_bucket_hauler[$i-1]) ? $record->jumlah_bucket_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endfor

                                                                <tr>
                                                                    <td colspan="8">
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <label for="no_loader_hauler" class="ms-0">No Loader</label>
                                                                                <input type="text" class="form-control" id="no_loader_hauler_3" name="no_loader_hauler_2" 
                                                                                    value="{{ old('no_loader_hauler.2', isset($record->no_loader_hauler[2]) ? $record->no_loader_hauler[2] : '') }}" 
                                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                </tr>>
                                                                @for($i = 11; $i <= 15; $i++)
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="nomor_dtht_hauler" name="nomor_dtht_hauler_{{ $i }}"
                                                                                value="{{ old('nomor_dtht_hauler_'.$i, isset($record->nomor_dtht_hauler[$i-1]) ? $record->nomor_dtht_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="nama_operator_hauler" name="nama_operator_hauler_{{ $i }}"
                                                                                value="{{ old('nama_operator_hauler_'.$i, isset($record->nama_operator_hauler[$i-1]) ? $record->nama_operator_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="jarak_hauling_hauler" name="jarak_hauling_hauler_{{ $i }}"
                                                                                value="{{ old('jarak_hauling_hauler_'.$i, isset($record->jarak_hauling_hauler[$i-1]) ? $record->jarak_hauling_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" min="00:00" max="59:59" class="form-control" id="waktu_antri_hauler" name="waktu_antri_hauler_{{ $i }}"
                                                                                value="{{ old('waktu_antri_hauler_'.$i, isset($record->waktu_antri_hauler[$i-1]) ? $record->waktu_antri_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" min="00:00" max="59:59" class="form-control" id="meninggalkan_front_hauler" name="meninggalkan_front_hauler_{{ $i }}"
                                                                                value="{{ old('meninggalkan_front_hauler_'.$i, isset($record->meninggalkan_front_hauler[$i-1]) ? $record->meninggalkan_front_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="time" step="1" class="form-control" id="cycle_timer_hauler" name="cycle_timer_hauler_{{ $i }}" value="{{ old('cycle_timer_hauler'.$i, isset($record->cycle_timer_hauler[$i-1]) ? $record->cycle_timer_hauler[$i-1] : '')}}" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="jumlah_bucket_hauler" name="jumlah_bucket_hauler_{{ $i }}"
                                                                                value="{{ old('jumlah_bucket_hauler_'.$i, isset($record->jumlah_bucket_hauler[$i-1]) ? $record->jumlah_bucket_hauler[$i-1] : '') }}"
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endfor
                                                            </tbody>
                                                        </table>                                                         
                                                    </div>
                                                    <div>
                                                        <h5>Dibuat Oleh</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_hauler" class="ms-0">Nama Pembuat</label>
                                                                    <select name="dibuat_hauler" id="dibuat_hauler" class="form-control" required {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option disabled {{ optional($record)->dibuat_hauler == '' ? 'selected' : '' }}>-- Select Pembuat --</option>
                                                                        @foreach ($approvalList as $user)
                                                                            <option value="{{ $user->nik }}" {{ optional($record)->dibuat_hauler == $user->nik ? 'selected' : '' }}>
                                                                                {{ $user->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($isShowDetail)
                                                                        <span class="
                                                                            {{ $record->status_dibuat_hauler == 'Approve' ? 'text-success' : '' }}
                                                                            {{ $record->status_dibuat_hauler == 'Pending' ? 'text-warning' : '' }}
                                                                            {{ $record->status_dibuat_hauler == 'Reject' ? 'text-danger' : '' }}">
                                                                            {{ ucfirst($record->status_dibuat_hauler) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                @php
                                                                    $loggedInUserId = session('user_id');
                                                                @endphp
                                                                @if(optional($record)->dibuat_hauler == $loggedInUserId)
                                                                    <div>
                                                                        <button class="btnApprove btn btn-info btn-sm" data-id="{{ $record->id }}">Approve</button>
                                                                        <button class="btnReject btn btn-danger btn-sm" data-id="{{ $record->id }}">Reject</button>
                                                                    </div>
                                                                @endif
                                                            </div>
        
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jabatan_dibuat_hauler" class="ms-0">Jabatan</label>
                                                                    <select class="form-control" name="jabatan_dibuat_hauler" id="jabatan_dibuat_hauler" required
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option value="LH"
                                                                            {{ old('jabatan_dibuat_hauler', $record->jabatan_dibuat_hauler ?? '') == 'LH' ? 'selected' : '' }}>
                                                                            LH</option>
                                                                        <option value="Foreman Prod"
                                                                            {{ old('jabatan_dibuat_hauler', $record->jabatan_dibuat_hauler ?? '') == 'Foreman Prod' ? 'selected' : '' }}>
                                                                            Foreman Prod</option>
                                                                        <option value="Trainer"
                                                                            {{ old('jabatan_dibuat_hauler', $record->jabatan_dibuat_hauler ?? '') == 'Trainer' ? 'selected' : '' }}>
                                                                            Trainer</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div>
                                                        <h5>Diketahui Oleh</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_hauler" class="ms-0">Nama Pemeriksa</label>
                                                                    <select name="mengetahui_hauler" id="mengetahui_hauler" class="form-control" required {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option disabled {{ optional($record)->mengetahui_hauler == '' ? 'selected' : '' }}>-- Select Pemeriksa --</option>
                                                                        @foreach ($approvalList as $user)
                                                                            <option value="{{ $user->nik }}" {{ optional($record)->mengetahui_hauler == $user->nik ? 'selected' : '' }}>
                                                                                {{ $user->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($isShowDetail)
                                                                        <span class="
                                                                            {{ $record->status_mengetahui_hauler == 'Approve' ? 'text-success' : '' }}
                                                                            {{ $record->status_mengetahui_hauler == 'Pending' ? 'text-warning' : '' }}
                                                                            {{ $record->status_mengetahui_hauler == 'Reject' ? 'text-danger' : '' }}">
                                                                            {{ ucfirst($record->status_mengetahui_hauler) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                @php
                                                                    $loggedInUserId = session('user_id');
                                                                @endphp

                                                                @if(optional($record)->mengetahui_hauler == $loggedInUserId)
                                                                    <div>
                                                                        <button class="btnApprove btn btn-info btn-sm" data-id="{{ $record->id }}">Approve</button>
                                                                        <button class="btnReject btn btn-danger btn-sm" data-id="{{ $record->id }}">Reject</button>
                                                                    </div>
                                                                @endif
                                                            </div>
        
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jabatan_mengetahui_hauler" class="ms-0">Jabatan</label>
                                                                    <select class="form-control" name="jabatan_mengetahui_hauler" id="jabatan_mengetahui_hauler" required
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option value="Spv. Prod"
                                                                            {{ old('jabatan_mengetahui_hauler', $record->jabatan_mengetahui_hauler ?? '') == 'Spv. Prod' ? 'selected' : '' }}>
                                                                            Spv. Prod</option>
                                                                        <option value="Kabag. Prod"
                                                                            {{ old('jabatan_mengetahui_hauler', $record->jabatan_mengetahui_hauler ?? '') == 'Kabag. Prod' ? 'selected' : '' }}>
                                                                            Kabag. Prod</option>
                                                                        <option value="Project Manager"
                                                                            {{ old('jabatan_mengetahui_hauler', $record->jabatan_mengetahui_hauler ?? '') == 'Project Manager' ? 'selected' : '' }}>
                                                                            Project Manager</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- Hauler End --}}
                                    
                                    <!-- Loader Start -->
                                        <div>
                                            <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapseLoader" role="button" aria-expanded="false" aria-controls="collapseHauler">
                                                <h5 style="color: white;">Form Loader</h5>
                                            </a>
                                            {{-- Isi Loader --}}
                                            <div class="collapse {{ $isShowDetail ? 'show' : '' }} mt-2" id="collapseLoader">
                                                <div class="card card-body">
                                                    <div class="mx-3">
                                                    <!-- Basic Information -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="tanggal_loader" class="ms-0">Tanggal</label>
                                                                    <input type="date" class="form-control" id="tanggal_loader" name="tanggal_loader" required
                                                                    value="{{ old('tanggal_loader', $record->tanggal_loader ?? '') }}"
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="shift_loader" class="ms-0">Shift Kerja</label>
                                                                    <select name="shift_loader" class="form-control" {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        {!! $shift_loader !!}
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="nama_operator_loader" class="ms-0">Nama Operator Loader</label>
                                                                    <input type="text" class="form-control" id="nama_operator_loader" name="nama_operator_loader" required
                                                                    value="{{ old('nama_operator_loader', $record->nama_operator_loader ?? '') }}"
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="nomor_exca_loader" class="ms-0">Nomor Excavator</label>
                                                                    <input type="text" class="form-control" id="nomor_exca_loader" name="nomor_exca_loader" required
                                                                    value="{{ old('nomor_exca_loader', $record->nomor_exca_loader ?? '') }}"
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="lokasi_loader" class="ms-0">Lokasi Loading</label>
                                                                    <input type="text" class="form-control" id="lokasi_loader" name="lokasi_loader" required
                                                                    value="{{ old('lokasi_loader', $record->lokasi_loader ?? '') }}"
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jumlah_hauler_digunakan_loader" class="ms-0">Jumlah Loader Digunakan</label>
                                                                    <input type="text" class="form-control" id="jumlah_hauler_digunakan_loader" name="jumlah_hauler_digunakan_loader" required
                                                                    value="{{ old('jumlah_hauler_digunakan_loader', $record->jumlah_hauler_digunakan_loader ?? '') }}"
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jarak_hauling_loader" class="ms-0">Jarak Hauling/Disposal (meter)</label>
                                                                    <input type="number" class="form-control" id="jarak_hauling_loader" name="jarak_hauling_loader" required
                                                                        value="{{ old('jarak_hauling_loader', $record->jarak_hauling_loader ?? '') }}"
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="kondisi_front_loader" class="ms-0">Kondisi Front</label>
                                                                    <input type="text" class="form-control" id="kondisi_front_loader" name="kondisi_front_loader" required
                                                                        value="{{ old('kondisi_front_loader', $record->kondisi_front_loader ?? '') }}"
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_loader" class="ms-0">Alat Support</label>
                                                                    <input type="text" class="form-control" id="alat_support_loader" name="alat_support_loader" required
                                                                        value="{{ old('alat_support_loader', $record->alat_support_loader ?? '') }}"
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="cuaca_loader" class="ms-0">Cuaca</label>
                                                                    <input type="text" class="form-control" id="cuaca_loader" name="cuaca_loader" required
                                                                        value="{{ old('cuaca_loader', $record->cuaca_loader ?? '') }}"
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered">

                                                            <thead class="bg-success text-white">
                                                                <tr>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 60px;">No</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Jenis Material</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 60px;">Nomor CMT/DT</th>
                                                                    <th colspan="4" class="text-center">Waktu Pengisian Vessel Primary Activity (detik)</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 8%;">Total Waktu Pengisian (detik)</th>
                                                                    <th colspan="2" class="text-center">Keterangan "Waste" Secondary Activity (detik)</th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center; vertical-align: middle; width: 5%;">Digging</th>
                                                                    <th style="text-align: center; vertical-align: middle; width: 5%;">Swing Isi</th>
                                                                    <th style="text-align: center; vertical-align: middle; width: 5%;">Load</th>
                                                                    <th style="text-align: center; vertical-align: middle; width: 5%;">Swing Kosong</th>
                                                                    <th style="text-align: center; vertical-align: middle; width: 5%;">Durasi</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Reason</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                @for($i = 1; $i <= 18; $i++)
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="no_loader" name="no_loader_{{ $i }}" 
                                                                                value="{{ old('no_loader_'.$i, isset($record->no_loader[$i-1]) ? $record->no_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="jenis_material_loader" name="jenis_material_loader_{{ $i }}" 
                                                                                value="{{ old('jenis_material_loader_'.$i, isset($record->jenis_material_loader[$i-1]) ? $record->jenis_material_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="nomor_cmtdt_loader" name="nomor_cmtdt_loader_{{ $i }}" 
                                                                                value="{{ old('nomor_cmtdt_loader_'.$i, isset($record->nomor_cmtdt_loader[$i-1]) ? $record->nomor_cmtdt_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="digging_loader" name="digging_loader_{{ $i }}" 
                                                                                value="{{ old('digging_loader_'.$i, isset($record->digging_loader[$i-1]) ? $record->digging_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="swing_isi_loader" name="swing_isi_loader_{{ $i }}" 
                                                                                value="{{ old('swing_isi_loader_'.$i, isset($record->swing_isi_loader[$i-1]) ? $record->swing_isi_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="load_loader" name="load_loader_{{ $i }}" 
                                                                                value="{{ old('load_loader_'.$i, isset($record->load_loader[$i-1]) ? $record->load_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="swing_kosong_loader" name="swing_kosong_loader_{{ $i }}" 
                                                                                value="{{ old('swing_kosong_loader_'.$i, isset($record->swing_kosong_loader[$i-1]) ? $record->swing_kosong_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="total_pengisian_loader" name="total_pengisian_loader_{{ $i }}" value="{{ old('total_pengisian_loader'.$i, isset($record->total_pengisian_loader[$i-1]) ? $record->total_pengisian_loader[$i-1] : '')}}" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="durasi_loader" name="durasi_loader_{{ $i }}" 
                                                                                value="{{ old('durasi_loader_'.$i, isset($record->durasi_loader[$i-1]) ? $record->durasi_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="reason_loader" name="reason_loader_{{ $i }}" 
                                                                                value="{{ old('reason_loader_'.$i, isset($record->reason_loader[$i-1]) ? $record->reason_loader[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endfor
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                        <div>
                                                        <h5>Dibuat Oleh</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_hauler" class="ms-0">Nama Pembuat</label>
                                                                    <select name="dibuat_loader" id="dibuat_loader" class="form-control" required {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option disabled {{ optional($record)->dibuat_loader == '' ? 'selected' : '' }}>-- Select Pembuat --</option>
                                                                        @foreach ($approvalList as $user)
                                                                            <option value="{{ $user->nik }}" {{ optional($record)->dibuat_loader == $user->nik ? 'selected' : '' }}>
                                                                                {{ $user->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($isShowDetail)
                                                                        <span class="
                                                                            {{ $record->status_dibuat_loader == 'Approve' ? 'text-success' : '' }}
                                                                            {{ $record->status_dibuat_loader == 'Pending' ? 'text-warning' : '' }}
                                                                            {{ $record->status_dibuat_loader == 'Reject' ? 'text-danger' : '' }}">
                                                                            {{ ucfirst($record->status_dibuat_loader) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                @php
                                                                    $loggedInUserId = session('user_id');
                                                                @endphp

                                                                @if(optional($record)->dibuat_loader == $loggedInUserId)
                                                                    <div>
                                                                        <button class="btnApprove btn btn-info btn-sm" data-id="{{ $record->id }}">Approve</button>
                                                                        <button class="btnReject btn btn-danger btn-sm" data-id="{{ $record->id }}">Reject</button>
                                                                    </div>
                                                                @endif
                                                            </div>
        
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jabatan_dibuat_loader" class="ms-0">Jabatan</label>
                                                                    <select class="form-control" name="jabatan_dibuat_loader" id="jabatan_dibuat_loader" required
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option value="Foreman"
                                                                            {{ old('jabatan_dibuat_loader', $record->jabatan_dibuat_loader ?? '') == 'Foreman' ? 'selected' : '' }}>
                                                                            Foreman</option>
                                                                        <option value="Pengawas Produksi"
                                                                            {{ old('jabatan_dibuat_loader', $record->jabatan_dibuat_loader ?? '') == 'Pengawas Produksi' ? 'selected' : '' }}>
                                                                            Pengawas Produksi</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div>
                                                        <h5>Diketahui Oleh</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_hauler" class="ms-0">Nama Pemeriksa</label>
                                                                    <select name="mengetahui_loader" id="mengetahui_loader" class="form-control" required {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option disabled {{ optional($record)->mengetahui_loader == '' ? 'selected' : '' }}>-- Select Pemeriksa --</option>
                                                                        @foreach ($approvalList as $user)
                                                                            <option value="{{ $user->nik }}" {{ optional($record)->mengetahui_loader == $user->nik ? 'selected' : '' }}>
                                                                                {{ $user->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($isShowDetail)
                                                                        <span class="
                                                                            {{ $record->status_mengetahui_loader == 'Approve' ? 'text-success' : '' }}
                                                                            {{ $record->status_mengetahui_loader == 'Pending' ? 'text-warning' : '' }}
                                                                            {{ $record->status_mengetahui_loader == 'Reject' ? 'text-danger' : '' }}">
                                                                            {{ ucfirst($record->status_mengetahui_loader) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                @php
                                                                    $loggedInUserId = session('user_id');
                                                                @endphp

                                                                @if(optional($record)->mengetahui_loader == $loggedInUserId)
                                                                    <div>
                                                                        <button class="btnApprove btn btn-info btn-sm" data-id="{{ $record->id }}">Approve</button>
                                                                        <button class="btnReject btn btn-danger btn-sm" data-id="{{ $record->id }}">Reject</button>
                                                                    </div>
                                                                @endif
                                                            </div>
        
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jabatan_mengetahui_loader" class="ms-0">Jabatan</label>
                                                                    <select class="form-control" name="jabatan_mengetahui_loader" id="jabatan_mengetahui_loader" required
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option value="Spv. Prod"
                                                                            {{ old('jabatan_mengetahui_loader', $record->jabatan_mengetahui_loader ?? '') == 'Spv. Prod' ? 'selected' : '' }}>
                                                                            Spv. Prod</option>
                                                                        <option value="Kabag. Prod"
                                                                            {{ old('jabatan_mengetahui_loader', $record->jabatan_mengetahui_loader ?? '') == 'Kabag. Prod' ? 'selected' : '' }}>
                                                                            Kabag. Prod</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- Loader End --}}

                                    <!-- Dozer Start -->
                                        <div>
                                            <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapseDozer" role="button" aria-expanded="false" aria-controls="collapseHauler">
                                                <h5 style="color: white;">Form Dozer</h5>
                                            </a>
                                            {{-- Isi Dozer --}}
                                            <div class="collapse {{ $isShowDetail ? 'show' : '' }} mt-2" id="collapseDozer">
                                                <div class="card card-body">
                                                    <div class="mx-3">
                                                    <!-- Basic Information -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="tanggal_dozer" class="ms-0">Tanggal</label>
                                                                    <input type="date" class="form-control" id="tanggal_dozer" name="tanggal_dozer" required
                                                                    value="{{ old('tanggal_dozer', $record->tanggal_dozer ?? '') }}"
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="shift_dozer" class="ms-0">Shift Kerja</label>
                                                                    <select name="shift_dozer" class="form-control" {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        {!! $shift_dozer !!}
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="nama_operator_dozer" class="ms-0">Nama Operator Dozer</label>
                                                                    <input type="text" class="form-control" id="nama_operator_dozer" name="nama_operator_dozer" required
                                                                    value="{{ old('nama_operator_dozer', $record->nama_operator_dozer ?? '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="nomor_lambung_dozer" class="ms-0">Nomor Lambung</label>
                                                                    <input type="text" class="form-control" id="nomor_lambung_dozer" name="nomor_lambung_dozer" required
                                                                    value="{{ old('pemnomor_lambung_dozereriksa', $record->nomor_lambung_dozer ?? '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="lokasi_dozing_dozer" class="ms-0">Lokasi Dozing</label>
                                                                    <input type="text" class="form-control" id="lokasi_dozing_dozer" name="lokasi_dozing_dozer" required
                                                                    value="{{ old('lokasi_dozing_dozer', $record->lokasi_dozing_dozer ?? '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="material_dozer" class="ms-0">Material</label>
                                                                    <input type="text" class="form-control" id="material_dozer" name="material_dozer" required
                                                                    value="{{ old('material_dozer', $record->material_dozer ?? '') }}" 
                                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jarak_dozing_dozer" class="ms-0">Jarak Dozing (meter)</label>
                                                                    <input type="number" class="form-control" id="jarak_dozing_dozer" name="jarak_dozing_dozer" required
                                                                        value="{{ old('jarak_dozing_dozer', $record->jarak_dozing_dozer ?? '') }}" 
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="kondisi_area_kerja_dozer" class="ms-0">Kondisi Area Kerja</label>
                                                                    <input type="text" class="form-control" id="kondisi_area_kerja_dozer" name="kondisi_area_kerja_dozer" required
                                                                        value="{{ old('kondisi_area_kerja_dozer', $record->kondisi_area_kerja_dozer ?? '') }}" 
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_dozer" class="ms-0">Alat Support</label>
                                                                    <input type="text" class="form-control" id="alat_support_dozer" name="alat_support_dozer" required
                                                                        value="{{ old('alat_support_dozer', $record->alat_support_dozer ?? '') }}" 
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="cuaca_dozer" class="ms-0">Cuaca</label>
                                                                    <input type="text" class="form-control" id="cuaca_dozer" name="cuaca_dozer" required
                                                                        value="{{ old('cuaca_dozer', $record->cuaca_dozer ?? '') }}" required
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered">

                                                            <thead class="bg-success text-white">
                                                                <tr>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 5%;">No</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 12%;">Dozing (detik)</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 12%;">Reverse Detik</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 12%;">Gear Shifting (detik)</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 12%;">Total(Detik)</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 12%;">CM (menit)</th>
                                                                    <th rowspan="2" style="text-align: center; vertical-align: middle; width: 12%;">Jarak (M)</th>
                                                                    <th colspan="2" style="text-align: center; vertical-align: middle;">Keterangan "Waste" Secondary Activity (detik)</th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center; vertical-align: middle; width: 12%;">Durasi</th>
                                                                    <th style="text-align: center; vertical-align: middle;">Reason</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                @for($i = 1; $i <= 22; $i++)
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="no_dozer" name="no_dozer_{{ $i }}" 
                                                                                value="{{ old('no_dozer_'.$i, isset($record->no_dozer[$i-1]) ? $record->no_dozer[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="dozing_dozer" name="dozing_dozer_{{ $i }}" 
                                                                                value="{{ old('dozing_dozer_'.$i, isset($record->dozing_dozer[$i-1]) ? $record->dozing_dozer[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="reverse_dozer" name="reverse_dozer_{{ $i }}" 
                                                                                value="{{ old('reverse_dozer_'.$i, isset($record->reverse_dozer[$i-1]) ? $record->reverse_dozer[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="gear_shifting_dozer" name="gear_shifting_dozer_{{ $i }}" 
                                                                                value="{{ old('gear_shifting_dozer_'.$i, isset($record->gear_shifting_dozer[$i-1]) ? $record->gear_shifting_dozer[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="total_dozer" name="total_dozer_{{ $i }}" value="{{ old('total_dozer'.$i, isset($record->total_dozer[$i-1]) ? $record->total_dozer[$i-1] : '')}}" readonly>

                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="cm_dozer" name="cm_dozer_{{ $i }}" 
                                                                                value="{{ old('cm_dozer_'.$i, isset($record->cm_dozer[$i-1]) ? $record->cm_dozer[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="jarak_dozer" name="jarak_dozer_{{ $i }}" 
                                                                                value="{{ old('jarak_dozer_'.$i, isset($record->jarak_dozer[$i-1]) ? $record->jarak_dozer[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="number" class="form-control" id="durasi_dozer" name="durasi_dozer_{{ $i }}" 
                                                                                value="{{ old('durasi_dozer_'.$i, isset($record->durasi_dozer[$i-1]) ? $record->durasi_dozer[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static mb-3">
                                                                            <input type="text" class="form-control" id="reason_dozer" name="reason_dozer_{{ $i }}" 
                                                                                value="{{ old('reason_dozer_'.$i, isset($record->reason_dozer[$i-1]) ? $record->reason_dozer[$i-1] : '') }}" 
                                                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endfor
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div>
                                                        <h5>Dibuat Oleh</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_hauler" class="ms-0">Nama Pembuat</label>
                                                                    <select name="dibuat_dozer" id="dibuat_dozer" class="form-control" required {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option disabled {{ optional($record)->dibuat_dozer == '' ? 'selected' : '' }}>-- Select Pembuat --</option>
                                                                        @foreach ($approvalList as $user)
                                                                            <option value="{{ $user->nik }}" {{ optional($record)->dibuat_dozer == $user->nik ? 'selected' : '' }}>
                                                                                {{ $user->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($isShowDetail)
                                                                        <span class="
                                                                            {{ $record->status_dibuat_dozer == 'Approve' ? 'text-success' : '' }}
                                                                            {{ $record->status_dibuat_dozer == 'Pending' ? 'text-warning' : '' }}
                                                                            {{ $record->status_dibuat_dozer == 'Reject' ? 'text-danger' : '' }}">
                                                                            {{ ucfirst($record->status_dibuat_dozer) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                @php
                                                                    $loggedInUserId = session('user_id');
                                                                @endphp

                                                                @if(optional($record)->dibuat_dozer == $loggedInUserId)
                                                                    <div>
                                                                        <button class="btnApprove btn btn-info btn-sm" data-id="{{ $record->id }}">Approve</button>
                                                                        <button class="btnReject btn btn-danger btn-sm" data-id="{{ $record->id }}">Reject</button>
                                                                    </div>
                                                                @endif

                                                            </div>
        
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jabatan_dibuat_dozer" class="ms-0">Jabatan</label>
                                                                    <select class="form-control" name="jabatan_dibuat_dozer" id="jabatan_dibuat_dozer" required
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option value="LH Produksi"
                                                                            {{ old('jabatan_dibuat_dozer', $record->jabatan_dibuat_dozer ?? '') == 'LH Produksi' ? 'selected' : '' }}>
                                                                            LH Produksi</option>
                                                                        <option value="Foreman Prod"
                                                                            {{ old('jabatan_dibuat_dozer', $record->jabatan_dibuat_dozer ?? '') == 'Foreman Prod' ? 'selected' : '' }}>
                                                                            Foreman Prod</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <h5>Diketahui Oleh</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="alat_support_hauler" class="ms-0">Nama Pemeriksa</label>
                                                                    <select name="mengetahui_dozer" id="mengetahui_dozer" class="form-control" required {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option disabled {{ optional($record)->mengetahui_dozer == '' ? 'selected' : '' }}>-- Select Pemeriksa --</option>
                                                                        @foreach ($approvalList as $user)
                                                                            <option value="{{ $user->nik }}" {{ optional($record)->mengetahui_dozer == $user->nik ? 'selected' : '' }}>
                                                                                {{ $user->nama }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($isShowDetail)
                                                                        <span class="
                                                                            {{ $record->status_mengetahui_dozer == 'Approve' ? 'text-success' : '' }}
                                                                            {{ $record->status_mengetahui_dozer == 'Pending' ? 'text-warning' : '' }}
                                                                            {{ $record->status_mengetahui_dozer == 'Reject' ? 'text-danger' : '' }}">
                                                                            {{ ucfirst($record->status_mengetahui_dozer) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                @php
                                                                    $loggedInUserId = session('user_id');
                                                                @endphp

                                                                @if(optional($record)->mengetahui_dozer == $loggedInUserId)
                                                                    <div>
                                                                        <button class="btnApprove btn btn-info btn-sm" data-id="{{ $record->id }}">Approve</button>
                                                                        <button class="btnReject btn btn-danger btn-sm" data-id="{{ $record->id }}">Reject</button>
                                                                    </div>
                                                                @endif

                                                            </div>
        
                                                            <div class="col-md-4">
                                                                <div class="input-group input-group-static mb-3">
                                                                    <label for="jabatan_mengetahui_dozer" class="ms-0">Jabatan</label>
                                                                    <select class="form-control" name="jabatan_mengetahui_dozer" id="jabatan_mengetahui_dozer" required
                                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                                        <option value="Spv. Prod"
                                                                            {{ old('jabatan_mengetahui_dozer', $record->jabatan_mengetahui_dozer ?? '') == 'Spv. Prod' ? 'selected' : '' }}>
                                                                            Spv. Prod</option>
                                                                        <option value="Kabag. Prod"
                                                                            {{ old('jabatan_mengetahui_dozer', $record->jabatan_mengetahui_dozer ?? '') == 'Kabag. Prod' ? 'selected' : '' }}>
                                                                            Kabag. Prod</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    {{-- Dozer End --}}

                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-12 text-end" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">

                                        <a href="{{ route('prod.kalibrasi-ct.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('prod.kalibrasi-ct.export', ['id' => $record->id]) }}" class="btn btn-primary">
                                            <i class="material-icons">download</i> Export PDF
                                        </a>
                                </div>
                            </div>
                            </form>    
                        </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let inputs = document.querySelectorAll("[name^='dozing_dozer_'], [name^='reverse_dozer_'], [name^='gear_shifting_dozer_']");
        inputs.forEach(input => {
            input.addEventListener("input", hitungTotal);
        });

        let loaderInputs = document.querySelectorAll("[name^='digging_loader_'], [name^='swing_isi_loader_'], [name^='load_loader_'], [name^='swing_kosong_loader_']");
        loaderInputs.forEach(input => {
            input.addEventListener("input", hitungTotalPengisian);
        });

        let haulerInputs = document.querySelectorAll("[name^='waktu_antri_hauler_'], [name^='meninggalkan_front_hauler_']");
        haulerInputs.forEach(input => {
            input.addEventListener("input", hitungCycleTime);
        });
    });

    function hitungTotal() {
        document.querySelectorAll("[name^='dozing_dozer_']").forEach(input => {
            let i = input.name.split("_").pop();
            let dozing = parseFloat(document.querySelector(`[name='dozing_dozer_${i}']`).value) || 0;
            let reverse = parseFloat(document.querySelector(`[name='reverse_dozer_${i}']`).value) || 0;
            let gearShifting = parseFloat(document.querySelector(`[name='gear_shifting_dozer_${i}']`).value) || 0;
            
            let total = dozing + reverse + gearShifting;
            document.querySelector(`[name='total_dozer_${i}']`).value = total;
        });
    }

    function hitungTotalPengisian() {
        document.querySelectorAll("[name^='digging_loader_']").forEach(input => {
            let i = input.name.split("_").pop();
            let digging = parseFloat(document.querySelector(`[name='digging_loader_${i}']`).value) || 0;
            let swingIsi = parseFloat(document.querySelector(`[name='swing_isi_loader_${i}']`).value) || 0;
            let load = parseFloat(document.querySelector(`[name='load_loader_${i}']`).value) || 0;
            let swingKosong = parseFloat(document.querySelector(`[name='swing_kosong_loader_${i}']`).value) || 0;

            let totalPengisian = digging + swingIsi + load + swingKosong;
            document.querySelector(`[name='total_pengisian_loader_${i}']`).value = totalPengisian;
        });
    }

    function hitungCycleTime() {
    let i = this.name.match(/\d+/)[0]; // Ambil angka index dari name

    let waktuAntri = document.querySelector(`[name='waktu_antri_hauler_${i}']`).value;
    let meninggalkanFront = document.querySelector(`[name='meninggalkan_front_hauler_${i}']`).value;

    let totalSeconds = convertToSeconds(waktuAntri) + convertToSeconds(meninggalkanFront);
    let result = convertToTimeFormat(totalSeconds);

    document.querySelector(`[name='cycle_timer_hauler_${i}']`).value = result;
}

function convertToSeconds(time) {
    let [hh, mm, ss] = time.split(":").map(Number);
    return (hh * 3600) + (mm * 60) + ss;
}

function convertToTimeFormat(totalSeconds) {
    let hh = Math.floor(totalSeconds / 3600);
    let mm = Math.floor((totalSeconds % 3600) / 60);
    let ss = totalSeconds % 60;
    return `${String(hh).padStart(2, '0')}:${String(mm).padStart(2, '0')}:${String(ss).padStart(2, '0')}`;
}
</script>


@endsection

@section('custom-css')
    <style>
        .table> :not(caption)>*>* {
            padding: 0.5rem;
        }

        .form-container {
            display: flex;
            align-items: center;
            margin: 10px;
            gap: 120px;

        }



        .form-actions {
            justify-content: flex-end;
            display: flex;
            gap: 10px;
            margin-top: 10px;

        }

        .bg-success {
            background-color: #a6000b !important;
        }

        /* Center all content in tbody */
        .table tbody td {
            text-align: center;
            vertical-align: middle;
            height: 60px;
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .table thead {
            position: sticky;
            top: 0;
            z-index: 1;
            background-color: #f8f9fa;

        }

        .table tbody td.form-control {
            text-align: left;
        }




        .custom-checkbox {
            width: 20px;
            height: 20px;
            transform: scale(1.5);
            cursor: pointer;
        }
    </style>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
    $(function() {
        // Delegasi event ke tombol Approve
        $(document).on("click", ".btnApprove", function(e) {
            e.preventDefault();
            const recordId = $(this).data("id"); // Ambil ID dari atribut data-id
            const url = `{{ route('prod.kalibrasi-ct.approve', ['id' => ':id']) }}`.replace(":id", recordId);

            axios.post(url, {
                _token: '{{ csrf_token() }}'
            }).then(function(response) {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message
                    }).then(() => {
                        location.reload(); // Reload halaman
                    });
                }
            }).catch(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan pada sistem'
                });
            });
        });

        // Delegasi event ke tombol Reject
        $(document).on("click", ".btnReject", function(e) {
            e.preventDefault();
            const recordId = $(this).data("id"); // Ambil ID dari atribut data-id
            const url = `{{ route('prod.kalibrasi-ct.reject', ['id' => ':id']) }}`.replace(":id", recordId);

            axios.post(url, {
                _token: '{{ csrf_token() }}'
            }).then(function(response) {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message
                    }).then(() => {
                        location.reload(); // Reload halaman
                    });
                }
            }).catch(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan pada sistem'
                });
            });
        });
    });
</script>

@endsection
