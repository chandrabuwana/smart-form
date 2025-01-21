@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <style>
        .filter-btn {
            display: inline;
            width: auto
        }
        .position-relative {
            position: relative;
        }
        .position-absolute {
            position: absolute;
        }
        .suggestion {
            position: absolute;
            top: 100%;
            max-height: 100px;
            width: 100%;
            overflow-y: auto;
            z-index: 99;
            color: black;
            border: 1px solid rgba(85, 83, 83, 0.534);
            border-radius: 4px 4px 4px 4px;
        }
        .suggestion-child {
            cursor: pointer;
            font-size: 12px;
            padding: 2px 4px;
            border-bottom: 1px solid rgba(85, 83, 83, 0.534);
        }
        .text-light {
            color: #f0f2f5;
        }
        .stats-card {
            transition: all 0.3s ease-in-out;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Printer Maintenance</h6>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mx-3 mt-4">
                    <div class="col-xl-3 col-sm-6 mb-4">
                        <div class="card stats-card">
                            <div class="card-header p-3 pt-2">
                                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">inventory_2</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Total Records</p>
                                    <h4 class="mb-0">{{ $statistics->total_records }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 mb-4">
                        <div class="card stats-card">
                            <div class="card-header p-3 pt-2">
                                <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">build</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Broken Components</p>
                                    <h4 class="mb-0">{{ $statistics->broken_components }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 mb-4">
                        <div class="card stats-card">
                            <div class="card-header p-3 pt-2">
                                <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">calendar_month</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">This Month</p>
                                    <h4 class="mb-0">{{ $statistics->maintenance_this_month }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 mb-4">
                        <div class="card stats-card">
                            <div class="card-header p-3 pt-2">
                                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">task_alt</i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Completion Rate</p>
                                    <h4 class="mb-0">{{ $statistics->completion_rate }}%</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center mx-3">
                        <a href="{{ route('it-ops.form-printer') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $filters['start_date'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $filters['end_date'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="site">Site</label>
                                <select class="form-control form-select" name="site" id="site">
                                    <option value="all">All Sites</option>
                                    @foreach($sites as $site)
                                        <option value="{{ $site }}" {{ ($filters['site'] ?? '') == $site ? 'selected' : '' }}>{{ strtoupper($site) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="search">Search</label>
                                <input type="text" class="form-control" name="search" id="search" 
                                    value="{{ $filters['search'] ?? '' }}" 
                                    placeholder="Search by name, or NIK">
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnFilterSubmit">
                                Filter
                            </button>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnClearFilter">
                                Clear Filter
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="list-form" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Dept</th>
                                    <th>Site</th>
                                    <th>Asset No</th>
                                    <th>Asset Type</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Components</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maintenanceRecords as $record)
                                    <tr>
                                        <td>{{ $record->created_at }}</td>
                                        <td>{{ $record->nama }}</td>
                                        <td>{{ $record->nik }}</td>
                                        <td>{{ $record->dept }}</td>
                                        <td>{{ $record->site }}</td>
                                        <td>{{ $record->no_asset }}</td>
                                        <td>{{ $record->jenis_aset }}</td>
                                        <td>{{ $record->merk }}</td>
                                        <td>{{ $record->model }}</td>
                                        <td>
                                            @if($record->broken_components > 0)
                                                <span class="badge bg-danger">{{ $record->broken_components }} Broken</span>
                                            @else
                                                <span class="badge bg-success">All Good</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('it-ops.form-printer') }}?id={{ $record->id }}" class="btn btn-primary btn-action text-white">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">No maintenance records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mx-3">
                        {{ $maintenanceRecords->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const btnFilterSubmit = document.getElementById('btnFilterSubmit');
            const btnClearFilter = document.getElementById('btnClearFilter');
            const filterInputs = {
                start_date: document.getElementById('start_date'),
                end_date: document.getElementById('end_date'),
                site: document.getElementById('site'),
                search: document.getElementById('search')
            };

            btnFilterSubmit.addEventListener('click', function() {
                const params = new URLSearchParams();
                
                Object.entries(filterInputs).forEach(([key, input]) => {
                    if (input.value) {
                        params.append(key, input.value);
                    }
                });

                window.location.href = `${window.location.pathname}?${params.toString()}`;
            });

            btnClearFilter.addEventListener('click', function() {
                Object.values(filterInputs).forEach(input => {
                    input.value = input.tagName === 'SELECT' ? 'all' : '';
                });
                window.location.href = window.location.pathname;
            });

            // Auto-submit on site change
            filterInputs.site.addEventListener('change', function() {
                btnFilterSubmit.click();
            });
        });
    </script>
@endsection
