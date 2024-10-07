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
                        <h6 class="text-white text-capitalize ps-3">Dashboard User Management</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center ms-3">
                        <a href="{{ route('user-management.create') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New User
                            </button>
                        </a>
                    </div>

                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-3 row mb-3">
                        <div class="col-6 col-md-3 ps-0">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterUsername">Username</label>
                                <input style="width: 100%" id="filterUsername" class="form-control" name="filterUsername" placeholder="--- Cari Username ---">
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterRole">Role</label>
                                <select style="width: 100%" id="filterRole" class="form-control" name="filterRole">
                                    <option value="" selected disabled>--- Cari Role ---</option>
                                    <option value="s">Super Admin</option>
                                    <option value="n">User</option>
                                </select>
                            </div>
                        </div>

                        <div class="ps-0">
                            <button class="btn btn-primary ms-auto filter-btn" id="btnClearFilter" onclick="clearFilter(this)">
                                Clear Filter
                            </button>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnFilterSubmit" onclick="applyFilter(this)">
                                Filter
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="list-user" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="no_doc">
                            <thead>
                                <tr>
                                    <th data-field="username" data-align="center" data-halign="center">
                                        Username
                                    </th>
                                    <th data-field="role_name" data-align="center" data-halign="center">
                                        Role
                                    </th>
                                    <th data-field="last_login" data-align="center" data-halign="center">
                                        Last Login
                                    </th>
                                    <th data-field="last_logout" data-align="center" data-halign="center">
                                        Last Logout
                                    </th>
                                    <th data-field="device" data-align="center" data-halign="center">
                                        Device
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
        var $table = $("#list-user");

        const filter = {
            username: '',
            role: ''
        }

        $('#filterUsername').change( function(e) {
            filter.username = e.target.value;
        });

        $('#filterRole').change( function(e) {
            filter.role = e.target.value;
        });

        function applyFilter(e) {
            $table.bootstrapTable('refresh')
        }

        function clearFilter(e) {
            filter.username = null
            $('#filterUsername').val('');

            filter.role = null
            $('#filterRole').val('');

            $table.bootstrapTable('refresh')
        }

        function actionFormatter(value, row, index) {
            return `
                <a class="btn btn-primary btn-action btn-sm me-1" href="/user-management/edit/${row.userid}">Edit</a>
                <a class="btn btn-danger btn-action btn-sm" href="/user-management/destroy/${row.userid}">Delete</a>
            `;
        }

        function fetchFormsData(params) {
            if(filter.username) params.data.username = filter.username;
            if(filter.role) params.data.role = filter.role;

            var url = `<?= route('user-management.get-dashboard-data') ?>`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

    </script>
@endsection
