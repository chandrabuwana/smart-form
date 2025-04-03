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
                        <h6 class="text-white text-capitalize ps-3">Data Supplier</h6>
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

                    <form method="POST" action="{{route('bss-form.sm.submit-approve-supplier')}}" enctype="multipart/form-data">
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
                                                    {{$data['nama_vendor']}}
                                                    <input type="text" class="form-control" id="tId" name="tId" value="{{$data['id']}}" hidden>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Status Pajak</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" value="PKP" name="rPkp" id="rPkp" {{ old('rPkp',$data['status_pajak_pkp']) == 'PKP' ? 'checked' : '' }} disabled>
                                                      <label class="form-check-label" for="rPkp">
                                                        PKP
                                                      </label>
                                                    
                                                      <input class="form-check-input" type="radio" value="NON-PKP" name="rPkp" id="rPkp" {{ old('rPkp',$data['status_pajak_pkp']) == 'NON-PKP' ? 'checked' : '' }} disabled>
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
                                                    {{$data['no_npwp']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Bidang Usaha</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['bidang_usaha']}}
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
                                                      <input class="form-check-input" type="radio" value="Tunai" name="rMetodePembayaran" id="rCash" {{ old('rMetodePembayaran',$data['metode_pembayaran']) == 'Tunai' ? 'checked' : '' }} disabled>
                                                      <label class="form-check-label" for="rPkp">
                                                        Tunai
                                                      </label>
                                                      <input class="form-check-input" type="radio" value="Transfer" name="rMetodePembayaran" id="rTransfer" {{ old('rMetodePembayaran',$data['metode_pembayaran']) == 'Transfer' ? 'checked' : '' }} disabled>
                                                      <label class="form-check-label" for="rNonPkp">
                                                        Transfer
                                                      </label>
                                                      <input class="form-check-input" type="radio" value="Cheque/Giro" name="rMetodePembayaran" id="rCheque" {{ old('rMetodePembayaran',$data['metode_pembayaran']) == 'Cheque/Giro' ? 'checked' : '' }} disabled>
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
                                                    {{$data['syarat_pembayaran']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">PPN %</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['ppn']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">PPH %</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['pph']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Rekening 1</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['nama_rekening_1']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nomor Rekening 1</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['nomor_rekening_1']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Bank 1</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['nama_bank_1']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Alamat Bank 1</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['alamat_bank_1']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Rekening 2</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['nama_rekening_2']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nomor Rekening 2</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['nomor_rekening_2']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Nama Bank 2</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['nama_bank_2']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Alamat Bank 2</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['alamat_bank_2']}}
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
                                                    {{$data['alamat_kantor']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Kota</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['kota']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['telepon']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['email']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Kode Pos</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['kode_pos']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Penanggung Jawab 1</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['pj_1']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['tlp_1']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Jabatan</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['jabatan_1']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['jabatan_1_email']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Penanggung Jawab 2</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['pj_2']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Telepon</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['tlp_2']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Jabatan</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['jabatan_2']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:40%">Email</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['jabatan_2_email']}}
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
                                                    {{$data['npwp']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SPPKP</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['sppkp']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>NIB / SIUP</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['nib_siup']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Akta Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['akta_perusahaan']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pakta Integritas</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['pakta_integritas']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kartu Identitas Direktur</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['kartu_identitas_direktur']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Struktur Organisasi</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['struktur_organisasi']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Profile Perusahaan</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['profile_perusahaan']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat Lainnya</td>
                                                <td>:</td>
                                                <td>
                                                    {{$data['surat_lainnya']}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span style="display: none;" id="requestornik">{{ session('user_id') }}</span>
                        
                        <div class="card-footer">
                        <div class="d align-items-center">
                            @if (session('username')==($data['disetujui_oleh']))
                                <button class="btn btn-primary ms-auto uploadBtn" style="margin:5px" id="btnApprove">
                                    <i class="fas fa-check"></i>
                                    Approve
                                </button>
                                <button class="btn btn-warning ms-auto uploadBtn" style="margin:5px" id="btnReject">
                                    <i class="fas fa-close"></i>
                                    Reject
                                </button>
                                <a href="{{url()->previous()}}" class="btn btn-success" style="margin:5px"><i class="fas fa-cancel"></i> Cancel</a>
                            @else
                                <a href="{{url()->previous()}}" class="btn btn-success" style="margin:5px"><i class="fas fa-cancel"></i> Cancel</a>
                            @endif
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

        
        var btnApprove = $("#btnApprove");
        var btnReject = $("#btnReject");
        var tId = $("#tId");
        var dataArray = {
            formName: "Data Form",
            jobSite: "",
            id: "",
            status: "",
            
            item: [{}]
        }
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
                detial.forEach(element => {
                    $table.bootstrapTable('append', element)
                });
                

                dataPemakaianSolar.fuel = iFuel.val()

            }

            btnApprove.click(function(e) {
                e.preventDefault();
                
                    var dataReq = {
                        id: tId.text(),
                        status: "Approved"
                    }
                    let formData = new FormData();

                    formData.append('item',JSON.stringify(dataArray.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    // TODO
                    axios.post('/bss-form/sm/submit-approve-supplier?id='+tId.text(), formData, {
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
                                title: 'Berhasil di Approve!',
                                // text: response.data.data,
                            }).then((result) => {
                                window.location.href = `/bss-form/sm/registrasi-supplier`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function() {
                        stopLoading()
                    })
                // submitAssetRequest(dataReq);
            })

            btnReject.click(function(e) {
                e.preventDefault();
                
                    var dataReq = {
                        id: tId.text(),
                        status: "Reject"
                    }
                    let formData = new FormData();

                    formData.append('item',JSON.stringify(dataArray.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    // TODO
                    axios.post('/bss-form/log/submit-reject-pemakaian-solar?id='+tId.text(), formData, {
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
                                title: 'Rejected!',
                                // text: response.data.data,
                            }).then((result) => {
                                window.location.href = `/bss-form/log/pemakaian-solar`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function() {
                        stopLoading()
                    })
                // submitAssetRequest(dataReq);
            })
        })
    </script>
@endsection
