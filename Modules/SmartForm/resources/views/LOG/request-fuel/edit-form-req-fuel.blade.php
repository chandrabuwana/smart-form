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
            <form class="card my-4" id="formRequestFuel">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Form Permintaan Pengisian Fuel</h6>
                        </div>
                    </div>

                    <div class="card-body my-1">
                        <div class="row gx-4">
                            <div class="col-auto my-auto ms-3">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="w-full">
                                    <input type="text" class="input-text w-full" id="tglDoc" name="tglDoc" value="{{$data['id']}}" hidden>
                                    <tr>
                                        <td>Date</td>
                                        <td>
                                            <input type="text" class="input-text w-full" id="tglDoc" name="tglDoc" value="{{$data['tanggal']}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>
                                            <input type="text" class="input-text w-full" id="i_jabatan" name="i_jabatan" value="{{$data['jabatan']}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td><input type="text" class="input-text w-full" id="i_nik" value="{{$data['dibuat_oleh']}}" disabled></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 mb-4">
                                <table class="w-full">
                                    <tr>
                                        <td>Departemen</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="i_departemen" name="i_departemen">
                                            <option value="{{$data['departemen']}}" selected>{{$data['departemen']}}</option>    
                                                <option value="ENG">ENGINEERING</option>
                                                <option value="SHE">SHE</option>
                                                <option value="PRD">PRODUKSI</option>
                                                <option value="SM">SM</option>
                                                <option value="IC">IC</option>
                                                <option value="GS">GS</option>
                                                <option value="RM">PLANT</option>
                                                <option value="BDV">BUSDEV</option>
                                                <option value="FIN">FINANCE</option>
                                                <option value="ATA">Accounting & Tax</option>
                                                <option value="DTC">DATA CENTER</option>
                                                <option value="MM">LOGISTIK</option>
                                                <option value="OPR">OPERATION</option>
                                                <option value="LEG">LEGAL</option>
                                                <option value="OD">ORGANIZATION DEVELOPMENT</option>
                                                <option value="Z001">ASSESSMENT CENTER</option>
                                                <option value="Z002">LABOR SUPPLY</option>
                                                <option value="Z003">MANAGEMENT CONSULTANT</option>
                                                <option value="Z004">SERTIFIKASI</option>
                                                <option value="TC">TRAINING CENTER</option>
                                        </select>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td><input type="text" class="input-text w-full" id="i_nama" value="{{$data['nama']}}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>No Lambung</td>
                                        <td><input type="text" class="input-text w-full" id="i_no_lambung" name="i_no_lambung" value="{{$data['no_lambung']}}"></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kendaraan</td>
                                        <td><input type="text" class="input-text w-full" id="i_jenis_kendaraan" name="i_jenis_kendaraan" value="{{$data['jenis_kendaraan']}}"></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- ====================================== -->
                            <div class="w-1/2 md:w-1/6">
                                <span>Jam</span>
                                    <input  type="time" class="input-text w-full" id="iJam" name="iJam" value="{{$data['jam']}}">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Shift</span>
                                <select class="form-select form-select-sm input-text" aria-label="Default select example" id="i_shift" name="i_shift">
                                    <option value="{{$data['shift']}}"selected>{{$data['shift']}}</option>    
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                </select> 
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>HM</span>
                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_hm" name="i_hm" value="{{$data['hm']}}">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>KM</span>
                                    <input  type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_km" name="i_km" value="{{$data['km']}}">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Flow Meter Awal</span>
                                    <input  type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_awal" name="i_awal" value="{{$data['awal']}}">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Flow Meter Akhir</span>
                                    <input  type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_akhir" name="i_akhir" value="{{$data['akhir']}}">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Total Liter</span>
                                    <input  type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_total_liter" name="i_total_liter" value="{{$data['total_liter']}}">
                            </div>
                        </div>

                    <table style="width:100%" >
                          <tr>
                            <td>Diisi Oleh/Filled by,</td>
                            <td>: {{ session('username') }} {{ session('user_id') }}
                            </td>
                            <td>Diserahkan Oleh, :</td>
                            <td> 
                                <select name="dDiterima" class="form-control text-center" required>
                                    <option value="{{$data['diserahkan_oleh']}}">{{$data['diserahkan_oleh']}}</option>
                                    @foreach($approvalList as $user)
                                        <option value="{{ $user->nama }}">
                                            {{ $user->nama }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>Diterima Oleh, :</td>
                            <td>
                                <select name="dApproved" class="form-control text-center" required>
                                    <option value="{{$data['diterima_oleh']}}">{{$data['diterima_oleh']}}</option>
                                    @foreach($approvalList as $user)
                                        <option value="{{ $user->nama }}">
                                            {{ $user->nama }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                          </tr>
                    </table>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitFormRequestFuel">
                                <i class="fas fa-save"></i>
                                Submit Form
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var tglNow = new Date()
        var mudof = new Date();
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var months_angka = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
        var tanggalSekarang = $("#tanggalSekarang")
        var iKupon = $("#iKupon");
        var tglDoc = $("#tglDoc");

        var dataForm = {
            formName: "Data Form",
            id: "",
            dibuat_oleh: "",
            tanggal: ""
        }

        //  END MEMBUAT NO KUPON URUT FORMAT YYMM000x

        tanggalSekarang.attr('min', getTodayDate())

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }
        
        $(function() {

            iAkhir.change(function(e) {
                iTotalLiter.text((iAkhir.val()) - (iAwal.val() ))
            });

            tStokAwal.change(function(e) {
                tTotalAkhir.text((tStokAwal.val()) - (parseInt(tTotals.text())))
            });
            
            if(isError.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: isError.errorMessage,
                }).then((result) => {

                })
            } else {
                console.log({{ Illuminate\Support\Js::from($data) }})
                
                tglDoc.val({{ Illuminate\Support\Js::from( $data['tanggal']) }})

                dataForm.tanggal = tglDoc.val()

            }

            function validateForm() {
                var errorValidate = []
                
                if(iForeman.val() == ""){
                    errorValidate.push({
                        field: "Kolom Foreman",
                        message: "Harus dipilih"
                    })
                }
                if(tStokAwal.val() == "") {
                    errorValidate.push({
                        field: "Kolom Stok Awal",
                        message: "Harus Diisi"
                    })
                }
                if(tMasuk.val() == "") {
                    errorValidate.push({
                        field: "Kolom Masuk",
                        message: "Harus Diisi"
                    })
                }
                if(iFuel.val() == ""){
                    errorValidate.push({
                        field: "Kolom Fuel",
                        message: "Harus diisi"
                    })
                }
                if(iShift.val() == ""){
                    errorValidate.push({
                        field: "Kolom Shift",
                        message: "Harus dipilih"
                    })
                }

                return errorValidate
            }

            btnSubmitSolar.click(function(e) {
                e.preventDefault();
                var errValidate = validateForm()
                if(errValidate.length > 0) {
                    var msg = ""
                    for (var listErr of errValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg,
                    }).then((result) => {
                        // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                    })
                } else {
                    var dataReq = {
                        formName: dataPemakaianSolar.formName,
                        id: tglDoc.val(),
                        jobSite: iJobSite.val(),
                        noDoc: noDoc.text(),
                        tglDoc: formatTgl(),
                        approval: dApproved.val(),
                        shift: iShift.val(),
                        total_pemakaian: tTotals.val(),
                        stokAwal: tStokAwal.val(),
                        stokAkhir: tTotalAkhir.text(),
                        status: "Need Approval",
                        masuk: tMasuk.val(),
                        fuel: iFuel.val()
                    }
                    
                    // TODO
                    axios.post('/bss-form/log/update-req-fuel?id='+id.text(), formData, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        console.log(response.data)
                        showLoading()
                        Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Diperbarui!',
                                // text: response.data.data,
                            }).then((result) => {
                                window.location.href = `/bss-form/log/request-fuel/dashboard-request-fuel`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function() {
                        stopLoading()
                    })
                }
                // submitAssetRequest(dataReq);
            })
        })
    </script>
@endsection
