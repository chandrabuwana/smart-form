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
                                    <tr>
                                        <td>No Kupon</td>
                                        <td><input type="text" class="input-text w-full" id="i_kupon" name="i_kupon"></td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td><input type="text" class="input-text w-full" id="i_nama" value="{{ session('username') }}" disabled></td>
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
                                        <td><input type="text" class="input-text w-full" id="i_departemen" name="i_departemen"></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td><input type="date" class="input-text w-full" id="i_tgl" name="i_tgl"></td>
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
                                <td><input type="text" class="input-text w-full" id="i_jam" name="i_jam"></td>
                                <!-- <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputJam" name="inputJam">
                                    <option value="" selected>-- Pilih Jam --</option> 
                                    <option value="aa">06:00-07:00</option>
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
                                </select> -->
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
                                    <input type="text" class="input-text w-full" id="i_hm" name="i_hm">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>KM</span>
                                    <input type="text" class="input-text w-full" id="i_km" name="i_km">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Awal</span>
                                    <input type="text" class="input-text w-full" id="i_awal" name="i_awal">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Akhir</span>
                                    <input type="text" class="input-text w-full" id="i_akhir" name="i_akhir">
                            </div>
                            <div class="w-1/2 md:w-1/6">
                                <span>Total Liter</span>
                                    <input type="text" class="input-text w-full" id="i_total_liter" name="i_total_liter">
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
