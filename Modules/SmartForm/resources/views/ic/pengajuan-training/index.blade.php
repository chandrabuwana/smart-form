@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker-bs5.min.css">
    <style>
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            margin-bottom: 15px;
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
                    <div class="d-flex align-items-center">
                        <a href="{{ route('ic.training.add') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                Pengajun Training
                            </button>
                        </a>
                    </div>
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterSite">Site</label>
                                <select class="form-control form-select" name="filterSite" id="filterSite">
                                    <option value="">-- Filter Site --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="table-dashboard-vendor" data-toggle="table" data-ajax="getData" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="nama" data-align="left">Nama Vendor</th>
                                    <th data-field="mandatory_type" data-align="left" data-formatter="mandatoryFormatter">Mandatory</th>
                                    <th data-field="harga" data-formatter="hargaFormatter" data-align="center">harga</th>
                                    <th data-field="offline_online" data-formatter="offOnLineFormatter" data-align="center">harga</th>
                                    <th data-formatter="actionFormatter" data-align="center">Actions</th>
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
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        const baseUrl = '/ic/training';
        const mTrainingHelper = baseUrl + "/helper/mtraining";
        // const elem = document.querySelector('input[name="foo"]');
        // const datepicker = new Datepicker(elem, {
        //     format: "MM",
        //     pickLevel: 1
        // }); 

        function formatRupiah(angka) {
            angka = angka.toString().replace(".", ",")
            const rupiah = angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            
            return rupiah;
        }

        function getData(params) {
            
            // if(filterParams.site) params.data.site = filterParams.site

            $.get(mTrainingHelper + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })

        }

        function mandatoryFormatter(value, row, index) {
            let nilai = value
            
            if(value == 1) {
                nilai = "Mandatory"
            }
            if(value == 0) {
                nilai = "Non Mandatory"
            }

            return nilai
        }

        function hargaFormatter(value, row, index) {
            let nilai = value

            return "Rp" + formatRupiah(value)
        }

        function offOnLineFormatter(value, row, index) {
            let nilai = value
            if(value == 0) nilai = "Offline"
            if(value == 1) nilai = "Online"
            if(value == 2) nilai = "Offline & Online"

            return nilai
        }
    </script>
@endsection