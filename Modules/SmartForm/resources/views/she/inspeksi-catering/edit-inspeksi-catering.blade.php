@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }
    .ml-16px {
        margin-left: 16px;
    }
    .mb-8px {
        margin-bottom: 8px;
    }
    .display-block {
        display: block;
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
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form class="card my-4" method="POST" id="formEditInspeksiCatering">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Edit Form Inspeksi Catering</h6>
                    </div>
                </div>

                <div class="card-body my-1">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <table class="w-full">
                                <tr>
                                    <td>Nama Site</td>
                                    <td>
                                        <!-- <input type="text" class="input-text w-full" id="tNamaSite" name="tNamaSite" value="{{ $data->nama_site }}"> -->
                                        <select class="form-select form-select-sm input-text" id="tNamaSite" name="tNamaSite">
                                        <option value="{{ $data->nama_site }}">{{ $data->nama_site }}</option>
                                            @forelse($sites as $site)
                                                <option value="{{ $site->KodeST ?? '' }}">
                                                    {{ $site->KodeST ?? 'Site tidak tersedia' }}
                                                </option>
                                            @empty
                                                <option>Data site tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Departemen</td>
                                    <td>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dDept" name="dDept">
                                            <option value="{{ $data->department ?? '' }}">{{ $data->department}}</option>
                                            @forelse($dept as $dept)
                                                <option value="{{ $dept->Nama ?? '' }}">
                                                        {{ $dept->Nama ?? 'Departement tidak tersedia' }}
                                                </option>
                                                @empty
                                                    <option>Data Departement tidak ditemukan</option>
                                                @endforelse
                                            </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift</td>
                                    <td>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dShift" name="dShift">
                                            <option value="">-- Pilih Shift --</option>    
                                            <option value="DS" {{ $data->shift == 'DS' ? 'selected' : '' }}>DS</option>
                                            <option value="NS" {{ $data->shift == 'NS' ? 'selected' : '' }}>NS</option>
                                        </select> 
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-4">
                            <table class="w-full">
                                <tr>
                                    <td>Lokasi Kerja</td>
                                    <td><input type="text" class="input-text w-full" id="tLoker" name="tLoker" value="{{ $data->lokasi_kerja }}"></td>
                                </tr>
                                <tr>
                                    <td>Jumlah Inspektor</td>
                                    <td><input type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-half" id="tJmlIns" name="tJmlIns" value="{{ $data->jumlah_inspektor }}"></td>
                                </tr>
                                <tr>
                                    <td>Mengetahui</td>
                                    <td>
                                        <select name="dMengetahui" id="dMengetahui" class="form-control text-center">
                                            <option value="">-- Pilih Mengetahui --</option>
                                            @foreach($approvalList as $user)
                                                <option value="{{ $user->nama }}" {{ $data->mengetahui == $user->nama ? 'selected' : '' }}>
                                                    {{ $user->nama }} ({{ $user->nik }})
                                                </option>
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
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA1" name="tA1" placeholder="1 - 10" required value="{{ $data->q_penerimaan_1 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA1a" name="tA1a" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_1 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">2.</td>
                                        <td style="width:50%">Apakah karyawan penerimaan / gudang menggunakan APD yang bersih</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA2" name="tA2" placeholder="1 - 10" required value="{{ $data->q_penerimaan_2 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA2b" name="tA2b" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_2 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">3.</td>
                                        <td style="width:50%">Apakah bahan makanan diterima dalam kondisi bersih dan segar</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA3" name="tA3" placeholder="1 - 10" required value="{{ $data->q_penerimaan_3 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA3c" name="tA3c" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_3 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">4.</td>
                                        <td style="width:50%">Apakah pengemasan / kemasan bahan makanan dalam kondisi baik</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA4" name="tA4" placeholder="1 - 10" required value="{{ $data->q_penerimaan_4 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA4d" name="tA4d" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_4 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">5.</td>
                                        <td style="width:50%">Apakah label, tanggal kadaluwarsa tertera pada kemasan bahan makanan</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA5" name="tA5" placeholder="1 - 10" required value="{{ $data->q_penerimaan_5 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA5e" name="tA5e" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_5 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">6.</td>
                                        <td style="width:50%">Apakah proses penyimpanan sayur dan buah terpisah dengan daging, ikan, dll</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA6" name="tA6" placeholder="1 - 10" required value="{{ $data->q_penerimaan_6 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA6f" name="tA6f" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_6 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">7.</td>
                                        <td style="width:50%">Apakah transportasi pengiriman bahan makanan dibersihkan secara berkala</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA7" name="tA7" placeholder="1 - 10" required value="{{ $data->q_penerimaan_7 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA7g" name="tA7g" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_7 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">8.</td>
                                        <td style="width:50%">Apakah bahan makanan diterima dalam kondisi tidak melebihi 4°C untuk sayuran dan buah-buahan, serta maksimal 5°C untuk daging dan produk susu</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA8" name="tA8" placeholder="1 - 10" required value="{{ $data->q_penerimaan_8 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA8h" name="tA8h" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_8 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">9.</td>
                                        <td style="width:50%">Apakah personil penerimaan bahan makanan memakai sarung tangan dan masker selama proses pengirimannya</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA9" name="tA9" placeholder="1 - 10" required value="{{ $data->q_penerimaan_9 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA9i" name="tA9i" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_9 }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:2%">10.</td>
                                        <td style="width:50%">Apakah tersedia sertifikat halal untuk bahan makanan tertentu (jika dipersyaratkan)</td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tA10" name="tA10" placeholder="1 - 10" required value="{{ $data->q_penerimaan_10 }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tA10j" name="tA10j" placeholder="Keterangan" value="{{ $data->q_keterangan_penerimaan_10 }}">
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
                                    @for ($i = 1; $i <= 9; $i++)
                                    <tr>
                                        <td style="width:2%">{{ $i }}.</td>
                                        <td style="width:50%">
                                            @switch($i)
                                                @case(1)
                                                    Apakah gudang penyimpanan bahan makanan dalam keadaan bersih dan higienis
                                                    @break
                                                @case(2)
                                                    Apakah wadah penyimpanan bahan makanan bersih dan tidak rusak
                                                    @break
                                                @case(3)
                                                    Apakah suhu tempat penyimpanan sesuai dengan jenis bahan makanan
                                                    @break
                                                @case(4)
                                                    Apakah aliran udara dalam gudang penyimpanan baik
                                                    @break
                                                @case(5)
                                                    Apakah dilakukan pencatatan terhadap pengeluaran dan jumlah bahan makanan dalam gudang
                                                    @break
                                                @case(6)
                                                    Apakah karyawan gudang menggunakan APD yang bersih
                                                    @break
                                                @case(7)
                                                    Apakah dilakukan sistem FIFO (First In First Out) dalam pengambilan bahan makanan dari gudang
                                                    @break
                                                @case(8)
                                                    Apakah tersedia thermometer untuk memantau suhu ruangan di gudang penyimpanan
                                                    @break
                                                @case(9)
                                                    Apakah jarak antar tumpukan penyimpanan bahan makanan cukup untuk sirkulasi udara
                                                    @break
                                                @default
                                                    Question {{ $i }}
                                            @endswitch
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tB{{ $i }}" name="tB{{ $i }}" placeholder="1 - 10" required value="{{ $data->{'q_penyimpanan_'.$i} }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tB{{ $i }}{{ chr(96 + $i) }}" name="tB{{ $i }}{{ chr(96 + $i) }}" placeholder="Keterangan" value="{{ $data->{'q_keterangan_penyimpanan_'.$i} }}">
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-1" style="padding:1rem">
                        <div style="background-color:orange;"><label class="form-label" style="color:white">(C) Persiapan NILAI (ACT/STD*10)</label></div>
                        <div class="row mb-2">
                            <div class="card col-md-12 was-validated">
                                <table class="w-full">
                                    @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td style="width:2%">{{ $i }}.</td>
                                        <td style="width:50%">
                                            @switch($i)
                                                @case(1)
                                                    Apakah karyawan yang bertugas dalam keadaan sehat
                                                    @break
                                                @case(2)
                                                    Apakah karyawan menggunakan APD lengkap (hairnet, masker, dan sarung tangan)
                                                    @break
                                                @case(3)
                                                    Apakah alat pemotong (pisau, talenan, dll) dalam keadaan bersih
                                                    @break
                                                @case(4)
                                                    Apakah pisau, talenan yang digunakan untuk ikan, daging, sayur, buah berbeda
                                                    @break
                                                @case(5)
                                                    Apakah tersedia tempat cuci tangan dengan sabun dan air mengalir
                                                    @break
                                                @case(6)
                                                    Apakah karyawan mencuci tangan sebelum dan sesudah mempersiapkan bahan makanan
                                                    @break
                                                @case(7)
                                                    Apakah meja persiapan dalam keadaan bersih
                                                    @break
                                                @case(8)
                                                    Apakah lantai ruang persiapan dalam keadaan bersih
                                                    @break
                                                @case(9)
                                                    Apakah bahan makanan dicuci dengan cara yang baik dan benar sebelum diproses
                                                    @break
                                                @case(10)
                                                    Apakah tersedia tempat sampah tertutup untuk sisa sampah hasil persiapan bahan makanan
                                                    @break
                                                @default
                                                    Question {{ $i }}
                                            @endswitch
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tC{{ $i }}" name="tC{{ $i }}" placeholder="1 - 10" required value="{{ $data->{'q_persiapan_'.$i} }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tC{{ $i }}{{ chr(96 + $i) }}" name="tC{{ $i }}{{ chr(96 + $i) }}" placeholder="Keterangan" value="{{ $data->{'q_keterangan_persiapan_'.$i} }}">
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-1" style="padding:1rem">
                        <div style="background-color:orange;"><label class="form-label" style="color:white">(D) Pengolahan NILAI (ACT/STD*10)</label></div>
                        <div class="row mb-2">
                            <div class="card col-md-12 was-validated">
                                <table class="w-full">
                                    @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td style="width:2%">{{ $i }}.</td>
                                        <td style="width:50%">
                                            @switch($i)
                                                @case(1)
                                                    Apakah karyawan yang bertugas dalam keadaan sehat
                                                    @break
                                                @case(2)
                                                    Apakah karyawan menggunakan APD lengkap
                                                    @break
                                                @case(3)
                                                    Apakah peralatan masak dalam keadaan bersih dan tidak rusak
                                                    @break
                                                @case(4)
                                                    Apakah kerapian menempatkan peralatan masak di dapur dalam keadaan baik
                                                    @break
                                                @case(5)
                                                    Apakah lantai dapur tidak licin dan bersih
                                                    @break
                                                @case(6)
                                                    Apakah tersedia wastafel dengan air mengalir dan sabun untuk mencuci tangan
                                                    @break
                                                @case(7)
                                                    Apakah bahan makanan yang diolah dalam keadaan baik
                                                    @break
                                                @case(8)
                                                    Apakah bahan yang diolah dipisahkan dari bahan mentah
                                                    @break
                                                @case(9)
                                                    Apakah di dapur tersedia thermometer untuk mengecek suhu makanan
                                                    @break
                                                @case(10)
                                                    Apakah di dapur tersedia tempat sampah tertutup
                                                    @break
                                                @default
                                                    Question {{ $i }}
                                            @endswitch
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tD{{ $i }}" name="tD{{ $i }}" placeholder="1 - 10" required value="{{ $data->{'q_pengolahan_'.$i} }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tD{{ $i }}{{ chr(96 + $i) }}" name="tD{{ $i }}{{ chr(96 + $i) }}" placeholder="Keterangan" value="{{ $data->{'q_keterangan_pengolahan_'.$i} }}">
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-1" style="padding:1rem">
                        <div style="background-color:orange;"><label class="form-label" style="color:white">(E) Penggolongan Sampah NILAI (ACT/STD*10)</label></div>
                        <div class="row mb-2">
                            <div class="card col-md-12 was-validated">
                                <table class="w-full">
                                    @for ($i = 1; $i <= 9; $i++)
                                    <tr>
                                        <td style="width:2%">{{ $i }}.</td>
                                        <td style="width:50%">
                                            @switch($i)
                                                @case(1)
                                                    Apakah tersedia tempat sampah untuk sampah organik
                                                    @break
                                                @case(2)
                                                    Apakah tersedia tempat sampah untuk sampah anorganik
                                                    @break
                                                @case(3)
                                                    Apakah tersedia tempat sampah untuk sampah B3
                                                    @break
                                                @case(4)
                                                    Apakah sampah dibuang setiap hari
                                                    @break
                                                @case(5)
                                                    Apakah tempat sampah dalam keadaan baik dan bersih
                                                    @break
                                                @case(6)
                                                    Apakah tersedia tempat penampungan sampah sementara
                                                    @break
                                                @case(7)
                                                    Apakah tutup TPS dalam kondisi baik
                                                    @break
                                                @case(8)
                                                    Apakah dilakukan pembersihan TPS secara rutin
                                                    @break
                                                @case(9)
                                                    Apakah area pembuangan sampah dalam keadaan bersih
                                                    @break
                                                @default
                                                    Question {{ $i }}
                                            @endswitch
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" max="10" class="form-control" id="tE{{ $i }}" name="tE{{ $i }}" placeholder="1 - 10" required value="{{ $data->{'q_penggolongan_sampah_'.$i} }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="tE{{ $i }}{{ chr(96 + $i) }}" name="tE{{ $i }}{{ chr(96 + $i) }}" placeholder="Keterangan" value="{{ $data->{'q_keterangan_penggolongan_sampah_'.$i} }}">
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </button>
                            <button type="button" class="btn btn-primary ms-auto" id="btnSubmitUpdate">
                                <i class="fas fa-save"></i>
                                Update Form
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dDept').select2();
            $('#dMengetahui').select2();
            $('#tNamaSite').select2();
        });
        $(document).ready(function() {
            function stopLoading() {
                $("body").css("overflow-y", "auto");
                if ($("#loading-animation").length > 0) {
                    $("#loading-animation").css("display", "none");
                }
            }
            
            var btnSubmitUpdate = $("#btnSubmitUpdate");
            
            btnSubmitUpdate.click(function(e) {
                e.preventDefault();
                
                let isValid = true;
                $('#formEditInspeksiCatering input[required]').each(function() {
                    if ($(this).val() === '') {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill all required fields'
                    });
                    return;
                }
                
                Swal.fire({
                    title: 'Updating data...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                const form = document.getElementById('formEditInspeksiCatering');
                const formData = new FormData(form);
                
                const formObject = {};
                formData.forEach((value, key) => {
                    formObject[key] = value;
                });
                
                console.log('Submitting form data:', formObject);
                
                fetch('{{ route("bss-form.she-048.update-inspeksi-catering") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message
                        }).then(() => {
                            window.location.href = "{{ route('bss-form.she-048.inspeksi-catering.dashboard') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'An error occurred'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Failed to update the record. Please try again later or contact support.'
                    });
                });
            });
        });
    </script>
@endsection