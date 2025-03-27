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
                        <h6 class="text-white text-capitalize ps-3">Edit Form Monitoring Control Disiplin, Skill & Attitude Anak Asuh</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <form method="POST" id="anakAsuhEditForm" action="{{ route('prod.anak-asuh.update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $record->id }}">
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="name" class="ms-0">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $record->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="departemen" class="ms-0">Departemen</label>
                                        <div class="form-control p-0">
                                            {!! \Modules\SmartForm\helpers\DepartmentHelper::renderDepartmentSelect('departemen', old('departemen', $record->departemen), false, true, 'departemen', 'form-control border-0') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nik" class="ms-0">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $record->nik) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="jabatan" class="ms-0">Jabatan</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $record->jabatan) }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Anak Asuh Monitoring Table -->
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>SHIFT</th>
                                            <th>NO</th>
                                            <th>NAMA ANAK ASUH</th>
                                            <th colspan="4" class="text-center">KEHADIRAN</th>
                                            <th>REVIEW / TEMUAN</th>
                                            <th colspan="3" class="text-center">KATEGORI</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4"></th>
                                            <th>HADIR</th>
                                            <th>IZIN</th>
                                            <th>SAKIT</th>
                                            <th>ALFA</th>
                                            <th></th>
                                            <th>DISIPLIN</th>
                                            <th>SKILL</th>
                                            <th>ATTITUDE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 1; $i <= 10; $i++)
                                        <tr>
                                            <td>
                                                <input type="date" class="form-control" name="tanggal_{{ $i }}" value="{{ old('tanggal_'.$i, isset($record->tanggal_items[$i-1]) ? $record->tanggal_items[$i-1] : '') }}">
                                            </td>
                                            <td>
                                                <select class="form-control" name="shift_{{ $i }}">
                                                    <option value="">-- Pilih Shift --</option>
                                                    @foreach(['DS', 'NS'] as $shift)
                                                        <option value="{{ $shift }}" {{ (old('shift_'.$i, isset($record->shift_items[$i-1]) ? $record->shift_items[$i-1] : '') == $shift) ? 'selected' : '' }}>{{ $shift }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <input type="text" class="form-control" name="nama_anak_asuh_{{ $i }}" value="{{ old('nama_anak_asuh_'.$i, isset($record->nama_anak_asuh_items[$i-1]) ? $record->nama_anak_asuh_items[$i-1] : '') }}">
                                            </td>
                                            <td class="checkbox-cell">
                                                <div class="checkbox-wrapper">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="attendance_{{ $i }}" value="hadir" {{ old('attendance_'.$i, isset($record->attendance_items[$i-1]) && $record->attendance_items[$i-1] == 'hadir' ? 'checked' : '') }}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="checkbox-cell">
                                                <div class="checkbox-wrapper">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="attendance_{{ $i }}" value="izin" {{ old('attendance_'.$i, isset($record->attendance_items[$i-1]) && $record->attendance_items[$i-1] == 'izin' ? 'checked' : '') }}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="checkbox-cell">
                                                <div class="checkbox-wrapper">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="attendance_{{ $i }}" value="sakit" {{ old('attendance_'.$i, isset($record->attendance_items[$i-1]) && $record->attendance_items[$i-1] == 'sakit' ? 'checked' : '') }}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="checkbox-cell">
                                                <div class="checkbox-wrapper">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="attendance_{{ $i }}" value="alfa" {{ old('attendance_'.$i, isset($record->attendance_items[$i-1]) && $record->attendance_items[$i-1] == 'alfa' ? 'checked' : '') }}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="review_temuan_{{ $i }}" rows="2">{{ old('review_temuan_'.$i, isset($record->review_temuan_items[$i-1]) ? $record->review_temuan_items[$i-1] : '') }}</textarea>
                                            </td>
                                            <td>
                                                <select class="form-control" name="disiplin_score_{{ $i }}">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach(range(1, 4) as $score)
                                                        <option value="{{ $score }}" {{ (old('disiplin_score_'.$i, isset($record->disiplin_score_items[$i-1]) ? $record->disiplin_score_items[$i-1] : '') == $score) ? 'selected' : '' }}>{{ $score }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="skill_score_{{ $i }}">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach(range(1, 4) as $score)
                                                        <option value="{{ $score }}" {{ (old('skill_score_'.$i, isset($record->skill_score_items[$i-1]) ? $record->skill_score_items[$i-1] : '') == $score) ? 'selected' : '' }}>{{ $score }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="attitude_score_{{ $i }}">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach(range(1, 4) as $score)
                                                        <option value="{{ $score }}" {{ (old('attitude_score_'.$i, isset($record->attitude_score_items[$i-1]) ? $record->attitude_score_items[$i-1] : '') == $score) ? 'selected' : '' }}>{{ $score }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>

                            <!-- Score Legend -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h6>Keterangan Score:</h6>
                                    <table class="table table-bordered">
                                        <tr class="bg-danger text-white">
                                            <td>1</td>
                                            <td>Kurang</td>
                                        </tr>
                                        <tr class="bg-warning">
                                            <td>2</td>
                                            <td>Cukup</td>
                                        </tr>
                                        <tr class="bg-info text-white">
                                            <td>3</td>
                                            <td>Baik</td>
                                        </tr>
                                        <tr class="bg-success text-white">
                                            <td>4</td>
                                            <td>Sangat Baik</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Signature Section -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="created_by" class="ms-0">Dibuat Oleh</label>
                                        <input type="text" class="form-control" id="created_by" name="created_by" value="{{ old('created_by', $record->created_by) }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="{{ route('prod.anak-asuh.dashboard') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
