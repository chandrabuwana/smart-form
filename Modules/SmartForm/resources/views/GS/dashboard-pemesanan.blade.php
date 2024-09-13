@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <style>
        .center-container {
            display: none;
            align-items: center;
            justify-content: center;
            height: 8em;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #0000001f
        }
        .text-light {
            color: #f0f2f5;
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
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Pemesanan Catering</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('form-timesheet-produksi') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>
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
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="filterNama">Selected</label>
                                <select class="form-control form-select" name="filterSelected" id="filterSelected" required>
                                    <option value="" selected>-- Filter Jenis Pemesanan --</option>
                                    <option value="system">By System</option>
                                    <option value="request">By Request</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterJenis">Waktu</label>
                                <select class="form-control form-select" name="filterJenis" id="filterJenis" required>
                                    <option value="" selected>-- Filter Waktu --</option>
                                    <option value="pagi">Pagi</option>
                                    <option value="siang">Siang</option>
                                    <option value="malam">Malam</option>
                                </select>
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
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server" data-filter-control="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="kode_pemesanan" data-show-export="true" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="kode_pemesanan" data-align="left" data-halign="text-center"
                                        data-sortable="true">Kode Pemesanan
                                    </th>
                                    <th data-field="site" data-align="center" data-halign="center" >Site</th>
                                    <th data-field="selected" data-align="center" data-halign="center" >Selected</th>
                                    <th data-field="jenis_pemesanan" data-align="left" data-halign="center">Jenis Pemesanan</th>
                                    
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
    <script>
        var $table = $("#list-form");
        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
        var btnClearFilter = document.getElementById("btnClearFilter")
        var additonalQuery = {
            tanggal: null,
            site: null,
            selected: null,
            jenis: null
        }
        var filterTanggal = document.getElementById("filterTanggal")
        var filterSite = document.getElementById("filterSite")
        var filterSelected = document.getElementById("filterSelected")
        var filterJenis = document.getElementById("filterJenis")
        
        btnClearFilter.addEventListener("click", function(e) {
            document.getElementById("filterTanggal").value = ""
            document.getElementById("filterSite").value = ""
            document.getElementById("filterSelected").value = ""
            document.getElementById("filterJenis").value = ""
        })

        btnFilterSubmit.addEventListener("click", function(e) {
            var searchQuery = {
                tanggal: filterTanggal.value == '' ? null : filterTanggal.value,
                site: filterSite.value == '' ? null : filterSite.value,
                selected: filterSelected.value == '' ? null : filterSelected.value,
                jenis: filterJenis.value == '' ? null : filterJenis.value,
            }
            additonalQuery = searchQuery;
            $table.bootstrapTable('refresh')
        })
        
        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = '/bss-form/catering/list-pemesanan'
            // console.log(params.data)
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }
    </script>
@endsection