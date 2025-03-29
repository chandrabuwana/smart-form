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
            <form method="POST" action="{{route('bss-form.log.update-fuel')}}">
                @csrf
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Update Permintaan Pengisian Fuel</h6>
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
                                    <input type="text" class="input-text w-full" name="idDoc" value="{{$data['id']}}" hidden>
                                    <tr>
                                        <td>Date</td>
                                        <td>
                                            <input type="text" class="input-text w-full" id="tglDoc" name="tglDoc" value="{{$data['tanggal']}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>
                                            <input type="text" class="input-text w-full" name="i_jabatan" value="{{$data['jabatan']}}">
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
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" name="i_departemen">
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
                                        <td><input type="text" class="input-text w-full" name="i_no_lambung" value="{{$data['no_lambung']}}"></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kendaraan</td>
                                        <td><input type="text" class="input-text w-full" name="i_jenis_kendaraan" value="{{$data['jenis_kendaraan']}}"></td>
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
                                    <option value="DS">DS</option>
                                    <option value="NS">NS</option>
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
                                <select name="dDiserahkan" class="form-control text-center">
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
                                <select name="dDiterima" class="form-control text-center">
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
                            <button type="submit" class="btn btn-primary ms-auto uploadBtn">
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

    </script>
@endsection
