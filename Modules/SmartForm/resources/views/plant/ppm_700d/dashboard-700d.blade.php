@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .stats-card {
            transition: all 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .filter-btn {
            display: inline;
            width: auto;
            margin-right: 8px;
        }

        .status {
            display: flex;
            gap: 10px;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .box {
            width: 20px;
            height: 20px;
            display: inline-block;
            border-radius: 4px;
        }

        .red {
            background-color: #F44335;
        }

        .green {
            background-color: #4CAF50;
        }

        .blue {
            background-color: #0000FF;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form PPM XCMG XE700D</h6>
                    </div>
                </div>
                <!-- Statistics Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <i class="fas fa-file text-primary fa-2x"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Total Records</p>
                                        <h4 class="mb-0">{{ $statistics->total_records }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <i class="fas fa-calendar text-success fa-2x"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">This Month</p>
                                        <h4 class="mb-0">{{ $statistics->total_this_month }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <i class="fas fa-tram fa-2x" style="color: #B197FC;"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">CN Unit</p>
                                        <h4 class="mb-0">{{ $statistics->engine_model }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <i class="fas fa-sitemap fa-2x" style="color: #74C0FC;"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Job Site</p>
                                        <h4 class="mb-0">{{ $statistics->job_site }}</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center mx-3">
                        <a href="{{ route('plant.ppm.700d.form') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <form action="" method="GET" id="filterForm">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label>Search</label>
                                        <input type="text" name="search" class="form-control" placeholder="Search"
                                            value="{{ $filters['search'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3
                                            mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="unit_cn" class="ms-0">Unit C/N</label>
                                        <select name="unit_cn" class="form-control" id="unit_cn">
                                            <option value="" disabled selected>-- Select --</option>
                                            @foreach ($cn as $cn_unit)
                                                <option value="{{ $cn_unit->no_lambung }}"
                                                    {{ $cn_unit->no_lambung == $filters['unit_cn'] ? 'selected' : '' }}>
                                                    {{ $cn_unit->no_lambung }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="job" class="ms-0">Job Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect(
                                            'job_site',
                                            strtolower($filters['job_site']),
                                            $isDisabled = false,
                                            $isRequired = false,
                                        ) !!}
                                    </div>
                                </div>
                                <div class="col-md-3
                                mb-3">
                                    @php
                                        $validatedBy = $filters['validated_by'] ?? null;
                                    @endphp
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="validated_by" class="ms-0">Approval</label>

                                        <select name="validated_by" id="approval" class="form-control">

                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 d-flex justify-content-start">
                                    <button type="submit" class="btn btn-primary filter-btn" id="btnFilterSubmit">
                                        Filter
                                    </button>
                                    <button type="button" class="btn btn-secondary filter-btn" id="btnClearFilter">
                                        Clear Filter
                                    </button>
                                </div>
                                <div class="col-md-12 d-flex justify-content-end">

                                    <div class="status me-2">
                                        <span class="box red"></span> Rejected
                                    </div>
                                    <div class="status me-2">
                                        <span class="box green"></span> Approved
                                    </div>
                                    <div class="status me-2">
                                        <span class="box blue"></span> Draft
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="card">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Doc
                                            Number</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            C/N Unit</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            HM At Inspection</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Job Site</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Validate</th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Status</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($record as $data)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $data->doc_num }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $data->unit_cn }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    {{ $data->at_inspection }} </p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    {{ $data->job_site }} </p>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold">{{ $data->date }}</span>
                                            </td>


                                            <td>
                                                <span class="text-xs font-weight-bold">
                                                    @if ($data->status === 'approved')
                                                        <span class="badge bg-success">{{ $data->validated_by }}</span>
                                                    @elseif ($data->status === 'rejected')
                                                        <span class="badge bg-danger">{{ $data->validated_by }}</span>
                                                    @elseif ($data->status == 'draft')
                                                        <span class="badge bg-info">{{ $data->validated_by }}</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold">
                                                    @if ($data->status === 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif ($data->status === 'rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @elseif ($data->status === 'draft')
                                                        <span class="badge bg-info">Menunggu validasi Foreman</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                @if ($session == $data->creator)
                                                    @if ($data->status === 'rejected' || $data->status === 'draft')
                                                        <a href="{{ route('plant.ppm.700d.detail', ['id' => $data->id]) }}"
                                                            class="btn btn-warning btn-sm mt-3">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm mt-3"
                                                            onclick="deleteXcmg700('{{ $data->doc_num }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                                <a href="{{ route('plant.ppm.700d.show', ['id' => $data->id]) }}"
                                                    class="btn btn-info btn-sm mt-3">
                                                    <i class="far fa-check-circle" style="font-size:12px;"></i>
                                                </a>

                                                <a href="{{ route('plant.ppm.700d.export', ['id' => $data->id]) }}"
                                                    class="btn btn-primary btn-sm mt-3">
                                                    <i class="fas fa-download"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-left mt-3">
                                {{ $record->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('#approval').select2();
            $('#job_site').select2();
            $('#unit_cn').select2();
        });
        $(function() {
            // Clear filter button
            $('#btnClearFilter').click(function() {
                window.location.href = '{{ route('plant.ppm.700d.dashboard') }}';
            });

        });

        function deleteXcmg700(id) {
            console.log('Delete ID:', id);
            if (confirm('Are you sure you want to delete this data?')) {
                axios.delete('{{ route('plant.ppm.700d.delete', ['id' => 'ID']) }}'.replace('ID', id))
                    .then(function(response) {
                        console.log('Response:', response);
                        if (response.data.success) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then(() => {

                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete the compressor.'
                            });
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
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
            }
        }
    </script>
    <script>
        $(function() {
            const selectedNama = @json($validatedBy); 

            $('#approval').select2({
                placeholder: '-- Pilih Approval --',
                width: '100%',
                ajax: {
                    url: '{{ route('700d.approval.list') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                if (!item.nama) return null;
                                return {
                                    id: item.nama,
                                    text: item.nama + ' (' + item.nik + ')'
                                };
                            }).filter(Boolean)
                        };
                    },
                    cache: true
                }
            });

            // Preselect jika nama sudah ada
            if (selectedNama) {
                $.ajax({
                    url: '{{ route('700d.approval.list') }}',
                    dataType: 'json',
                    success: function(data) {
                        const matched = data.find(item => item.nama === selectedNama);
                        if (matched) {
                            const option = new Option(matched.nama + ' (' + matched.nik + ')', matched
                                .nama, true, true);
                            $('#approval').append(option).trigger('change');
                        }
                    }
                });
            }
        });
    </script>
@endsection
