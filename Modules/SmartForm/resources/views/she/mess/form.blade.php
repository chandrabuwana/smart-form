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
                        <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Inspeksi Toilet, Mess dan Kantor</h6>
                    </div>
                </div>
                <div class="card-body px-4">
                    <form id="messForm" action="{{ route('she.mess.store') }}" method="POST">
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
                                        <select class="form-control" id="site_name" name="site_name" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Site --</option>
                                            @foreach(['agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj'] as $site)
                                                <option value="{{ $site }}" {{ isset($data) && strtolower($data->site_name) === $site ? 'selected' : '' }}>{{ strtoupper($site) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Lokasi Kerja</label>
                                        <input type="text" class="form-control" name="work_location" value="{{ isset($data) ? $data->work_location : '' }}" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Dept./Section</label>
                                        <input type="text" class="form-control" name="department" value="{{ isset($data) ? $data->department : 'SHE & GS' }}" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Shift</label>
                                        <select class="form-control" name="shift" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Shift --</option>
                                            @foreach(['Day', 'Night'] as $shift)
                                                <option value="{{ $shift }}" {{ isset($data) && $data->shift === $shift ? 'selected' : '' }}>{{ $shift }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Jumlah Inspektor</label>
                                        <input type="number" class="form-control" name="inspector_count" value="{{ isset($data) ? $data->inspector_count : '1' }}" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="survey_date" 
                                               value="{{ isset($data->survey_date) ? $data->survey_date : now()->format('Y-m-d') }}"
                                               {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                        <!-- Risk Level Table -->
                        <table class="table table-bordered mb-4">
                            <thead>
                                <tr style="background-color: #3498db; color: white;">
                                    <th>TINGKAT RISIKO</th>
                                    <th>POTENSI RISIKO</th>
                                    <th>KEMUNGKINAN AKIBAT</th>
                                    <th>TINDAKAN PERBAIKAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="background-color: #ff0000; color: white;">Risiko Kritikal</td>
                                    <td>75 - 125</td>
                                    <td style="white-space: pre-line;">
                                        > Rp 100 Juta dan Sakit akut/ meninggal

                                        Tidak sesuai baku mutu/peraturan perundangan dan mendapatkan ancaman denda atau pidana, penutupan permanen perusahaan atau berdampak ke masyarakat nasional
                                    </td>
                                    <td style="white-space: pre-line;">
                                        <span style="color: red;">TIDAK DAPAT DITERIMA (STOP)</span>

                                        Pekerjaan tidak boleh dilakukan sampai tingkat risiko diturunkan. Jika risiko tidak mungkin diturunkan sekalipun dengan sumberdaya yang tidak terbatas, pekerjaan dihentikan dan tidak boleh dilakukan
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #ffa500; color: white;">Risiko Tinggi</td>
                                    <td>32 - 75</td>
                                    <td style="white-space: pre-line;">
                                        Rp 50 Juta – Rp 100 Juta dan Sakit dan rawat inap /kronis/PAK

Tidak sesuai baku mutu/peraturan perundangan dan mendapatkan peringatan keras dari pemerintah, penghentian operasional perusahaan sementara atau berdampak ke masyarakat yg lebih luas
                                    </td>
                                    <td style="white-space: pre-line;">
                                        Pekerjaan dapat dilakukan

                                        Tindakan pengendalian segera dilakukan untuk menurunkan tingkat resiko. Keterlibatan Pimpinan diperlukan untuk pengendalian tersebut.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #ffff00;">Risiko Sedang</td>
                                    <td>18 - 32</td>
                                    <td style="white-space: pre-line;">
                                        Rp 10 Juta – Rp 50 Juta, Ada gangguan tidak dapat masuk kerja

Sesuai dengan baku mutu/peraturan perundangan atau berdampak ke masyarakat di sekitar area kerja perusahaan
                                    </td>
                                    <td style="white-space: pre-line;">
                                        Harus dilakukan pengendalian tambahan untuk menurunkan tingkat resiko.

                                        Pengendalian tambahan harus diterapkan dalam periode waktu tertentu.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #90EE90;">Risiko Rendah</td>
                                    <td>2 - 18</td>
                                    <td style="white-space: pre-line;">
                                        Ada Kerusakan dan Rp 0 - Rp 10 Juta

Tidak ada peraturan yg berlaku atau berdampak kelingkungan perusahaan
                                    </td>
                                    <td style="white-space: pre-line;">
                                        Tidak diperlukan pengendalian tambahan.

                                        Diperlukan pemantauan untuk memastikan pengendalian yang ada dipelihara dan dilaksanakan.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Checklist Table -->
                        <table class="table table-bordered mb-4">
                            <thead>
                                <tr style="background-color: #3498db;">
                                    <th colspan="6" class="text-center text-white" >CHECKLIST INSPEKSI MESS</th>
                                </tr>
                                <tr style="background-color: #f4f4f4;">
                                    <th width="5%">No</th>
                                    <th width="50%">HAL UNTUK DIPERIKSA</th>
                                    <th colspan="2" class="text-center">Kondisi Actual</th>
                                    <th width="15%">Tingkat Risiko</th>
                                    <th width="20%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $checklistItems = [
                                        'Bangunan, Atap, dinding, pintu, jendela, aman dan bersih.',
                                        'Permukaan tempat jalan, lantai dalam kondis bersih dan didisinfeksi',
                                        'Pencahayaan / Penerangan kamar / ruangan memadai',
                                        'Ventilasi kamar, segala ruangan Memadai',
                                        'Kebersihan dan housekeeping yang baik di dalam rumah dan sekitarnya',
                                        'Tempat tidur dan kasur dalam kondisi bersih dan rapi',
                                        'Kamar mandi dan toilet bersih dan berfungsi dengan baik',
                                        'Tempat sampah tersedia dan dikelola dengan baik',
                                        'Peralatan P3K tersedia dan lengkap',
                                        'APAR tersedia dan dalam kondisi baik',
                                        'Instalasi listrik aman dan rapi',
                                        'Area dapur bersih dan tertata rapi',
                                        'Peralatan dapur bersih dan tersimpan dengan baik',
                                        'Area makan bersih dan nyaman',
                                        'Sistem drainase berfungsi dengan baik'
                                    ];
                                @endphp

                                @foreach($checklistItems as $index => $item)
                                <tr class="checklist-row">
                                    <td class="text-center" style="border: 1px solid #dee2e6;">{{ $index + 1 }}</td>
                                    <td style="border: 1px solid #dee2e6;">{{ $item }}</td>
                                    <td colspan="2" style="border: 1px solid #dee2e6;">
                                        @php
                                            $savedCondition = '';
                                            $savedNotes = '';
                                            if (isset($data->checklist_items) && is_array($data->checklist_items) && isset($data->checklist_items[$index])) {
                                                $savedCondition = $data->checklist_items[$index]['condition'] ?? '';
                                                $savedNotes = $data->checklist_items[$index]['notes'] ?? '';
                                            }
                                        @endphp
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="condition[{{ $index }}]" 
                                                   value="OK" {{ $savedCondition === 'OK' ? 'checked' : '' }} 
                                                   {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                            <label class="form-check-label">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="condition[{{ $index }}]"
                                                   value="NOT OK" {{ $savedCondition === 'NOT OK' ? 'checked' : '' }} 
                                                   {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                            <label class="form-check-label">Tidak</label>
                                        </div>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <input type="text" class="form-control" name="notes[{{ $index }}]" 
                                               value="{{ $savedNotes }}"
                                               {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

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
                                        <textarea class="form-control border-0" name="risk_description" rows="3" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>{{ isset($data->risk_description) ? $data->risk_description : '' }}</textarea>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <textarea class="form-control border-0" name="improvement_action" rows="3" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>{{ isset($data->improvement_action) ? $data->improvement_action : '' }}</textarea>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <textarea class="form-control border-0" name="done_by" rows="3" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>{{ isset($data->done_by) ? $data->done_by : '' }}</textarea>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <input type="date" class="form-control" name="completion_date" 
                                               value="{{ isset($data->completion_date) ? $data->completion_date : '' }}"
                                               {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Signatures -->
                        <table class="table table-bordered mb-4">
                            <tr>
                                <td width="25%">Diinspeksi Oleh</td>
                                <td width="25%">: <input type="text" class="form-control d-inline-block w-75" name="inspected_by[]" 
                                                        value="{{ isset($data->inspected_by) ? $data->inspected_by : '' }}"
                                                        {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}></td>
                                <td width="25%">Tanda Tangan</td>
                                <td width="25%">
                                    <div class="form-check">
                                    </div>
                                </td>
                                <td>Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="acknowledgment_date"
                                        value="{{ isset($data->inspection_date) ? $data->inspection_date : now()->format('Y-m-d') }}"
                                        {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Diinspeksi Oleh</td>
                                <td>: <input type="text" class="form-control d-inline-block w-75" name="inspected_by[]"
                                           value="{{ isset($data->inspected_by2) ? $data->inspected_by2 : '' }}"
                                           {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}></td>
                                <td>Tanda Tangan</td>
                                <td>
                                    <div class="form-check">
                                    </div>
                                </td>
                                <td>Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="acknowledgment_date"
                                        value="{{ isset($data->inspection_date2) ? $data->inspection_date2 : '' }}"
                                        {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Diinspeksi Oleh</td>
                                <td>: <input type="text" class="form-control d-inline-block w-75" name="inspected_by[]"
                                           value="{{ isset($data->inspected_by3) ? $data->inspected_by3 : '' }}"
                                           {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}></td>
                                <td>Tanda Tangan</td>
                                <td>
                                    <div class="form-check">
                                    </div>
                                </td>
                                <td>Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="acknowledgment_date"
                                        value="{{ isset($data->inspection_date3) ? $data->inspection_date3 : '' }}"
                                        {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Mengetahui</td>
                                <td>: <input type="text" class="form-control d-inline-block w-75" name="acknowledged_by"
                                           value="{{ isset($data->acknowledged_by) ? $data->acknowledged_by : '' }}" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}></td>
                                <td>Tanda Tangan</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="acknowledged_signature"
                                               {{ isset($data->acknowledged_signature) && $data->acknowledged_signature ? 'checked' : '' }} {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                        <label class="form-check-label">Signed</label>
                                    </div>
                                </td>
                                <td>Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="acknowledgment_date"
                                           value="{{ isset($data->acknowledgment_date) ? $data->acknowledgment_date : now()->format('Y-m-d') }}"
                                           {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                        </table>

                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('she.mess.dashboard') }}" class="btn btn-secondary">Back</a>
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
    padding: 8px;
    vertical-align: middle;
}
.form-check-input {
    margin-top: 0;
}
.table-bordered > :not(caption) > * > * {
    border-width: 1px;
}
</style>
@endsection

@section('custom-js')
<script>
$(document).ready(function() {
    // Initialize all datepickers
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        orientation: 'bottom'
    }).on('show', function() {
        // Ensure datepicker is above other elements
        $('.datepicker-dropdown').css('z-index', '9999');
    });

    // Form validation
    $('#messForm').on('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        let isValid = true;
        const requiredFields = $(this).find('[required]');
        
        requiredFields.each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Validate radio buttons
        $('.checklist-row').each(function() {
            const radioButtons = $(this).find('input[type="radio"]');
            if (!radioButtons.is(':checked')) {
                isValid = false;
                $(this).find('.form-check').addClass('is-invalid');
            } else {
                $(this).find('.form-check').removeClass('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                text: 'Mohon lengkapi semua field yang wajib diisi'
            });
            return;
        }

        // Get form data
        let formData = new FormData(this);

        // Add checklist items
        $('.checklist-row').each(function(index) {
            const condition = $(this).find('input[type="radio"]:checked').val();
            const notes = $(this).find('input[name^="notes"]').val();
            formData.append(`condition[${index}]`, condition || '');
            formData.append(`notes[${index}]`, notes || '');
        });

        // Submit form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message || 'Data inspeksi berhasil disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '{{ route("she.mess.dashboard") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Terjadi kesalahan saat menyimpan data'
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            }
        });
    });
});
</script>
@endsection