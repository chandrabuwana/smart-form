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
                        <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Form Monitoring Control Disiplin, Skill & Attitude Anak Asuh</h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <form method="POST" id="anakAsuhForm">
                        @csrf
                        @if($isShowDetail && $record)
                            <input type="hidden" name="id" value="{{ $record->id }}">
                        @endif
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="name" class="ms-0">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $record->name ?? '') }}" required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="departemen" class="ms-0">Departemen</label>
                                        <input type="text" class="form-control" id="departemen" name="departemen" value="{{ old('departemen', $record->departemen ?? '') }}" required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nik" class="ms-0">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $record->nik ?? '') }}" required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="jabatan" class="ms-0">Jabatan</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $record->jabatan ?? '') }}" required {{ $isShowDetail ? 'disabled' : '' }}>
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
                                                <input type="date" class="form-control" name="tanggal_{{ $i }}" value="{{ old('tanggal_'.$i, isset($record->tanggal_items[$i-1]) ? $record->tanggal_items[$i-1] : '') }}" {{ $isShowDetail ? 'disabled' : '' }}>
                                            </td>
                                            <td>
                                                <select class="form-control" name="shift_{{ $i }}" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">-- Pilih Shift --</option>
                                                    @foreach(['DS', 'NS'] as $shift)
                                                        <option value="{{ $shift }}" {{ (old('shift_'.$i, isset($record->shift_items[$i-1]) ? $record->shift_items[$i-1] : '') == $shift) ? 'selected' : '' }}>{{ $shift }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <input type="text" class="form-control" name="nama_anak_asuh_{{ $i }}" value="{{ old('nama_anak_asuh_'.$i, isset($record->nama_anak_asuh_items[$i-1]) ? $record->nama_anak_asuh_items[$i-1] : '') }}" {{ $isShowDetail ? 'disabled' : '' }}>
                                            </td>
                                            <td class="checkbox-cell">
                                                <div class="checkbox-wrapper">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="attendance_{{ $i }}" value="hadir" {{ old('attendance_'.$i, isset($record->attendance_items[$i-1]) && $record->attendance_items[$i-1] == 'hadir' ? 'checked' : '') }} {{ $isShowDetail ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="checkbox-cell">
                                                <div class="checkbox-wrapper">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="attendance_{{ $i }}" value="izin" {{ old('attendance_'.$i, isset($record->attendance_items[$i-1]) && $record->attendance_items[$i-1] == 'izin' ? 'checked' : '') }} {{ $isShowDetail ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="checkbox-cell">
                                                <div class="checkbox-wrapper">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="attendance_{{ $i }}" value="sakit" {{ old('attendance_'.$i, isset($record->attendance_items[$i-1]) && $record->attendance_items[$i-1] == 'sakit' ? 'checked' : '') }} {{ $isShowDetail ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="checkbox-cell">
                                                <div class="checkbox-wrapper">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="attendance_{{ $i }}" value="alfa" {{ old('attendance_'.$i, isset($record->attendance_items[$i-1]) && $record->attendance_items[$i-1] == 'alfa' ? 'checked' : '') }} {{ $isShowDetail ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="review_temuan_{{ $i }}" rows="2" {{ $isShowDetail ? 'disabled' : '' }}>{{ old('review_temuan_'.$i, isset($record->review_temuan_items[$i-1]) ? $record->review_temuan_items[$i-1] : '') }}</textarea>
                                            </td>
                                            <td>
                                                <select class="form-control" name="disiplin_score_{{ $i }}" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">--</option>
                                                    @foreach(range(1, 4) as $score)
                                                        <option value="{{ $score }}" {{ (old('disiplin_score_'.$i, isset($record->disiplin_score_items[$i-1]) ? $record->disiplin_score_items[$i-1] : '') == $score) ? 'selected' : '' }}>{{ $score }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="skill_score_{{ $i }}" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">--</option>
                                                    @foreach(range(1, 4) as $score)
                                                        <option value="{{ $score }}" {{ (old('skill_score_'.$i, isset($record->skill_score_items[$i-1]) ? $record->skill_score_items[$i-1] : '') == $score) ? 'selected' : '' }}>{{ $score }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="attitude_score_{{ $i }}" {{ $isShowDetail ? 'disabled' : '' }}>
                                                    <option value="">--</option>
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
                            <div class="mt-4">
                                <h6>Penilaian Kategori (Disiplin/Skill/Attitude)</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="max-width: 300px;">
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
                                        <label for="created_by" class="ms-0">Created By</label>
                                        <input type="text" class="form-control" id="created_by" name="created_by" value="{{ old('created_by', $record->created_by ?? '') }}" required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="acknowledged_by" class="ms-0">Acknowledged By</label>
                                        <input type="text" class="form-control" id="acknowledged_by" name="acknowledged_by" value="{{ old('acknowledged_by', $record->acknowledged_by ?? '') }}" {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    @if($isShowDetail)
                                        <a href="{{ route('prod.anak-asuh.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('prod.anak-asuh.export', ['id' => $record->id]) }}" class="btn btn-primary">
                                            <i class="material-icons">download</i> Export PDF
                                        </a>
                                    @else
                                        <a href="{{ route('prod.anak-asuh.dashboard') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
    .table > :not(caption) > * > * {
        padding: 0.5rem;
    }
    .bg-success {
        background-color: #00a65a !important;
    }
    /* Center all content in tbody */
    .table tbody td {
        text-align: center;
        vertical-align: middle;
        height: 60px;
    }
    .table tbody td input.form-control,
    .table tbody td select.form-control,
    .table tbody td textarea.form-control {
        text-align: center;
    }
    /* Override text alignment for review/temuan textarea */
    .table tbody td textarea.form-control {
        text-align: left;
    }
    /* Center radio buttons */
    .checkbox-cell {
        padding: 0 !important;
        position: relative;
        min-width: 50px;
    }
    .checkbox-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .form-check {
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .form-check-input[type="radio"] {
        margin: 0;
        width: 20px;
        height: 20px;
        cursor: pointer;
        position: relative;
        top: 0;
    }
</style>
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
$(function() {
    var form = $("#anakAsuhForm");
    var submitBtn = form.find('button[type="submit"]');

    form.submit(function(e) {
        e.preventDefault();
        submitBtn.prop('disabled', true);

        var formData = new FormData(this);
        
        axios.post('{{ route("prod.anak-asuh.store") }}', formData)
            .then(function(response) {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("prod.anak-asuh.dashboard") }}';
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