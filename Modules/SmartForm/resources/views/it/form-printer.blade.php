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
                    <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : ($isEdit ? 'Edit' : 'New')}} Maintenance Printer 1</h6>
                </div>
            </div>
            
            <div class="card-body my-1">
                <form id="maintenanceForm" method="POST" action="{{ $isEdit ? route('it-ops.update-printer') : route('it-ops.submit-printer') }}" class="form">
                    @csrf
                    @if($isEdit)
                        <input type="hidden" name="id" value="{{ $maintenanceRecord->id }}">
                    @endif
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
                                            value="{{ $isShowDetail || $isEdit ? $maintenanceRecord->nama : (session('username') ?? '') }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="nik">NIK</label>
                                        <input type="text" class="form-control input-text" id="nik" name="nik" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail || $isEdit ? $maintenanceRecord->nik : (session('user_id') ?? '') }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="dept">Dept</label>
                                        {!! \Modules\SmartForm\helpers\DepartmentHelper::renderDepartmentSelect('dept', ($isShowDetail || $isEdit) ? $maintenanceRecord->dept : null, $isShowDetail) !!}
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="site">Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site', ($isShowDetail || $isEdit) ? strtolower($maintenanceRecord->site) : null, $isShowDetail) !!}
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
                                            value="{{ $isShowDetail || $isEdit ? $maintenanceRecord->no_asset : '' }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="jenis_aset">Jenis Asset</label>
                                        <input type="text" class="form-control input-text" id="jenis_aset" name="jenis_aset" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail || $isEdit ? $maintenanceRecord->jenis_aset : '' }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="merk">Merk</label>
                                        <input type="text" class="form-control input-text" id="merk" name="merk" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail || $isEdit ? $maintenanceRecord->merk : '' }}">
                                    </div>
                                    <div class="mb-0 d-flex align-items-center">
                                        <label class="form-label me-2 w-25" for="model">Model</label>
                                        <input type="text" class="form-control input-text" id="model" name="model" required
                                            {{ $isShowDetail ? 'disabled' : '' }}
                                            value="{{ $isShowDetail || $isEdit ? $maintenanceRecord->model : '' }}">
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
                                    <div class="table-responsive">
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
                                                    'case_casing_condition' => 'Case/Casing',
                                                    'adaptor_condition' => 'Adaptor',
                                                    'kabel_power_condition' => 'Kabel Power',
                                                    'paper_tray_condition' => 'Paper Tray',
                                                    'ink_condition' => 'Tinta',
                                                    'cartridge_condition' => 'Cartridge',
                                                    'lamp_indicator_condition' => 'Lampu Indikator',
                                                    'touchscreen_condition' => 'Touchscreen'
                                                ] as $field => $label)
                                                    <tr class="border">
                                                        <td class="border">{{ $label }}</td>
                                                        <td class="text-center border">
                                                            <input type="radio" 
                                                                name="{{ $field }}" 
                                                                value="baik"
                                                                {{ ($isShowDetail || $isEdit) && isset($maintenanceRecord->$field) && $maintenanceRecord->$field === 'baik' ? 'checked' : '' }}
                                                                {{ $isShowDetail ? 'disabled' : '' }}
                                                                required>
                                                        </td>
                                                        <td class="text-center border">
                                                            <input type="radio" 
                                                                name="{{ $field }}" 
                                                                value="rusak"
                                                                {{ ($isShowDetail || $isEdit) && isset($maintenanceRecord->$field) && $maintenanceRecord->$field === 'rusak' ? 'checked' : '' }}
                                                                {{ $isShowDetail ? 'disabled' : '' }}
                                                                required>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <small class="text-muted">* Jika ada</small>
                                    </div>
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
                                                'software_update' => 'Software Update',
                                                'print_test' => 'Print Test',
                                                'scan_test' => 'Scan Test',
                                                'network_test' => 'Network Test*',
                                                'bluetooth_test' => 'Bluetooth Test*',
                                                'cable_test' => 'Cable Test',
                                                'toner_level' => 'Level Tinta'
                                            ] as $field => $label)
                                            <tr class="border">
                                                <td class="border">{{ $label }}</td>
                                                <td class="text-center border">
                                                    <input type="checkbox" 
                                                        name="{{ $field }}" 
                                                        value="1"
                                                        {{ ($isShowDetail || $isEdit) && isset($maintenanceRecord->$field) && $maintenanceRecord->$field ? 'checked' : '' }}
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
                                    <a href="{{ route('it-ops.dashboard-printer') }}" class="btn btn-secondary">Back</a>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Submit' }}</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('it-ops.dashboard-printer') }}" class="btn btn-secondary">Back</a>
                                </div>
                                <div>
                                    <a href="{{ route('it-ops.form-printer.export', ['id' => $maintenanceRecord->id]) }}" class="btn btn-primary">
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
        var maintenanceForm = $("#maintenanceForm");

        maintenanceForm.submit(function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            
            axios.post('{{ route("it-ops.submit-printer") }}', formData)
                .then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("it-ops.dashboard-printer") }}';
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
                });
        });
    });
    </script>
@endsection
