@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link href="{{ asset('master/css/app-baf8d111.css') }}" rel="stylesheet" />
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
                    <div class="row">
                        <div class="col-md-6">
                            <table class="w-full">
                                <tr>
                                    <td>Site</td>
                                    <td><input type="text" class="input-text w-full" id="inputSite"></td>
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
                                    <td>Nama & No. Unit</td>
                                    <td><input type="text" class="input-text w-full" id="inputNamaNoUnit"></td>
                                </tr>
                                <tr>
                                    <td>Driver</td>
                                    <td><input type="text" class="input-text w-full" id="inputDriver"></td>
                                </tr>
                                <tr>
                                    <td>HM Awal</td>
                                    <td><input type="text" class="input-text w-full" id="inputAwalHM"></td>
                                </tr>
                                <tr>
                                    <td>HM Akhir</td>
                                    <td><input type="text" class="input-text w-full" id="inputAkhirHM"></td>
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
                            <input class="input-text display-block w-full" aria-label="Default select example" id="inputMenitRit" name="inputMenitRit">
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
                            <input type="text" class="input-text display-block w-full" id="inputKodeAktifitas">
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
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
        var inputNamaNoUnit = $("#inputNamaNoUnit");
        var inputDriver = $("#inputDriver");
        var inputAwalHM = $("#inputAwalHM");
        var inputAkhirHM = $("#inputAkhirHM");

        var inputJam = $("#inputJam");
        var inputMenitRit = $("#inputMenitRit");
        var inputMaterialSeam = $("#inputMaterialSeam");
        var inputKodeAktifitas = $("#inputKodeAktifitas");
        var inputProblem = $("#inputProblem");
        var inputAwal = $("#inputAwal");
        var inputAkhir = $("#inputAkhir");
        
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
                <i class="fas fa-circle-minus text-red-800 fa-2x" onclick="deleteRow(${index})"></i>
            `;
        }

        function deleteRow(id) {
            $table.bootstrapTable('remove', {
                field: '$index',
                values: [id]
            })
        }
        $table.on('post-body.bs.table', function(data) {
            items = {}
            $tableSummaryRit.bootstrapTable('removeAll')
            data.sender.data.forEach(function (item, index, arr) {
                items[item.jam] = item.jam in items ? items[item.jam] + 1 : 1;
            })

            for(var key in items) {
                // console.log(key, items[key])
                $tableSummaryRit.bootstrapTable('append', {
                    jam: key,
                    total_rit: items[key]
                })
            }
            // console.log(items)
        })
        document.getElementById("inputTanggal").addEventListener("change", function(e) {
            var tgl = new Date(e.target.value);
            // console.log(hariMapping[tgl.getDay()])
            inputHari.val(hariMapping[tgl.getDay()])
        })
        $(function() {
            $btnAddItem.click(function(e) {
                e.preventDefault()
                $table.bootstrapTable('sortBy', {
                    field: "jam",
                    sortOrder: "asc"
                })

                $table.bootstrapTable('append', {
                    jam: inputJam.val(),
                    menitRit: inputMenitRit.val(),
                    materialSeam: inputMaterialSeam.val(),
                    kodeAktifitas: inputKodeAktifitas.val(),
                    problem: inputProblem.val(),
                    awal: inputAwal.val(),
                    akhir: inputAkhir.val()
                })
                $table.bootstrapTable('scrollTo', 'bottom')

                // console.log({
                //     site: inputSite.val(),
                //     hari: inputHari.val(),
                //     tanggal: inputTanggal.val(),
                //     shift: inputShift.val(),
                //     namaNoUnit: inputNamaNoUnit.val(),
                //     driver: inputDriver.val(),
                //     awalHM: inputAwalHM.val(),
                //     akhirHM: inputAkhirHM.val(),
                // })

                //     jam: inputJam.val(),
                //     menitRit: inputMenitRit.val(),
                //     materialSeam: inputMaterialSeam.val(),
                //     kodeAktifitas: inputKodeAktifitas.val(),
                //     awal: inputAwal.val(),
                //     akhir: inputAkhir.val()
                // })
            })

            btnSubmitForm.click(function(e) {
                e.preventDefault()
                var detailData = $table.bootstrapTable('getData'); 
                var dataReq = {
                    site: inputSite.val(),
                    hari: inputHari.val(),
                    tanggal: inputTanggal.val(),
                    shift: inputShift.val(),
                    namaNoUnit: inputNamaNoUnit.val(),
                    driver: inputDriver.val(),
                    awalHM: inputAwalHM.val(),
                    akhirHM: inputAkhirHM.val(),
                    problem: inputProblem.val(),
                    totalRit: detailData.length,
                    detail: detailData
                }

                axios.post('/submit-form-timesheet', dataReq, {
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
                    } else {
                        data.icon = 'error'
                        data.title = "Gagal!"
                        data.text = response.data.message
                    }

                    Swal.fire(data).then((result) => {
                        // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                    })
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
            })
        })
    </script>
@endsection