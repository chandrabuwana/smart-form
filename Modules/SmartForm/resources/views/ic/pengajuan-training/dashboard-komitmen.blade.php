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
            /* width: 100%; */
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

        .table-poin tr td {
            vertical-align: top;
        }
        .table-approval tr td {
            text-align: center;
        }
        .form-check:not(.form-switch) .form-check-input[type="radio"]:checked {
            border-color: #e91e63;
            border-width: 5px;
            padding: 0;
        }
        .form-check:not(.form-switch) .form-check-input[type="radio"]:after {
            background-image: url("data:image/svg xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'><circle r='2' fill='#fff'/></svg>");

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
                        <h6 class="text-white text-capitalize ps-3">Dashboard Komitmen Training</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    {{-- <h4 class="mx-3">Filter Data</h4> --}}
                    {{-- <div class="mx-4 row mb-3">
                            <fieldset class="mb-3">
                                <legend>Filter Data</legend>
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkAdditional" name="checkAdditional">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Hanya saya
                                    </label>
                                </div>
                            </fieldset>
                        <div class="">
                            <button class="btn btn-primary" id="btnPilih">
                                Filter
                            </button>
                        </div>
                    </div> --}}
                    
                    <div class="table-responsive p-0">
                        <table id="table-data" data-toggle="table" data-side-pagination="server" 
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"  data-ajax="getData"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="id" data-align="left" data-visible="false">ID</th>
                                    <th data-field="NIK" data-align="left">NIK</th>
                                    <th data-field="nama" data-align="left">Nama</th>
                                    <th data-field="jabatan" data-align="left" data-halign="center">Jabatan</th>
                                    <th data-field="department" data-align="left">Departmen</th>
                                    <th data-field="site" data-align="left">Site</th>
                                    <th data-field="training" data-align="left">Training</th>
                                    <th data-field="status" data-align="center" data-formatter="statusFormatter">Status</th>
                                    <th data-field="action" data-align="left" data-formatter="actionFormatter">Action</th>
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
        const baseURL = "/ic/training"
        const getDataURL = {{ Illuminate\Support\Js::from(route('ic.training.dashboard-komitmen-data')) }}
        function getData(params) {
            $.get(getDataURL + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            return `<a href="${baseURL}/form-komitmen/${row.id}"><button class="btn btn-secondary btn-action-format"><i class="bi bi-info-circle-fill"></i></button></a>`
        }
        
        function statusFormatter(value, row, index) {
            if(value == "0") return '<button class="btn btn-warning btn-action-format">On progres</button>'
            if(value == "1") return '<button class="btn btn-success btn-action-format">Progres approval</button>'
            if(value == "2") return '<button class="btn btn-success btn-action-format">Done approval</button>'
            if(value == "-1") return '<button class="btn btn-danger btn-action-format">Menolak</button>'
            if(value == "-2") return '<button class="btn btn-danger btn-action-format">Ditolak aproval</button>'

            return value
        }
    </script>
@endsection