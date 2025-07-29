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
                        <h6 class="text-white text-capitalize ps-3">Edit Inspeksi Toilet, Mess dan Kantor</h6>
                    </div>
                </div>
                <div class="card-body px-4">
                    <form id="messEditForm" action="{{ route('she.mess.store') }}" method="POST">
                        @csrf
                        @if(isset($data) && isset($data->id))
                            <input type="hidden" name="id" value="{{ $data->id }}">
                        @endif
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Site Name</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site_name', $data->site_name ?? null, !$isShowDetail, true, 'site_name', 'form-control') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Work Location</label>
                                        <input type="text" class="form-control" name="work_location" value="{{ isset($data) ? $data->work_location : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Department</label>
                                        <input type="text" class="form-control" name="department" value="{{ isset($data) ? $data->department : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Shift</label>
                                        <select class="form-control" name="shift" required>
                                            <option value="">-- Pilih Shift --</option>
                                            <option value="DS" {{ isset($data) && $data->shift == 'DS' ? 'selected' : '' }}>Day Shift</option>
                                            <option value="NS" {{ isset($data) && $data->shift == 'NS' ? 'selected' : '' }}>Night Shift</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Jumlah Inspektor</label>
                                        <input type="number" class="form-control" name="inspector_count" value="{{ isset($data) ? $data->inspector_count : '1' }}" min="1" step="1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Tanggal Survey</label>
                                        <input type="date" class="form-control" name="survey_date" value="{{ isset($data) ? $data->survey_date : now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Tanggal Penyelesaian</label>
                                        <input type="date" class="form-control" name="completion_date" value="{{ isset($data) ? $data->completion_date : now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Risk Level Table -->
                        <table class="table table-bordered mb-4">
                            <thead>
                                <tr style="background-color: #3498db; color: white;">
                                    <th>TINGKAT RISIKO</th>
                                    <th>DEFINISI</th>
                                    <th>TINDAKAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="background-color: #e74c3c; color: white; font-weight: bold; text-align: center;">TINGGI</td>
                                    <td style="white-space: pre-line;">
                                        Tidak sesuai baku mutu/peraturan perundangan dan mendapatkan peringatan keras dari pemerintah, penghentian operasional perusahaan sementara atau berdampak ke masyarakat yg lebih luas
                                    </td>
                                    <td style="white-space: pre-line;">
                                        Pekerjaan dapat dilakukan
                                        Dengan pengawasan ketat
                                        Harus ada ijin kerja
                                        Harus ada JSA
                                        Harus ada toolbox meeting
                                        Harus ada pengawasan
                                        Harus ada APD lengkap
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f39c12; color: white; font-weight: bold; text-align: center;">SEDANG</td>
                                    <td style="white-space: pre-line;">
                                        Tidak sesuai baku mutu/peraturan perundangan dan mendapatkan teguran dari pemerintah atau berdampak ke lingkungan sekitar perusahaan
                                    </td>
                                    <td style="white-space: pre-line;">
                                        Pekerjaan dapat dilakukan
                                        Dengan pengawasan
                                        Harus ada ijin kerja
                                        Harus ada JSA
                                        Harus ada toolbox meeting
                                        Harus ada pengawasan
                                        Harus ada APD sesuai pekerjaan
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #2ecc71; color: white; font-weight: bold; text-align: center;">RENDAH</td>
                                    <td style="white-space: pre-line;">
                                        Tidak ada peraturan yg berlaku atau berdampak kelingkungan perusahaan
                                    </td>
                                    <td style="white-space: pre-line;">
                                        Tidak diperlukan pengendalian tambahan.
                                        Pertimbangkan penyelesaian yang lebih hemat biaya atau peningkatan yang tidak menambah biaya.
                                        Pemantauan diperlukan untuk memastikan bahwa pengendalian dipelihara.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Checklist Table -->
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #f4f4f4;">
                                        <th width="5%" class="text-center align-middle">No</th>
                                        <th width="40%" class="align-middle">Item Pemeriksaan</th>
                                        <th width="15%" class="text-center align-middle">Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $checklistItems = [
                                            'Bangunan, Atap, dinding, pintu, jendela, aman dan bersih.',
                                            'Permukaan tempat jalan, lantai dalam kondis bersih dan didisinfeksi',
                                            'Penerangan dan ventilasi cukup',
                                            'Toilet bersih dan tidak berbau',
                                            'Toilet dalam kondisi baik dan berfungsi',
                                            'Tersedia sabun cuci tangan',
                                            'Tersedia tempat sampah',
                                            'Tersedia tissue toilet',
                                            'Tersedia disinfektan',
                                            'Tersedia air bersih',
                                            'Tersedia sapu dan alat pel',
                                            'Tersedia sikat toilet',
                                            'Tersedia karbol',
                                            'Tersedia pengharum ruangan',
                                            'Tersedia tisu tangan',
                                            'Tersedia hand sanitizer',
                                            'Tersedia tempat cuci tangan',
                                            'Tersedia poster cuci tangan',
                                            'Tersedia poster etika batuk',
                                            'Tersedia poster physical distancing',
                                            'Kondisi Bangunan',
                                        ];
                                    @endphp

                                    @foreach($checklistItems as $index => $item)
                                        <tr>
                                            <td class="text-center align-middle">{{ $index + 1 }}</td>
                                            <td class="align-middle">{{ $item }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center gap-3">
                                                    @php
                                                        $checklist_value = isset($data) && is_array($data->checklist_items) ? 
                                                            ($data->checklist_items[$index] ?? '') : '';
                                                    @endphp
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="checklist[{{ $index }}]" value="OK" id="ok_{{ $index }}" {{ $checklist_value == 'OK' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="ok_{{ $index }}">OK</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="checklist[{{ $index }}]" value="NOT OK" id="not_ok_{{ $index }}" {{ $checklist_value == 'NOT OK' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="not_ok_{{ $index }}">NOT OK</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Risk Level and Notes Section -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label"><strong>Tingkat Risiko</strong></label>
                                    <div class="p-3" style="background-color: #ffff00;">
                                        <strong>Resiko Sedang</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="keterangan" class="form-label"><strong>Keterangan</strong></label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4"
                                        placeholder="Harus dilakukan pengendalian tambahan untuk menurunkan tingkat resiko. Pengendalian tambahan harus diterapkan dalam periode waktu tertentu."
                                        style="resize: none;">{{ isset($data->keterangan) ? $data->keterangan : '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Rincian Bahaya -->
                        <table class="table table-bordered mb-4">
                            <thead>
                                <tr style="background-color: #f4f4f4;">
                                    <th width="40%" class="align-middle">Rincian Bahaya</th>
                                    <th width="25%" class="align-middle">Perbaikan Langsung</th>
                                    <th width="20%" class="align-middle">Dilakukan Oleh</th>
                                    <th width="15%" class="align-middle">Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #dee2e6;">
                                        <textarea class="form-control border-0" name="risk_description" rows="3" placeholder="Deskripsi Rincian Bahaya">{{ isset($data->risk_description) ? $data->risk_description : '' }}</textarea>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <textarea class="form-control border-0" name="improvement_action" rows="3" placeholder="Deskripsi Perbaikan langsung">{{ isset($data->improvement_action) ? $data->improvement_action : '' }}</textarea>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <textarea class="form-control border-0" name="done_by" rows="3" placeholder="Dilakukan oleh">{{ isset($data->done_by) ? $data->done_by : '' }}</textarea>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <input type="date" class="form-control border-0" name="completion_date" value="{{ isset($data->completion_date) ? $data->completion_date : now()->format('Y-m-d') }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Approval Section -->
                        <table class="table table-bordered mb-4">
                            <tr>
                                <td width="15%" class="border">Diinspeksi Oleh</td>
                                <td width="25%" class="border">
                                    <select name="inspected_by_name" id="inspected_by_name" class="form-control text-center" required>
                                        <option value="">-- Pilih Inspektor --</option>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $data->inspected_by_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="inspected_by_nik" value="{{ isset($data) ? $data->inspected_by_nik : '' }}">
                                </td>
                                <td width="10%" class="border">Status</td>
                                <td width="15%" class="border">
                                    <span class="badge bg-{{ isset($data) && $data->inspected_by_status == 'approved' ? 'success' : (isset($data) && $data->inspected_by_status == 'rejected' ? 'danger' : 'secondary') }}">
                                        {{ isset($data) ? ucfirst($data->inspected_by_status) : 'Pending' }}
                                    </span>
                                    <input type="hidden" name="inspected_by_status" value="{{ isset($data) ? $data->inspected_by_status : 'pending' }}">
                                </td>
                                <td width="10%" class="border">Tanggal</td>
                                <td width="25%" class="border">
                                    {{ isset($data) && $data->inspection_date ? date('d/m/Y', strtotime($data->inspection_date)) : date('d/m/Y') }}
                                    <input type="hidden" name="inspection_date" value="{{ isset($data) ? $data->inspection_date : now()->format('Y-m-d') }}">
                                </td>
                            </tr>
                            <tr>
                                <td width="15%" class="border">Diinspeksi Oleh</td>
                                <td width="25%" class="border">
                                    <select name="inspected_by2_name" id="inspected_by2_name" class="form-control text-center" required>
                                        <option value="">-- Pilih Inspektor --</option>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $data->inspected_by2_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="inspected_by2_nik" value="{{ isset($data) ? $data->inspected_by2_nik : '' }}">
                                </td>
                                <td width="10%" class="border">Status</td>
                                <td width="15%" class="border">
                                    <span class="badge bg-{{ isset($data) && $data->inspected_by2_status == 'approved' ? 'success' : (isset($data) && $data->inspected_by2_status == 'rejected' ? 'danger' : 'secondary') }}">
                                        {{ isset($data) ? ucfirst($data->inspected_by2_status) : 'Pending' }}
                                    </span>
                                    <input type="hidden" name="inspected_by2_status" value="{{ isset($data) ? $data->inspected_by2_status : 'pending' }}">
                                </td>
                                <td width="10%" class="border">Tanggal</td>
                                <td width="25%" class="border">
                                    {{ isset($data) && $data->inspection_date2 ? date('d/m/Y', strtotime($data->inspection_date2)) : date('d/m/Y') }}
                                    <input type="hidden" name="inspection_date2" value="{{ isset($data) ? $data->inspection_date2 : now()->format('Y-m-d') }}">
                                </td>
                            </tr>
                            <tr>
                                <td width="15%" class="border">Diinspeksi Oleh</td>
                                <td width="25%" class="border">
                                    <select name="inspected_by3_name" id="inspected_by3_name" class="form-control text-center" required>
                                        <option value="">-- Pilih Inspektor --</option>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $data->inspected_by3_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="inspected_by3_nik" value="{{ isset($data) ? $data->inspected_by3_nik : '' }}">
                                </td>
                                <td width="10%" class="border">Status</td>
                                <td width="15%" class="border">
                                    <span class="badge bg-{{ isset($data) && $data->inspected_by3_status == 'approved' ? 'success' : (isset($data) && $data->inspected_by3_status == 'rejected' ? 'danger' : 'secondary') }}">
                                        {{ isset($data) ? ucfirst($data->inspected_by3_status) : 'Pending' }}
                                    </span>
                                    <input type="hidden" name="inspected_by3_status" value="{{ isset($data) ? $data->inspected_by3_status : 'pending' }}">
                                </td>
                                <td width="10%" class="border">Tanggal</td>
                                <td width="25%" class="border">
                                    {{ isset($data) && $data->inspection_date3 ? date('d/m/Y', strtotime($data->inspection_date3)) : date('d/m/Y') }}
                                    <input type="hidden" name="inspection_date3" value="{{ isset($data) ? $data->inspection_date3 : now()->format('Y-m-d') }}">
                                </td>
                            </tr>
                            <tr>
                                <td width="15%" class="border">Disetujui Oleh</td>
                                <td width="25%" class="border">
                                    <select name="acknowledged_by_name" id="acknowledged_by_name" class="form-control text-center" required>
                                        <option value="">-- Pilih Inspektor --</option>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" {{ $data->acknowledged_by_name == $user->nama ? 'selected' : '' }}>{{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="acknowledged_by_nik" value="{{ isset($data) ? $data->acknowledged_by_nik : '' }}">
                                </td>
                                <td width="10%" class="border">Status</td>
                                <td width="15%" class="border">
                                    <span class="badge bg-{{ isset($data) && $data->acknowledged_by_status == 'approved' ? 'success' : (isset($data) && $data->acknowledged_by_status == 'rejected' ? 'danger' : 'secondary') }}">
                                        {{ isset($data) ? ucfirst($data->acknowledged_by_status) : 'Pending' }}
                                    </span>
                                    <input type="hidden" name="acknowledged_by_status" value="{{ isset($data) ? $data->acknowledged_by_status : 'pending' }}">
                                </td>
                                <td width="10%" class="border">Tanggal</td>
                                <td width="25%" class="border">
                                    {{ isset($data) && $data->acknowledgment_date ? date('d/m/Y', strtotime($data->acknowledgment_date)) : date('d/m/Y') }}
                                    <input type="hidden" name="acknowledgment_date" value="{{ isset($data) ? $data->acknowledgment_date : now()->format('Y-m-d') }}">
                                </td>
                            </tr>
                        </table>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('she.mess.dashboard') }}'">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
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
    .form-check-input[type="radio"] {
        margin-top: 0.3rem;
    }
    .form-check-label {
        margin-bottom: 0;
    }
    .form-check {
        margin-bottom: 0;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .table th, .table td {
        padding: 0.75rem;
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function() {
        $('#inspected_by_name, #inspected_by2_name, #inspected_by3_name, #acknowledged_by_name').select2({
            placeholder: '-- Pilih Nama --',
            width: '100%'
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize the form
        initializeForm();
        
        // Handle inspector selection changes
        $('#inspected_by_name').change(function() {
            var selectedOption = $(this).find('option:selected');
            var nik = selectedOption.data('nik');
            $('#inspected_by_nik').val(nik);
        });
        
        $('#inspected_by2_name').change(function() {
            var selectedOption = $(this).find('option:selected');
            var nik = selectedOption.data('nik');
            $('#inspected_by2_nik').val(nik);
        });
        
        $('#inspected_by3_name').change(function() {
            var selectedOption = $(this).find('option:selected');
            var nik = selectedOption.data('nik');
            $('#inspected_by3_nik').val(nik);
        });
        
        $('#acknowledged_by_name').change(function() {
            var selectedOption = $(this).find('option:selected');
            var nik = selectedOption.data('nik');
            $('#acknowledged_by_nik').val(nik);
        });
        
        // Set initial NIK values based on selected options
        function initializeForm() {
            $('#inspected_by_name').trigger('change');
            $('#inspected_by2_name').trigger('change');
            $('#inspected_by3_name').trigger('change');
            $('#acknowledged_by_name').trigger('change');
        }
    });
    
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            // Validate checklist items
            const checklistItems = document.querySelectorAll('input[type="radio"][name^="checklist"]');
            const checklistGroups = {};
            
            checklistItems.forEach(item => {
                const name = item.getAttribute('name');
                if (!checklistGroups[name]) {
                    checklistGroups[name] = false;
                }
                if (item.checked) {
                    checklistGroups[name] = true;
                }
            });
            
            let hasUncheckedGroup = false;
            for (const group in checklistGroups) {
                if (!checklistGroups[group]) {
                    hasUncheckedGroup = true;
                    break;
                }
            }
            
            if (hasUncheckedGroup) {
                e.preventDefault();
                alert('Please check all inspection items');
                return false;
            }
            
            // Validate required fields
            const requiredFields = form.querySelectorAll('[required]');
            let hasEmptyRequired = false;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    hasEmptyRequired = true;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (hasEmptyRequired) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }
        });
    });
</script>
@endsection
