@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link href="{{ asset('master/css/app-baf8d111.css') }}" rel="stylesheet" />
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
                        <div class="row gx-4">
                            <div class="col-auto my-auto ms-3">
                                <div class="h-100">
                                    <p class="mb-0 fw-bold text-sm">
                                        Requested NIK : <span id="requestor">{{ $data['nik'] }}</span>
                                    </p>
                                    <p class="mb-0 fw-bold text-sm">
                                        Requested Name : <span id="requestor">{{ $data['driver'] }}</span>
                                    </p>
                                    <div class="mb-3 mt-3">
                                        <span class="fw-bold">Pengawas</span>
                                        <input type="text" class="input-text w-full" id="inputPengawas" disabled value="{{ $data['pengawas_nama'] }}">
                                    </div>
                                    
                                    @if($data['pengawas'] == session('user_id'))
                                        @if($data['status'] == null || $data['status'] == 'null' || $data['status'] == 1 || $data['status'] == '1')
                                            <div>
                                                <a href="#" onclick="submitActionPengawas(this)" data-action="approve"><button class="btn btn-primary btn-action text-white">Approve</button></a>
                                                <a href="#" onclick="submitActionPengawas(this)" data-action="reject"><button class="btn btn-secondary btn-action text-white">Reject</button></a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="w-full">
                                <tr>
                                    <td>Site</td>
                                    <td><input type="text" class="input-text w-full" id="inputSite" disabled value="{{ $data['site'] }}"></td>
                                </tr>
                                <tr>
                                    <td>Hari</td>
                                    <td><input type="text" class="input-text w-full" id="inputHari" disabled value="{{ $data['hari'] }}"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td><input type="text" class="input-text w-full" id="inputTanggal" disabled value="{{ $data['tanggal'] }}"></td>
                                </tr>
                                <tr>
                                    <td>Shift</td>
                                    <td><input type="text" class="input-text w-full" id="inputShift" disabled value="{{ $data['shift'] }}"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-4">
                            <table class="w-full">
                                <tr>
                                    <td>Nama & No. Unit</td>
                                    <td><input type="text" class="input-text w-full" id="inputNamaNoUnit" disabled value="{{ $data['no_unit'] }}"></td>
                                </tr>
                                <tr>
                                    <td>Driver</td>
                                    <td><input type="text" class="input-text w-full" id="inputDriver" disabled value="{{ $data['driver'] }}"></td>
                                </tr>
                                <tr>
                                    <td>HM Awal</td>
                                    <td><input type="text" class="input-text w-full" id="inputAwalHM" disabled value="{{ $data['hm_awal'] }}"></td>
                                </tr>
                                <tr>
                                    <td>HM Akhir</td>
                                    <td><input type="text" class="input-text w-full" id="inputAkhirHM" disabled value="{{ $data['hm_akhir'] }}"></td>
                                </tr>
                            </table>
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
                            </tr>
                        </thead>
                    </table>
                    <table id="summary-rit" class="w-auto mt-4" data-toggle="table" data-show-footer="true" data-footer-style="footerStyle">
                        <thead>
                            <tr>
                                <th data-width="30" data-field="jam" data-formatter="jamMapper" data-footer-formatter="totalRitase">Jam</th>
                                <th data-width="30"  data-field="total_rit" data-footer-formatter="ritSum">Total RIT</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <span id="id_timesheet" style="display: none">{{ $data['id'] }}</span>

                {{-- <div class="card-footer">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitForm">
                            <i class="fas fa-save"></i>
                            Submit Form
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
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
        var idDokumen= $("#id_timesheet");
        
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

        function totalRitase(data) {
            return "Total";
        }
        function ritSum(data) {
            var field = this.field
            return data.map(function (row) {
                return + row[field]
            }).reduce(function (sum, i) {
                return sum + i
            }, 0)
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
        var dataDetail = {{ Illuminate\Support\Js::from($data_detail) }}
        // console.log(dataDetail)
        function submitActionPengawas(e) {
            var selectedActionPengawas = e.getAttribute("data-action");
            var dialogTitle = selectedActionPengawas.split('')
            dialogTitle[0] = dialogTitle[0].toUpperCase()
            dialogTitle = dialogTitle.join("")


            Swal.fire({
                title: dialogTitle,
                text: "Konfirmasi aksi " + dialogTitle + "?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#7b809a",
                confirmButtonText: "Yes, " + dialogTitle + "!",
                cancelButtonText: "Batal"
            })
            .then((result) => {
                if (result.isConfirmed) {
                    actionResult = {
                        title: "",
                        // text: "",
                        icon: ""
                    }
                    axios.post('/bss-form/timesheet/submit-action-pengawas', {
                        id_timesheet: idDokumen.text(),
                        action: selectedActionPengawas
                    }, {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
                        .then(function(resp) {
                            // console.log(resp.data)
                            if(resp.data.isSuccess) {
                                actionResult.title = dialogTitle
                                actionResult.text = "Berhasil melakukan " + dialogTitle
                                actionResult.icon = "success"
                            } else {
                                actionResult.title = dialogTitle
                                // actionResult.text = "Gagal melakukan" + dialogTitle
                                actionResult.html = "Gagal melakukan " +dialogTitle + "<br>" + resp.data.errorMessage
                                actionResult.icon = "error"
                            }
                        })
                        .catch(function(err) {
                            actionResult.title = dialogTitle
                            actionResult.text = "Terjadi kesalahan, coba beberapa saat lagi!"
                            actionResult.icon = "error"
                        })
                        .finally(function() {
                            Swal.fire(actionResult)
                                .then(function() {
                                    if(actionResult.icon == "success") {
                                        location.reload();
                                    }
                                });
                        })
                }
            })
            
        }
        $(function() {
            dataDetail.forEach(element => {
                $table.bootstrapTable('append', element)
            });
        })
    </script>
@endsection