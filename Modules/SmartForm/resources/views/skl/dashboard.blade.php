@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <style>
        /* .form-control {
            border: 1px solid;
            padding: 4px;
        }
        .form-control:focus {
            border: 1px solid;
        } */
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
            /* background-color: rgba(39, 39, 38, 0.192); */
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
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard SKL</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterTanggal">Tanggal</label>
                                <input type="date" class="form-control" name="filterTanggal" id="filterTanggal">
                                </input>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterSite">Site</label>
                                <select class="form-control form-select" name="filterSite" id="filterSite">
                                    <option value="">-- Filter Site --</option>
                                    <option value="AGM">AGM</option>
                                    <option value="MBL">MBL</option>
                                    <option value="MME">MME</option>
                                    <option value="MAS">MAS</option>
                                    <option value="PMSS">PMSS</option>
                                    <option value="TAJ">TAJ</option>
                                    <option value="BSSR">BSSR</option>
                                    <option value="TDM">TDM</option>
                                    <option value="MSJ">MSJ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterDepartement">Departement</label>
                                <select class="form-control form-select" name="filterDepartement" id="filterDepartement">
                                    <option value="">-- Filter Departement --</option>
                                    @foreach($departements as $item)
                                        <option value="{{ $item->KodeDP }}">{{ $item->NamaDepartement }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterStatus">Status</label>
                                <select class="form-control form-select" name="filterStatus" id="filterStatus" required>
                                    <option value="" selected>-- Filter Status --</option>
                                    <option value="Dalam Review">Dalam Review</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <button class="btn btn-primary ms-auto filter-btn me-2" id="btnFilterSubmit">
                                    Filter
                                </button>
                                <button class="btn btn-primary ms-auto filter-btn" id="btnClearFilter">
                                    Clear Filter
                                </button>
                            </div>

                            <a class="btn btn-success ms-auto filter-btn" href="javascript:;" id="download-excel">
                                Download Excel
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server" data-filter-control="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-show-export="false" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="NoForm" data-align="left" data-halign="text-center"
                                        data-sortable="true">
                                        No. Form
                                    </th>
                                    <th data-field="NamaDepartement" data-align="center" data-halign="center" >
                                        Departement
                                    </th>
                                    <th data-field="KodeST" data-align="center" data-halign="center" >
                                        Site
                                    </th>
                                    <th data-field="TglPelaksanaan" data-align="left" data-halign="center">
                                        Tanggal
                                    </th>
                                    <th data-field="Shift" data-align="left" data-halign="center">
                                        Shift
                                    </th>
                                    <th data-field="Status" data-align="center"
                                        data-halign="center" data-sortable="true" data-formatter="statusFormatter">
                                        Status
                                    </th>
                                    <th data-field="action" data-formatter="actionFormatter">
                                        Actions
                                    </th>
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
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        var $table = $("#list-form");
        var filterNama = document.getElementById("filterNama")
        var suggestNik = document.getElementById("suggest-nik")
        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
        var btnClearFilter = document.getElementById("btnClearFilter")
        var filterTanggal = document.getElementById("filterTanggal")
        var filterSite = document.getElementById("filterSite")
        var filterDepartement = document.getElementById("filterDepartement")
        var filterStatus = document.getElementById("filterStatus")
        var additonalQuery = {
            tanggal: null,
            site: null,
            departement: null,
            status: null
        }

        btnClearFilter.addEventListener("click", function(e) {
            additonalQuery.departement = null;
            additonalQuery.site = null;
            additonalQuery.status = null;
            additonalQuery.tanggal = null;

            filterDepartement.value = '';
            filterSite.value = '';
            filterStatus.value = '';
            filterTanggal.value = '';

            $table.bootstrapTable('refresh')
        })
        btnFilterSubmit.addEventListener("click", function(e) {
            var searchQuery = {
                tanggal: filterTanggal.value == '' ? null : c.value,
                site: filterSite.value == '' ? null : filterSite.value,
                departement: filterDepartement.value == '' ? null : filterDepartement.value,
                status: filterStatus.value == '' ? null : filterStatus.value,
            }
            additonalQuery = searchQuery;
            $table.bootstrapTable('refresh')
        })

        $('#download-excel').click( function() {
            const url = `{{ route('bss-skl.download-excel') }}`;
            const searchQuery = {
                tanggal: filterTanggal.value == '' ? '' : c.value,
                site: filterSite.value == '' ? '' : filterSite.value,
                departement: filterDepartement.value == '' ? '' : filterDepartement.value,
                status: filterStatus.value == '' ? '' : filterStatus.value,
            }

            window.open(url + '?' + (new URLSearchParams(searchQuery)).toString());
        });

        function actionFormatter(value, row, index) {
            const url = `{{ route('bss-skl.detail') }}`;
            return '<a href="' + url + '?NoForm=' + row.NoForm + '"><button class="btn btn-primary btn-action text-white">detail</button></a>';
        }

        function statusFormatter(value, row, index) {
            var formatData = ''
            if(value == 'Dalam Review') {
                formatData = `<span class="text-warning fw-bold">Dalam Review (${row.ApprovalProgress})</span>`
            } else if(value == 'Approved') {
                formatData = '<span class="text-success fw-bold">Approved</span>'
            } else if(value == 'Rejected') {
                formatData = '<span class="text-danger fw-bold">Rejected</span>'
            }

            return formatData;
        }


        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = `{{ route('bss-skl.dashboard-get-data') }}`
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

    </script>
@endsection
