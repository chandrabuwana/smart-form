@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .table tbody tr:last-child td {
            border-width: 0 1px;
        }

        .table .search-input {
            border: 1px solid #ced4da;
            padding: 6px 15px;
        }

        .clearfix {
            border: none !important
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Create General Inspection Dongfeng</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>General Inspection Dongfeng</h2>
                            <a href="{{ route('bss-form.plant.general-inspection.dongfeng.create') }}"
                                class="btn btn-primary mb-3">+
                                Add New Inspection
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
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
                                                <p class="text-sm mb-0 text-capitalize">Model Unit</p>
                                                <h4 class="mb-0" data-field="model_unit">{{ $statistics->model_unit }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="searchSite">Site</label>
                                {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('searchSite') !!}
                            </div>
                            <div class="col-md-3">
                                <label for="searchSite">Status Approval</label>
                                <select id="searchStatus" class="form-control">
                                    <option value="">Filter by Status</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Draft">Draft</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="searchSite">Date</label>
                                <input type="date" id="searchDate" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="searchModel">Model Unit</label>
                                <input type="text" id="searchModel" class="form-control"
                                    placeholder="Filter by Model Unit">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" onclick="refreshTable()">Filter</button>
                                <button class="btn btn-secondary" onclick="resetFilter()">Reset</button>
                            </div>
                        </div>
                        <div class="table  p-0">
                            <table id="list-form" class="table table-bordered" data-toggle="table"
                                data-side-pagination="server" data-pagination="true" data-search="true"
                                data-query-params="queryParams" data-ajax="fetchData" data-sortable="true">
                                <thead>
                                    <tr>

                                        <th data-field="site" data-sortable="true">Site</th>
                                        <th data-field="model_unit" data-sortable="true">Model Unit</th>
                                        <th data-field="diperiksa" data-sortable="true">Diperiksa</th>
                                        <th data-field="diketahui" data-sortable="true">Diketahui</th>
                                        <th data-field="status_form" class="text-center" data-sortable="true">Status Form</th>
                                        <th data-field="status" class="text-center" data-sortable="true">Status Approval</th>
                                        <th data-field="created_at" data-sortable="true">Date</th>
                                        <th data-formatter="actionFormatter">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#searchSite').select2();
        });

        function queryParams(params) {

            return {
                search: params.search,
                limit: params.limit,
                offset: params.offset,
                sort: params.sort,
                order: params.order,
                site: document.getElementById("searchSite").value,
                status: document.getElementById("searchStatus").value,
                date: document.getElementById("searchDate").value,
                model: document.getElementById("searchModel").value
            };
        }

        function refreshTable() {
            $('#list-form').bootstrapTable('refresh');
        }

        function resetFilter() {
            $('#searchSite').val('').trigger('change');
            document.getElementById("searchStatus").value = "";
            document.getElementById("searchDate").value = "";
            document.getElementById("searchModel").value = "";
            refreshTable();
        }
        const currentUserId = @json($session); // Ambil ID user yang login dari Blade
        console.log(currentUserId);

        function actionFormatter(value, row, index) {
            let editUrl = `{{ route('bss-form.plant.general-inspection.dongfeng.edit', ':id') }}`.replace(':id', row.id);
            let showUrl = `{{ route('bss-form.plant.general-inspection.dongfeng.show', ':id') }}`.replace(':id', row.id);
            let deleteUrl = `{{ route('bss-form.plant.general-inspection.dongfeng.destroy', ':id') }}`.replace(':id', row
                .id);
            let printUrl = `{{ route('bss-form.plant.general-inspection.dongfeng.print', ':id') }}`.replace(':id', row.id);

            let printButton = '';

            printButton = `
            <a class="btn btn-outline-secondary btn-sm" href="${printUrl}" target="_blank">
                <i class="fa fa-print"></i>
            </a>
        `;

            // Jika bukan creator, jangan tampilkan tombol Edit & Hapus
            if (row.creator !== currentUserId) {
                return `
            <a class="btn btn-outline-info btn-sm" href="${showUrl}">
                <i class="far fa-check-circle " style="font-size:12px;"></i>
            </a>
             ${printButton}

        `;
            }

            // Jika creator, tampilkan semua tombol
            if (row.status !== 'Approved') {
                return `
        <a class="btn btn-outline-warning btn-sm" href="${editUrl}">
            <i class="fa fa-pencil"></i>
        </a>
        <a class="btn btn-outline-info btn-sm" href="${showUrl}">
            <i class="far fa-check-circle" style="font-size:12px;"></i>
        </a>

        <form action="${deleteUrl}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>
        </form>
        ${printButton}
    `;
            } else {
                return `
        <a class="btn btn-outline-info btn-sm" href="${showUrl}">
            <i class="far fa-check-circle" style="font-size:12px;"></i>
        </a>
        ${printButton}
    `;
            }
        }

        function fetchData(params) {
            const url = `{{ route('bss-form.plant.general-inspection.dongfeng.get-data') }}`;

            axios.get(url, {
                    params: params.data
                })
                .then(response => {
                    const res = response.data;
                    if (res.status) {

                        const approvalList = @json($approvalList);


                        const transformedData = res.data.data.map(item => {
                            return {
                                ...item,
                                diperiksa: approvalList.find(user => user.nik === item.diperiksa)?.nama || item
                                    .diperiksa,
                                diketahui: approvalList.find(user => user.nik === item.diketahui)?.nama || item
                                    .diketahui
                            };
                        });

                        params.success({
                            total: res.data.total,
                            rows: transformedData
                        });
                    } else {
                        params.error(res.message);
                    }
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                    params.error();
                });
        }
    </script>
@endsection
