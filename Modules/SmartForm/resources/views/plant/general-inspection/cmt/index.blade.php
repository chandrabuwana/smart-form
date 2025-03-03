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
                        <h6 class="text-white text-capitalize ps-3">Create General Inspection CMT</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>General Inspection CMT</h2>
                            <a href="{{ route('bss-form.plant.general-inspection.cmt.create') }}"
                                class="btn btn-primary mb-3">+
                                Add New Inspection
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table  p-0">
                            <table id="list-form" class="table table-bordered" data-toggle="table"
                                data-side-pagination="server" data-pagination="true" data-search="true"
                                data-query-params="queryParams" data-ajax="fetchData" data-sortable="true">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">#</th>
                                        <th data-field="site" data-sortable="true">Site</th>
                                        <th data-field="model_unit" data-sortable="true">Model Unit</th>
                                        <th data-field="cn" data-sortable="true">C/N</th>
                                        <th data-field="hm" data-sortable="true">HM</th>
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

    <script type="text/javascript">
        function queryParams(params) {

            return {
                search: params.search,
                limit: params.limit,
                offset: params.offset,
                sort: params.sort,
                order: params.order,
            };
        }

        function actionFormatter(value, row, index) {
            let editUrl = `{{ route('bss-form.plant.general-inspection.cmt.edit', ':id') }}`.replace(':id', row.id);
            let deleteUrl = `{{ route('bss-form.plant.general-inspection.cmt.destroy', ':id') }}`.replace(':id', row.id);
            let printUrl = `{{ route('bss-form.plant.general-inspection.cmt.print', ':id') }}`.replace(':id', row.id);

            return `
                <a class="btn btn-outline-warning btn-sm" href="${editUrl}">
                    <i class="fa fa-pencil"></i>
                </a>
                <form action="${deleteUrl}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>
                </form>
                <a class="btn btn-outline-secondary btn-sm" href="${printUrl}" target="_blank">
                    <i class="fa fa-print"></i>
                </a>
            `;
        }

        function fetchData(params) {
            const url = `{{ route('bss-form.plant.general-inspection.cmt.get-data') }}`;

            axios.get(url, {
                    params: params.data
                })
                .then(response => {
                    const res = response.data;
                    if (res.status) {
                        params.success({
                            total: res.data.total,
                            rows: res.data.data
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
