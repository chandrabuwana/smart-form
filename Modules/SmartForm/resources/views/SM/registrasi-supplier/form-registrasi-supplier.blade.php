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
    #npwp {
         width: 100px;
         height: 150px;
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
                                <label class="form-label fw-bold">Informasi Umum Vendor / Vendor Information:</label>
                                <div class="row mb-2">
                                        <div class="card col-md-6 was-validated">
                                        <table class="w-full">
                                            <tr>
                                                <td style="width:40%">Jenis Badan Usaha</td>
                                                <td>:</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dJenisUsaha" name="dJenisUsaha" required>
                                                        <option value="" selected>-- Pilih Jenis Badan Usaha --</option>
                                                        <option value="CV">CV</option>
                                                        <option value="PT">PT</option>
                                                        <option value="Perorangan">Perorangan</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Vendor (CV/PT/Perorangan)</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tVendorName" name="tVendorName" placeholder="Vendor's Name" required>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tBidang" name="tBidang" placeholder="Business Field" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1">
                                <label class="form-label fw-bold">Informasi Referensi Transaksi Pembayaran/ Payment Reference :</label>
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
                                                    <select class="form-select form-select-sm input-text" aria-label="Default select example" id="tSyaratPemb" name="tSyaratPemb" required>
                                                        <option value="" selected>-- Pilih Syarat Pembayaran --</option>
                                                        <option value="0">0</option>
                                                        <option value="14">14</option>
                                                        <option value="30">30</option>
                                                        <option value="45">45</option>
                                                        <option value="60">60</option>
                                                    </select>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tAccNm1" name="tAccNm1" placeholder="Account Name" required>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tNamaBank1" name="tNamaBank1" placeholder="Bank Name" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Alamat Bank 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tBankAdd1" name="tBankAdd1" placeholder="Bank Address" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Rekening 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tAccNm2" name="tAccNm2" placeholder="Account Name" required>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tNamaBank2" name="tNamaBank2" placeholder="Bank Name" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Alamat Bank 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tBankAdd2" name="tBankAdd2" placeholder="Bank Address" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1">
                                <label class="form-label fw-bold">Informasi Alamat dan Kontak / Address and Contact Information :</label>
                                <div class="row mb-2">
                                        <div class="card col-md-6 was-validated">
                                        <table class="w-full">
                                            <tr>
                                                <td style="width:40%">Alamat Kantor</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tAlamatKan" name="tAlamatKan" placeholder="Company Address" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Kota</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tKota" name="tKota" placeholder="City" required>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tPic1" name="tPic1" placeholder="Person in charge" required>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tJabatPic1" name="tJabatPic1" placeholder="Postion" required>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tPic2" name="tPic2" placeholder="Person in charge" required>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tJabatPic2" name="tJabatPic2" placeholder="Postion" required>
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
                                <label class="form-label fw-bold">Lampiran Dokumen /Attached Documents :</label>
                                <div class="row mb-2">
                                        <div class="card col-md-12 was-validated">
                                        <table class="w-full">
                                            <tr class="cvpt">
                                                <td style="width:20%">NPWP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rNpwp1" id="rNpwp1">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rNpwp1" id="rNpwp1">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fNpwp" accept="image/*" onchange="previewImage(event)">
                                                    <img id="npwp" alt="NPWP">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SPPKP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rSppkp" id="rSppkp">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rSppkp" id="rSppkp">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fSppkp">
                                                    <div class="invalid-feedback">Lampiran SPPKP</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>NIB / SIUP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rNib" id="rNib">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rNib" id="rNib">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fNib">
                                                    <div class="invalid-feedback">Lampiran NIB/SIUP</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Akta Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rAkta" id="rAkta">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rAkta" id="rAkta">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fAkta">
                                                    <div class="invalid-feedback">Lampiran Akta Perusahaan</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pakta Integritas</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rPakta" id="rPakta">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rPakta" id="rPakta">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fPakta">
                                                    <div class="invalid-feedback">Lampiran Pakta Integritas</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kartu Identitas Direktur</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rKartu" id="rIden">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rKartu" id="rIden">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fKartu">
                                                    <div class="invalid-feedback">Lampiran Kartu Identitas Direktur</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Struktur Organisasi</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rStruktur" id="rStruktur">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rStruktur" id="rStruktur">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fStruktur">
                                                    <div class="invalid-feedback">Lampiran Struktur Organisasi</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Profile Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rProfile" id="rProfile">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rProfile" id="rProfile">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fProfile">
                                                    <div class="invalid-feedback">Lampiran Profile Perusahaan</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat Lainnya</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rSurat" id="rSuratLain">
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rSurat" id="rSuratLainNo">
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fSurat">
                                                    <div class="invalid-feedback">Lampiran lainnya</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span style="display: none;" id="requestornik">{{ session('user_id') }}</span>

                        <table style="width:100%" >
                          <tr>
                            <td>Diisi Oleh/Filled by, :</td>
                            <td><input type="text" style="text-transform:uppercase" class="form-control" id="tFiller" name="tFiller" placeholder="Filler Name" required>
                            </td>
                            <td>Diterima Oleh/Received by, :</td>
                            <td> 
                                <select name="dDiterima" id="dDiterima" class="form-control text-center" required>
                                    <option value="">-- Pilih Penerima --</option>
                                    @foreach($approvalList as $user)
                                        <option value="{{ $user->nama }}">
                                            {{ $user->nama }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <!-- <td>Disetujui Oleh/Approved by, :</td>
                            <td>
                                <select name="dApproved" id="dApproved" class="form-control text-center" required>
                                    <option disabled selected>-- Pilih Approver --</option>
                                    @foreach($approvalList as $user)
                                        <option value="{{ $user->nama }}">{{ $user->nama }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </td> -->
                          </tr>
                        </table>
                        
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" type="submit" style="margin:5px">
                                    <i class="fas fa-save"></i>
                                    Submit Form
                                </button>
                                <a href="{{url()->previous()}}" class="btn btn-success" style="margin:5px"><i class="fas fa-cancel"></i> Cancel</a>
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
        function previewImage(event) {
         var input = event.target;
         var image = document.getElementById('npwp');
         if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
               image.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
         }
      }
        $(document).ready(function() {
            $('#dApproved').select2();
            $('#dDiterima').select2();
        });
        // JENIS BADAN USAHA CV/PT/PERORANGAN
        $(document).ready(function(){
            $('#dJenisUsaha').change(function () {
                if($(this).val() ==='Perorangan') {
                    $('#rIden').prop('required',true);
                    $('#fKartu').prop('required',true);

                    $('#rPakta').prop('required',true);
                    $('#fPakta').prop('required',true);
                } else {
                    //NPWP
                    $('#rNpwp1').prop('required',true);
                    $('#fNpwp').prop('required',true);
                    //SPPKP
                    $('#rSppkp').prop('required',true);
                    $('#fSppkp').prop('required',true);
                    //NIB / SIUP
                    $('#rNib').prop('required',true);
                    $('#fNib').prop('required',true);
                    //AKTA PERUSAHAAN
                    $('#rAkta').prop('required',true);
                    $('#fAkta').prop('required',true);
                    //PAKTA INT
                    $('#rPakta').prop('required',true);
                    $('#fPakta').prop('required',true);
                    //KARTU IDENTITAS DIR
                    $('#rIden').prop('required',true);
                    $('#fKartu').prop('required',true);
                }
            });
        });
        
        // PKP NON PKP
        $(document).ready(function(){
            $('input[name="rPkp"]').change(function () {
                if($(this).val() =='PKP') {
                    $('#tNoNpwp').prop('required',true);
                } else {
                    $('#tNoNpwp').prop('required',false);
                }
            });
        });
        // NPWP
        $(document).ready(function(){
            $('input[name="rNpwp1"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fNpwp').prop('required',true);
                } else {
                    $('#fNpwp').prop('hidden',true);
                }
            });
        });
        // SPPKP
        $(document).ready(function(){
            $('input[name="rSppkp"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fSppkp').prop('required',true);
                } else {
                    $('#fSppkp').prop('required',false);
                }
            });
        });
        // NIB/SIUP
        $(document).ready(function(){
            $('input[name="rNib"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fNib').prop('required',true);
                } else {
                    $('#fNib').prop('required',false);
                }
            });
        });
        // AKTA PERUSAHAAN
        $(document).ready(function(){
            $('input[name="rAkta"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fAkta').prop('required',true);
                } else {
                    $('#fAkta').prop('required',false);
                }
            });
        });
        // PAKTA INTEGRITAS
        $(document).ready(function(){
            $('input[name="rPakta"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fPakta').prop('required',true);
                } else {
                    $('#fPakta').prop('required',false);
                }
            });
        });
        // KARTU IDENTITAS
        $(document).ready(function(){
            $('input[name="rKartu"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fKartu').prop('required',true);
                } else {
                    $('#fKartu').prop('required',false);
                }
            });
        });
        // STRUKTUR ORGANISASI
        $(document).ready(function(){
            $('input[name="rStruktur"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fStruktur').prop('required',true);
                } else {
                    $('#fStruktur').prop('required',false);
                }
            });
        });
        // PROFIL PERUSAHAAN
        $(document).ready(function(){
            $('input[name="rProfile"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fProfile').prop('required',true);
                } else {
                    $('#fProfile').prop('required',false);
                }
            });
        });
        // SURAT LAINNYA
        $(document).ready(function(){
            $('input[name="rSurat"]').change(function () {
                if($(this).val() =='Ada') {
                    $('#fSurat').prop('required',true);
                } else {
                    $('#fSurat').prop('required',false);
                }
            });
        });
    </script>
@endsection
