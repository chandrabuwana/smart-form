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
            /* border: 1px solid #cccccc; */
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
                        <h6 class="text-white text-capitalize ps-3">Form Komitmen Peserta Pelatihan & Sertifikasi</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="mx-4 mb-2">
                        <fieldset>
                            <legend style="font-size: large;">Saya yang bertanda tangan di bawah ini : </legend>
                            <table class="table-poin" style="margin-left: 16px;">
                                <tr>
                                    <td style="vertical-align: top;">Nama</td>
                                    <td> : <span id="textNama">{{ $data->NIK_nama }}</span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">NRP</td>
                                    <td> : <span id="textNIK">{{ $data->NIK }}</span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Jabatan</td>
                                    <td> : <span id="textJabatan">{{ $data->jabatan }}</span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Departemen</td>
                                    <td> : <span id="textDept">{{ $data->departemen }}</span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Judul Training</td>
                                    <td> : <span id="textTraining">{{ $data->training_nama }}</span></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div class="mx-4 mb-2">
                        <span style="font-size: large;">Dengan dilakukannya kegiatan training diatas, saya memiliki kewajiban untuk :</span>
                        <table class="table-poin">
                                <tr>
                                    <td>1. </td>
                                    <td>Presentasi keatasan dan manajemen terkait hasil training yang sudah diikuti (H+30)</td>
                                </tr>
                                <tr>
                                    <td>2. </td>
                                    <td>Membuat improvement project (min 1 Suggestion System) sampai dengan evaluasi dan monitoring (H+30)</td>
                                </tr>
                                <tr>
                                    <td>3. </td>
                                    <td>Mampu mentransfer ke tim yang lain (minimal 2 orang)</td>
                                </tr>
                                <tr>
                                    <td>4. </td>
                                    <td>Harus mencapai standar kelulusan jika ada tugas praktek/ teori dari training tersebut</td>
                                </tr>
                                <tr>
                                    <td>5. </td>
                                    <td>Bersedia tidak akan resign min 2 tahun kedepan pasca training</td>
                                </tr>
                        </table>
                    </div>
                    <div class="mx-4 mb-2">
                        <span style="font-size: large;">Note :</span>
                        <table class="table-poin">
                                <tr>
                                    <td>a. </td>
                                    <td>Poin 1-3 diberlakukan untuk training soft skill, sertifikasi, teknis di level Staff & Non Staff</td>
                                </tr>
                                <tr>
                                    <td>b. </td>
                                    <td>Poin 4 jika saya tidak lulus training maka saya siap dikenakan sanksi pembinaan dan harus mengikuti batch berikutnya dengan biaya pribadi dalam kurun waktu maksimal 3 bulan pasca training sebelumnya.</td>
                                </tr>
                                <tr>
                                    <td>c. </td>
                                    <td>Jika poin 5 terjadi, bersedia membayar penggantian biaya 2x lipat dari biaya training dan akomodasi training (jika ada) yang telah dikeluarkan dan akan masuk ke daftar blacklist perusahaan.</td>
                                </tr>
                                <tr>
                                    <td>d. </td>
                                    <td>Seluruh jam pelatihan dalam satu hari akan diperhitungkan sebagai 11 jam kerja (walaupun secara aktual bisa kurang atau lebih dari 11 jam kerja).</td>
                                </tr>
                                <tr>
                                    <td>e. </td>
                                    <td>Pemberian insentif untuk Operator & Mekanik diberikan secara proporsional jika pada bulan tersebut tercapai persyaratan untuk perolehan insentifnya.</td>
                                </tr>
                                <tr>
                                    <td>f. </td>
                                    <td>Point nomer 1 - 4 Tidak berlaku untuk point Training/Pelatihan Susbintal</td>
                                </tr>
                        </table>
                    </div>
                    <div class="mx-4 mb-3 row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="inputPeriode"><strong>Demikian surat ini saya buat dengan sebenar-benarnya. Terima kasih</strong></label>
                                <input type="text" class="form-control" id="inputPeriode" name="inputPeriode" placeholder="Bulan Tahun" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    @if ($data->status == '0')
                        <div class="table-responsive p-0">
                            <table id="table-syarat" data-toggle="table" data-side-pagination="client"
                                data-content-type="application/json" data-data-type="json" data-pagination="false"
                                data-unique-id="id" data-header-style="headerStyle">
                                <thead>
                                    <tr>
                                        <th data-field="approval_role" data-align="left"></th>
                                        <th data-field="jabatan" data-align="left">Jabatan</th>
                                        <th data-field="pic" data-align="left">PIC</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dibuat oleh</td>
                                        <td>{{ $data->NIK }} - {{ $data->NIK_nama }}</td>
                                        <td>
                                            <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                                {{-- TODO : enable ini ketika mau deploy --}}
                                                {{-- <select class="form-control form-select form-approval" name="persetujuan" id="persetujuan"> --}}
                                                <select class="form-control form-select form-approval" name="persetujuan" id="persetujuan" {{$data->NIK == session('user_id') && $data->status == '0' ? "" : "disabled"}}>
                                                    <option value="">-- Setuju / Tidak setuju --</option>
                                                    <option value="1">Setuju</option>
                                                    <option value="-1">Tidak setuju</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Disetujui oleh</td>
                                        <td>Kabag / Kasi Dept</td>
                                        <td>
                                            <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                                {{-- TODO : enable ini ketika mau deploy --}}
                                                {{-- <select class="form-control form-select form-approval" name="disetujui1" id="disetujui1"> --}}
                                                <select class="form-control form-select form-approval" name="disetujui1" id="disetujui1" {{$data->NIK == session('user_id') && $data->status == '0' ? "" : "disabled"}}>
                                                    <option value="">-- Pilih PIC --</option>
                                                    @foreach ($dataApproval['disetujui']['1'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->NIK }} - {{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Diketahui oleh</td>
                                        <td>Kabag / Kasi ICGS</td>
                                        <td>
                                            <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                                {{-- TODO : enable ini ketika mau deploy --}}
                                                {{-- <select class="form-control form-select form-approval" name="diketahui1" id="diketahui1"> --}}
                                                <select class="form-control form-select form-approval" name="diketahui1" id="diketahui1" {{$data->NIK == session('user_id') && $data->status == '0' ? "" : "disabled"}}>
                                                    <option value="">-- Pilih PIC --</option>
                                                    @foreach ($dataApproval['diketahui']['1'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->NIK }} - {{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Diketahui oleh</td>
                                        <td>Project Manager/Kadept Dept</td>
                                        <td>
                                            <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                                {{-- TODO : enable ini ketika mau deploy --}}
                                                {{-- <select class="form-control form-select form-approval" name="diketahui2" id="diketahui2"> --}}
                                                <select class="form-control form-select form-approval" name="diketahui2" id="diketahui2" {{$data->NIK == session('user_id') && $data->status == '0' ? "" : "disabled"}}>
                                                    <option value="">-- Pilih PIC --</option>
                                                    @foreach ($dataApproval['diketahui']['2'] as $item)
                                                    <option value="{{ $item->id }}">{{ $item->NIK }} - {{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="input-group input-group-static mt-3" id="fieldMenolak" style="display: none;">
                                <label style="width: 100%;"><strong>Alasan Menolak Training</strong></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="alasanMenolak" id="flexRadioDefault1" value="0">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    Training Mandiri
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="alasanMenolak" id="flexRadioDefault2" value="1">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                    Menolak / Alasan lain
                                    </label>
                                </div>
                                <div class="input-group input-group-static my-1">
                                    <input class="form-control" type="text" name="alasanLain"
                                        placeholder="Tuliskan alasan anda" value="" required id="alasanLain">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table-approval" style="width: 100%;">
                                <tr>
                                    <td>Hormat saya,</td>
                                    <td>Disetujui Oleh,</td>
                                    <td colspan="2">Diketahui Oleh,</td>
                                </tr>
                                <tr>
                                    <td>Done</td>
                                    @foreach ($selectedApproval as $item)
                                        <td>{{ $approvalStatusMapping[$item->status] }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>{{ $data->NIK_nama }}</td>
                                    @foreach ($selectedApproval as $item)
                                        <td>{{ $item->nama }}</td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                    @endif
                    {{-- TODO : enable ini ketika mau deploy --}}
                    @if ($data->NIK == session('user_id') && $data->status == '0')
                        <div style="display: flex; justify-content: end;">
                            <button class="btn btn-primary mb-0" onclick="submitKomitmen(event)">Submit Pelatihan</button>
                        </div>
                    @endif
                    @if ($data->status == '1')
                        @if ($currentApproval['NIK'] == session('user_id'))
                            <div style="display: flex; justify-content: end;gap: 12px;" class="mt-4">
                                <button class="btn btn-primary mb-0" onclick="approveAct(event, '1')">Approve</button>
                                <button class="btn btn-danger mb-0" onclick="approveAct(event, '-1')">Reject</button>
                            </div>
                        @endif
                    @endif
                    @if ($data->status == '-2')
                        <div style="display: flex; justify-content: start;gap: 12px;" class="mt-4">
                            <label class="bg-danger text-white">Alasan : {{ $data->keterangan }}</label>
                        </div>
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
        (function () {
                Datepicker.locales.en = {
                days: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
                daysShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                daysMin: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
                months: ["Januari", "Februari", "Maret", "Apri", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                monthsShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                today: "Hari",
                monthsTitle: "Bulan",
                clear: "Clear",
                weekStart: 0,
                format: "dd/mm/yyyy"
            }
        })()

        const dataApproval = {{ Illuminate\Support\Js::from($dataApproval) }}
        const approveActURL = {{ Illuminate\Support\Js::from(route('ic.training.komitment-approve')) }}
        // $(".form-approval").select2({})
        const persetujuan = document.getElementById("persetujuan")
        const fieldMenolak = document.getElementById("fieldMenolak")

        const elem = document.getElementById("inputPeriode")
        const datepicker = new Datepicker(elem, {
            format: "dd MM yyyy",
            pickLevel: 1
        })

        datepicker.setDate({{ $data->NIK == session('user_id') ? Illuminate\Support\Js::from($tglDibuat) : ''}})
        
        function submitKomitmen(e) {
            e.target.disabled = true
            let url = {{ Illuminate\Support\Js::from(route('ic.training.form-komitmen-act')) }}
            let dataBody = {
                approval: [
                    { jenisApproval: "disetujui", approvalOrder: 1, approvalId: $("#disetujui1").val()},
                    { jenisApproval: "diketahui", approvalOrder: 1, approvalId: $("#diketahui1").val()},
                    { jenisApproval: "diketahui", approvalOrder: 2, approvalId: $("#diketahui2").val()}
                ],
                isSetuju: $("#persetujuan").val(),
                alasanMenolak: $("input[type='radio'][name='alasanMenolak']:checked").val() || null,
                textAlasan: $("#alasanLain").val(),
                komitmenId: {{ Illuminate\Support\Js::from($komitmenId) }}
            }

            console.log(dataBody)

            
            let validasiInput = validateForm()
            if(validasiInput.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: validasiInput.join("<br>")
                })
                e.target.disabled = false
            } else {
                showLoading()
                axios.post(url, dataBody, {
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
                            backdrop: false,
                            icon: 'error',
                            title: 'Gagal!',
                            text: resp.data.message || 'Error, coba beberapa saat lagi'
                        }
                    }
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
            }
        }

        function validateForm() {
            let errList = []
            if($("#persetujuan").val() == "") errList.push("Persetujuan Kosong")
            
            if($("#persetujuan").val() == "-1") {
                if(!$("input[type='radio'][name='alasanMenolak']:checked").val()) errList.push("Alasan Menolak training kosong")
            } else if($("#persetujuan").val() == "1"){
                if($("#disetujui1").val() == "") errList.push("Kabag / Kasi Dept kosong")
                if($("#diketahui1").val() == "") errList.push("Kabag / Kasi ICGS kosong")
                if($("#diketahui2").val() == "") errList.push("Project Manager/Kadept Dept")
            }

            return errList
        }

        $(document).ready(function() {
            $("#persetujuan").on('change', function(e){
                console.log(e.target.value)
                if(e.target.value == 1) {
                    $("#fieldMenolak").hide()
                } else {
                    $("#fieldMenolak").show()
                }
            })
        })

        function approveAct(e, nilai) {
            console.log(nilai)
            e.target.disabled = true
            let bodyReq = {
                komitmenId: {{ Illuminate\Support\Js::from($komitmenId) }},
                approvalId: {{ Illuminate\Support\Js::from($currentApproval['id']) }},
                status: nilai,
                keterangan: ""
            }
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
                                backdrop: false,
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