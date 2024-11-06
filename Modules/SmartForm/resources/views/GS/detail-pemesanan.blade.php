@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
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
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
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
        .btn.disabled {
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
                        <h6 class="text-white text-capitalize ps-3">Detail Pemesanan Catering</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="mx-4">
                        <h6>Tanggal : {{ $data['master']->tanggal ?? ""}}</h6>
                        <h6>Adjustment : {{ $data['master']->adjustment ?? 0}}</h6>
                        <h6>Selected : {{ $data['master']->selected ?? ""}}</h6>
                        <h6>Jumlah Adjustment : {{ $data['master']->adjustment ?? 0}}</h6>
                        
                        <h4>Detail per Vendor</h4>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="data-per-vendor" data-toggle="table" data-ajax="fetchPerVendor"
                            data-side-pagination="client" data-filter-control="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="kode_pemesanan" data-show-export="true" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="kode_pemesanan" data-align="left" data-halign="text-center"
                                        data-sortable="true">Kode Pemesanan
                                    </th>
                                    <th data-field="KodeSite" data-align="center" data-halign="center" >Site</th>
                                    <th data-field="NamaVendor" data-align="left" data-halign="center" >Vendor</th>
                                    <th data-field="Jumlah" data-align="center" data-halign="center">Jumlah</th>
                                    {{-- <th data-field="status" data-align="center" data-halign="center">Status Pemesanan</th> --}}
                                    {{-- <th data-align="center" data-halign="center" data-formatter="actionPerVendor">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($data['detail'] as $detail)
                                    <tr>
                                        <td>{{ $detail->kode_pemesanan }}</td>
                                        <td>{{ $detail->KodeSite }}</td>
                                        <td>{{ $detail->NamaVendor }}</td>
                                        <td>{{ $detail->Jumlah }}</td>
                                        <td>{{ $detail->status }}</td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="mx-4">
                        <h4>Detail per lokasi</h4>
                    </div>
                        <table id="data-per-lokasi" data-toggle="table"
                            data-side-pagination="server" data-filter-control="true" data-ajax="ajaxRequest"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="kode_pemesanan" data-show-export="true" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="kode_pemesanan" data-align="left" data-halign="text-center"
                                        data-sortable="true">Kode Pemesanan
                                    </th>
                                    <th data-field="lokasi" data-align="left" data-halign="center" data-formatter="lokasiFormatter">Lokasi</th>
                                    <th data-field="nama_vendor" data-align="left" data-halign="center">Vendor</th>
                                    <th data-field="jumlah" data-align="center" data-halign="center">Jumlah</th>
                                    <th data-field="status" data-align="center" data-halign="center" data-formatter="statusFormatter">Status</th>
                                    <th data-field="action" data-align="center" data-halign="center" data-formatter="actionFormatter">Actions</th>
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
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        var baseURL = "/bss-form/catering"
        // console.log({{ Illuminate\Support\Js::from($data) }})

        function lokasiFormatter(value, row, index) {
            if(value == null || value == 'null') return 'Lapangan'
            
            return value
        }

        function actionFormatter(value, row, index) {
            console.log({status: row.status, file_evidence: row.file_evidence})
            var _id = ", '"+ row.id_detail + "'"
            var _dataStatus = 'data-status="' + row.status + '"'
            var _dataFileEvidence = ", '" + row.file_evidence + "'"
            var isDisabled = ""
            if(row.status == "Diterima GS" || row.status == "Dalam Proses" || row.status == "Pesanan Baru" || row.status == null || row.status == "null") isDisabled = "disabled"
  
            var btnTerima = '<button class="btn btn-primary ' + isDisabled +  '" ' + _dataStatus  + ' onclick="actionTerima(this'+ _id + _dataFileEvidence + ')"'+'>Terima</button>'
            
            return btnTerima
        }

        function actionPerVendor(value, row, index) {
            var _id = ", '"+ row.id_detail_vendor + "'"
            var _dataStatus = 'data-status="' + row.status + '"'
            var isDisabled = ""
            if(row.status == "Diterima GS" || row.status == "Dalam Proses" || row.status == "Pesanan Baru" || row.status == null || row.status == "null") isDisabled = "disabled"
  
            var btnTerima = '<button class="btn btn-primary ' + isDisabled +  '" ' + _dataStatus  + ' onclick="actionTerimaVendor(this'+ _id +')"'+'>Terima</button>'
            
            return btnTerima
        }
        
        function statusFormatter(value, row, index) {
            if(!value) return "Dalam Proses"
            else return value
        }

        function actionTerima(e, idDetail, dataFileEvidence) {
            console.log(idDetail)
            Swal.fire({
                title: "Apakah yakin ingin terima?",
                icon: "question",
                html: "",
                imageUrl: "/storage/" + dataFileEvidence,
                // imageWidth: 400,
                imageAlt: "Custom image",
                showCancelButton: true,
                confirmButtonText: "Terima",
                cancelButtonText: "Batal",
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#d33"
            }).then(function(result) {
                if (result.isConfirmed) {
                    e.disabled = true
                    var dataMsgTerima = {
                        icon: "error",
                        title: ""
                    }
                    var reBodyTerima = {status: "Diterima GS", id_detail: idDetail}
                    axios.put(baseURL + '/update-status-pemesanan', reBodyTerima , {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(function(resp) {
                        if(resp.data.isSuccess) {
                            dataMsgTerima.icon = "success"
                            dataMsgTerima.title = "Berhasil!"
                            dataMsgTerima.text = resp.data.message
                            $("#data-per-lokasi").bootstrapTable("refresh")
                        } else {
                            dataMsgTerima.icon = "error"
                            dataMsgTerima.title = "Gagal!"
                            dataMsgTerima.html = resp.data.errorMessage.join("<br>")
                        }
                    })
                    .catch(function(err) {
                        dataMsgTerima.icon = "error"
                        dataMsgTerima.title = "Gagal!"
                        dataMsgTerima.text = "Terjadi kesalahan, coba beberapa saat lagi"
                    })
                    .finally(function() {
                        e.disabled = false
                        Swal.fire(dataMsgTerima)
                    })
                }
            })
        }

        function actionTerimaVendor(e, idDetail) {
            // console.log(idDetail)
            Swal.fire({
                title: "Apakah yakin ingin terima?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Terima",
                cancelButtonText: "Batal",
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#d33"
            }).then(function(result) {
                if (result.isConfirmed) {
                    e.disabled = true
                    var dataMsgTerima = {
                        icon: "error",
                        title: ""
                    }
                    var reBodyTerima = {status: "Diterima GS", id_detail_vendor: idDetail}
                    axios.put(baseURL + '/update-status-pemesanan-vendor', reBodyTerima , {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(function(resp) {
                        if(resp.data.isSuccess) {
                            dataMsgTerima.icon = "success"
                            dataMsgTerima.title = "Berhasil!"
                            dataMsgTerima.text = resp.data.message
                            $("#data-per-vendor").bootstrapTable("refresh")
                        } else {
                            dataMsgTerima.icon = "error"
                            dataMsgTerima.title = "Gagal!"
                            dataMsgTerima.html = resp.data.errorMessage.join("<br>")
                        }
                    })
                    .catch(function(err) {
                        dataMsgTerima.icon = "error"
                        dataMsgTerima.title = "Gagal!"
                        dataMsgTerima.text = "Terjadi kesalahan, coba beberapa saat lagi"
                    })
                    .finally(function() {
                        e.disabled = false
                        Swal.fire(dataMsgTerima)
                    })
                }
            })
        }

        function ajaxRequest(params) {
            var url = baseURL + '/list-pemesanan-lokasi'
            var queryString = window.location.search;
            var urlParams = new URLSearchParams(queryString);
            params.data.id = urlParams.get('id')

            $.get(url + '?' + $.param(params.data)).then(function (res) {
                console.log(res)
                params.success(res.data)
            })
        }

        function fetchPerVendor(params) {
            var url = baseURL + '/list-pemesanan-per-vendor'
            var queryString = window.location.search;
            var urlParams = new URLSearchParams(queryString);
            params.data.id = urlParams.get('id')

            $.get(url + '?' + $.param(params.data)).then(function (res) {
                console.log(res)
                params.success(res.data)
            })
        }

        function modalDetail(e, _id) {
            console.log(_id)
        }

        function fetchSite(cb=function(site) {}) {
            axios.post("/bss-form/catering/helper-site", {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                var opstionSite = []
                // opstionSite.push(new Option("--- Cari Site ---", "", true, true))
                opstionSite.push({
                    id: "",
                    text: "--- Cari Site ---"
                })

                data.data.data.forEach(element => {
                    opstionSite.push({
                        id: element.id,
                        text: element.text
                    })

                    // opstionSite.push(new Option(element.text, element.id))
                });
                
                cb(opstionSite)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }

        fetchSite(function(data) {
            // console.log(data)
            data.forEach(function(opt) {
                $('#filterSite').append(new Option(opt.text, opt.id))
            })
            // data.forEach(function(opt) {
            //     $('#editSite').append(opt)
            // })
        })
    </script>
@endsection