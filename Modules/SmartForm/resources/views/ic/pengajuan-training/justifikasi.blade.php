@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
                            data-unique-id="komitmen_id" data-row-style="rowStyle">
                            <thead>
                                <tr>
                                    <th data-field="komitmen_id" data-align="left" data-visible="false">komitmen id</th>
                                    <th data-field="NIK" data-align="left">NIK</th>
                                    <th data-field="nama" data-align="left">Nama</th>
                                    <th data-field="jabatan" data-align="left" data-sortable="true">Jabatan</th>
                                    <th data-field="departement" data-align="left" data-sortable="true">Departement</th>
                                    <th data-field="KodeSt" data-align="center">Site</th>
                                    <th data-field="komitmen_status" data-align="center" data-formatter="statusFormatter">Status</th>
                                    <th data-field="original_komitmen_status" data-visible="false">Status</th>
                                    <th data-field="keterangan" data-visible="false">Keterangan</th>
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
                                        <td>{{ $item->komitmen_status }}</td>
                                        <td></td>
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
                                        {{ $data->tanggal }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">Tempat Pelaksanaan</td>
                                <td style="vertical-align: top;"> : </td>
                                <td>
                                    <div class="input-group input-group-static">
                                        {{ $data->tempat }}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <p class="m-0 mt-3"><strong>Tujuan Training untuk menunjang  Logic Tree (KPI) yang mana, Kondisi sekarang seperti apa?</strong></p>
                        <table id="table-tujuan" data-toggle="table" data-side-pagination="client"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id" data-show-header="false">
                            <thead>
                                <tr>
                                    <th data-field="no" data-align="right" data-width="200" data-formatter="noTujuanFormatter"></th>
                                    <th data-field="tujuan" data-align="left">Tujuan</th>
                                    <th data-field="nama" data-align="left">Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataSubmitted['tujuan'] as $item)
                                <tr>
                                    <td></td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->nama }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <p class="m-0 mt-3"><strong>Pengganti Tugas selama Training</strong></p>
                        <table id="table-pengganti" data-toggle="table" data-side-pagination="client"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id" data-show-header="false">
                            <thead style="display: none;">
                                <tr>
                                    <th data-field="no" data-align="right" data-width="200" data-formatter="penggantiFormatter"></th>
                                    <th data-field="pengganti" data-align="left">NIK</th>
                                    <th data-field="nama" data-align="left">nama</th>
                            </thead>

                            <tbody>
                                @foreach ($dataSubmitted['pengganti'] as $item)
                                <tr>
                                    <td></td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->nama }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>

                        <p class="m-0 mt-3"><strong>Detail urgensi (Kepentingan mendesak) training/sertifikasi ini harus dijalankan segera?</strong></p>
                        <table id="table-urgensi" data-toggle="table" data-side-pagination="client"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id" data-show-header="false">
                            <thead style="display: none;">
                                <tr>
                                    <th data-field="no" data-align="right" data-width="200" data-formatter="urgensiFormatter"></th>
                                    <th data-field="urgensi" data-align="left">Urgensi</th>
                            </thead>
                            <tbody>
                                @foreach ($dataSubmitted['urgensi'] as $item)
                                <tr>
                                    <td></td>
                                    <td>{{ $item->keterangan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
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
        // const elem = document.getElementById("inputTanggalPelaksanaan");
        
        const baseURL = "/ic/training"
        const getDataURL = {{ Illuminate\Support\Js::from(route('ic.training.dashboard-komitmen-data')) }}
        function getData(params) {
            $.get(getDataURL + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            let currentApproval = {{ Illuminate\Support\Js::from($currentApproval) }}
            if(!currentApproval) currentApproval = {jenis: '-'}
            let iconHapus = row.komitmen_status == -2 ? '<i class="bi bi-arrow-repeat"></i>' : '<i class="bi bi-x-circle-fill"></i>'
            let btnRejectClass =  row.komitmen_status == -2 ? 'btn-success' : 'btn-danger'
            let btnReject = currentApproval['jenis'] == 'dibuat' ? `<button type="button" class="btn ${btnRejectClass} btn-action-format" onclick="aksiReject(event, ${row.NIK}, ${row.komitmen_id}, ${row.komitmen_status}, ${row.original_komitmen_status})">${iconHapus}</button>` : ''
            let btnInfo = `<a href="${baseURL}/form-komitmen/${row.komitmen_id}"><button class="btn btn-secondary btn-action-format"><i class="bi bi-info-circle-fill"></i></button></a>`
            if(!(row.komitmen_status == 0 || row.komitmen_status == -2)) btnReject = ""
            return '<div style="display: flex; gap:6px; justify-content: center;">' + btnInfo + btnReject + '</div>'
        }
        
        function statusFormatter(value, row, index) {
            if(value == "0") return '<button class="btn btn-warning btn-action-format">On progres</button>'
            if(value == "1") return '<button class="btn btn-success btn-action-format">Setuju</button>'
            if(value == "2") return '<button class="btn btn-success btn-action-format">Done approval</button>'
            if(value == "-1") return '<button class="btn btn-danger btn-action-format">Menolak</button>'
            if(value == "-2") return '<button class="btn btn-danger btn-action-format">Rejected / Dihapus</button>'

            return value
        }
        
        function jenisFormatter(value, row, index) {
            if(value == "1") return 'BA justifikasi' //'<button class="btn btn-warning btn-action-format">BA justifikasi</button>'
            if(value == "0") return 'Form justifikasi' //'<button class="btn btn-success btn-action-format">Form justifikasi</button>'

            return value
        }

        function noTujuanFormatter(value, row, index) {
            return `Tujuan ${index+1} `
        }

        function penggantiFormatter(value, row, index) {
            return `PIC ${index+1} : `
        }

        function urgensiFormatter(value, row, index) {
            return `Kepentingan Mendesak ${index+1} : `
        }
 
        function approveAct(e, nilai) {
            console.log(nilai)
            e.target.disabled = true
            let validateForm = []
            if(jenisCurrApproval == "dibuat") {
                console.log($("#table-komitmen").bootstrapTable('getData').filter((data) => data.komitment_status == 0).length);
                
                if($("#table-komitmen").bootstrapTable('getData').filter((data) => data.komitmen_status == 0).length > 0) {
                    validateForm.push("Terdapat form komitmen yang belum dilakukan persetujuan")
                }
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
            }
            $("#table-komitmen").bootstrapTable('getData').forEach((data) => {
                if(data.komitmen_status != 0) bodyReq.listKomitmen.push({
                    id: data.komitmen_id,
                    status: data.komitmen_status,
                    keterangan: data.keterangan
                })
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

        function aksiReject(e, nik, komitmenId, status, originalStatus) {
            console.log({nik, nik, id: komitmenId, status: status, origin: originalStatus})
            if(status != -2) {
                Swal.fire({
                    title: "Alasan menghapus dari ATMP",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    console.log(result)
                    
                    if (result.isConfirmed) {
                        $("#table-komitmen").bootstrapTable('updateByUniqueId', {
                            id: komitmenId,
                            row: {
                                komitmen_status: status == -2 ? originalStatus : -2,
                                keterangan: status == -2 ? '' : result.value
                            }
                        })
    
                        let rejectedData = $("#table-komitmen").bootstrapTable('getData').filter(function(data) {
                            return data.komitmen_status == -2
                        })
    
                        if(rejectedData.length > 0) {
                            $("#table-komitmen").bootstrapTable('showColumn', 'keterangan')
                        } else {
                            $("#table-komitmen").bootstrapTable('hideColumn', 'keterangan')
                        }   
                    }   
                })
            } else {
                $("#table-komitmen").bootstrapTable('updateByUniqueId', {
                    id: komitmenId,
                    row: {
                        komitmen_status: status == -2 ? originalStatus : -2,
                        keterangan: ''
                    }
                })

                let rejectedData = $("#table-komitmen").bootstrapTable('getData').filter(function(data) {
                    return data.komitmen_status == -2
                })

                if(rejectedData.length > 0) {
                    $("#table-komitmen").bootstrapTable('showColumn', 'keterangan')
                } else {
                    $("#table-komitmen").bootstrapTable('hideColumn', 'keterangan')
                }  
            }

            
            
        }

        function rowStyle(row, index) {
            if(row.komitmen_status == -2) {
                return {
                    classes: 'bg-danger text-white'
                }
            }
            return {}
        }
    </script>
@endsection