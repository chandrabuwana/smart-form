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
                        <h6 class="text-white text-capitalize ps-3">
                            @if(isset($isEdit) && $isEdit)
                                Edit
                            @elseif($isShowDetail)
                                Detail
                            @else
                                New
                            @endif
                            Inspeksi Toilet, Mess dan Kantor
                        </h6>
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
                                        <select class="form-control" id="site_name" name="site_name" required {{ $isShowDetail ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Site --</option>
                                            @foreach(\Modules\SmartForm\helpers\SiteHelper::getAllSites() as $code => $name)
                                                <option value="{{ strtoupper($code) }}" 
                                                    {{ $isShowDetail && strtolower($data->site_name) == strtolower($code) ? 'selected' : 
                                                    (!$isShowDetail && isset($defaultValues['site_name']) && strtolower($defaultValues['site_name']) == strtolower($code) ? 'selected' : '') }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                            <option value="BSS" 
                                                {{ $isShowDetail && strtolower($data->site_name) == 'bss' ? 'selected' : 
                                                (!$isShowDetail && isset($defaultValues['site_name']) && strtolower($defaultValues['site_name']) == 'bss' ? 'selected' : '') }}>
                                                BSS
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Lokasi Kerja</label>
                                        <input type="text" class="form-control" name="work_location" value="{{ isset($data) ? $data->work_location : '' }}" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }} required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Dept./Section</label>
                                        <select class="form-control" name="department" id="department" {{ $isShowDetail ? 'disabled' : '' }} required>
                                            <option value="">-- Pilih Departemen --</option>
                                            @foreach(\Modules\SmartForm\helpers\DepartmentHelper::getAllDepartments() as $code => $name)
                                                <option value="{{ $code }}" {{ $isShowDetail && $data->department == $code ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Shift</label>
                                        {!! \Modules\SmartForm\helpers\ShiftHelper::renderShiftSelect('shift', $isShowDetail ? $data->shift : (isset($defaultValues['shift']) ? $defaultValues['shift'] : null), isset($isShowDetail) && $isShowDetail) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Jumlah Inspektor</label>
                                        <input type="number" class="form-control" name="inspector_count" value="{{ isset($data) ? $data->inspector_count : '1' }}" {{ isset($isShowDetail) && $isShowDetail ? 'disabled' : '' }} min="1" step="1">
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
                                    <td style="background-color: #90EE90;" class="text-center border">Risiko Rendah</td>
                                    <td class="text-center border">2 - 18</td>
                                    <td style="white-space: pre-line;" class="border">
                                        Ada Kerusakan dan Rp 0 - Rp 10 Juta

Tidak ada peraturan yg berlaku atau berdampak kelingkungan perusahaan
                                    </td>
                                    <td style="white-space: pre-line;" class="border">
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
                                    <tr class="border">
                                        <td class="text-center align-middle border">{{ $index + 1 }}</td>
                                        <td class="align-middle border">{{ $item }}</td>
                                        <td class="text-center align-middle border">
                                            <div class="d-flex justify-content-center gap-3">
                                                @php
                                                    $checklist_value = isset($data) && is_array($data->checklist_items) ? 
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
                            <tr class="border">
                                <td width="25%">Diinspeksi Oleh</td>
                                <td width="25%">
                                    <select name="inspected_by_name" id="inspected_by_name" class="form-control text-center" required {{ $isShowDetail ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Inspektor --</option>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" 
                                                {{ ($isShowDetail && isset($data->inspected_by_name) && $data->inspected_by_name == $user->nama) || 
                                                   (!$isShowDetail && $user->nama == session('username')) ? 'selected' : '' }}>
                                                {{ $user->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="inspected_by_nik" id="inspected_by_nik" 
                                           value="{{ $isShowDetail && isset($data->inspected_by_nik) ? $data->inspected_by_nik : session('user_id') }}">
                                </td>
                                <td width="15%">Status</td>
                                <td width="10%">
                                    @if($isShowDetail)
                                        <span class="badge bg-{{ $data->inspected_by_status == 'approved' ? 'success' : ($data->inspected_by_status == 'rejected' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($data->inspected_by_status) }}
                                        </span>
                                    @else
                                        <select name="inspected_by_status" class="form-control" disabled>
                                            <option value="pending" {{ isset($data) && $data->inspected_by_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ isset($data) && $data->inspected_by_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ isset($data) && $data->inspected_by_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    @endif
                                </td>
                                <td width="10%">Tanggal</td>
                                <td width="15%">
                                    <input type="date" class="form-control" name="inspection_date"
                                           value="{{ isset($data->inspection_date) ? $data->inspection_date : now()->format('Y-m-d') }}"
                                           {{ $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                            <tr class="border">
                                <td>Diinspeksi Oleh</td>
                                <td>
                                    <select name="inspected_by2_name" id="inspected_by2_name" class="form-control text-center" {{ $isShowDetail ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Inspektor --</option>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" 
                                                {{ ($isShowDetail && isset($data->inspected_by2_name) && $data->inspected_by2_name == $user->nama) || 
                                                   (!$isShowDetail && $user->nama == session('username')) ? 'selected' : '' }}>
                                                {{ $user->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="inspected_by2_nik" id="inspected_by2_nik" 
                                           value="{{ $isShowDetail && isset($data->inspected_by2_nik) ? $data->inspected_by2_nik : '' }}">
                                </td>
                                <td>Status</td>
                                <td>
                                    @if($isShowDetail)
                                        <span class="badge bg-{{ $data->inspected_by2_status == 'approved' ? 'success' : ($data->inspected_by2_status == 'rejected' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($data->inspected_by2_status) }}
                                        </span>
                                    @else
                                        <select name="inspected_by2_status" class="form-control" disabled>
                                            <option value="pending" {{ isset($data) && $data->inspected_by2_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ isset($data) && $data->inspected_by2_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ isset($data) && $data->inspected_by2_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    @endif
                                </td>
                                <td>Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="inspection_date2"
                                           value="{{ isset($data->inspection_date2) ? $data->inspection_date2 : now()->format('Y-m-d') }}"
                                           {{ $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                            <tr class="border">
                                <td>Diinspeksi Oleh</td>
                                <td>
                                    <select name="inspected_by3_name" id="inspected_by3_name" class="form-control text-center" {{ $isShowDetail ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Inspektor --</option>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" 
                                                {{ ($isShowDetail && isset($data->inspected_by3_name) && $data->inspected_by3_name == $user->nama) || 
                                                   (!$isShowDetail && $user->nama == session('username')) ? 'selected' : '' }}>
                                                {{ $user->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="inspected_by3_nik" id="inspected_by3_nik" 
                                           value="{{ $isShowDetail && isset($data->inspected_by3_nik) ? $data->inspected_by3_nik : '' }}">
                                </td>
                                <td>Status</td>
                                <td>
                                    @if($isShowDetail)
                                        <span class="badge bg-{{ $data->inspected_by3_status == 'approved' ? 'success' : ($data->inspected_by3_status == 'rejected' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($data->inspected_by3_status) }}
                                        </span>
                                    @else
                                        <select name="inspected_by3_status" class="form-control" disabled>
                                            <option value="pending" {{ isset($data) && $data->inspected_by3_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ isset($data) && $data->inspected_by3_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ isset($data) && $data->inspected_by3_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    @endif
                                </td>
                                <td>Tanggal</td>
                                <td>
                                    <input type="date" class="form-control" name="inspection_date3"
                                           value="{{ isset($data->inspection_date3) ? $data->inspection_date3 : now()->format('Y-m-d') }}"
                                           {{ $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                            <tr class="border">
                                <td class="border">Disetujui Oleh</td>
                                <td class="border">
                                    <select name="acknowledged_by_name" id="acknowledged_by_name" class="form-control text-center" {{ $isShowDetail ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Approver --</option>
                                        @foreach($approvalList as $user)
                                            <option value="{{ $user->nama }}" data-nik="{{ $user->nik }}" 
                                                {{ ($isShowDetail && isset($data->acknowledged_by_name) && $data->acknowledged_by_name == $user->nama) || 
                                                   (!$isShowDetail && $user->nama == session('username')) ? 'selected' : '' }}>
                                                {{ $user->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="acknowledged_by_nik" id="acknowledged_by_nik" 
                                           value="{{ $isShowDetail && isset($data->acknowledged_by_nik) ? $data->acknowledged_by_nik : '' }}">
                                </td>
                                <td class="border">Status</td>
                                <td class="border">
                                    @if($isShowDetail)
                                        <span class="badge bg-{{ $data->acknowledged_by_status == 'approved' ? 'success' : ($data->acknowledged_by_status == 'rejected' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($data->acknowledged_by_status) }}
                                        </span>
                                    @else
                                        <select name="acknowledged_by_status" class="form-control" disabled>
                                            <option value="pending" {{ isset($data) && $data->acknowledged_by_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ isset($data) && $data->acknowledged_by_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ isset($data) && $data->acknowledged_by_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    @endif
                                </td>
                                <td class="border">Tanggal</td>
                                <td class="border">
                                    <input type="date" class="form-control" name="acknowledgment_date"
                                           value="{{ isset($data->acknowledgment_date) ? $data->acknowledgment_date : now()->format('Y-m-d') }}"
                                           {{ $isShowDetail ? 'disabled' : '' }}>
                                </td>
                            </tr>
                        </table>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12 text-end">
                                @if($isShowDetail)
                                    <a href="{{ route('she.mess.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                                    <a href="{{ route('she.mess.export', ['id' => $data->id]) }}" class="btn btn-primary">Export PDF</a>
                                @else
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('she.mess.dashboard') }}'">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        @if(isset($isEdit) && $isEdit)
                                            Update
                                        @else
                                            Save
                                        @endif
                                    </button>
                                @endif
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
    $(document).ready(function() {
        // Initialize the form
        initializeForm();
        
        // Handle checklist item changes
        $('.condition-select').on('change', function() {
            updateRiskLevel();
        });

        // Handle NIK selection for inspectors and acknowledger
        $('#inspected_by_name').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var nik = selectedOption.data('nik');
            $('#inspected_by_nik').val(nik);
        });

        $('#inspected_by2_name').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var nik = selectedOption.data('nik');
            $('#inspected_by2_nik').val(nik);
        });

        $('#inspected_by3_name').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var nik = selectedOption.data('nik');
            $('#inspected_by3_nik').val(nik);
        });

        $('#acknowledged_by_name').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var nik = selectedOption.data('nik');
            $('#acknowledged_by_nik').val(nik);
        });

        // Trigger change events to set initial NIK values
        $('#inspected_by_name').trigger('change');
        $('#inspected_by2_name').trigger('change');
        $('#inspected_by3_name').trigger('change');
        $('#acknowledged_by_name').trigger('change');
    });

    function initializeForm() {
        // Set up initial values and states
        updateRiskLevel();
        
        // Make sure checkboxes are properly initialized
        $('.form-check-input').each(function() {
            if ($(this).prop('checked')) {
                $(this).closest('tr').find('.condition-select').val('OK');
            }
        });
    }

    function updateRiskLevel() {
        var notOkCount = 0;
        $('.condition-select').each(function() {
            if ($(this).val() === 'NOT OK') {
                notOkCount++;
                $(this).closest('tr').find('.description-input').prop('required', true);
            } else {
                $(this).closest('tr').find('.description-input').prop('required', false);
            }
        });

        var riskLevel = 'LOW';
        if (notOkCount > 5) {
            riskLevel = 'HIGH';
        } else if (notOkCount > 2) {
            riskLevel = 'MEDIUM';
        }

        $('#risk_level').val(riskLevel);
    }

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