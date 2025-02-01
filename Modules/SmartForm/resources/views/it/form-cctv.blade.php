@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        .ml-16px {
            margin-left: 16px;
        }
        .mb-8px {
            margin-bottom: 8px;
        }
        .display-block {
            display: block;
        }
        .m-0 {
            margin: 0;
        }
        .text-right {
            text-align: right;
        }
        .input-text {
            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
            background: transparent;
            width: 100%;
        }
        .input-text:focus {
            border: 0;
            border-bottom: 2px solid #4CAF50;
            padding: 2px;
            box-shadow: none;
            outline: none;
        }
        .reset-border {
            border: 0;
        }
        .w-full {
            width: 100%
        }
        .th-baik {
            background-color: #4CAF50 !important;
            color: white !important;
            text-align: center;
        }
        .th-rusak {
            background-color: #dc3545 !important;
            color: white !important;
            text-align: center;
        }
        .table > :not(caption) > * > * {
            padding: 0.5rem;
            border-bottom-width: 1px;
            border-color: rgb(188, 188, 188);
        }
        .table td {
            vertical-align: middle;
        }
        .form-label {
            margin-bottom: 0;
            font-weight: 500;
        }
        .card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 1rem;
        }
        .card-header h5 {
            margin: 0;
            color: #344767;
            font-size: 1rem;
            font-weight: 600;
        }
        .form-select.input-text {
            background-position: right 0.25rem center;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Maintenance CCTV</h6>
                </div>
            </div>
            
            <div class="card-body my-1">
                <form id="maintenanceForm" method="POST" action="{{ route('it-ops.submit-cctv') }}" class="form">
                    @csrf
                    <div class="row mb-4">
                        <!-- Teknisi Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Teknisi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="nama">Nama</label>
                                        <input type="text" class="form-control input-text" id="nama" name="nama" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail ? $maintenanceRecord->nama : (session('username') ?? '') }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="nik">NIK</label>
                                        <input type="text" class="form-control input-text" id="nik" name="nik" required
                                        {{ $isShowDetail ? 'disabled' : '' }}
                                        value="{{ $isShowDetail ? $maintenanceRecord->nik :  (session('user_id') ?? '') }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="dept">Dept</label>
                                        <input type="text" class="form-control input-text" id="dept" name="dept" required
                                        {{ $isShowDetail ? 'disabled' : '' }}
                                        value="{{ $isShowDetail ? $maintenanceRecord->dept : (session('kode_department') ?? '') }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="site">Site</label>
                                        <select class="form-select input-text" id="site" name="site" required
                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Site --</option>
                                            @foreach(['agm', 'mbl', 'mme', 'mas', 'pmss', 'taj', 'bssr', 'tdm', 'msj'] as $site)
                                                <option value="{{ $site }}" {{ $isShowDetail && strtolower($maintenanceRecord->site) == $site ? 'selected' : '' }}>
                                                    {{ strtoupper($site) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Spesifikasi Barang -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Spesifikasi Barang</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="no_asset">No Asset</label>
                                        <input type="text" class="form-control input-text" id="no_asset" name="no_asset" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail ? $maintenanceRecord->no_asset : '' }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="jenis_aset">Jenis Asset</label>
                                        <input type="text" class="form-control input-text" id="jenis_aset" name="jenis_aset" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail ? $maintenanceRecord->jenis_aset : '' }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="merk">Merk</label>
                                        <input type="text" class="form-control input-text" id="merk" name="merk" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail ? $maintenanceRecord->merk : '' }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="model">Model</label>
                                        <input type="text" class="form-control input-text" id="model" name="model" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail ? $maintenanceRecord->model : '' }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="area_cctv">Area CCTV</label>
                                        <input type="text" class="form-control input-text" id="area_cctv" name="area_cctv" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail ? $maintenanceRecord->area_cctv : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Kondisi -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Hardware Conditions</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kondisi</th>
                                                <th class="text-center th-baik">Baik</th>
                                                <th class="text-center th-rusak">Rusak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach([
                                                'camera_condition' => 'Fisik Kamera',
                                                'lens_condition' => 'Lensa',
                                                'cable_condition' => 'Kabel Power',
                                                'storage_cctv_condition' => 'Storage CCTV*'
                                            ] as $field => $label)
                                            <tr>
                                                    <td>{{ $label }}</td>
                                                    <td class="text-center">
                                                        <input type="radio" 
                                                            name="{{ $field }}" 
                                                            value="baik"
                                                            {{ $isShowDetail && isset($maintenanceRecord->$field) && $maintenanceRecord->$field === 'baik' ? 'checked' : '' }}
                                                            {{ $isShowDetail ? 'disabled' : '' }}
                                                            required>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" 
                                                            name="{{ $field }}" 
                                                            value="rusak"
                                                            {{ $isShowDetail && isset($maintenanceRecord->$field) && $maintenanceRecord->$field === 'rusak' ? 'checked' : '' }}
                                                            {{ $isShowDetail ? 'disabled' : '' }}
                                                            required>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <small class="text-muted">*Jika ada</small>
                                </div>
                            </div>
                        </div>

                        <!-- MAINTENANCE -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Maintenance</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">Check</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach([
                                                'cover_area' => 'Cover Area',
                                                'video_quality' => 'Kualitas Video',
                                                'sound_quality' => 'Kualitas Suara*',
                                                'remote_view_nvr' => 'Remote View NVR*',
                                                'remote_playback' => 'Remote Playback',
                                            ] as $field => $label)
                                                <tr>
                                                    <td>{{ $label }}</td>
                                                    <td class="text-center">
                                                        <input type="checkbox" 
                                                            name="{{ $field }}" 
                                                            value="1"
                                                            {{ $isShowDetail && isset($maintenanceRecord->$field) && $maintenanceRecord->$field ? 'checked' : '' }}
                                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$isShowDetail)
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('it-ops.dashboard-cctv') }}" class="btn btn-secondary">Back</a>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('it-ops.dashboard-cctv') }}" class="btn btn-secondary">Back</a>
                                </div>
                                <div>
                                    <a href="{{ route('it-ops.form-cctv.export', ['id' => $maintenanceRecord->id]) }}" class="btn btn-primary">
                                        <i class="fas fa-file-export"></i> Export
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
    $(function() {
        var btnSubmitForm = $("#btnSubmitForm");
        var maintenanceForm = $("#maintenanceForm");

        maintenanceForm.submit(function(e) {
            e.preventDefault();
            btnSubmitForm.prop('disabled', true);

            var formData = new FormData(this);
            
            axios.post('{{ route("it-ops.submit-cctv") }}', formData)
                .then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("it-ops.dashboard-cctv") }}';
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
                    btnSubmitForm.prop('disabled', false);
                });
        });
    });
    </script>
@endsection
