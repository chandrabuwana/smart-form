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
                        <table id="list-form" data-toggle="table"
                            data-side-pagination="client" data-filter-control="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="kode_pemesanan" data-show-export="true" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="kode_pemesanan" data-align="left" data-halign="text-center"
                                        data-sortable="true">Kode Pemesanan
                                    </th>
                                    <th data-field="site" data-align="center" data-halign="center" >Site</th>
                                    <th data-field="nama" data-align="left" data-halign="center" >Vendor</th>
                                    <th data-field="jumlah" data-align="center" data-halign="center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['detail'] as $detail)
                                    <tr>
                                        <td>{{ $detail->kode_pemesanan }}</td>
                                        <td>{{ $detail->KodeSite }}</td>
                                        <td>{{ $detail->Nama }}</td>
                                        <td>{{ $detail->Jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mx-4">
                        <h4>Detail per lokasi</h4>
                    </div>
                        <table id="list-form" data-toggle="table"
                            data-side-pagination="client" data-filter-control="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="kode_pemesanan" data-show-export="true" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="kode_pemesanan" data-align="left" data-halign="text-center"
                                        data-sortable="true">Kode Pemesanan
                                    </th>
                                    <th data-field="site" data-align="left" data-halign="center">Lokasi</th>
                                    <th data-field="nama" data-align="left" data-halign="center">Vendor</th>
                                    <th data-field="jumlah" data-align="center" data-halign="center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['detail_lokasi'] as $detail_lokasi)
                                    <tr>
                                        <td>{{ $detail_lokasi->kode_pemesanan }}</td>
                                        <td>{{ $detail_lokasi->NamaMess }}</td>
                                        <td>{{ $detail_lokasi->nama_vendor }}</td>
                                        <td>{{ $detail_lokasi->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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
        console.log({{ Illuminate\Support\Js::from($data) }})
        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = '/bss-form/catering/list-pemesanan'
            // console.log(params.data)
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            var _id = ", '"+ row.kode_pemesanan + "'"
            // var _id_vendor = ", '"+ row.id_vendor + "'"
            // var _site = ", '"+ row.site + "'"
            // var _jenis_pemesanan = ", '"+ row.jenis_pemesanan + "'"
            // var _lokasi = ", '"+ row.lokasi + "'"
            // var _nama_vendor = ", '"+ row.nama_vendor + "'"

            // var _clickEvent = 'onclick="modalDetail(this'  + _id + _id_vendor + _site + _jenis_pemesanan + _lokasi + _nama_vendor +')"'
            // var _clickEventDelete = 'onclick="actionDelete(this'  + _id +')"'
            var _clickEvent = 'onclick="modalDetail(this' + _id + ')"'
            var _clickEventDelete = 'onclick="actionDelete(this)"'

            var btnDetail = '<a href="#" '+ _clickEvent +' data-action="detail" style="color: black;margin: 0px 4px;"><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-action="delete" style="color: red;margin: 0px 4px;"><i class="fa-solid fa-trash-can cursor-pointer"></i></a>';
            
            return btnDetail
        }

        function modalDetail(e, _id) {
            console.log(_id)
        }

        function fetchSite(cb=function(site) {}) {
            axios.post("/helper/department", {
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