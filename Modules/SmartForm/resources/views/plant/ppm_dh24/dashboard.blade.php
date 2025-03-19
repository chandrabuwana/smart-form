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
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form PPM SHANTUI D24 SERIES</h6>
                    </div>
                </div>
            </div>
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
                                    <h4 class="mb-0">3</h4>
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
                                    <h4 class="mb-0">4</h4>
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
                                    <p class="text-sm mb-0 text-capitalize">Engine Model</p>
                                    <h4 class="mb-0">2</h4>
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
                                    <h4 class="mb-0">54</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center mx-3">
                        <a href="{{ route('form-create-dh24') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <form action="" method="GET" id="filterForm">
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
                                        <label for="engine_model" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control" id="engine_model" name="engine_model"
                                            value="{{ $filters['engine_model'] ?? '' }}">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="job" class="ms-0">Job Site</label>
                                        <select class="form-control" name="job_site" id="job_site">
                                            <option disabled selected>-- Select Site --</option>
                                            <option value="agm">agm</option>
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
                            </div>
                        </form>
                    </div>
                </div>

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
                                            Engine Model</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Unit Model</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Inspection</th>

                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date</th>
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
                                                        <h6 class="mb-0 text-sm">{{ $data->doc_num }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $data->engine_model }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $data->unit_model }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $data->at_inspection }}</p>
                                            </td>

                                            <td>
                                                <span class="text-xs font-weight-bold">{{ $data->date }}</span>
                                            </td>
                                            <td>
                                                <a href="#"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('export-pdf-dh24', ['id' => $data->id]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i>
                                                 </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-left mt-3">
                                {{-- {{ $record->links('pagination::bootstrap-4') }} --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
