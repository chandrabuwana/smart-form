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
                        <h6 class="text-white text-capitalize ps-3">Update Data Supplier</h6>
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

                    <form method="POST" action="{{route('bss-form.sm.update-supplier')}}" enctype="multipart/form-data">
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tVendorName" name="tVendorName" value="{{$data['nama_vendor']}}" required>
                                                    <input type="text" class="form-control" id="tId" name="tId" value="{{$data['id']}}" hidden>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Status Pajak</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="PKP" name="rPkp" id="rPkp" {{ old('rPkp',$data['status_pajak_pkp']) == 'PKP' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        PKP
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="NON-PKP" name="rPkp" id="rPkp" {{ old('rPkp',$data['status_pajak_pkp']) == 'NON-PKP' ? 'checked' : '' }} required>
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
                                                    <input type="text" class="form-control" id="tNoNpwp" name="tNoNpwp" value="{{$data['no_npwp']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Bidang Usaha</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tBidang" name="tBidang" value="{{$data['bidang_usaha']}}" required>
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
                                                      <input class="form-check-input" type="radio" value="Tunai" name="rMetodePembayaran" id="rCash" {{ old('rMetodePembayaran',$data['metode_pembayaran']) == 'Tunai' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Tunai
                                                      </label>
                                                      <input class="form-check-input" type="radio" value="Transfer" name="rMetodePembayaran" id="rTransfer" {{ old('rMetodePembayaran',$data['metode_pembayaran']) == 'Transfer' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Transfer
                                                      </label>
                                                      <input class="form-check-input" type="radio" value="Cheque/Giro" name="rMetodePembayaran" id="rCheque" {{ old('rMetodePembayaran',$data['metode_pembayaran']) == 'Cheque/Giro' ? 'checked' : '' }} required>
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
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tSyaratPemb" name="tSyaratPemb" value="{{$data['syarat_pembayaran']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">PPN %</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tPpn" name="tPpn" value="{{$data['ppn']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">PPH %</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tPph" name="tPph" value="{{$data['pph']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Rekening 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tAccNm1" name="tAccNm1" value="{{$data['nama_rekening_1']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nomor Rekening 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tAccNo1" name="tAccNo1" value="{{$data['nomor_rekening_1']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Bank 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tNamaBank1" name="tNamaBank1" value="{{$data['nama_bank_1']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Alamat Bank 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tBankAdd1" name="tBankAdd1" value="{{$data['alamat_bank_1']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Rekening 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tAccNm2" name="tAccNm2" value="{{$data['nama_rekening_2']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nomor Rekening 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tAccNo2" name="tAccNo2" value="{{$data['nomor_rekening_2']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Bank 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tNamaBank2" name="tNamaBank2" value="{{$data['nama_bank_2']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Alamat Bank 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tBankAdd2" name="tBankAdd2" value="{{$data['alamat_bank_2']}}" required>
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
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tAlamatKan" name="tAlamatKan" value="{{$data['alamat_kantor']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Kota</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tKota" name="tKota" value="{{$data['kota']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tTlp" name="tTlp" value="{{$data['telepon']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="email" class="form-control" id="tEmail" name="tEmail" value="{{$data['email']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Kode Pos</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tKodePos" name="tKodePos" value="{{$data['kode_pos']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Penanggung Jawab 1</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tPic1" name="tPic1" value="{{$data['pj_1']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tTlpPic1" name="tTlpPic1" value="{{$data['tlp_1']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Jabatan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tJabatPic1" name="tJabatPic1" value="{{$data['jabatan_1']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="email" class="form-control" id="tEmailPic1" name="tEmailPic1" value="{{$data['jabatan_1_email']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Penanggung Jawab 2</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tPic2" name="tPic2" value="{{$data['pj_2']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tTlpPic2" name="tTlpPic2" value="{{$data['tlp_2']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Jabatan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" style="text-transform:uppercase" class="form-control" id="tJabatPic2" name="tJabatPic2" value="{{$data['jabatan_2']}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="email" class="form-control" id="tEmailPic2" name="tEmailPic2" value="{{$data['jabatan_2_email']}}" required>
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
                                                      <input class="form-check-input" type="radio" value="Ada" name="rNpwp1" id="rNpwp1" {{ old('rNpwp1',$data['npwp']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rNpwp1" id="rNpwp1" {{ old('rNpwp1',$data['npwp']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fNpwp" required>{{$data['file_npwp']}}
                                                    <div class="invalid-feedback">Lampiran NPWP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SPPKP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rSppkp" id="rSppkp" {{ old('rSppkp',$data['sppkp']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rSppkp" id="rNonSppkp" {{ old('rNonSppkp',$data['sppkp']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fSppkp" required>
                                                    <div class="invalid-feedback">Lampiran SPPKP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>NIB / SIUP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rNib" id="rNib" {{ old('rNib',$data['nib_siup']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rNib" id="rNibNo" {{ old('rNib',$data['nib_siup']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fNib" required>
                                                    <div class="invalid-feedback">Lampiran NIB/SIUP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Akta Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rAkta" id="rAkta" {{ old('rAkta',$data['akta_perusahaan']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rAkta" id="rAktraNo" {{ old('rAkta',$data['akta_perusahaan']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fAkta" required>
                                                    <div class="invalid-feedback">Lampiran Akta Perusahaan belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pakta Integritas</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rPakta" id="rPakta" {{ old('rPakta',$data['pakta_integritas']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rPakta" id="rPaktaNo" {{ old('rPakta',$data['pakta_integritas']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fPakta" required>
                                                    <div class="invalid-feedback">Lampiran Pakta Integritas belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kartu Identitas Direktur</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rKartu" id="rIden" {{ old('rKartu',$data['kartu_identitas_direktur']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rKartu" id="rIdenNo" {{ old('rKartu',$data['kartu_identitas_direktur']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fKartu" required>
                                                    <div class="invalid-feedback">Lampiran Kartu Identitas Direktur belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Struktur Organisasi</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rStruktur" id="rStruktur" {{ old('rStruktur',$data['struktur_organisasi']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rStruktur" id="rStrukturNo" {{ old('rStruktur',$data['struktur_organisasi']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fStruktur" required>
                                                    <div class="invalid-feedback">Lampiran Struktur Organisasi belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Profile Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rProfile" id="rProfile" {{ old('rProfile',$data['profile_perusahaan']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rProfile" id="rProfile" {{ old('rProfile',$data['profile_perusahaan']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fProfile" required>
                                                    <div class="invalid-feedback">Lampiran Profile Perusahaan belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat Lainnya</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="Ada" name="rSurat" id="rSuratLain" {{ old('rSurat',$data['surat_lainnya']) == 'Ada' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="Tidak" name="rSurat" id="rSuratLainNo" {{ old('rSurat',$data['surat_lainnya']) == 'Tidak' ? 'checked' : '' }} required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" name="filenames[]" id="fSurat" required>
                                                    <div class="invalid-feedback">Lampiran lainnya belum dipilih</div>
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
                            <td>Diisi Oleh/Filled by,</td>
                            <td>: {{ session('username') }} {{ session('user_id') }}
                            </td>
                            <td>Diterima Oleh/Received by, :</td>
                            <td> 
                                <select name="dDiterima" class="form-control text-center" required>
                                    <option value="{{$data['diterima_oleh']}}">{{$data['diterima_oleh']}}</option>
                                    @foreach($approvalList as $user)
                                        <option value="{{ $user->nama }}">
                                            {{ $user->nama }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>Disetujui Oleh/Approved by, :</td>
                            <td>
                                <select name="dApproved" class="form-control text-center" required>
                                    <option value="{{$data['disetujui_oleh']}}">{{$data['disetujui_oleh']}}</option>
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
                                <button class="btn btn-primary ms-auto uploadBtn" type="submit" style="margin:3px">
                                    <i class="fas fa-save"></i>
                                    Update
                                </button>
                                    <a href="{{url()->previous()}}" class="btn btn-success" style="margin:3px"><i class="fas fa-cancel"></i> Cancel</a>
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
                    $('#fNpwp').prop('required',false);
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
        // NIB/SIP
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
