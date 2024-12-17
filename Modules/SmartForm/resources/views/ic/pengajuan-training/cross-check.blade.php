@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker-bs5.min.css">
    <style>
        legend {
            display: block;
            width: auto;
            float: none;
        }
        fieldset {
            padding: 4px 10px 8px 10px;
            margin: 0;
            width: auto;
            border: 1px solid #cccccc;
        }
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            /* margin-bottom: 15px; */
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 32px;
            padding: 8px 0px;
        }
        .select2.select2-container{
            width: 100%;
        }
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
        .select2-selection .select2-selection--single {
            margin-bottom: 0;
        }
        .search-input {
            border-radius: 0;
            border-bottom: 1px solid #e91e63;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }
        .search-input:valid {
            border-radius: 0;
            border-bottom: 1px solid #e91e63;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }

        .row>* {
            padding: 0;
        }
        
        .btn-action-format {
            margin: 0;
            padding: 10px 16px;
        }
        .btn-no-action:hover {
            cursor: default;
        }
    </style>
@endsection

@section('content')
{{-- <input type="text" name="foo"> --}}
    {{-- {{ dd($data) }} --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4 pb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Pengajuan Training</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    {{-- <h4 class="mx-3">Filter Data</h4> --}}
                    <div class="mx-4 row mb-3">
                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="filterPelatihan" style="width: 100%;"><strong>Pelatihan</strong></label>
                                <select class="form-control form-select" name="filterPelatihan" id="filterPelatihan">
                                    <option value="">-- Cari Pelatihan --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive p-0">
                        <table id="table-data" data-toggle="table" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true" data-ajax="getData"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="NIK" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    {{-- <th data-field="pengajuan_training_id" data-align="left">ID Pengajuan</th> --}}
                                    <th data-field="nama_pelatihan" data-align="left">Pelatihan</th>
                                    {{-- <th data-field="id_training" data-align="l`eft" data-halign="center">ID Pelatihan</th> --}}
                                    {{-- <th data-field="KodeDP" data-align="left">Departement</th> --}}
                                    <th data-field="dept" data-align="left">Departement</th>
                                    <th data-field="KodeST" data-align="left">Site</th>
                                    <th data-field="bulan" data-align="left" data-sortable="true">Bulan</th>
                                    <th data-field="tahun" data-align="left" data-sortable="true">Tahun</th>
                                    <th data-field="status" data-align="center" data-formatter="statusFormatter">Status</th>
                                    <th data-field="action" data-formatter="actionFormatter" data-align="center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{-- <div class="card-footer">
                    <div style="display: flex; justify-content: end;">
                        <button class="btn btn-primary mb-0" onclick="submitPengajuan(event)">Submit Pelatihan</button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        var getDataURL = "{{route('ic.training.data-crosscheck')}}"
        function getData(params) {
            $.get(getDataURL + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            let btnCrossCheck = `<a href="/ic/training/cross-check-dtl/${row.trj_id}"> <button class="btn btn-primary btn-action-format"><i class="bi bi-info-circle-fill"></i></button></a>`
            let btnJustifikasi= row.status != 0 ? `<a href="/ic/training/justifikasi/${row.trj_id}"> <button class="btn btn-action-format" style="background: #1A2365;"><i class="bi bi-arrow-right-circle text-white"></i></button> </a>` : ''
            return '<div style="display: flex; gap:6px; justify-content: center;">'+ btnCrossCheck + btnJustifikasi + '</div>'
        }

        function statusFormatter(value, row, index) {
            if(value == 1) return '<button class="btn btn-success btn-no-action btn-action-format">Komitmen & justifikasi</button>'
            if(value == 2) return '<button class="btn btn-success btn-no-action btn-action-format">Done Justifikasi</button>'
            // if(value == 3) return '<button class="btn btn-success btn-no-action btn-action-format">Done Justifikasi</button>'
            if(value == -2) return '<button class="btn btn-success btn-no-action btn-action-format">Rejected Justifikasi</button>'
            if(value == 0) return '<button class="btn btn-warning btn-no-action btn-action-format">Cross check Kabag</button>'
            
            return value
        }
    </script>
@endsection