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
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form Registrasi Supplier</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Requested By : <span id="requestor">{{ session('username') }}</span>
                                    {{-- session()->get('name') . ' - ' . session()->get('dept') . ' - ' . session()->get('site') --}}
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="/bss-form/sm/create-registrasi-supplier" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="my-3">
                            <div class="mb-1">
                                <label class="form-label">Informasi Umum Vendor / Vendor Information:</label>
                                <div class="row mb-2">
                                        <div class="card col-md-6 was-validated">
                                        <table class="w-full">
                                            <tr>
                                                <td style="width:40%">Nama Vendor (CV/PT)</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tVendorName" name="tVendorName" placeholder="Vendor's Name" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Status Pajak</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="PKP" name="rPkp" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        PKP
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="NON-PKP" name="rPkp" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        NON PKP
                                                      </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">No. NPWP</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tNoNpwp" name="tNoNpwp" placeholder="No NPWP (only for domestic Vendor)" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Bidang Usaha</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tBidang" name="tBidang" placeholder="Business Field" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1">
                                <label class="form-label">Informasi Referensi Transaksi Pembayaran/ Payment Reference :</label>
                                <div class="row mb-2">
                                        <div class="card col-md-6 was-validated">
                                        <table class="w-full">
                                            <tr>
                                                <td style="width:40%">Metode Pembayaran</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Tunai" name="rMetodePembayaran" id="rCash" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Tunai
                                                      </label>
                                                      <input class="form-check-input" type="radio" value="Transfer" name="rMetodePembayaran" id="rTransfer" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Transfer
                                                      </label>
                                                      <input class="form-check-input" type="radio" value="Cheque/Giro" name="rMetodePembayaran" id="rCheque" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Cheque / Giro
                                                      </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Syarat Pembayaran (hari)</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tSyaratPemb" name="tSyaratPemb" placeholder="Terms of Payment (day)" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">PPN %</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tPpn" name="tPpn" placeholder="PPN %" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">PPH %</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tPph" name="tPph" placeholder="PPH %" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Rekening 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tAccNm1" name="tAccNm1" placeholder="Account Name" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nomor Rekening 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tAccNo1" name="tAccNo1" placeholder="Account Number" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Bank 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tNamaBank1" name="tNamaBank1" placeholder="Bank Name" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Alamat Bank 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tBankAdd1" name="tBankAdd1" placeholder="Bank Address" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Rekening 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tAccNm2" name="tAccNm2" placeholder="Account Name" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nomor Rekening 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tAccNo2" name="tAccNo2" placeholder="Account Number" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Bank 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tNamaBank2" name="tNamaBank2" placeholder="Bank Name" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Alamat Bank 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tBankAdd2" name="tBankAdd2" placeholder="Bank Address" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1">
                                <label class="form-label">Informasi Alamat dan Kontak / Address and Contact Information :</label>
                                <div class="row mb-2">
                                        <div class="card col-md-6 was-validated">
                                        <table class="w-full">
                                            <tr>
                                                <td style="width:40%">Alamat Kantor</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tAlamatKan" name="tAlamatKan" placeholder="Company Address" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Kota</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tKota" name="tKota" placeholder="City" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tTlp" name="tTlp" placeholder="Telephone" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="email" class="form-control" id="tEmail" name="tEmail" placeholder="Email" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Kode Pos</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tKodePos" name="tKodePos" placeholder="Postal Code" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Penanggung Jawab 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tPic1" name="tPic1" placeholder="Person in charge" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tTlpPic1" name="tTlpPic1" placeholder="Telephone" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Jabatan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tJabatPic1" name="tJabatPic1" placeholder="Postion" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="email" class="form-control" id="tEmailPic1" name="tEmailPic1" placeholder="Email" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Penanggung Jawab 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tPic2" name="tPic2" placeholder="Person in charge" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tTlpPic2" name="tTlpPic2" placeholder="Telephone" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Jabatan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" class="form-control" id="tJabatPic2" name="tJabatPic2" placeholder="Postion" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="email" class="form-control" id="tEmailPic2" name="tEmailPic2" placeholder="Email" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1">
                                <label class="form-label">Lampiran Dokumen /Attached Documents :</label>
                                <div class="row mb-2">
                                        <div class="card col-md-12 was-validated">
                                        <table class="w-full">
                                            <tr>
                                                <td style="width:20%">NPWP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rNpwp1" id="rNpwp1" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rNpwp1" id="rNonNpwp1" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran NPWP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SPPKP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rSppkp" id="rSppkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rSppkp" id="rNonSppkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran SPPKP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>NIB / SIUP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rNib" id="rNib" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rNib" id="rNibNo" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran NIB/SIUP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Akta Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rAkta" id="rAkta" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rAkta" id="rAktraNo" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran Akta Perusahaan belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pakta Integritas</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rPakta" id="rPakta" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rPakta" id="rPaktaNo" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran Pakta Integritas belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kartu Identitas Direktur</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rKartu" id="rIden" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rKartu" id="rIdenNo" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran Kartu Identitas Direktur belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Struktur Organisasi</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rStruktur" id="rStruktur" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rStruktur" id="rStrukturNo" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran Struktur Organisasi belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Profile Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rProfile" id="rProfile" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rProfile" id="rProfile" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran Profile Perusahaan belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat Lainnya</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rSurat" id="rSuratLain" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rSurat" id="rSuratLainNo" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" required>
                                                    <div class="invalid-feedback">Lampiran lainnya belum dipilih</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span style="display: none;" id="requestornik">{{ session('user_id') }}</span>
                        
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" type="submit">
                                    <i class="fas fa-save"></i>
                                    Submit Form
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
    </script>
@endsection
