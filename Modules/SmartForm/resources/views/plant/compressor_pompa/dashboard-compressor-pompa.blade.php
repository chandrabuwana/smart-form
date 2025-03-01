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
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Compressor Pompa (Standard)</h6>
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
                                        <i class="fas fa-solid fa-location-dot text-danger fa-2x"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Location</p>
                                        <h4 class="mb-0">{{ $statistics->location }}</h4>
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
                                        <i class="fas fa-solid fa-code-branch fa-2x"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Site</p>
                                        <h4 class="mb-0">{{ $statistics->site }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center mx-3">
                        <a href="{{ route('plant.compressor.form') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <form action="{{ route('plant.compressor.dashboard') }}" method="GET" id="filterForm">
                            <div class="row align-items-center">
                                <div class="col-md-2 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label>Search</label>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search by doc number or name"
                                            value="{{ $filters['search'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3
                                            mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="location" class="ms-0">Location</label>
                                        <select class="form-control" id="location" name="location">
                                            <option selected disabled>-- Select Location --</option>
                                            <option value="Workshop"
                                                {{ isset($filters['location']) && $filters['location'] == 'Workshop' ? 'selected' : '' }}>
                                                Workshop</option>
                                            <option value="Pitstop"
                                                {{ isset($filters['location']) && $filters['location'] == 'Pitstop' ? 'selected' : '' }}>
                                                Pitstop</option>
                                            <option value="Service"
                                                {{ isset($filters['location']) && $filters['location'] == 'Service' ? 'selected' : '' }}>
                                                Service</option>
                                            <option value="Truck"
                                                {{ isset($filters['location']) && $filters['location'] == 'Truck' ? 'selected' : '' }}>
                                                Truck</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3
                                            mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="location" class="ms-0">Site</label>
                                        <select class="form-control" name="site" id="site">
                                            <option disabled selected>-- Select Site --</option>
                                            <option value="agm"
                                                {{ isset($filters['site']) && $filters['site'] == 'agm' ? 'selected' : '' }}>
                                                agm</option>
                                            <option value="mbl"
                                                {{ isset($filters['site']) && $filters['site'] == 'mbl' ? 'selected' : '' }}>
                                                mbl</option>
                                            <option value="mme"
                                                {{ isset($filters['site']) && $filters['site'] == 'mme' ? 'selected' : '' }}>
                                                mme</option>
                                            <option value="mas"
                                                {{ isset($filters['site']) && $filters['site'] == 'mas' ? 'selected' : '' }}>
                                                mas</option>
                                            <option value="pmss"
                                                {{ isset($filters['site']) && $filters['site'] == 'pmss' ? 'selected' : '' }}>
                                                pmss</option>
                                            <option value="taj"
                                                {{ isset($filters['site']) && $filters['site'] == 'taj' ? 'selected' : '' }}>
                                                taj</option>
                                            <option value="bssr"
                                                {{ isset($filters['site']) && $filters['site'] == 'bssr' ? 'selected' : '' }}>
                                                bssr</option>
                                            <option value="tdm"
                                                {{ isset($filters['site']) && $filters['site'] == 'tdm' ? 'selected' : '' }}>
                                                tdm</option>
                                            <option value="msj"
                                                {{ isset($filters['site']) && $filters['site'] == 'msj' ? 'selected' : '' }}>
                                                msj</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="date" class="ms-0">Date</label>
                                        <input type="date" class="form-control" id="date" name="date"
                                            value="{{ $filters['date'] ?? '' }}">
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
                                            Unit</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Lokasi</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Site</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Generator Model</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Month</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $record->doc_number }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $record->unit_name }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $record->location }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $record->site }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $record->generator_model }}
                                                </p>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($record->month)->format('F') }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('plant.compressor.form', ['id' => $record->id]) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('plant.compressor.export', ['id' => $record->id]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $records->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(function() {
            // Clear filter button
            $('#btnClearFilter').click(function() {
                window.location.href = '{{ route('plant.compressor.dashboard') }}';
            });

        });
    </script>
@endsection
