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
            margin-left: 8px;
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

        .columns-right > .btn-secondary {
            margin: 0;
            padding: 10px 16px;
        }

        #table-tujuan > thead {
            display: none;
        }

        .input-text {
            border-bottom: 1px solid #6c757d;
            border-radius: 0;
        }
        .input-text:focus {
            border-bottom: 1px solid #e91e63;
        }

    </style>
@endsection

@section('content')
{{-- <input type="text" name="foo"> --}}
    {{-- {{ dd(['authorized' => $listApproval['authorized']->search(session('user_id')), 'data' => $data]); }} --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4 pb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Justifikasi</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    
                    <div class="mx-4">
                        <h5>Dengan ini , Saya selaku atasan dari : </h5>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="table-komitmen" data-toggle="table" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="komitmen_id">
                            <thead>
                                <tr>
                                    <th data-field="komitmen_id" data-align="left" data-visible="false">komitmen id</th>
                                    <th data-field="NIK" data-align="left">NIK</th>
                                    <th data-field="nama" data-align="left">Nama</th>
                                    <th data-field="jabatan" data-align="left" data-sortable="true">Jabatan</th>
                                    <th data-field="departement" data-align="left" data-sortable="true">Departement</th>
                                    <th data-field="KodeSt" data-align="center">Site</th>
                                    <th data-field="komitmen_status" data-align="center" data-formatter="statusFormatter">Status</th>
                                    <th data-field="action" data-formatter="actionFormatter" data-align="center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listKomitmen as $item)
                                    <tr>
                                        <td>{{ $item->komitmen_id }}</td>
                                        <td>{{ $item->NIK }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>{{ $item->departement }}</td>
                                        <td>{{ $item->KodeST }}</td>
                                        <td>{{ $item->komitmen_status }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mx-4">
                        <h5 class="mt-3">Justifikasi</h5>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="table-justifikasi" data-toggle="table" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="id" data-align="left" data-visible="false">ID</th>
                                    <th data-field="jenis" data-align="left" data-formatter="jenisFormatter">BA / Form</th>
                                    <th data-field="status" data-align="left" data-formatter="statusJustFormatter" data-visible="false">Status</th>
                                    <th data-field="action" data-align="left" data-formatter="actionJustFormatter" data-visible="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listJustifikasi as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->jenis_dokumen }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mx-3">
                        <p class="m-0">Merekomendasikan karyawan tersebut untuk mengikuti :</p>
                        <table style="width: 100%;">
                            <tr>
                                <td style="vertical-align: top;">Nama Training</td>
                                <td style="vertical-align: top;"> : </td>
                                <td>{{ $data->training_nama }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">Tanggal Pelaksanaan</td>
                                <td style="vertical-align: top;"> : </td>
                                {{-- <td>
                                    <div class="input-group input-group-static">
                                        <input type="date" class="form-control" id="inputTanggalPelaksanaan" name="inputTanggalPelaksanaan" placeholder="Bulan Tahun">
                                    </div>
                                </td> --}}
                                <td>
                                    <div class="input-group input-group-static">
                                        <!--<input type="date" class="form-control" id="inputTanggalPelaksanaan" name="inputTanggalPelaksanaan" placeholder="Bulan Tahun" {{ $data->trj_status == 2 || $data->trj_status == -2 || $data->trj_status == 3 ? 'disabled' : ''}}
                                            value="{{$data->trj_status == 2 || $data->trj_status == -2 || $data->trj_status == 3 ? $data->tanggal : ''}}" {{ $isDibuatOleh ? '' : 'disabled'}}> -->
                                        {{-- <input type="date" class="form-control" id="inputTanggalPelaksanaan" name="inputTanggalPelaksanaan" placeholder="Bulan Tahun" > --}}
                                        @if($data->trj_status == 1 && $isDibuatOleh)
                                            <input type="date" class="form-control" id="inputTanggalPelaksanaan" name="inputTanggalPelaksanaan" placeholder="Bulan Tahun" >
                                        @else
                                            {{ $data->tanggal }}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">Tempat Pelaksanaan</td>
                                <td style="vertical-align: top;"> : </td>
                                <td>
                                    <div class="input-group input-group-static">
                                        @if($data->trj_status == 1 && $isDibuatOleh)
                                            <input type="text" class="form-control" id="inputTempatPelaksanaan" name="inputTempatPelaksanaan">
                                        @else
                                            {{ $data->tempat }}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <p class="m-0 mt-3"><strong>Tujuan Training untuk menunjang  Logic Tree (KPI) yang mana, Kondisi sekarang seperti apa?</strong></p>
                        @if ($data->trj_status == 1 && $isDibuatOleh)
                            <div style="display: flex; gap: 12px; margin-bottom: 12px;" class="col-md-6">
                                <input type="text" class="form-control input-text w-fit" placeholder="Cth “Menunjang KPI Fullfillment Manpower Ach : 80%”" id="inputTujuan">
                                <button class="btn btn-secondary m-0" type="button" id="btnAddTujuan" onclick="addTujuan(event)"><i class="bi fa-plus"></i> </button>
                            </div>
                        @endif
                        <table id="table-tujuan" data-toggle="table" data-side-pagination="client"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id" data-show-header="false">
                            <thead>
                                <tr>
                                    <th data-field="no" data-align="right" data-width="200" data-formatter="noTujuanFormatter"></th>
                                    <th data-field="tujuan" data-align="left">Tujuan</th>
                                    @if ($data->trj_status == 1)
                                    <th data-field="action" data-align="center" data-formatter="htujuanFormatter"></th>
                                    @endif
                                </tr>
                            </thead>
                            @if(!($data->trj_status == 1 && $isDibuatOleh) || $data->trj_status == 2 || $data->trj_status == -2 || $data->trj_status == 3)
                                <tbody>
                                    @foreach ($dataSubmitted['tujuan'] as $item)
                                    <tr>
                                        <td></td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>

                        <p class="m-0 mt-3"><strong>Pengganti Tugas selama Training</strong></p>
                        
                        @if ($data->trj_status == 1 && $isDibuatOleh)
                            <div style="display: flex; gap: 12px; margin-bottom: 12px;" class="col-md-6">
                                <input type="text" class="form-control input-text w-fit" placeholder="PIC 1, PIC 2, PIC 3" id="inputPengganti">
                                <button class="btn btn-secondary m-0" type="button" id="btnAddPengganti" onclick="addPengganti(event)"><i class="bi fa-plus"></i> </button>
                            </div>
                        @endif
                        <table id="table-pengganti" data-toggle="table" data-side-pagination="client"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id" data-show-header="false">
                            <thead style="display: none;">
                                <tr>
                                    <th data-field="no" data-align="right" data-width="200" data-formatter="penggantiFormatter"></th>
                                    <th data-field="pengganti" data-align="left">Pengganti</th>
                                    @if ($data->trj_status == 1 && $isDibuatOleh)
                                    <th data-field="action" data-align="center" data-formatter="hapusPenggantFormatter"></th>
                                    @endif
                            </thead>
                            @if (!($data->trj_status == 1 && $isDibuatOleh) || $data->trj_status == 2 || $data->trj_status == -2 || $data->trj_status == 3)
                                <tbody>
                                    @foreach ($dataSubmitted['pengganti'] as $item)
                                    <tr>
                                        <td></td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>

                        <p class="m-0 mt-3"><strong>Detail urgensi (Kepentingan mendesak) training/sertifikasi ini harus dijalankan segera?</strong></p>
                        @if ($data->trj_status == 1 && $isDibuatOleh)
                            <div style="display: flex; gap: 12px; margin-bottom: 12px;" class="col-md-6">
                                <input type="text" class="form-control input-text w-fit" placeholder="Detail urgensi" id="inputUrgensi">
                                <button class="btn btn-secondary m-0" type="button" id="btnAddUrgensi" onclick="addUrgensi(event)"><i class="bi fa-plus"></i> </button>
                            </div>
                        @endif
                        <table id="table-urgensi" data-toggle="table" data-side-pagination="client"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id" data-show-header="false">
                            <thead style="display: none;">
                                <tr>
                                    <th data-field="no" data-align="right" data-width="200" data-formatter="urgensiFormatter"></th>
                                    <th data-field="urgensi" data-align="left">Urgensi</th>
                                    @if ($data->trj_status == 1 && $isDibuatOleh)
                                    <th data-field="action" data-align="center" data-formatter="actionUrgensiFormatter"></th>
                                    @endif
                            </thead>
                            @if (!($data->trj_status == 1 && $isDibuatOleh) || $data->trj_status == 2 || $data->trj_status == -2 || $data->trj_status == 3)
                                <tbody>
                                    @foreach ($dataSubmitted['urgensi'] as $item)
                                    <tr>
                                        <td></td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>

                        <p class="m-0 mt-3"><strong>Bentuk Pertanggung jawaban ?</strong></p>
                        <table>
                            <tr>
                                <td>1. </td>
                                <td>menerapkan hasil training dalam lingkup pekerjaan personal, Department dan perusahaan sehingga lebih efektif dan sesuai dengan prosedur yang ada</td>
                            </tr>
                            <tr>
                                <td>2. </td>
                                <td>Memberikan kontribusi terhadap perusahaan dalam peningkatan KPI Department</td>
                            </tr>
                            <tr>
                                <td>3. </td>
                                <td>Mampu mentransfer ke tim yang lain</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="table-responsive p-0">
                        <table class="table-approval" style="width: 100%;">
                            <tr>
                                <td>Hormat saya,</td>
                                <td>Disetujui Oleh,</td>
                                <td colspan="2">Diketahui Oleh,</td>
                            </tr>
                            <tr>
                                @foreach ($selectedApproval as $item)
                                    <td>{{ $item['status'] }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($selectedApproval as $item)
                                    <td>{{ $item['nama'] }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                    
                    @if ($data->trj_status == '1')
                        @if ($currentApproval != null )
                            @if($currentApproval['NIK'] == session('user_id'))
                            <div style="display: flex; justify-content: end;gap: 12px;" class="mt-4">
                                <button class="btn btn-primary mb-0" onclick="approveAct(event, '1')">Approve</button>
                                <button class="btn btn-danger mb-0" onclick="approveAct(event, '-1')">Reject</button>
                            </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('master/js/loading.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        const trjID = {{ Illuminate\Support\Js::from($data->trj_id) }}
        const jenisCurrApproval = {{ Illuminate\Support\Js::from($currentApproval==null ? null : $currentApproval['jenis']) }}
        document.querySelector("#table-tujuan thead").style.display = "none";
        const elem = document.getElementById("inputTanggalPelaksanaan");
        
        const baseURL = "/ic/training"
        const getDataURL = {{ Illuminate\Support\Js::from(route('ic.training.dashboard-komitmen-data')) }}
        function getData(params) {
            $.get(getDataURL + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            return `<a href="${baseURL}/form-komitmen/${row.komitmen_id}"><button class="btn btn-secondary btn-action-format"><i class="bi bi-info-circle-fill"></i></button></a>`
        }

        function actionJustFormatter(value, row, index) {
            return `<a href="${baseURL}/form-komitmen/${row.id}"><button class="btn btn-secondary btn-action-format"><i class="bi bi-info-circle-fill"></i></button></a>`
        }
        
        function statusFormatter(value, row, index) {
            if(value == "0") return '<button class="btn btn-warning btn-action-format">On progres</button>'
            if(value == "1") return '<button class="btn btn-success btn-action-format">Setuju</button>'
            if(value == "2") return '<button class="btn btn-success btn-action-format">Done approval</button>'
            if(value == "-1") return '<button class="btn btn-danger btn-action-format">Menolak</button>'
            if(value == "-2") return '<button class="btn btn-danger btn-action-format">Ditolak aproval</button>'

            return value
        }
        
        function jenisFormatter(value, row, index) {
            if(value == "1") return 'BA justifikasi' //'<button class="btn btn-warning btn-action-format">BA justifikasi</button>'
            if(value == "0") return 'Form justifikasi' //'<button class="btn btn-success btn-action-format">Form justifikasi</button>'

            return value
        }

        function statusJustFormatter(value, row, index) {
            if(value == "0") return '<button class="btn btn-warning btn-action-format">On Progres</button>'
            if(value == "1") return '<button class="btn btn-success btn-action-format">Done</button>'
            
            return value
        }

        function noTujuanFormatter(value, row, index) {
            return `Tujuan ${index+1} `
        }
        

        function validasiForm() {
            let dataKomitmen = $("#table-komitmen").bootstrapTable("getData").filter((nilai) => {
                return nilai.komitmen_status != 2 || nilai.komitmen_status != -2
            })

            let dataBAJustifikasi = $("#table-justifikasi").bootstrapTable("getData").filter((nilai) => {
                return nilai.status == 1
            })

            let listErr = [];

            if(dataKomitmen.length > 0) listErr.push("Validasi Komitmen belum lengkap")
            if(!$("#disetujui1").val()) listErr.push("Kabag / Kasi ICGS kosong")
            if(!$("#diketahui1").val()) listErr.push("Project Manager/People Partner kosong")
            if(!$("#diketahui2").val()) listErr.push("kadep HO kosong")
            
            if(dataBAJustifikasi.count > 0) {
                if($("#diketahui3").val()) listErr.push("Think tank kosong")
            }

            return listErr
        }

        function htujuanFormatter(value, row, index) {
            return `<button class="btn btn-danger btn-action-format" onclick="hapusItem(${index})"><i class="bi bi-trash-fill"></i></button>`
        }

        function hapusItem(index) {
            $("#table-tujuan").bootstrapTable('remove', {
                field: '$index',
                values: [index]
            })
        }

        function penggantiFormatter(value, row, index) {
            return `PIC ${index+1} : `
        }
        function hapusPenggantFormatter(value, row, index) {
            return `<button class="btn btn-danger btn-action-format" onclick="hapusPengganti(${index})"><i class="bi bi-trash-fill"></i></button>`
        }
        function hapusUrgensi(index) {
            $("#table-urgensi").bootstrapTable('remove', {
                field: '$index',
                values: [index]
            })
        }

        function urgensiFormatter(value, row, index) {
            return `Kepentingan Mendesak ${index+1} : `
        }
        function actionUrgensiFormatter(value, row, index) {
            return `<button class="btn btn-danger btn-action-format" onclick="hapusUrgensi(${index})"><i class="bi bi-trash-fill"></i></button>`
        }
        function hapusPengganti(index) {
            $("#table-pengganti").bootstrapTable('remove', {
                field: '$index',
                values: [index]
            })
        }

        function addTujuan(e) {
            console.log($("#inputTujuan").val())
            $("#table-tujuan").bootstrapTable("append", {
                no: null,
                tujuan: $("#inputTujuan").val(),
                action: null
            })
        }

        function addPengganti(e) {
            console.log($("#inputPengganti").val())
            $("#table-pengganti").bootstrapTable("append", {
                no: null,
                pengganti: $("#inputPengganti").val(),
                action: null
            })
        }

        function addUrgensi(e) {
            console.log($("#inputUrgensi").val())
            $("#table-urgensi").bootstrapTable("append", {
                no: null,
                urgensi: $("#inputUrgensi").val(),
                action: null
            })
        }
 
        function approveAct(e, nilai) {
            console.log(nilai)
            e.target.disabled = true
            let validateForm = []
            if(jenisCurrApproval == "dibuat") {
                if($("#table-komitmen").bootstrapTable('getData').filter((data) => data.status == 0).length > 0) {
                    validateForm.push("Terdapat form komitmen yang belum dilakukan persetujuan")
                }
                if(!$("#inputTempatPelaksanaan").val().trim()) validateForm.push("Tempat pelaksaan belum diisi") 
                if(!$("#inputTanggalPelaksanaan").val()) validateForm.push("Tanggal pelaksaan belum diisi")
            } 

            if(validateForm.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: validateForm.join("<br>")
                })
                e.target.disabled = false
                return
            }
            
            let bodyReq = {
                trjId: {{ Illuminate\Support\Js::from($data->trj_id) }},
                approvalId: {{ Illuminate\Support\Js::from($currentApproval == null ? null : $currentApproval['approvalId']) }},
                status: nilai,
                keterangan: "",
                tempat: jenisCurrApproval == "dibuat" ? $("#inputTempatPelaksanaan").val() : "",
                tanggal: jenisCurrApproval == "dibuat" ? $("#inputTanggalPelaksanaan").val() : "",
                listKomitmen: [],
                tujuan: [],
                pengganti: [],
                urgensi: [],
            }

            $("#table-tujuan").bootstrapTable("getData").forEach(element => {
                bodyReq.tujuan.push(element.tujuan)
            })

            $("#table-pengganti").bootstrapTable("getData").forEach(element => {
                bodyReq.pengganti.push(element.pengganti)
            })

            $("#table-urgensi").bootstrapTable("getData").forEach(element => {
                bodyReq.urgensi.push(element.urgensi)
            })
            
            $("#table-komitmen").bootstrapTable('getData').forEach((data) => {
                if(data.komitmen_status == -1 || data.komitmen_status == 1) bodyReq.listKomitmen.push(data.komitmen_id)
            })
            // console.log(bodyReq)
            // return
            let actMapping = {
                '1': 'Approve',
                '-1': 'Reject'
            }
            let swalConfig = {
                '1' : {
                    showCancelButton: true,
                    confirmButtonText: actMapping[nilai],
                    text: "Konfirmasi " + actMapping[nilai] + " ? ",
                    icon: "warning"
                },
                '-1' : {
                    showCancelButton: true,
                    confirmButtonText: actMapping[nilai],
                    text: "Konfirmasi " + actMapping[nilai] + " ? ",
                    icon: "warning",
                    input: "text",
                    inputLabel: "Alasan reject",
                    inputValidator: (value) => {
                        value = value.trim()
                        if (!value) {
                            return "Alasan tidak boleh kosong";
                        }
                    }
                }
            }
            const approveActURL = {{ Illuminate\Support\Js::from(route('ic.training.justifikasi-approve')) }}

            Swal.fire(swalConfig[nilai])
            .then((result) => {
                console.log(result)
                if (result.isConfirmed) {
                    if(nilai == -1) bodyReq.keterangan = result.value || ""
                    console.log(bodyReq)
                    showLoading()
                    axios.post(approveActURL, bodyReq, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(function(resp) {
                        let dataSwal = {}
                        if(resp.data.isSuccess) {
                            dataSwal = {
                                backdrop: false,
                                icon: 'success',
                                title: 'Berhasil!',
                                text: resp.data.message || 'Berhasil'
                            }
                        } else {
                            dataSwal = {
                                icon: 'error',
                                title: 'Gagal!',
                                text: resp.data.message || 'Error, coba beberapa saat lagi'
                            }
                        }
                        // Swal.fire(dataSwal)
                        Swal.fire(dataSwal)
                                .then((result) => {
                                    if (result.isConfirmed && resp.data.isSuccess) {
                                        location.reload()
                                    }
                                })
                    })
                    .catch(function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan, coba beberapa saat lagi'
                        })
                    })
                    .finally(function() {
                        stopLoading()
                        e.target.disabled = false
                    })
                    e.target.disabled = false
                } else {
                    e.target.disabled = false
                }
            })
        }
    </script>
@endsection