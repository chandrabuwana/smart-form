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
            <form class="card my-4" method="POST" id="formRequestFuel">
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
                                        <td><input type="text" class="input-text w-full" id="iKupon" name="iKupon" hidden></td>
                                    <tr>
                                        <td>Date</td>
                                        <td><input type="text" class="input-text w-full" id="tglDoc" name="tglDoc"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Jabatan</td>
                                        <td><input type="text" class="input-text w-full" id="i_jabatan" name="i_jabatan"></td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td><input type="text" class="input-text w-full" id="i_nik" value="{{ session('user_id') }}" disabled></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 mb-4">
                                <table class="w-full">
                                    <tr>
                                        <td>Departemen</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="i_departemen" name="i_departemen">
                                            <option value="" selected>-- Pilih Departemen --</option>    
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
                                        <td><input type="text" class="input-text w-full" id="i_nama" value="{{ session('username') }}" disabled></td>
                                    </tr>
                                    <tr>
                                        <td>No Lambung</td>
                                        <td><input type="text" class="input-text w-full" id="i_no_lambung" name="i_no_lambung"></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kendaraan</td>
                                        <td><input type="text" class="input-text w-full" id="i_jenis_kendaraan" name="i_jenis_kendaraan"></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- ====================================== -->
                            <div class="w-1/2 md:w-1/6">
                                <span>Jam</span>
                                    <input  type="time" class="input-text w-full" id="iJam" name="iJam">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Shift</span>
                                <select class="form-select form-select-sm input-text" aria-label="Default select example" id="i_shift" name="i_shift">
                                    <option value="" selected>-- Pilih Shift --</option>    
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                </select> 
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>HM</span>
                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_hm" name="i_hm">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>KM</span>
                                    <input  type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_km" name="i_km">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Awal</span>
                                    <input  type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_awal" name="i_awal">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Akhir</span>
                                    <input  type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_akhir" name="i_akhir">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Total Liter</span>
                                    <input  type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-full" id="i_total_liter" name="i_total_liter">
                            </div>
                        </div>

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

        //  START MEMBUAT NO KUPON URUT FORMAT YYMMDD000x
        function getMonth(mudof) {
            //get the month
            var month = mudof.getMonth();

            //increment month by 1 since it is 0 indexed
            //converts month to a string
            //if month is 1-9 pad right with a 0 for two digits
            month = (month + 1).toString().padStart(2, '0');

            return month;
        }

        // function getDay with 1 parameter expecting date
        // This function returns a string of type dd (example: 09 = The 9th day of the month)
        function getDay(mudof) {
            //get the day
            //convert day to string
            //if day is between 1-9 pad right with a 0 for two digits
            var day = mudof.getDate().toString().padStart(2, '0');;

            return day;
        }

        function getYear(tglNow) {
            //get the year
            var year = mudof.getFullYear();

            //pull the last two digits of the year
            year = year.toString().substr(-2);

            return year;
        }
        //A function for formatting a date to yyMMDD
        function formatNomor(mudof)
        {
            //return the string "yyMMDD"
            return getYear(mudof) + getMonth(mudof);
        }
        
        function getTodayDate() {
            const today = new Date();
            const year = today.getYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        function generateNoDoc() {
            return (formatNomor(mudof) + ( (Math.random()*100000).toFixed()));
        }
        //  END MEMBUAT NO KUPON URUT FORMAT YYMM000x

        tanggalSekarang.attr('min', getTodayDate())

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }
        $(function() {
            document.getElementById("iKupon").value=(generateNoDoc());
            document.getElementById("tglDoc").value=(formatTgl() || "-");
        })
        
        $('#btnSubmitFormRequestFuel').click( function(e) {
            e.preventDefault();
            const formData = $('#formRequestFuel').serialize();

            axios.post(`{{ isset($formRequestFuel) ? route('bss-form.log.edit-req-fuel', ['id' => $formRequestFuel->id]) : route('bss-form.log.create-req-fuel') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form Request Fuel Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('bss-form.log.fuel.dashboard') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form Permintaan Fuel'
                });
            });
        });
        
    </script>
@endsection
