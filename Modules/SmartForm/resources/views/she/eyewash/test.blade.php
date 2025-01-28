@extends('master.master_page')


@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Inspeksi Eyewash</h6>
                </div>
            </div>
                <div class="card-body px-0 pb-2">
                    <form action="{{ route('she-inspeksi.submit') }}" method="POST">
                        @csrf
                        <div class="mx-3">
                            <!-- Date and Location -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Tanggal</label>
                                        <input type="date" name="inspection_date" class="form-control" required
                                            value="{{ $isShowDetail ? $maintenanceRecord->inspection_date : now()->format('Y-m-d') }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Lokasi</label>
                                        <input type="text" name="location" class="form-control" required
                                            value="{{ $isShowDetail ? $maintenanceRecord->location : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <!-- Inspection Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2" class="text-center">Bulan</th>
                                            <th colspan="7" class="text-center">Item Pemeriksaan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Kondisi Tangki</th>
                                            <th class="text-center">Penutup Tangki</th>
                                            <th class="text-center">Warna Air</th>
                                            <th class="text-center">Bau Air</th>
                                            <th class="text-center">Volume Air</th>
                                            <th class="text-center">Kebersihan Tangki</th>
                                            <th class="text-center">Fungsi EyeWash</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $months = [
                                                'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
                                                'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
                                            ];
                                            $conditions = ['Baik', 'Rusak'];
                                            $waterColors = ['Jernih', 'Keruh'];
                                            $waterSmells = ['Tidak bau', 'Bau'];
                                            $volumes = ['Penuh', 'Kurang', 'Kosong'];
                                            $cleanConditions = ['Bersih', 'Kotor'];
                                        @endphp

                                        @foreach($months as $index => $month)
                                        @php
                                            $monthData = $isShowDetail ? ($maintenanceRecord->monthly_data[$month] ?? null) : null;
                                        @endphp
                                        <tr>
                                            <td class="text-center align-middle">{{ $index + 1 }}</td>
                                            <td class="align-middle">{{ $month }}</td>
                                            <td>
                                                <select name="kondisi_tangki_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['kondisi_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="penutup_tangki_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['penutup_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="warna_air_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($waterColors as $color)
                                                        <option value="{{ $color }}" {{ $monthData && $monthData['warna_air'] == $color ? 'selected' : '' }}>
                                                            {{ $color }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="bau_air_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($waterSmells as $smell)
                                                        <option value="{{ $smell }}" {{ $monthData && $monthData['bau_air'] == $smell ? 'selected' : '' }}>
                                                            {{ $smell }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="volume_air_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($volumes as $volume)
                                                        <option value="{{ $volume }}" {{ $monthData && $monthData['volume_air'] == $volume ? 'selected' : '' }}>
                                                            {{ $volume }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="kebersihan_tangki_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($cleanConditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['kebersihan_tangki'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="fungsi_eyewash_{{ $month }}" class="form-control form-select" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    @foreach($conditions as $condition)
                                                        <option value="{{ $condition }}" {{ $monthData && $monthData['fungsi_eyewash'] == $condition ? 'selected' : '' }}>
                                                            {{ $condition }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Notes -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group input-group-static">
                                        <label>Catatan</label>
                                        <textarea name="notes" class="form-control" rows="3" {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $maintenanceRecord->notes : '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Approval Section -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label>Dibuat Oleh Tim Hygiene</label>
                                        <input type="text" name="created_by" class="form-control" required
                                            value="{{ $isShowDetail ? $maintenanceRecord->created_by : session('username') }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label>Diperiksa Oleh Supervisor</label>
                                        <input type="text" name="supervisor" class="form-control" required
                                            value="{{ $isShowDetail ? $maintenanceRecord->supervisor : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label>Disampaikan kepada DH</label>
                                        <input type="text" name="dh" class="form-control" required
                                            value="{{ $isShowDetail ? $maintenanceRecord->dh : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label>Disampaikan kepada DH Terkait</label>
                                        <input type="text" name="dh_terkait" class="form-control"
                                            value="{{ $isShowDetail ? $maintenanceRecord->dh_terkait : '' }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div> -->
                            </div>

                            <!-- Submit/Back Buttons -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    @if($isShowDetail)
                                        <a href="{{ route('she-inspeksi.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('she-inspeksi.form.export', ['id' => $maintenanceRecord->id]) }}" class="btn btn-primary">
                                            <i class="fas fa-file-export"></i> Export
                                        </a>
                                    @else
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ route('she-inspeksi.dashboard') }}" class="btn btn-secondary">Back</a>
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
