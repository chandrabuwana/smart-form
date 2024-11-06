@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link href="{{ asset('master/css/app-baf8d111.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="{{ asset('master/js/app-e576488e.js') }}"></script> --}}
    {{-- @vite('resources/css/app.css') --}}
    <style>
        /* .form-control {
            border: 1px solid;
            padding: 4px;
        } */
        /* .form-control:focus {
            border: 1px solid;
        } */
        .ml-16px {
            margin-left: 16px;
        }
        .mb-8px {
            margin-bottom: 8px;
        }
        .display-block {
            display: block;
        }
        .m-0 {
            margin: 0;
        }
        .text-right {
            text-align: right;
        }
        .input-text {

            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
        }
        .input-text:focus {
            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
        }
        .reset-border {
            border: 0;
        }
        .w-full {
            width: 100%
        }
        .collapse {
            visibility: visible;
        }
        .mouse-click {
            cursor: pointer;
        }
    </style>

@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form Timesheet Produksi</h6>
                    </div>
                </div>

                <div class="card-body my-1">
                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Requested NIK : <span id="requestor">{{ session('user_id') }}</span>
                                </p>
                                <p class="mb-0 fw-bold text-sm">
                                    Requested Name : <span id="requestor">{{ session('username') }}</span>
                                </p>
                                <div class="mb-3 mt-3">
                                    <span class="fw-bold">Pengawas</span>
                                    <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputPengawas" name="inputPengawas">
                                            <option value="" selected>-- Pilih Pengawas --</option>
                                        @foreach($data_pengawas as $pengawas)
                                            <option value="{{ $pengawas->nik }}">{{ $pengawas->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="w-full">
                                <tr>
                                    <td>Site</td>
                                    <td>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputSite" name="inputSite">
                                            <option value="">-- Pilih Site --</option>
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
                                        <!--<input type="text" class="input-text w-full" id="inputSite">-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hari</td>
                                    <td><input type="text" class="input-text w-full" id="inputHari" disabled></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td><input type="date" class="input-text w-full" id="inputTanggal"></td>
                                </tr>
                                <tr>
                                    <td>Shift</td>
                                    <td>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputShift" name="inputDepartment">
                                            <option value="DS">Day Shift (DS)</option>
                                            <option value="NS">Night Shift (NS)</option>
                                        </select>
                                        {{-- <input type="text" class="input-text w-full" id="inputShift"> --}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-4">
                            <table class="w-full">
                                <tr>
                                    <td>No. Unit</td>
                                    <td><input type="text" class="input-text w-full" id="inputNoUnit"></td>
                                </tr>
                                <tr>
                                    <td>Driver</td>
                                    <td><input type="text" class="input-text w-full" id="inputDriver" value="{{ session('username') }}" disabled></td>
                                </tr>
                                <tr>
                                    <td>HM Awal</td>
                                    <td><input type="text" class="input-text w-full" id="inputAwalHM" disabled></td>
                                </tr>
                                <tr>
                                    <td>HM Akhir</td>
                                    <td><input type="text" class="input-text w-full" id="inputAkhirHM" disabled></td>
                                </tr>
                            </table>
                        </div>

                        <div class="w-1/2 md:w-1/6">
                            <span>Jam</span>
                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputJam" name="inputDepartment">
                                <option value="aa" selected>06:00-07:00</option>
                                <option value="ab">18:00-19:00</option>
                                <option value="ba">07:00-08:00</option>
                                <option value="bb">19:00-20:00</option>
                                <option value="ca">08:00-09:00</option>
                                <option value="cb">20:00-21:00</option>
                                <option value="da">09:00-10:00</option>
                                <option value="db">21:00-22:00</option>
                                <option value="ea">10:00-11:00</option>
                                <option value="eb">22:00-23:00</option>
                                <option value="fa">11:00-12:00</option>
                                <option value="fb">23:00-24:00</option>
                                <option value="ga">12:00-13:00</option>
                                <option value="gb">24:00-01:00</option>
                                <option value="ha">13:00-14:00</option>
                                <option value="hb">01:00-02:00</option>
                                <option value="ia">14:00-15:00</option>
                                <option value="ib">02:00-03:00</option>
                                <option value="ja">15:00-16:00</option>
                                <option value="jb">03:00-04:00</option>
                                <option value="ka">16:00-17:00</option>
                                <option value="kb">04:00-05:00</option>
                                <option value="la">17:00-18:00</option>
                                <option value="lb">05:00-06:00</option>
                            </select>
                        </div>
                        <div class="w-1/2 md:w-1/6">
                            <span>RIT (Menit ke)</span>
                            <input class="input-text display-block w-full" aria-label="Default select example" id="inputMenitRit" name="inputMenitRit" placeholder="Menit ke 0 - 59">
                            </input>
                        </div>
                        <div class="col-md-4">
                            <span>Problem</span>
                            <input type="text" class="input-text display-block w-full" id="inputProblem">
                        </div>
                        <div class="col-md-4">
                            <span>Material & Seam</span>
                            <input type="text" class="input-text display-block w-full" id="inputMaterialSeam">
                        </div>
                        <div class="w-1/2 md:w-1/6">
                            <span>Blok</span>
                            <input type="text" class="input-text display-block w-full" id="inputBlok">
                        </div>

                        <div class="w-1/2 md:w-1/6">
                            <span>Kode Aktifitas</span>
                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputKodeAktifitas" name="inputKodeAktifitas">
                                <option value="S1" selected>S1 - Overshift/P5M</option>
                                <option value="S2">S2 - Hujan, Licin</option>
                                <option value="S3">S3 - Blasting</option>
                                <option value="S4">S4 - No Driver</option>
                                <option value="S5">S5 - P2H</option>
                                <option value="S6">S6 - Tunggu Alat Lain</option>
                                <option value="S7">S7 - Isi Solar</option>
                                <option value="S8">S8 - Berdebu</option>
                                <option value="S9">S9 - Perbaikan Jalan</option>
                                <option value="S10">S10 - Kabut</option>
                                <option value="S11">S11 - Cuci Unit</option>
                                <option value="S12">S12 - Demo</option>
                                <option value="S13">S13 - Insident</option>
                                <option value="S14">S14 - Antrian Timbangan</option>
                                <option value="S15">S15 - Antrian Di Pit</option>
                                <option value="S16">S16 - Stock File Penuh</option>
                                <option value="S17">S17 - Makan & Istirahat</option>
                                <option value="S18">S18 - No Coal</option>
                                <option value="S19">S19 - Perbaikan Front</option>
                                <option value="S20">S20 - Lain-lain</option>
                            </select>
                            {{-- <input type="text" class="input-text display-block w-full" id="inputKodeAktifitas"> --}}
                        </div>
                        <div class="w-1/2 md:w-1/6">
                            <span>Awal</span>
                            <input type="text" class="input-text display-block w-full" id="inputAwal">
                        </div>
                        <div class="w-1/2 md:w-1/6 mb-4">
                            <span>Akhir</span>
                                <input type="text" class="input-text display-block w-full" id="inputAkhir">
                        </div>
                        <button class="btn btn-primary w-auto" id="btn-add-item">
                            <i class="fas fa-plus"></i>
                            item
                        </button>
                    </div>

                    <table id="item-asset" class="display" data-toggle="table">
                        <thead>
                            <tr>
                                <th data-field="jam" data-formatter="jamMapper">Jam</th>
                                <th data-field="rit_menit">Rit (Menit Ke)</th>
                                <th data-field="problem">Problem</th>
                                {{-- <th data-field="durasi">Durasi</th> --}}
                                <th data-field="mns">Material & Seam</th>
                                <th data-field="blok">Blok</th>
                                <th data-field="kd_aktifitas">Kode Aktifitas</th>
                                <th data-field="awal">Awal</th>
                                <th data-field="akhir">Akhir</th>
                                <th data-formatter="actionFormatter" data-align="center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                    <table id="summary-rit" class="w-auto mt-4" data-toggle="table">
                        <thead>
                            <tr>
                                <th data-width="30" data-field="jam" data-formatter="jamMapper">Jam</th>
                                <th data-width="30"  data-field="total_rit">Total RIT</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitForm">
                            <i class="fas fa-save"></i>
                            Submit Form
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var hariMapping = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        var btnSubmitForm = $("#btnSubmitForm");
        var $table = $("#item-asset");
        var $tableSummaryRit = $("#summary-rit");
        var $btnAddItem = $("#btn-add-item");
        var inputSite = $("#inputSite");
        var inputHari = $("#inputHari");
        var inputTanggal = $("#inputTanggal");
        var inputShift = $("#inputShift");
        var inputNoUnit = $("#inputNoUnit");
        var inputDriver = $("#inputDriver");
        var inputAwalHM = $("#inputAwalHM");
        var inputAkhirHM = $("#inputAkhirHM");

        var inputJam = $("#inputJam");
        var inputMenitRit = $("#inputMenitRit");
        var inputMaterialSeam = $("#inputMaterialSeam");
        var inputKodeAktifitas = $("#inputKodeAktifitas");
        var inputProblem = $("#inputProblem");
        var inputBlok = $("#inputBlok");
        var inputAwal = $("#inputAwal");
        var inputAkhir = $("#inputAkhir");
        var inputPengawas = $("#inputPengawas");

        var optionJam = {
            DS: [
                { value: 'aa', text: '06:00-07:00' },
                { value: 'ba', text: '07:00-08:00' },
                { value: 'ca', text: '08:00-09:00' },
                { value: 'da', text: '09:00-10:00' },
                { value: 'ea', text: '10:00-11:00' },
                { value: 'fa', text: '11:00-12:00' },
                { value: 'ga', text: '12:00-13:00' },
                { value: 'ha', text: '13:00-14:00' },
                { value: 'ja', text: '14:00-15:00' },
                { value: 'ka', text: '15:00-16:00' },
                { value: 'la', text: '16:00-17:00' },
                { value: 'ma', text: '17:00-18:00' },
            ],
            NS: [
                { value: 'ab', text: '18:00-19:00' },
                { value: 'bb', text: '19:00-20:00' },
                { value: 'cb', text: '20:00-21:00' },
                { value: 'db', text: '21:00-22:00' },
                { value: 'eb', text: '22:00-23:00' },
                { value: 'fb', text: '23:00-00:00' },
                { value: 'gb', text: '00:00-01:00' },
                { value: 'hb', text: '01:00-02:00' },
                { value: 'jb', text: '02:00-03:00' },
                { value: 'kb', text: '03:00-04:00' },
                { value: 'lb', text: '04:00-05:00' },
                { value: 'mb', text: '05:00-06:00' },
            ]
        };

        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        inputTanggal.val(getTodayDate());
        inputHari.val(hariMapping[new Date(getTodayDate()).getDay()])

        function jamMapper(value, row, index) {
            // console.log("jamMapper " + value)
            var nilai = "";
            switch (value) {
                case "aa":
                    nilai = "06:00-07:00"
                    break;
                case "ab":
                    nilai = "18:00-19:00"
                    break;
                case "ba":
                    nilai="07:00-08:00"
                    break;
                case "bb":
                    nilai="19:00-20:00"
                    break;
                case "ca":
                    nilai="08:00-09:00"
                    break;
                case "cb":
                    nilai="20:00-21:00"
                    break;
                case "da":
                    nilai="09:00-10:00"
                    break;
                case "db":
                    nilai="21:00-22:00"
                    break;
                case "ea":
                    nilai="10:00-11:00"
                    break;
                case "eb":
                    nilai="22:00-23:00"
                    break;
                case "fa":
                    nilai="11:00-12:00"
                    break;
                case "fb":
                    nilai="23:00-24:00"
                    break;
                case "ga":
                    nilai="12:00-13:00"
                    break;
                case "gb":
                    nilai="24:00-01:00"
                    break;
                case "ha":
                    nilai="13:00-14:00"
                    break;
                case "hb":
                    nilai="01:00-02:00"
                    break;
                case "ia":
                    nilai="14:00-15:00"
                    break;
                case "ib":
                    nilai="02:00-03:00"
                    break;
                case "ja":
                    nilai="15:00-16:00"
                    break;
                case "jb":
                    nilai="03:00-04:00"
                    break;
                case "ka":
                    nilai="16:00-17:00"
                    break;
                case "kb":
                    nilai="04:00-05:00"
                    break;
                case "la":
                    nilai="17:00-18:00"
                    break;
                case "lb":
                    nilai="05:00-06:00"
                    break;
                default:
                    break;
            }

            return nilai;
        }

        function actionFormatter(value, row, index) {
            return `
                <i class="fas fa-circle-minus text-red-800 fa-2x mouse-click" onclick="deleteRow(${index})"></i>
            `;
        }

        function deleteRow(id) {
            $table.bootstrapTable('remove', {
                field: '$index',
                values: [id]
            })
        }

        function validateForm() {
            var errorList = []
            var validateError = {
                field: "",
                message: ""
            }

            $("#inputSite").val($("#inputSite").val().trim())
            $("#inputNoUnit").val($("#inputNoUnit").val().trim())
            $("#inputAwalHM").val($("#inputAwalHM").val().trim())
            $("#inputAkhirHM").val($("#inputAkhirHM").val().trim())

            if($("#inputSite").val().length < 1) {
                errorList.push({field: "Site", message: "Site tidak boleh kosong"})
            }
            if($("#inputNoUnit").val().length < 1) {
                errorList.push({field: "Nama & No. Unit", message: "Nama & No. Unit tidak boleh kosong"})
            }
            if($("#inputAwalHM").val().length < 1) {
                errorList.push({field: "HM Awal", message: "HM Awal tidak boleh kosong"})
            }
            if($("#inputAkhirHM").val().length < 1) {
                errorList.push({field: "HM Akhir", message: "HM Akhir tidak boleh kosong"})
            }
            if($("#inputPengawas").val().length < 1 || $("#inputPengawas").val() == "") {
                errorList.push({field: "Pengawas", message: "Pengawas belum dipilih"})
            }

            return errorList;
        }

        function validateItem() {
            var errorList = []
            var validateError = {
                field: "",
                message: ""
            }

            $("#inputMenitRit").val($("#inputMenitRit").val().trim())
            $("#inputMaterialSeam").val($("#inputMaterialSeam").val().trim())
            $("#inputBlok").val($("#inputBlok").val().trim())
            $("#inputKodeAktifitas").val($("#inputKodeAktifitas").val().trim())
            $("#inputAwal").val($("#inputAwal").val().trim())
            $("#inputAkhir").val($("#inputAkhir").val().trim())

            if($("#inputMenitRit").val().length < 1) {
                errorList.push({field: "RIT (Menit ke)", message: "RIT (Menit ke) tidak boleh kosong"})
            }
            if(!($("#inputMenitRit").val() >= 0 && $("#inputMenitRit").val() < 60)) {
                errorList.push({field: "RIT (Menit ke)", message: "RIT (Menit ke) hanya bernilai 0 - 59"})
            }
            if($("#inputMaterialSeam").val().length < 1) {
                errorList.push({field: "Material & Sam", message: "Material & Sam tidak boleh kosong"})
            }
            if($("#inputBlok").val().length < 1) {
                errorList.push({field: "Blok", message: "Blok tidak boleh kosong"})
            }
            if($("#inputKodeAktifitas").val().length < 1) {
                errorList.push({field: "Kode Aktifitas", message: "Kode Aktifitas tidak boleh kosong"})
            }
            if($("#inputAwal").val().length < 1) {
                errorList.push({field: "Awal", message: "Awal tidak boleh kosong"})
            }
            if($("#inputAkhir").val().length < 1) {
                errorList.push({field: "Akhir", message: "Akhir tidak boleh kosong"})
            }
            if(isNaN(parseInt($("#inputAwal").val()))) {
                errorList.push({field: "Awal", message: "Awal hanya boleh angka"})
            }
            if(isNaN(parseInt($("#inputAkhir").val()))) {
                errorList.push({field: "Akhir", message: "Akhir hanya boleh angka"})
            }

            return errorList;
        }

        function updateJam(shift) {
            const optionSelect = document.getElementById('inputJam');
            const selectedType = shift;

            // Hapus semua opsi yang ada
            optionSelect.innerHTML = '';

            // Jika tipe dipilih, tambahkan opsi baru berdasarkan pilihan
            if (selectedType && optionJam[selectedType]) {
                optionJam[selectedType].forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option.value;
                    opt.textContent = option.text;
                    optionSelect.appendChild(opt);
                });
            }
        }

        inputShift.change(function(e) {
            updateJam(e.target.value)
        })

        $table.on('post-body.bs.table', function(data) {
            var items = {}
            var awal = []
            var akhir = []

            $tableSummaryRit.bootstrapTable('removeAll')
            data.sender.data.forEach(function (item, index, arr) {
                // console.log(item)
                items[item.jam] = item.jam in items ? items[item.jam] + 1 : 1;
                awal.push(item.awal)
                akhir.push(item.akhir)
            })

            for(var key in items) {
                // console.log(key, items[key])
                $tableSummaryRit.bootstrapTable('append', {
                    jam: key,
                    total_rit: items[key]
                })
            }
            var minAwal = awal.length > 0 ? Math.min(...awal) : 0;
            var maxAkhir = akhir.length > 0 ? Math.max(...akhir) : 0;
            inputAwalHM.val(minAwal)
            inputAkhirHM.val(maxAkhir)
            // console.log(data.sender.data)
            // console.log({minAwal, maxAkhir})

        })
        document.getElementById("inputTanggal").addEventListener("change", function(e) {
            var tgl = new Date(e.target.value);
            // console.log(hariMapping[tgl.getDay()])
            inputHari.val(hariMapping[tgl.getDay()])
        })
        $(function() {
            inputPengawas.select2()
            updateJam(inputShift.val())
            $btnAddItem.click(function(e) {
                e.preventDefault()
                var validasiItem = validateItem()
                if(validasiItem.length > 0) {
                    var msg = "";
                    for (var listErr of validasiItem) {
                        msg = msg + "<p>" + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg
                    }).then((result) => {

                    })
                } else {
                    $table.bootstrapTable('sortBy', {
                        field: "jam",
                        sortOrder: "asc"
                    })

                    $table.bootstrapTable('append', {
                        jam: inputJam.val(),
                        rit_menit: inputMenitRit.val(),
                        mns: inputMaterialSeam.val(),
                        kd_aktifitas: inputKodeAktifitas.val(),
                        problem: inputProblem.val(),
                        awal: inputAwal.val(),
                        akhir: inputAkhir.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                }
            })

            btnSubmitForm.click(function(e) {
                e.preventDefault()
                var validasi = validateForm()
                if(validasi.length > 0) {
                    var msg = "";
                    for (var listErr of validasi) {
                        msg = msg + "<p>" + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg
                    }).then((result) => {
                        // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                    })
                } else {
                    var detailData = $table.bootstrapTable('getData');
                    var dataReq = {
                        site: inputSite.val(),
                        hari: inputHari.val(),
                        tanggal: inputTanggal.val(),
                        shift: inputShift.val(),
                        noUnit: inputNoUnit.val(),
                        driver: inputDriver.val(),
                        awalHM: inputAwalHM.val(),
                        akhirHM: inputAkhirHM.val(),
                        problem: inputProblem.val(),
                        blok: inputBlok.val(),
                        totalRit: detailData.length,
                        pengawas: inputPengawas.val(),
                        detail: detailData
                    }

                    axios.post('/bss-form/timesheet/submit-form', dataReq, {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    })
                    .then(function (response) {
                        var data = {
                            icon: 'error',
                            title: '',
                            text: ''
                        }
                        if(response.data.isSuccess) {
                            data.icon = 'success'
                            data.title = "Berhasil!"
                            data.text = response.data.message

                            Swal.fire(data).then((result) => {
                                window.location.href = "/bss-form/timesheet/dashboard";
                                // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                            })
                        } else {
                            data.icon = 'error'
                            data.title = "Gagal!"
                            data.text = response.data.message

                            Swal.fire(data).then((result) => {
                            })
                        }
                    })
                    .catch(function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan, coba beberapa saat lagi'
                        }).then((result) => {
                            // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                        })
                    });
                }
            })
        })
    </script>
@endsection
