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
            <form class="card my-4" method="POST" id="formInspeksiCatering">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Form Inspeksi Catering</h6>
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
                                    <td>
                                        <input type="text" class="input-text w-full" id="iKupon" name="iKupon" hidden>
                                    </td>
                                    <tr>
                                        <!-- <td>Date</td> -->
                                        <td><input type="text" class="input-text w-full" id="tglDoc" name="tglDoc" hidden></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Site</td>
                                        <td><input type="text" class="input-text w-full" id="tNamaSite" name="tNamaSite"></td>
                                    </tr>
                                    <tr>
                                        <td>Departemen</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dDept" name="dDept">
                                            <option value="" selected>-- Pilih Departemen --</option>
                                                <option value="SHE">SHE</option>
                                                <option value="GS">GS</option>
                                        </select>
                                    </td>
                                    <tr>
                                        <td>Shift</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dShift" name="dShift">
                                                <option value="" selected>-- Pilih Shift --</option>    
                                                <option value="I">I</option>
                                                <option value="II">II</option>
                                                <option value="III">III</option>
                                            </select> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- <td>NIK</td> -->
                                        <td hidden><input type="text" class="input-text w-full" id="i_nik" value="{{ session('user_id') }}" disabled></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 mb-4">
                                <table class="w-full">
                                    <tr>
                                        <td>Lokasi Kerja</td>
                                        <td><input type="text" class="input-text w-full" id="tLoker" name="tLoker"></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Inspektor</td>
                                        <td><input type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-half" id="tJmlIns" name="tJmlIns"></td>
                                    </tr>
                                    <tr>
                                        <td>Mengetahui</td>
                                        <td>
                                             <select name="sDataKaryawan" >
                                                @foreach($dataKaryawan as $dataKaryawan)
                                                <option value="{{ $dataKaryawan->id }}">{{ $dataKaryawan->nik }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="mb-1" style="padding:1rem">
                            <label class="form-label">INSPEKSI CATERING CHECKLSIT</label>
                            <div style="background-color:orange;"><label class="form-label" style="color:white">(A) Penerimaan NILAI (ACT/STD*10)</label></div>
                            <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                    <table class="w-full">
                                        <tr>
                                            <td style="width:2%">1.</td>
                                            <td style="width:50%">Apakah karyawan penerimaan / gudang dalam keadaan sehat</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="error" name="tA1" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1a" name="tA1a" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">2.</td>
                                            <td style="width:50%">Apakah karyawan bagian gudang / penerima sudah menggunakan alat yang aman</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA2" name="tA2" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1b" name="tA1b" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">3.</td>
                                            <td style="width:50%">Apakah bahan mentah yang di terima sudah di check</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA3" name="tA3" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1c" name="tA1c" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">4.</td>
                                            <td style="width:50%">Apakah bahan mentah yang diterima sesuai spesifikasi</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA4" name="tA4" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1d" name="tA1d" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">5.</td>
                                            <td style="width:50%">Apakah bahan yang tidak layak di kembalikan pada supleyernya</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA5" name="tA5" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1e" name="tA1e" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">6.</td>
                                            <td style="width:50%">Apakah bahan yang tidak layak di pakai sudah dimintakan penggantinya</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA6" name="tA6" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1f" name="tA1f" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">7.</td>
                                            <td style="width:50%">Apakah kemasan bahan yang diterima sudah sudah memenuhi syarat kemasan bahan makanan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA7" name="tA7" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1g" name="tA1g" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">8.</td>
                                            <td style="width:50%">Apakah alat yang digunakan dalam penerimaan sudah higienis dan aman</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA8" name="tA8" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1h" name="tA1h" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">9.</td>
                                            <td style="width:50%">Apakah tempat penerimaan sudah disiapkan bersih dan aman</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA9" name="tA9" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1i" name="tA1i" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">10.</td>
                                            <td style="width:50%">Apakah sudah dilakukan breafing sebelum dilakukan penerimaan matrial</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA10" name="tA10" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tA1j" name="tA1j" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mb-1" style="padding:1rem">
                            <div style="background-color:orange;"><label class="form-label" style="color:white">(B) Penyimpanan NILAI (ACT/STD*10)</label></div>
                            <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                    <table class="w-full">
                                        <tr>
                                            <td style="width:2%">1.</td>
                                            <td style="width:50%">Apakah tempat penyimpanan telah dibersihkan sebelum menyimpan barang</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB1" name="tB1" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1a" name="tB1a" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">2.</td>
                                            <td style="width:50%">Apakah stock card sudah sudah disiapkan untuk stock yang baru</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB2" name="tB2" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1b" name="tB1b" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">3.</td>
                                            <td style="width:50%">Apakah suhu ruang penyimpanan sudah di antisipasi</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB3" name="tB3" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1c" name="tB1c" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">4.</td>
                                            <td style="width:50%">Apakah sebelum disimpan barang sudah dilakukan pensortiran terhadap stok lama</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB4" name="tB4" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1d" name="tB1d" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">5.</td>
                                            <td style="width:50%">Apakah penempatan barang sudah memenuhi standar</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB5" name="tB5" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1e" name="tB1e" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">6.</td>
                                            <td style="width:50%">Apakah suhu ruang penyimpanan sudah diperiksa kembali setelah penyimpanan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB6" name="tB6" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1f" name="tB1f" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">7.</td>
                                            <td style="width:50%">Apakah penyimpanan barang sudah dipisahkan secara baik</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB7" name="tB7" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1g" name="tB1g" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">8.</td>
                                            <td style="width:50%">Apakah penyimpanan barang menggunakan penutup yang baik</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB8" name="tB8" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1h" name="tB1h" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">9.</td>
                                            <td style="width:50%">Apakah kondisi ruangan/alat sudah di chek sebelumnya</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB9" name="tB9" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tB1h" name="tB1h" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mb-1" style="padding:1rem">
                            <div style="background-color:orange;"><label class="form-label" style="color:white">(C) Persiapan NILAI (ACT/STD*10)</label></div>
                            <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                    <table class="w-full">
                                        <tr>
                                            <td style="width:2%">1.</td>
                                            <td style="width:50%">Apakah karyawan bagian produksi makanan dalam keadaan sehat</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC1" name="tC1" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1a" name="tC1a" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">2.</td>
                                            <td style="width:50%">Apakah karyawan sudah menggunakan alat yang aman</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC2" name="tC3" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1b" name="tC1b" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">3.</td>
                                            <td style="width:50%">Apakah sudah dilakukan breafing sistim produksi makanan terhadap karyawan produksi</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC3" name="tC3" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1c" name="tC1c" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">4.</td>
                                            <td style="width:50%">Apakah bahan mentah yang diterima sudah di chek jumlah dan spesifikasinya</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC4" name="tC4" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1d" name="tC1d" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">5.</td>
                                            <td style="width:50%">Apakah bahan yang tidak layak sudah di musnahkan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC5" name="tC5" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1e" name="tC1e" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">6.</td>
                                            <td style="width:50%">Apakah pelaksanan pencairan sudah dilakukan dengan baik dan benar</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC6" name="tC6" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1f" name="tC1f" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">7.</td>
                                            <td style="width:50%">Apakah sistim persiapan sudah dilakukan dengan baik ( pembersihan, pengupasan, pemotongan )</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC7" name="tC7" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1g" name="tC1g" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">8.</td>
                                            <td style="width:50%">Apakah penyimpanan barang sudah menggunakan penutup yang baik</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC8" name="tC8" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1h" name="tC1h" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">9.</td>
                                            <td style="width:50%">Apakah menu sudah di chek sesuai dengan kebutuhan karyawan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC9" name="tC9" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1i" name="tC1i" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">10.</td>
                                            <td style="width:50%">Apakah tempat selalu di bersihkan setelah dan sebelum digunakan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC10" name="tC10" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tC1j" name="tC1j" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mb-1" style="padding:1rem">
                            <div style="background-color:orange;"><label class="form-label" style="color:white">(D) Pengolahan NILAI (ACT/STD*10)</label></div>
                            <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                    <table class="w-full">
                                        <tr>
                                            <td style="width:2%">1.</td>
                                            <td style="width:50%">Apakah karyawan yang mengolah dalam keadaan sehat</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD1" name="tD1" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1a" name="tD1a" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">2.</td>
                                            <td style="width:50%">Apakah karyawan pengolahan dilakukan mcu berkala</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD2" name="tD2" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1b" name="tD1b" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">3.</td>
                                            <td style="width:50%">Apakah alat sudah dalam keadaan siap pakai</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD3" name="tD3" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1c" name="tD1c" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">4.</td>
                                            <td style="width:50%">Apakah pengolahan makanan sudah dilakukan dengan baik</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD4" name="tD4" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1d" name="tD1d" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">5.</td>
                                            <td style="width:50%">Apakah hasil pengolahan makan sudah dilakukan uji kematangan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD5" name="tD5" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1e" name="tD1e" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">6.</td>
                                            <td style="width:50%">Apakah hasil makanan sudah dilakukan uji cita rasa</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD6" name="tD6" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1f" name="tD1f" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">7.</td>
                                            <td style="width:50%">Apakah setiap yang disajikan sudah di buatkan food sample untuk disimpan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD7" name="tD7" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1g" name="tD1g" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">8.</td>
                                            <td style="width:50%">Apakah setiap karyawan bekerja dengan higine dan menggunakan peralatan standart</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD8" name="tD8" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1h" name="tD1h" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">9.</td>
                                            <td style="width:50%">Apakah barang yang tidak layak untuk di olah sudah di buang</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD9" name="tD9" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1i" name="tD1i" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">10.</td>
                                            <td style="width:50%">Apakah tempat pengolahan selalu di bersihkan setiap setelah dan sebelum pengolahan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD10" name="tD10" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tD1j" name="tD1j" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mb-1" style="padding:1rem">
                            <div style="background-color:orange;"><label class="form-label" style="color:white">(E) Penggolongan Sampah NILAI (ACT/STD*10)</label></div>
                            <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                    <table class="w-full">
                                        <tr>
                                            <td style="width:2%">1.</td>
                                            <td style="width:50%">Apakah karyawan yang bertugas menangani sampah dalam keadaan sehat</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE1" name="tE1" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1a" name="tE1a" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">2.</td>
                                            <td style="width:50%">Apakah karyawan yang membuang sampah menggunakan pelindung dengan benar</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE2" name="tE2" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1b" name="tE1b" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">3.</td>
                                            <td style="width:50%">Apakah sampah disetiap tempat dibuang ke tempat penampungan sementara</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE3" name="tE3" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1c" name="tE1c" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">4.</td>
                                            <td style="width:50%">Apakah tempat sampah dicuci dan di bersihkan setiap setelah membuang sampah</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE4" name="tE4" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1d" name="tE1d" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">5.</td>
                                            <td style="width:50%">Apakah plastik sampah di ikat kuat dan terhindar dari kebocoran</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE5" name="tE5" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1e" name="tE1e" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">6.</td>
                                            <td style="width:50%">Apakah bahan limbah di pisahkan dari penampungan sampah umum</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE6" name="tE6" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1f" name="tE1f" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">7.</td>
                                            <td style="width:50%">Apakah kemasan bahan yang diterima sudah memenuhi syarat kemasan bahan makanan</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE7" name="tE7" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1g" name="tE1g" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">8.</td>
                                            <td style="width:50%">Apakah bekas minyak goreng sudah di tandai dan tidak boleh digunakan lagi</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE8" name="tE8" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1h" name="tE1h" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <td style="width:2%">9.</td>
                                            <td style="width:50%">Apakah tempat penerimaan sudah disiapkan bersih dan aman</td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE9" name="tE9" placeholder="1 - 10" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="tE1i" name="tE1i" placeholder="Keterangan">
                                            </td>
                                        </tr>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmit">
                                    <i class="fas fa-save"></i>
                                    Submit Form
                                </button>
                            </div>
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
        
        $('#btnSubmit').click( function(e) {
            e.preventDefault();
            const formData = $('#formInspeksiCatering').serialize();

            axios.post(`{{ isset($formInspeksiCatering) ? route('bss-form.she-019B.edit-inspeksi-catering', ['id' => $formInspeksiCatering->id]) : route('bss-form.she-019B.create-inspeksi-catering') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form Inspeksi Catering Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('bss-form.she-048.inspeksi-catering.dashboard') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form Inspeksi Catering'
                });
            });
        });
        
    </script>
@endsection
