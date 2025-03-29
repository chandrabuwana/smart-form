@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }
    .filter-control {
        margin-bottom: 5px;
        width: 100%;
    }
    .search-container {
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Request Master</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <div class="">
                        <!-- Search and New Form Button -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="{{ route('bss-form.log.form-req-master') }}" class="btn btn-primary mb-0">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;New Form
                            </a>
                            
                        </div>

                        <!-- Filter Controls -->
                        <div class="filter-container mb-4">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control filter-control" data-field="no_dok" placeholder="No. Document">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control filter-control" data-field="site" placeholder="Site">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control filter-control" data-field="request_by" placeholder="Request By">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-outline">
                                        <select class="form-control filter-control" data-field="status_req" id="statusFilter">
                                            <option value="">All Status</option>
                                            <option value="OPEN">OPEN</option>
                                            <option value="CLOSE">CLOSE</option>
                                            <option value="APPROVED">APPROVED</option>
                                            <option value="REJECTED">REJECTED</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <button class="btn btn-primary me-2" id="btnFilterSubmit">
                                        <i class="fas fa-filter"></i>&nbsp;Apply
                                    </button>
                                    <button class="btn btn-secondary" id="btnClearFilter">
                                        <i class="fas fa-broom"></i>&nbsp;Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- START LIST REQUEST MASTER -->
                    <div class="table-responsive p-0">
                        <table id="list-req-master" 
                               data-toggle="table" 
                               data-url="/bss-form/log/list" 
                               data-side-pagination="server"
                               data-query-params="queryParams"
                               data-response-handler="responseHandler"
                               data-page-size="10"
                               data-page-list="[10, 25, 50]" 
                               data-sortable="true"
                               data-pagination="true"
                               data-search="false"
                               data-show-refresh="false"
                               data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="no_dok" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">No. Document</th>
                                    <th data-field="site" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">Site</th>
                                    <th data-field="request_by" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">Request by</th>
                                    <th data-field="cataloging_by" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">Cataloging by</th>
                                    <th data-field="cataloging_update" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">Cataloging Record</th>
                                    <th data-field="approval_by" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">Approval by</th>
                                    <th data-field="status_req" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">Status</th>
                                    <th data-field="created_at" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">Created Date</th>
                                    <th data-field="updated_at" data-sortable="true" class="text-uppercase text-secondary text-xxs font-weight-bolder ">Updated Date</th>
                                    <th data-field="action" data-formatter="actionFormatter" class="text-uppercase text-secondary text-xxs font-weight-bolder  text-center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- END LIST REQUEST MASTER -->
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
        var $table = $("#list-req-master");
        var currentFilters = {};
        var searchText = '';

        // Initialize table
        $(function() {
            $table.bootstrapTable();
        });

        // Function to handle query parameters
        function queryParams(params) {
            params.filters = currentFilters;
            params.search = searchText;
            return params;
        }

        // Function to handle server response
        function responseHandler(res) {
            return {
                "total": res.data.total,
                "totalNotFiltered": res.data.totalNotFiltered,
                "rows": res.data.rows
            };
        }

        // Search functionality
        $('#btnSearch').click(function() {
            searchText = $('#searchInput').val();
            $table.bootstrapTable('refresh');
        });

        $('#btnClearSearch').click(function() {
            $('#searchInput').val('');
            searchText = '';
            $table.bootstrapTable('refresh');
        });

        // Search functionality
        $('#btnSearch').click(function() {
            searchText = $('#searchInput').val();
            $table.bootstrapTable('refresh');
        });

        $('#btnClearSearch').click(function() {
            $('#searchInput').val('');
            searchText = '';
            $table.bootstrapTable('refresh');
        });

        // Filter functionality
        $('#btnFilterSubmit').click(function() {
            currentFilters = {};
            
            $('.filter-control').each(function() {
                var field = $(this).data('field');
                var value = $(this).val();
                console.log(field, value);
                if (value) {
                    currentFilters[field] = value;
                }
            });
            $table.bootstrapTable('refresh');
        });

        $('#btnClearFilter').click(function() {
            $('.filter-control').val('');
            currentFilters = {};
            $table.bootstrapTable('refresh');
        });

        // Allow pressing Enter in search input
        $('#searchInput').keypress(function(e) {
            if (e.which === 13) {
                $('#btnSearch').click();
            }
        });

        function actionFormatter(value, row, index) {
            var btn = '';
            if (row.status_req == "APPROVED") {
                btn = btn + '<a type="button" class="btn btn-success btn-sm me-1" href="/bss-form/log/detail-req-master?id=' + row.id + '">View</a>';
                btn = btn + '<a class="btn btn-primary btn-action btn-sm" href="/bss-form/log/pdf-req-master/' + row.id + '">Pdf</a>';
                return btn;
            }

            //btn requester
            if (row.created_by == "{{ session('user_id') }}") {
                btn = btn + '<a type="button" class="btn btn-success btn-sm me-1" href="/bss-form/log/detail-req-master?id=' + row.id + '">View</a>';
                btn = btn + '<a type="button" class="btn btn-info btn-sm me-1" href="/bss-form/log/edit-req-master?id=' + row.id + '">Edit</a>';
                btn = btn + '<a class="btn btn-primary btn-action btn-sm" href="/bss-form/log/pdf-req-master/' + row.id + '">Pdf</a>';
                return btn;
            } 

            //btm cataloging
            if (row.cataloging_by == "{{ session('username') }}") {
                btn = btn + '<a type="button" class="btn btn-warning btn-sm me-1" href="/bss-form/log/catalog-view-req-master?id=' + row.id + '">Review</a>';
                btn = btn + '<a class="btn btn-primary btn-action btn-sm" href="/bss-form/log/pdf-req-master/' + row.id + '">Pdf</a>';
                return btn;
            }

            //btn approval
            if (row.approval_by == "{{ session('username') }}") {
                if(row.status_req == "REJECTED"){
                    btn = btn + '<a type="button" class="btn btn-success btn-sm me-1" href="/bss-form/log/detail-req-master?id=' + row.id + '">View</a>';
                    btn = btn + '<a class="btn btn-primary btn-action btn-sm" href="/bss-form/log/pdf-req-master/' + row.id + '">Pdf</a>';
                    return btn;
                }

                btn = btn + '<a type="button" class="btn btn-warning btn-sm me-1" href="/bss-form/log/detail-req-master?id=' + row.id + '">Review</a>';
                btn = btn + '<a class="btn btn-primary btn-action btn-sm" href="/bss-form/log/pdf-req-master/' + row.id + '">Pdf</a>';
                return btn;
            }

            return btn;
        }
    </script>
@endsection