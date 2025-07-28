@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
        .table > :not(caption) > * > * {
        padding: 0.5rem;
    }
    .bg-success {
        background-color: #00a65a !important;
    }
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
    .table tbody td textarea.form-control {
        text-align: left;
    }
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
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.5;
        border: 1px solid #ced4da;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
    }
    
    .select2-results__option {
        padding: 6px 12px;
        font-size: 14px;
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

            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            @if($isShowDetail)
                                Detail
                            @elseif(isset($isEdit) && $isEdit)
                                Edit
                            @else
                                New
                            @endif
                            Form Monitoring Control Disiplin, Skill & Attitude Anak Asuh
                        </h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <form method="POST" id="anakAsuhForm" action="{{ route('prod.anak-asuh.store') }}">
                        @csrf
                        <div class="mx-3">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="name" class="ms-0">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $record->name ?? session('username')) }}" required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="departemen" class="ms-0">Departemen</label>
                                        @if($isShowDetail)
                                            <input type="text" class="form-control" id="departemen" 
                                                value="{{ \Modules\SmartForm\helpers\DepartmentHelper::getDepartmentNameWithCode($record->departemen ?? session('kode_department')) }}" 
                                                disabled>
                                            <input type="hidden" name="departemen" value="{{ $record->departemen ?? session('kode_department') }}">
                                        @else
                                            <div class="form-control p-0">
                                                {!! \Modules\SmartForm\helpers\DepartmentHelper::renderDepartmentSelect('departemen', old('departemen', $record->departemen ?? session('kode_department')), false, true, 'departemen', 'form-control border-0') !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nik" class="ms-0">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $record->nik ?? session('user_id')) }}" required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="jabatan" class="ms-0">Jabatan</label>
                                        @if($isShowDetail)
                                            <input type="text" class="form-control" id="jabatan" 
                                                value="{{ \Modules\SmartForm\helpers\JabatanHelper::getJabatanNameWithCode($record->jabatan ?? session('kode_jabatan')) }}" 
                                                disabled>
                                            <input type="hidden" name="jabatan" value="{{ $record->jabatan ?? session('kode_jabatan') }}">
                                        @else
                                            <div class="form-control p-0">
                                                {!! \Modules\SmartForm\helpers\JabatanHelper::renderJabatanSelect('jabatan', old('jabatan', $record->jabatan ?? session('kode_jabatan')), false, true, 'jabatan', 'form-control border-0') !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site" class="ms-0">Site</label>
                                        @if($isShowDetail)
                                            <input type="text" class="form-control" id="site" name="site" 
                                                value="{{ \Modules\SmartForm\helpers\SiteHelper::getSiteNameByCode($record->site ?? session('kode_site')) }}" 
                                                disabled>
                                            <input type="hidden" name="site" value="{{ $record->site ?? session('kode_site') }}">
                                        @else
                                            <div class="form-control p-0">
                                                {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site', old('site', $record->site ?? session('kode_site')), false, true, 'site', 'form-control border-0') !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="tanggal" class="ms-0">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                            value="{{ old('tanggal', $record->tanggal ?? date('Y-m-d')) }}" 
                                            required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="shift" class="ms-0">Shift</label>
                                        <select class="form-control" id="shift" name="shift">
                                            <option value="">-- Pilih Shift --</option>
                                            @foreach(['DS', 'NS'] as $shift)
                                                <option value="{{ $shift }}" {{ old('shift', $record->shift ?? '') == $shift ? 'selected' : '' }}>
                                                    {{ $shift }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Data Anak Asuh <span class="badge bg-primary" id="rowCount">0</span></h6>
                                    <div>
                                        @if(!$isShowDetail)
                                            <button type="button" class="btn btn-success btn-sm" id="addRowBtn">
                                                <i class="material-icons">add</i> Tambah Anak Asuh
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <table class="table table-bordered" id="anakAsuhTable">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>SHIFT</th>
                                            <th>NO</th>
                                            <th>NAMA ANAK ASUH</th>
                                            <th colspan="4" class="text-center">KEHADIRAN</th>
                                            <th>REVIEW / TEMUAN</th>
                                            <th colspan="3" class="text-center">KATEGORI</th>
                                            @if(!$isShowDetail)
                                                <th>Aksi</th>
                                            @endif
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
                                            @if(!$isShowDetail)
                                                <th></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $initialRows = isset($record->nama_anak_asuh_items) && is_array($record->nama_anak_asuh_items) 
                                                ? count($record->nama_anak_asuh_items) 
                                                : 1;
                                        @endphp
                                        
                                        @for($i = 1; $i <= $initialRows; $i++)
                                            <tr id="row_{{ $i }}">
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
                                                    <select name="nama_anak_asuh_{{ $i }}" class="form-control text-center" {{ $isShowDetail ? 'disabled' : '' }}>
                                                        <option value="">-- Pilih Anak Asuh --</option>
                                                        @foreach($approvalList as $user)
                                                        <option value="{{ $user->nama }}" {{ (old('nama_anak_asuh_'.$i, isset($record->nama_anak_asuh_items[$i-1]) ? $record->nama_anak_asuh_items[$i-1] : '') == $user->nama) ? 'selected' : '' }}>
                                                            {{ $user->nama }} ({{ $user->nik }})
                                                        </option>
                                                    @endforeach
                                                    </select>
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
                                                @if(!$isShowDetail)
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm removeRow" data-row="{{ $i }}">
                                                            <i class="material-icons">delete</i>
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <h6>Penilaian Kategori (Disiplin/Skill/Attitude)</h6>
                                <div class="table-responsive">
                                    <table class="table" style="max-width: 300px; border-radius: 8px; overflow: hidden;">
                                        <tr class="bg-danger text-white">
                                            <td style="width: 50px; text-align: center; border: 1px solid #dee2e6;">1</td>
                                            <td style="border: 1px solid #dee2e6;">Kurang</td>
                                        </tr>
                                        <tr class="bg-warning">
                                            <td style="width: 50px; text-align: center; border: 1px solid #dee2e6;">2</td>
                                            <td style="border: 1px solid #dee2e6;">Cukup</td>
                                        </tr>
                                        <tr class="bg-info text-white">
                                            <td style="width: 50px; text-align: center; border: 1px solid #dee2e6;">3</td>
                                            <td style="border: 1px solid #dee2e6;">Baik</td>
                                        </tr>
                                        <tr class="bg-success text-white">
                                            <td style="width: 50px; text-align: center; border: 1px solid #dee2e6;">4</td>
                                            <td style="border: 1px solid #dee2e6;">Sangat Baik</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="created_by" class="ms-0">Dibuat Oleh</label>
                                        <input type="text" class="form-control" id="created_by" name="created_by" value="{{ old('created_by', $record->created_by ?? session('username')) }}" required {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    @if($isShowDetail)
                                        <a href="{{ route('prod.anak-asuh.dashboard') }}" class="btn btn-secondary">Back</a>
                                        @if(isset($record->approval_status) && $record->approval_status == 'approved')
                                            <a href="{{ route('prod.anak-asuh.export', ['id' => $record->id]) }}" class="btn btn-primary">
                                                <i class="material-icons">download</i> Export PDF
                                            </a>
                                        @endif
                                    @elseif(isset($isEdit) && $isEdit)
                                        <a href="{{ route('prod.anak-asuh.dashboard') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
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

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(function() {
        var form = $("#anakAsuhForm");
        var submitBtn = form.find('button[type="submit"]');

        
        var initialRowCount = {{ isset($record->nama_anak_asuh_items) && is_array($record->nama_anak_asuh_items) ? count($record->nama_anak_asuh_items) : 1 }};
        
        var currentRowCount = initialRowCount;
        
        var nextRowNumber = initialRowCount + 1;
        
        function initSelect2(rowIndex) {
            $(`select[name="nama_anak_asuh_${rowIndex}"]`).select2({
                placeholder: "-- Pilih Anak Asuh --",
                allowClear: true,
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
            });
        }
        
        for (let i = 1; i <= initialRowCount; i++) {
            initSelect2(i);
        }

        var maxRows = 50;

        $("#tanggal").flatpickr({
            dateFormat: "Y-m-d",
            defaultDate: "{{ date('Y-m-d') }}",
            onChange: function(selectedDates, dateStr, instance) {
                syncRowsWithNames();
            }
        });

        function initRowDatepicker(rowIndex) {
            $(`input[name="tanggal_${rowIndex}"]`).flatpickr({
                dateFormat: "Y-m-d"
            });
        }

        for (let i = 1; i <= initialRowCount; i++) {
            initRowDatepicker(i);
        }

        function syncRowsWithNames() {
            const mainDate = $("#tanggal").val();
            const mainShift = $("#shift").val();
            
            $("#anakAsuhTable tbody tr").each(function() {
                const rowId = $(this).attr('id').replace('row_', '');
                const nameField = $(`select[name="nama_anak_asuh_${rowId}"]`);
                
                if (nameField.length && nameField.val() && nameField.val() !== '') {
                    if (mainDate) {
                        const rowDatePicker = $(`input[name="tanggal_${rowId}"]`)[0]._flatpickr;
                        if (rowDatePicker) {
                            rowDatePicker.setDate(mainDate);
                        }
                    }
                    
                    if (mainShift) {
                        $(`select[name="shift_${rowId}"]`).val(mainShift);
                    }
                }
            });
        }

        $("#shift").on('change', function() {
            syncRowsWithNames();
        });

        function setupNameFieldMonitoring(rowId) {
            $(`select[name="nama_anak_asuh_${rowId}"]`).on('change', function() {
                const nameValue = $(this).val();
                const mainDate = $("#tanggal").val();
                const mainShift = $("#shift").val();
                
                if (nameValue && nameValue !== '') {
                    const rowDatePicker = $(`input[name="tanggal_${rowId}"]`)[0]._flatpickr;
                    if (rowDatePicker && !rowDatePicker.input.value) {
                        rowDatePicker.setDate(mainDate);
                    }
                    
                    const shiftField = $(`select[name="shift_${rowId}"]`);
                    if (!shiftField.val() && mainShift) {
                        shiftField.val(mainShift);
                    }
                } else {
                    const rowDatePicker = $(`input[name="tanggal_${rowId}"]`)[0]._flatpickr;
                    if (rowDatePicker) {
                        rowDatePicker.clear();
                    }
                    
                    $(`select[name="shift_${rowId}"]`).val('');
                }
            });
        }

        for (let i = 1; i <= initialRowCount; i++) {
            setupNameFieldMonitoring(i);
        }

        $("#addRowBtn").on('click', function() {
            if (currentRowCount < maxRows) {
                currentRowCount++;
                
                const newRow = `
                    <tr id="row_${nextRowNumber}">
                        <td>
                            <input type="date" class="form-control" name="tanggal_${nextRowNumber}" {{ $isShowDetail ? 'disabled' : '' }}>
                        </td>
                        <td>
                            <select class="form-control" name="shift_${nextRowNumber}" {{ $isShowDetail ? 'disabled' : '' }}>
                                <option value="">-- Pilih Shift --</option>
                                @foreach(['DS', 'NS'] as $shift)
                                    <option value="{{ $shift }}">{{ $shift }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>${currentRowCount}</td>
                        <td>
                            <select name="nama_anak_asuh_${nextRowNumber}" class="form-control text-center select2-anak-asuh" {{ $isShowDetail ? 'disabled' : '' }}>
                                <option value="">-- Pilih Anak Asuh --</option>
                                @if(isset($approvalList))
                                    @foreach($approvalList as $user)
                                        <option value="{{ $user->nama }}">
                                            {{ $user->nama }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                        <td class="checkbox-cell">
                            <div class="checkbox-wrapper">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="attendance_${nextRowNumber}" value="hadir" {{ $isShowDetail ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </td>
                        <td class="checkbox-cell">
                            <div class="checkbox-wrapper">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="attendance_${nextRowNumber}" value="izin" {{ $isShowDetail ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </td>
                        <td class="checkbox-cell">
                            <div class="checkbox-wrapper">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="attendance_${nextRowNumber}" value="sakit" {{ $isShowDetail ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </td>
                        <td class="checkbox-cell">
                            <div class="checkbox-wrapper">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="attendance_${nextRowNumber}" value="alfa" {{ $isShowDetail ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </td>
                        <td>
                            <textarea class="form-control" name="review_temuan_${nextRowNumber}" rows="2" {{ $isShowDetail ? 'disabled' : '' }}></textarea>
                        </td>
                        <td>
                            <select class="form-control" name="disiplin_score_${nextRowNumber}" {{ $isShowDetail ? 'disabled' : '' }}>
                                <option value="">--</option>
                                @foreach(range(1, 4) as $score)
                                    <option value="{{ $score }}">{{ $score }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="skill_score_${nextRowNumber}" {{ $isShowDetail ? 'disabled' : '' }}>
                                <option value="">--</option>
                                @foreach(range(1, 4) as $score)
                                    <option value="{{ $score }}">{{ $score }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="attitude_score_${nextRowNumber}" {{ $isShowDetail ? 'disabled' : '' }}>
                                <option value="">--</option>
                                @foreach(range(1, 4) as $score)
                                    <option value="{{ $score }}">{{ $score }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRow" data-row="${nextRowNumber}">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                `;
                
                $("#anakAsuhTable tbody").append(newRow);
                
                initRowDatepicker(nextRowNumber);
                
                initSelect2(nextRowNumber);
                
                setupNameFieldMonitoring(nextRowNumber);
                
                $("#rowCount").text(currentRowCount);
                
                nextRowNumber++;
                
                if (currentRowCount >= maxRows) {
                    $(this).prop('disabled', true);
                }
            }
        });
        
        $(document).on('click', '.removeRow', function() {
            const rowId = $(this).data('row');
            $(`#row_${rowId}`).remove();
            
            currentRowCount--;
            
            let rowNum = 1;
            $("#anakAsuhTable tbody tr").each(function() {
                $(this).find('td:eq(2)').text(rowNum++);
            });
            
            $("#rowCount").text(currentRowCount);
            
            if (currentRowCount < maxRows) {
                $("#addRowBtn").prop('disabled', false);
            }
        });

        $(document).ready(function() {
            const isEdit = {{ isset($isEdit) && $isEdit ? 'true' : 'false' }};
            
            if (!isEdit) {
                syncRowsWithNames();
            }
            
            $("#rowCount").text(currentRowCount);
        });

        form.submit(function(e) {
            e.preventDefault();
            submitBtn.prop('disabled', true);

            var formData = new FormData(this);
            
            formData.append('row_count', nextRowNumber);
            
            axios.post('{{ isset($isEdit) && $isEdit ? route("prod.anak-asuh.update") : route("prod.anak-asuh.store") }}', formData)
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