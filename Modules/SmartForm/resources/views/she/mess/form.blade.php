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
                                    <th class="text-center">KEMUNGKINAN AKIBAT</th>
                                    <th class="text-center">TINDAKAN PERBAIKAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="background-color: #ff0000; color: white;" class="text-center">Risiko Kritikal</td>
                                    <td class="text-center">75 - 125</td>
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
                                    <td style="background-color: #ffa500; color: white;" class="text-center">Risiko Tinggi</td>
                                    <td class="text-center">32 - 75</td>
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
                                    <td style="background-color: #ffff00;" class="text-center">Risiko Sedang</td>
                                    <td class="text-center">18 - 32</td>
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
                                    <td style="background-color: #90EE90;" class="text-center">Risiko Rendah</td>
                                    <td class="text-center">2 - 18</td>
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
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #f4f4f4;">
                                        <th width="5%" class="text-center align-middle">No</th>
                                        <th width="40%" class="align-middle">Item Pemeriksaan</th>
                                        <th width="20%" class="text-center align-middle">Kondisi Aktual</th>
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
                                            'Tempat sampah mencukupi / dikosongkan secara berkala',
                                            'Tempat tidur / kamar bersih, rapi dan tidak bau lembab, ada kipas / ACnya',
                                            'Kamar mandi bersih, mnim 3 X seminggu dikuras baknya .',
                                            'Ada tempat jemuran yang bersih, sinar cukup dan aman',
                                            'Toilet bersih dan Didisinfeksi, ketersediaan air cukup dan kran air berfungsi baik, ada peralatan kebersihannya.',
                                            'Atap tidak bocor',
                                            'Tempat penyiapan makanan yang mencukupi, bersih dan bebas serangga,',
                                            'Instalasi Gas terkompresi Aman',
                                            'Kunci pintu - jendela dalam kondisi bagus dan bisa digunakan - ada teralis',
                                            'Kotak listrik / saklar penggerak / sambungan kabel aman',
                                            'Furnitur rumah dan Ergonomi',
                                            'Rak sepatu, tempat air minum, dan peralatan lain bersih dan keadaan baik',
                                            'Rambu tanda – tanda dan kode warna',
                                            'Tersedia Kotak P3K dan selalu di cek terkait isinya.',
                                            'Tersedia APAR, atau alat pencegah dan perlindungan dari kebakaran',
                                            'Tersedia air bersih yang cukup, dan adanya profiltank / tandon'
                                        ];
                                    @endphp

                                    @foreach($checklistItems as $index => $item)
                                    <tr>
                                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle">{{ $item }}</td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex justify-content-center gap-3">
                                                @php
                                                    $checklist_value = isset($data->checklist_items) && is_array($data->checklist_items) ? 
                                                        ($data->checklist_items[$index] ?? '') : '';
                                                @endphp
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="checklist[{{ $index }}]" value="OK"
                                                        required
                                                        {{ $checklist_value === 'OK' ? 'checked' : '' }}
                                                        {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                    <label class="form-check-label">OK</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="checklist[{{ $index }}]" value="NOT OK"
                                                        required
                                                        {{ $checklist_value === 'NOT OK' ? 'checked' : '' }}
                                                        {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                                    <label class="form-check-label">NOT OK</label>
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
                                        {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}
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
                                        <textarea class="form-control border-0" name="risk_description" rows="3" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }} placeholder="Deskripsi Rincian Bahaya">{{ isset($data->risk_description) ? $data->risk_description : '' }}</textarea>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <textarea class="form-control border-0" name="improvement_action" rows="3" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }} placeholder="Deskripsi Perbaikan langsung">{{ isset($data->improvement_action) ? $data->improvement_action : '' }}</textarea>
                                    </td>
                                    <td style="border: 1px solid #dee2e6;">
                                        <textarea class="form-control border-0" name="done_by" rows="3" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }} placeholder="Dilakukan oleh">{{ isset($data->done_by) ? $data->done_by : '' }}</textarea>
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
                                <td width="15%">Tanda Tangan</td>
                                <td width="10%">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="inspected_signature[]" value="1"
                                               {{ isset($data->inspected_signature) && $data->inspected_signature ? 'checked' : '' }}
                                               {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                        <label class="form-check-label">Signed</label>
                                    </div>
                                </td>
                                <td width="10%">Tanggal</td>
                                <td width="15%">
                                    <input type="date" class="form-control" name="inspection_date"
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
                                        <input class="form-check-input" type="checkbox" name="inspected_signature[]" value="1"
                                               {{ isset($data->inspected_signature2) && $data->inspected_signature2 ? 'checked' : '' }}
                                               {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                        <label class="form-check-label">Signed</label>
                                    </div>
                                </td>
                                <td>Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="inspection_date2"
                                           value="{{ isset($data->inspection_date2) ? $data->inspection_date2 : now()->format('Y-m-d') }}"
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
                                        <input class="form-check-input" type="checkbox" name="inspected_signature[]" value="1"
                                               {{ isset($data->inspected_signature3) && $data->inspected_signature3 ? 'checked' : '' }}
                                               {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                        <label class="form-check-label">Signed</label>
                                    </div>
                                </td>
                                <td>Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="inspection_date3"
                                           value="{{ isset($data->inspection_date3) ? $data->inspection_date3 : now()->format('Y-m-d') }}"
                                           {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td>Disetujui Oleh</td>
                                <td>: <input type="text" class="form-control d-inline-block w-75" name="acknowledged_by"
                                           value="{{ isset($data->acknowledged_by) ? $data->acknowledged_by : '' }}"
                                           {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}></td>
                                <td>Tanda Tangan</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="acknowledged_signature" value="1"
                                               {{ isset($data->acknowledged_signature) && $data->acknowledged_signature ? 'checked' : '' }}
                                               {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }}>
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

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12 text-end">
                            @if (isset($isShowDetail) && $isShowDetail)
                                <a href="{{ route('she.mess.dashboard') }}" class="btn btn-secondary">Back</a>
                                <a href="{{ route('she.mess.export', $data->id) }}" class="btn btn-primary">
                                    <i class="material-icons">download</i> Export
                                </a>
                            @else
                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('she.mess.dashboard') }}" class="btn btn-secondary">Back</a>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
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

    .kondisi-actual-cell {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        padding: 8px !important;
    }

    .form-check-inline {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-check-label {
        margin: 0;
    }
</style>
@endsection

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            // Validate checklist items
            const checklistItems = document.querySelectorAll('input[type="radio"][name^="checklist"]');
            const checklistGroups = {};
            
            // Group radio buttons by their name
            checklistItems.forEach(item => {
                const name = item.getAttribute('name');
                if (!checklistGroups[name]) {
                    checklistGroups[name] = [];
                }
                checklistGroups[name].push(item);
            });
            
            // Check if each group has a selected option
            for (let name in checklistGroups) {
                const isChecked = checklistGroups[name].some(radio => radio.checked);
                if (!isChecked) {
                    e.preventDefault();
                    const itemNumber = Array.prototype.indexOf.call(checklistItems, checklistGroups[name][0]) + 1;
                    alert(`Please select a condition for checklist item #${itemNumber}`);
                    checklistGroups[name][0].focus();
                    return false;
                }
            }

            // Existing validation
            const acknowledgedBy = document.querySelector('input[name="acknowledged_by"]');
            const acknowledgmentDate = document.querySelector('input[name="acknowledgment_date"]');
            const inspectedBy = document.querySelector('input[name="inspected_by[]"]');
            const inspectionDate = document.querySelector('input[name="inspection_date"]');

            if (!acknowledgedBy.value) {
                e.preventDefault();
                alert('Mengetahui field is required');
                acknowledgedBy.focus();
                return false;
            }

            if (!acknowledgmentDate.value) {
                e.preventDefault();
                alert('Acknowledgment date is required');
                acknowledgmentDate.focus();
                return false;
            }

            if (!inspectedBy.value) {
                e.preventDefault();
                alert('First inspector name is required');
                inspectedBy.focus();
                return false;
            }

            if (!inspectionDate.value) {
                e.preventDefault();
                alert('First inspection date is required');
                inspectionDate.focus();
                return false;
            }
        });
    });

    $(document).ready(function() {
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

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Error',
                    text: 'Mohon lengkapi semua field yang wajib diisi'
                });
                return;
            }

            // Submit form normally
            this.submit();
        });
    });
</script>
@endsection