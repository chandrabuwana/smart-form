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

                    <form action="" method="POST" id="formRegis">
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
                                                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        PKP
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="rNonPkp" required>
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
                                            <tr>
                                                <td style="width:40%">Kode Pos</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" onkeypress="return isNumber(event)" class="form-control" id="tKodePos" name="tKodePos" placeholder="Postal Code" required>
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
                                                      <input class="form-check-input" type="radio" name="fileNpwp" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="fileNpwp" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran NPWP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SPPKP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="fileSppkp" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="fileSppkp" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran SPPKP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>NIB / SIUP</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="fileNib" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="fileNib" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran NIB / SIUP belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Akta Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="fileAkta" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="fileAkta" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran Akta Perusahaan belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pakta Integritas</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="filePakta" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="filePakta" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran Pakta Integritas belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kartu Identitas Direktur</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="fileKartu" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="fileKartu" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran Identitas Direktur belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Struktur Organisasi</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="fileStruktur" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="fileStruktur" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran Struktur Organisasi belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Profile Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="fileProfile" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="fileProfile" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran Profile Perusahaan belum dipilih</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat Lainnya</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="fileSurat" id="rPkp" required>
                                                      <label class="form-check-label" for="rPkp">
                                                        Ada
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" name="fileSurat" id="rNonPkp" required>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Tidak
                                                      </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" aria-label="file example" required>
                                                    <div class="invalid-feedback">Lampiran lainnya belum dipilih</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span style="display: none;" id="requestornik">{{ session('user_id') }}</span>
                    </form>

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
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        var tglNow = new Date()
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var months_romawi = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

        var btnSubmit = $("#btnSubmit");

        function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ( (charCode > 31 && charCode < 48) || charCode > 57) {
            return false;
        }
        return true;
        }
       
        $('#btnSubmit').click( function(e) {
            e.preventDefault();
            const formData = $('#formRegis').serialize();

            axios.post(`{{ isset($formRegis) ? route('bss-form.sm.edit-registrasi-supplier', ['id' => $formRegis->id]) : route('bss-form.sm.create-registrasi-supplier') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form Registrasi Supplier Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('bss-form.sm.registrasi-supplier') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form Registrasi Supplier'
                });
            });
        });
    </script>
@endsection
