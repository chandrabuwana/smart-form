@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Role Management</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('role-management.create') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Role
                            </button>
                        </a>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="list-role" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="role_name" data-align="left" data-halign="text-center" data-sortable="true">
                                        Role Name
                                    </th>
                                    <th data-field="role_code" data-align="center" data-halign="center">
                                        Role Code
                                    </th>
                                    <th data-field="role_permission" data-align="center" data-halign="center">
                                        Permission
                                    </th>
                                    <th data-field="action" data-formatter="actionFormatter" >Actions</th>
                                </tr>
                            </thead>
                        </table>
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
        var $table = $("#list-role");

        function actionFormatter(value, row, index) {
            return `
                <a class="btn btn-primary btn-action btn-sm me-1" href="/role-management/edit/${row.id}">Edit</a>
                <a class="btn btn-danger btn-action btn-sm" href="/role-management/destroy/${row.id}">Delete</a>
            `;
        }

        function fetchFormsData(params) {
            var url = `<?= route('role-management.get-dashboard-data') ?>`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

    </script>
@endsection
