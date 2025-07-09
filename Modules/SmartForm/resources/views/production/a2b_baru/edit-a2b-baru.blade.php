!@extends('master.master_page')

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

                <div class="card">
                    <!-- Card Header -->
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2">
                            <h6 class="text-white text-capitalize ps-3">Detail Form P2H
                                A2B Baru</h6>
                        </div>
                    </div>

                    <form action="" id="a2bbaruForm" method="POST">
                        @csrf
                            <input type="hidden" name="id" value="{{ $record->id }}">
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <h5>Basic Information</h5>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nama_operator" class="ms-0">Nama Operator</label>
                                        <input type="text" class="form-control" id="nama_operator" name="nama_operator" required
                                            value="{{ old('nama_operator', $record->nama_operator ?? '') }}"
                                            >
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="input-group input-group-static mb-3">
                                        <label for="nrp" class="ms-0">NRP</label>
                                        <input type="number" class="form-control" id="nrp" name="nrp" required
                                            value="{{ old('nrp', $record->nrp ?? '') }}"
                                            >
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="tanggal" class="ms-0">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required
                                            value="{{ old('tanggal', $record->tanggal ?? '') }}"
                                            >
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="shift" class="ms-0">Shift</label>
                                        <select name="shift" class="form-control select2">
                                            {!! $shift !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="lokasi" class="ms-0">Lokasi</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" required
                                            value="{{ old('lokasi', $record->lokasi ?? '') }}"
                                            >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="type_nounit" class="ms-0">Type / No Unit</label>
                                        <input type="text" class="form-control" id="type_nounit" name="type_nounit" required
                                            value="{{ old('type_nounit', $record->type_nounit ?? '') }}"
                                            >
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hmawal1" class="ms-0">HM Awal</label>
                                        <input type="text" class="form-control" id="hmawal1" name="hmawal1" 
                                            value="{{ old('hmawal1', $record->hmawal1 ?? '') }}" 
                                            >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hmakhir1" class="ms-0">HM Akhir</label>
                                        <input type="text" class="form-control" id="hmakhir1" name="hmakhir1" 
                                            value="{{ old('hmakhir1', $record->hmakhir1 ?? '') }}" 
                                            >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="catatan_unit" class="ms-0">Catatan Kondisi Unit</label>
                                        <input type="text" class="form-control" id="catatan_unit" name="catatan_unit" 
                                            value="{{ old('catatan_unit', $record->catatan_unit ?? '') }}" 
                                            >
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hmawal2" class="ms-0">HM Awal</label>
                                        <input type="text" class="form-control" id="hmawal2" name="hmawal2" 
                                            value="{{ old('hmawal2', $record->hmawal2 ?? '') }}" 
                                            >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hmakhir2" class="ms-0">HM Akhir</label>
                                        <input type="text" class="form-control" id="hmakhir2" name="hmakhir2" 
                                            value="{{ old('hmakhir2', $record->hmakhir2 ?? '') }}" 
                                            >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="catatan_pengawas" class="ms-0">Catatan RM/Pengawas</label>
                                        <input type="text" class="form-control" id="catatan_pengawas" name="catatan_pengawas" 
                                            value="{{ old('catatan_pengawas', $record->catatan_pengawas ?? '') }}" 
                                            >
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hmawal2" class="ms-0">Operator</label>
                                            <select name="operator" id="operator" class="form-control select2">
                                                <option disabled {{ optional($record)->operator == '' ? 'selected' : '' }}>-- Select Operator --</option>
                                                @foreach ($approvalList as $user)
                                                    <option value="{{ $user->nik }}" {{ optional($record)->operator == $user->nik ? 'selected' : '' }}>
                                                        {{ $user->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($isShowDetail)
                                                <span class="
                                                    {{ $record->status_operator == 'Approve' ? 'text-success' : '' }}
                                                    {{ $record->status_operator == 'Pending' ? 'text-warning' : '' }}
                                                    {{ $record->status_operator == 'Reject' ? 'text-danger' : '' }}">
                                                    {{ ucfirst($record->status_operator) }}
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hmakhir2" class="ms-0">Pengawas</label>
                                            <select name="pengawas" id="pengawas" class="form-control select2">
                                                <option disabled {{ optional($record)->pengawas == '' ? 'selected' : '' }}>-- Select Pengawas --</option>
                                                @foreach ($approvalList as $user)
                                                    <option value="{{ $user->nik }}" {{ optional($record)->pengawas == $user->nik ? 'selected' : '' }}>
                                                        {{ $user->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($isShowDetail)
                                                <span class="
                                                    {{ $record->status_pengawas == 'Approve' ? 'text-success' : '' }}
                                                    {{ $record->status_pengawas == 'Pending' ? 'text-warning' : '' }}
                                                    {{ $record->status_pengawas == 'Reject' ? 'text-danger' : '' }}">
                                                    {{ ucfirst($record->status_pengawas) }}
                                                </span>
                                            @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <h5>Kondisi Android Sistem & Kondisi Unit</h5>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="kondisi1" class="ms-0">Aplikasi Aktifitas Hauler</label>
                                        <select class="form-control select2" name="kondisi1" id="kondisi1" required
                                            >
                                            <option value="Baik"
                                                {{ old('kondisi1', $record->kondisi1 ?? '') == 'Baik' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="Tidak"
                                                {{ old('kondisi1', $record->kondisi1 ?? '') == 'Tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="kondisi2" class="ms-0">Tablet 7"</label>
                                        <select class="form-control select2" name="kondisi2" id="kondisi2" required
                                            >
                                            <option value="Baik"
                                                {{ old('kondisi2', $record->kondisi2 ?? '') == 'Baik' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="Tidak"
                                                {{ old('kondisi2', $record->kondisi2 ?? '') == 'Tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="kondisi3" class="ms-0">Bracker</label>
                                        <select class="form-control select2" name="kondisi3" id="kondisi3" required
                                            >
                                            <option value="Baik"
                                                {{ old('kondisi3', $record->kondisi3 ?? '') == 'Baik' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="Tidak"
                                                {{ old('kondisi3', $record->kondisi3 ?? '') == 'Tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="kondisi4" class="ms-0">Charger/Cas Tablet</label>
                                        <select class="form-control select2" name="kondisi4" id="kondisi4" required
                                            >
                                            <option value="Baik"
                                                {{ old('kondisi4', $record->kondisi4 ?? '') == 'Baik' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="Tidak"
                                                {{ old('kondisi4', $record->kondisi4 ?? '') == 'Tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="kondisi_unit" class="ms-0">Laporan Kondisi Unit</label>
                                        <select class="form-control select2" name="kondisi_unit" id="kondisi_unit" required
                                            >
                                            <option value="Siap"
                                                {{ old('kondisi_unit', $record->kondisi_unit ?? '') == 'Siap' ? 'selected' : '' }}>
                                                Siap Di Operasikan</option>
                                            <option value="Tidak"
                                                {{ old('kondisi_unit', $record->kondisi_unit ?? '') == 'Tidak' ? 'selected' : '' }}>
                                                Perlu Repair Sebelum Di Operasikan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="kondisi_tubuh" class="ms-0">Kondisi Saya Saat Ini</label>
                                        <select class="form-control select2" name="kondisi_tubuh" id="kondisi_tubuh" required
                                            >
                                            <option value="Siap"
                                                {{ old('kondisi_tubuh', $record->kondisi_tubuh ?? '') == 'Fit' ? 'selected' : '' }}>
                                                Fit Dan Siap Kerja</option>
                                            <option value="Tidak"
                                                {{ old('kondisi_tubuh', $record->kondisi_tubuh ?? '') == 'Unfit' ? 'selected' : '' }}>
                                                Unfit Dan Siap Kerja</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead class="bg-success text-white">
                                        <tr>

                                            <th class="fix " style="text-align: center; vertical-align: middle; "
                                                rowspan="3">NO</th>
                                            <th class="fix" rowspan="3"
                                                style="text-align: center; vertical-align: middle; ">ITEM YANG HARUS DI PERIKSA</th>


                                            <th rowspan="2" class="fix" style="text-align: center; vertical-align: middle; ">TANDA KONDISI UNIT</th>
                                            <th rowspan="2" class="fix" style="text-align: center; vertical-align: middle; ">Fungsi Dari kelengkapan SKAT</th>
                                            <th>All Body Luar</th>
                                            <th>Attachment Kerja Unit</th>
                                            <th>Hidrolic Cyl & Hose</th>
                                            <th>Engine's Comp</th>
                                            <th>Power Train & Transmisi</th>
                                            <th>Undercarriage</th>
                                            <th>Wheel (roda ban) & Nut</th>
                                            <th>Suspension</th>
                                            <th>Brake (rem)</th>
                                            <th>Steering System</th>
                                            <th>Swing Mach, Cicle</th>
                                            <th>Electric's Comp</th>
                                            <th>Instumen Panel</th>
                                            <th rowspan="2" style="min-width: 500px; text-align: center; vertical-align: middle;">Deskripsi</th>

                                        </tr>
                                        <tr>
                                            @for ($i = 1; $i <= 13; $i++)
                                                <th style="text-align: center;">{{ $i }}</th>
                                            @endfor
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <b>SEBELUM OPERASI</b>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>1</td>
                                            <td>Keliling unit periksa kondisi abnormal</td>
                                            <td>
                                                <input type="hidden" name="question1_{{ 1 }}">
                                            </td>
                                            <td>
                                                <input type="hidden" name="question1_{{ 2 }}">
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 3 }}" value="1" {{ old('question1_' . 3, isset($record->question1[2]) ? $record->question1[2] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 4 }}" value="1" {{ old('question1_' . 4, isset($record->question1[3]) ? $record->question1[3] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 5 }}" value="1" {{ old('question1_' . 5, isset($record->question1[4]) ? $record->question1[4] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 6 }}" value="1" {{ old('question1_' . 6, isset($record->question1[5]) ? $record->question1[5] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="hidden" name="question1_{{ 7 }}">
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 8 }}" value="1" {{ old('question1_' . 8, isset($record->question1[7]) ? $record->question1[7] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 9 }}" value="1" {{ old('question1_' . 9, isset($record->question1[8]) ? $record->question1[8] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 10 }}" value="1" {{ old('question1_' . 10, isset($record->question1[9]) ? $record->question1[9] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="hidden" name="question1_{{ 11 }}">
                                            </td>
                                            <td>
                                                <input type="hidden" name="question1_{{ 12 }}">
                                            </td>
                                            <td>
                                                <input type="hidden" name="question1_{{ 13 }}">
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 14 }}" value="1" {{ old('question1_' . 14, isset($record->question1[13]) ? $record->question1[13] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question1_{{ 15 }}" value="1" {{ old('question1_' . 15, isset($record->question1[14]) ? $record->question1[14] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{1}}">{{ old('deskripsi_' . 1, isset($record->deskripsi[0]) ? $record->deskripsi[0] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>Periksa kebocoran oli,air,udara,bahan bakar </td>
                                            <td><input type="hidden" name="question2_{{ 1 }}"></td>
                                            <td><input type="hidden" name="question2_{{ 2 }}"></td>
                                            <td><input type="hidden" name="question2_{{ 3 }}"></td>
                                            <td><input type="hidden" name="question2_{{ 4 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question2_{{ 5 }}" value="1" {{ old('question2_' . 5, isset($record->question2[4]) ? $record->question2[4] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question2_{{ 6 }}" value="1" {{ old('question2_' . 6, isset($record->question2[5]) ? $record->question2[5] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question2_{{ 7 }}" value="1" {{ old('question2_' . 7, isset($record->question2[6]) ? $record->question2[6] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question2_{{ 8 }}" value="1" {{ old('question2_' . 8, isset($record->question2[7]) ? $record->question2[7] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question2_{{ 9 }}" value="1" {{ old('question2_' . 9, isset($record->question2[8]) ? $record->question2[8] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question2_{{ 10 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question2_{{ 11 }}" value="1" {{ old('question2_' . 11, isset($record->question2[10]) ? $record->question2[10] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question2_{{ 12 }}" value="1" {{ old('question2_' . 12, isset($record->question2[11]) ? $record->question2[11] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question2_{{ 13 }}" value="1" {{ old('question2_' . 13, isset($record->question2[12]) ? $record->question2[12] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question2_{{ 14 }}"></td>
                                            <td><input type="hidden" name="question2_{{ 15 }}"></td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{2}}">{{ old('deskripsi_' . 2, isset($record->deskripsi[1]) ? $record->deskripsi[1] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>3</td>
                                            <td>Check permukaan oli</td>
                                            <td><input type="hidden" name="question3_{{ 1 }}"></td>
                                            <td><input type="hidden" name="question3_{{ 2 }}"></td>
                                            <td><input type="hidden" name="question3_{{ 3 }}"></td>
                                            <td><input type="hidden" name="question3_{{ 4 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question3_{{ 5 }}" value="1" {{ old('question3_' . 5, isset($record->question3[4]) ? $record->question3[4] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question3_{{ 6 }}" value="1" {{ old('question3_' . 6, isset($record->question3[5]) ? $record->question3[5] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question3_{{ 7 }}" value="1" {{ old('question3_' . 7, isset($record->question3[6]) ? $record->question3[6] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question3_{{ 8 }}"></td>
                                            <td><input type="hidden" name="question3_{{ 9 }}"></td>
                                            <td><input type="hidden" name="question3_{{ 10 }}"></td>
                                            <td><input type="hidden" name="question3_{{ 11 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question3_{{ 12 }}" value="1" {{ old('question3_' . 12, isset($record->question3[11]) ? $record->question3[11] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question3_{{ 13 }}"></td>
                                            <td><input type="hidden" name="question3_{{ 14 }}"></td>
                                            <td><input type="hidden" name="question3_{{ 15 }}"></td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{3}}">{{ old('deskripsi_' . 3, isset($record->deskripsi[2]) ? $record->deskripsi[2] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>4</td>
                                            <td>Check permukaan air subtank dan wifer</td>
                                            <td><input type="hidden" name="question4_{{ 1 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 2 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question4_{{ 3 }}" value="1" {{ old('question4_' . 3, isset($record->question4[2]) ? $record->question4[2] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question4_{{ 4 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 5 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question4_{{ 6 }}" value="1" {{ old('question4_' . 6, isset($record->question4[5]) ? $record->question4[5] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question4_{{ 7 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 8 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 9 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 10 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 11 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 12 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 13 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 14 }}"></td>
                                            <td><input type="hidden" name="question4_{{ 15 }}"></td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{4}}">{{ old('deskripsi_' . 4, isset($record->deskripsi[3]) ? $record->deskripsi[3] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>5</td>
                                            <td>Check tekanan udara</td>
                                            <td><input type="hidden" name="question5_{{ 1 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 2 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 3 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 4 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 5 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 6 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 7 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 8 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question5_{{ 9 }}" value="1" {{ old('question5_' . 9, isset($record->question5[8]) ? $record->question5[8] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question5_{{ 10 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question5_{{ 11 }}" value="1" {{ old('question5_' . 11, isset($record->question5[10]) ? $record->question5[10] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question5_{{ 12 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 13 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 14 }}"></td>
                                            <td><input type="hidden" name="question5_{{ 15 }}"></td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{5}}">{{ old('deskripsi_' . 5, isset($record->deskripsi[4]) ? $record->deskripsi[4] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>6</td>
                                            <td>Test fungsi</td>
                                            <td><input type="hidden" name="question6_{{ 1 }}"></td>
                                            <td><input type="hidden" name="question6_{{ 2 }}"></td>
                                            <td><input type="hidden" name="question6_{{ 3 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question6_{{ 4 }}" value="1" {{ old('question6_' . 4, isset($record->question6[3]) ? $record->question6[3] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question6_{{ 5 }}" value="1" {{ old('question6_' . 5, isset($record->question6[4]) ? $record->question6[4] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question6_{{ 6 }}"></td>
                                            <td><input type="hidden" name="question6_{{ 7 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question6_{{ 8 }}" value="1" {{ old('question6_' . 8, isset($record->question6[7]) ? $record->question6[7] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question6_{{ 9 }}"></td>
                                            <td><input type="hidden" name="question6_{{ 10 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question6_{{ 11 }}" value="1" {{ old('question6_' . 11, isset($record->question6[10]) ? $record->question6[10] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question6_{{ 12 }}" value="1" {{ old('question6_' . 12, isset($record->question6[11]) ? $record->question6[11] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question6_{{ 13 }}" value="1" {{ old('question6_' . 13, isset($record->question6[12]) ? $record->question6[12] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><label>
                                                    <input type="checkbox" name="question6_{{ 14 }}" value="1" {{ old('question6_' . 14, isset($record->question6[13]) ? $record->question6[13] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question6_{{ 15 }}" value="1" {{ old('question6_' . 15, isset($record->question6[14]) ? $record->question6[14] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{6}}">{{ old('deskripsi_' . 6, isset($record->deskripsi[5]) ? $record->deskripsi[5] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>7</td>
                                            <td>Radio Komunikasi,Apar,Rotary, Traficone, Seatbelt ,Alarm mundur dan semua lampu kerja </td>
                                            <td><input type="hidden" name="question7_{{ 1 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question7_{{ 2 }}" value="1" {{ old('question7_' . 2, isset($record->question7[1]) ? $record->question7[1] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question7_{{ 3 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 4 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 5 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 6 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 7 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 8 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 9 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 10 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 11 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 12 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 13 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 14 }}"></td>
                                            <td><input type="hidden" name="question7_{{ 15 }}"></td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{7}}">{{ old('deskripsi_' . 7, isset($record->deskripsi[6]) ? $record->deskripsi[6] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2"><b>SELAMA OPERASI</b></td>
                                        </tr>

                                        <tr>
                                            <td>8</td>
                                            <td>Kondisi Dan Fungsi</td>
                                            <td><input type="hidden" name="question8_{{ 1 }}"></td>
                                            <td><input type="hidden" name="question8_{{ 2 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 3 }}" value="1" {{ old('question8_' . 3, isset($record->question8[2]) ? $record->question8[2] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 4 }}" value="1" {{ old('question8_' . 4, isset($record->question8[3]) ? $record->question8[3] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 5 }}" value="1" {{ old('question8_' . 5, isset($record->question8[4]) ? $record->question8[4] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 6 }}" value="1" {{ old('question8_' . 6, isset($record->question8[5]) ? $record->question8[5] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 7 }}" value="1" {{ old('question8_' . 7, isset($record->question8[6]) ? $record->question8[6] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 8 }}" value="1" {{ old('question8_' . 8, isset($record->question8[7]) ? $record->question8[7] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 9 }}" value="1" {{ old('question8_' . 9, isset($record->question8[8]) ? $record->question8[8] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 10 }}" value="1" {{ old('question8_' . 10, isset($record->question8[9]) ? $record->question8[9] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 11 }}" value="1" {{ old('question8_' . 11, isset($record->question8[10]) ? $record->question8[10] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 12 }}" value="1" {{ old('question8_' . 12, isset($record->question8[11]) ? $record->question8[11] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 13 }}" value="1" {{ old('question8_' . 13, isset($record->question8[12]) ? $record->question8[12] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 14 }}" value="1" {{ old('question8_' . 14, isset($record->question8[13]) ? $record->question8[13] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question8_{{ 15 }}" value="1" {{ old('question8_' . 15, isset($record->question8[14]) ? $record->question8[14] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{8}}">{{ old('deskripsi_' . 8, isset($record->deskripsi[7]) ? $record->deskripsi[7] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>9</td>
                                            <td>Lain-lain yang dianggap bahaya</td>
                                            <td><label>
                                                    <input type="checkbox" name="question9_{{ 1 }}" value="1" {{ old('question9_' . 1, isset($record->question9[0]) ? $record->question9[0] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question9_{{ 2 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 3 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 4 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 5 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 6 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 7 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 8 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 9 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 10 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 11 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 12 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 13 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 14 }}"></td>
                                            <td><input type="hidden" name="question9_{{ 15 }}"></td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{9}}">{{ old('deskripsi_' . 9, isset($record->deskripsi[8]) ? $record->deskripsi[8] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2"><b>SELESAI OPERASI</b></td>
                                        </tr>

                                        <tr>
                                            <td>10</td>
                                            <td>Kondisi unit pasca operasi baik</td>
                                            <td><input type="hidden" name="question10_{{ 1 }}"></td>
                                            <td><input type="hidden" name="question10_{{ 2 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question10_{{ 3 }}" value="1" {{ old('question10_' . 3, isset($record->question10[2]) ? $record->question10[2] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question10_{{ 4 }}" value="1" {{ old('question10_' . 4, isset($record->question10[3]) ? $record->question10[3] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question10_{{ 5 }}"></td>
                                            <td><input type="hidden" name="question10_{{ 6 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question10_{{ 7 }}" value="1" {{ old('question10_' . 7, isset($record->question10[6]) ? $record->question10[6] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question10_{{ 8 }}" value="1" {{ old('question10_' . 8, isset($record->question10[7]) ? $record->question10[7] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="triangle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question10_{{ 9 }}" value="1" {{ old('question10_' . 9, isset($record->question10[8]) ? $record->question10[8] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question10_{{ 10 }}" value="1" {{ old('question10_' . 10, isset($record->question10[9]) ? $record->question10[9] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="square"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question10_{{ 11 }}"></td>
                                            <td><input type="hidden" name="question10_{{ 12 }}"></td>
                                            <td><input type="hidden" name="question10_{{ 13 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question10_{{ 14 }}" value="1" {{ old('question10_' . 14, isset($record->question10[13]) ? $record->question10[13] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question10_{{ 15 }}" value="1" {{ old('question10_' . 15, isset($record->question10[14]) ? $record->question10[14] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{10}}">{{ old('deskripsi_' . 10, isset($record->deskripsi[9]) ? $record->deskripsi[9] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>11</td>
                                            <td>Posisi, tempat parkir dan kebersihan</td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question11_{{ 1 }}" value="1" {{ old('question11_' . 1, isset($record->question11[0]) ? $record->question11[0] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question11_{{ 2 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 3 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 4 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 5 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 6 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 7 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 8 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 9 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 10 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 11 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 12 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 13 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 14 }}"></td>
                                            <td><input type="hidden" name="question11_{{ 15 }}"></td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{10}}">{{ old('deskripsi_' . 10, isset($record->deskripsi[9]) ? $record->deskripsi[9] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>12</td>
                                            <td>Radio Komunikasi, Apar, Rotary, Traficone, Seatbelt Alarm mundur dan semua lampu kerja</td>
                                            <td><input type="hidden" name="question12_{{ 1 }}"></td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="question12_{{ 2 }}" value="1" {{ old('question12_' . 2, isset($record->question12[1]) ? $record->question12[1] : '') == 1 ? 'checked' : '' }}
                                                        >
                                                        <div class="shape-container">
                                                            <div class="circle"></div>
                                                                <span class="checkmark">✓</span>
                                                        </div>
                                                </label>
                                            </td>
                                            <td><input type="hidden" name="question12_{{ 3 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 4 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 5 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 6 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 7 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 8 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 9 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 10 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 11 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 12 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 13 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 14 }}"></td>
                                            <td><input type="hidden" name="question12_{{ 15 }}"></td>
                                            <td >
                                                <textarea class="form-control" name="deskripsi_{{12}}">{{ old('deskripsi_' . 12, isset($record->deskripsi[11]) ? $record->deskripsi[11] : '') }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="14">

                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                                    <div class="form-actions">
                                        <a href="{{ route('prod.a2b-baru.dashboard') }}"
                                            class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
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

        input[type="checkbox"] {
            display: none;
        }
        
        /* Style umum untuk container */
        .shape-container {
            position: relative;
            width: 50px;
            height: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Kotak outline */
        .square {
            width: 40px;
            height: 40px;
            border: 2px solid #000;
            background-color: transparent;
        }
        
        /* Segitiga dengan outline */
        .triangle {
            position: relative;
            width: 50px;
            height: 50px;
        }
        
        .triangle::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 35px solid #000;
        }
        
        .triangle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            border-left: 18px solid transparent;
            border-right: 18px solid transparent;
            border-bottom: 31px solid white;
            z-index: 1;
        }
        
        /* Lingkaran outline */
        .circle {
            width: 40px;
            height: 40px;
            border: 2px solid #000;
            border-radius: 50%;
            background-color: transparent;
        }
        
        /* Tanda checklist */
        .checkmark {
            position: absolute;
            color: #000;
            font-size: 24px;
            z-index: 2;
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        /* Tanda checklist untuk segitiga - disesuaikan posisinya */
        .triangle .checkmark {
            transform: translateY(5px);
        }
        
        /* Menampilkan tanda checklist saat dicentang */
        input[type="checkbox"]:checked + .shape-container .checkmark {
            opacity: 1;
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(function() {
        $('.select2').select2();
            var form = $("#a2bbaruForm");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);

                axios.post(`{{ route('prod.a2b-baru.update', ['id' => $record->id]) }}`, formData)
                    .then(function(response) {
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('prod.a2b-baru.dashboard') }}';
                                }
                            });
                        }
                    })
                    .catch(function(error) {
                        let errorMessage = 'Terjadi kesalahan pada sistem';

                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join(
                                    '\n');
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
