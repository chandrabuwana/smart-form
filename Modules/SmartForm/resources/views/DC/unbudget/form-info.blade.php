{{-- {{ dd(session('user_id')) }} --}}
@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .w-full {
            width: 100%;
        }
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
        .filter-section {
            display: flex;
            width: 100%;
            justify-content: end;
            gap: 8px;
        }
        /* .page-item .page-link {
            color: #FFFFFF;
        } */
        /* .active > .page-link {
            color: #cccccc;
        } */
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
        .table td {
            white-space: normal;
        }

        @media print {
        table.table-print thead {
            background-color: rgb(231, 231, 217);
        }
        table.table-print, table.table-print tr, table.table-print td{
            border-style: solid;
            border-width: 1px;
        }
        .only-print {
            display: inline;
        }
        .fixed-plugin-button {
            display: none;
        }
        /* Sembunyikan elemen yang tidak diperlukan */
        .no-print {
            display: none !important;
        }
        nav {
            display: none !important;
        }
        aside {
            display: none !important;
        }
        
        /* Atur ukuran font khusus untuk print */
        body {
            font-size: 12pt;
            height: auto;
            overflow: visible;
        }
        main {
            max-height: none !important;
        }
    }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4 pb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form BA Unbudget</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">

                    <div class="px-4 mt-3 row">
                        <div>
                            <h5>No Document</h5>
                            <label id='NoDocument'>{{ $data['master']->NoDocument }}</label>
                            <h5>Tanggal dibuat</h5>
                            <label>{{ $data['master']->tanggal_format }}</label>
                            <h5>Dibuat oleh</h5>
                            <label>{{ $data['master']->NIK }} - {{ $data['master']->Nama }}</label>
                            <h5>Site - Department</h5>
                            <label>{{ $data['master']->KodeST }} - {{ $data['master']->KodeDP }}</label>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="table-data" data-toggle="table" data-side-pagination="server"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="kode_material" data-align="left">Kode Material</th>
                                    <th data-field="nama_material" data-align="left">Nama Material</th>
                                    <th data-field="kode_coa" data-align="left">Kode COA</th>
                                    <th data-field="nama_coa" data-align="left">COA</th>
                                    <th data-field="qty" data-align="left">QTY</th>
                                    <th data-field="harga_satuan" data-align="left">Harga Satuan</th>
                                    <th data-field="total" data-align="left">Total</th>
                                    <th data-field="keterangan" data-align="left">Keterangan</th>
                            </thead>
                            <tbody>
                                @foreach ($data['detail'] as $item)
                                    <tr>
                                        <td>{{ $item->KodeMaterial }}</td>
                                        <td>{{ $item->NamaMaterial }}</td>
                                        <td>{{ $item->Code_COA }}</td>
                                        <td>{{ $item->COA }}</td>
                                        <td>{{ (int) $item->QTY }}</td>
                                        <td>{{ $item->HargaSatuan }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-4 mt-3 row ">
                            <h5>Catatan / Reason: Analisa (SEFTO)</h5>
                            <table class="table table-striped align-top">
                                <tbody>
                                    <tr>
                                        <td style="width: 16px;">1. </td>
                                        <td style="width: 48px;">Strategi</td>
                                        <td style="width: 12px;">:</td>
                                        <td>{{ $data['master']->strategi }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 16px;">2. </td>
                                        <td style="width: 48px;">Ekonomi</td>
                                        <td style="width: 12px;">:</td>
                                        <td>{{ $data['master']->ekonomi }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 16px;">3. </td>
                                        <td style="width: 48px;">Finance</td>
                                        <td style="width: 12px;">:</td>
                                        <td>{{ $data['master']->finance }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 16px;">4. </td>
                                        <td style="width: 48px;">Technology</td>
                                        <td style="width: 12px;">:</td>
                                        <td>{{ $data['master']->technology }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 16px;">5. </td>
                                        <td style="width: 48px;">Technology</td>
                                        <td style="width: 12px;">:</td>
                                        <td>{{ $data['master']->technology }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        
                    </div>

                    <div class="px-3">
                        <h5>Demikian berita acara ini dibuat dengan sebenar-benarnya.</h5>
                        <label>{{ $data['master']->tempat }}, {{ $data['master']->tanggal_format }}</label>
                    </div>

                    <div class="px-4 mt-3 row">
                        <table style="text-align: center; vertical-align: middle;">
                            <thead>
                                <tr>
                                    <td>Dibuat Oleh,</td>
                                    <td colspan="2">Diperiksa Oleh,</td>
                                    <td>Diketahui Oleh,</td>
                                    <td colspan="2">Disetujui Oleh,</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $data['master']->Nama }}</td>
                                    @foreach ($data['approval'] as $item)
                                        <td>{{ $item->Nama ? $item->Nama : $item->NIK}}</td>
                                    @endforeach
                                </tr>
                                <tr class="my-3">
                                    <td>Done</td>
                                    @foreach ($data['approval'] as $item)
                                        <td>{{ $item->status_nama }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Staff</td>
                                    @foreach ($data['approval'] as $item)
                                        <td>{{ $item->role }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>

                </div>
                
                <div class="card-footer" style="align-items: flex-end; display: flex; gap: 1rem; justify-content: end;">
                    @if ($data['master']->status == 0)
                        @if ($data['current_approval']['NIK'] == session('user_id'))
                            <button id="btn-submit" class="btn btn-success" onclick="aksiApproval(event, 1)">Approve</button>
                            <button id="btn-submit" class="btn btn-danger" onclick="aksiApproval(event, -1)">Reject</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="display-print">
        <table width="100%" class="center bordered">
            <tbody><tr>
                <td rowspan="3" align="center" width="150"><img width="100" src="https://budget.binasaranasukses.co.id/images/1.jpg"></td>
                <td colspan="3" align="center">INTEGRATED BSS EXCELLENT SYSTEM</td>
    
            </tr>
            <tr>
                <td width="700px" rowspan="2" align="center">FORM</td>
                <td class="label" align="left">No Dok</td>
                
                <td align="left">BSS-FRM-DC-001</td>
    
            </tr>
            <tr>
                <td align="left" class="label">Revisi</td>
                <td align="left">2</td>
            </tr>
            <tr>
                <td colspan="2" rowspan="2" align="center">BERITA ACARA COST DILUAR BUDGET</td>
                <td align="left" class="label">Tanggal</td>
                <td align="left">31/5/2024</td>
            </tr>
            <tr>
                <td align="left" class="label">Halaman</td>
                <td align="left">1 of 1</td>
            </tr>
        </tbody></table>
    </div> --}}
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }
    </script>
    <script>
        function aksiApproval(event, nilai) {
            event.target.disabled = true

            let dataApprove = {
                NoDocument: {{ Illuminate\Support\Js::from($data['master']->NoDocument) }},
                approvalValue: nilai
            }
            let nilaiMapping = {
                title: {
                    '1': 'Konfirmasi approve',
                    '-1': 'Konfirmasi reject'
                }
            }

            Swal.fire({
                title: nilaiMapping.title[nilai] + " BA " + $("#NoDocument").text() + " ?",
                showCancelButton: true,
                confirmButtonText: "Save",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                denyButtonText: `Don't save`
            })
            .then(function(data) {
                if(data.isConfirmed) {
                    showLoading()
                    axios.post({{ Illuminate\Support\Js::from(route('dc.unbudget.form-approval')) }}, 
                        dataApprove, 
                        {
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        }
                    )
                    .then(function(resp) {
                        let dataAlert = {
                            icon: "error",
                            title: "Gagal"
                        }

                        if(resp.data.isSuccess) {
                            dataAlert.icon = "success"
                            dataAlert.title = "Berhasil"
                        } 

                        dataAlert.text = resp.data.message

                        Swal.fire(dataAlert)
                        .then(data => {
                            if(resp.data.isSuccess) {
                                location.reload()
                            }
                        })
                    })
                    .catch(function(err) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: "Terjadi kesalahan, coba beberapa saat lagi"
                        })
                    })
                    .finally(function() {
                        event.target.disabled = false
                        stopLoading()
                    })
                } else {
                    event.target.disabled = false
                }
            })
        }
        
    </script>
@endsection