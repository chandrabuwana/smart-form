@extends('master.master_page')

@section('custom-css')
    <style>
        .input-text {
            border: 1px solid #d2d6da !important;
            border-color: rgb(188, 188, 188);
            padding-left: 0.4rem !important;
            padding-right: 0.4rem !important;
        }

        .select2-container {
            border: 1px solid #d2d6da !important;
            padding-top: 8.5px !important;
            border-radius: 0.375rem !important;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-xl-8">
            <form class="card my-4" method="POST" action="{{ route('form-penghapusan.store') }}">
                @csrf

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Form Penghapusan Dokumen Mutu
                        </h6>
                    </div>
                </div>

                <div class="card-body my-1">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Nomor Dokumen</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-text" id="noDokumen" name="noDokumen" placeholder="--- Masukkan Nomor Dokumen ---">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Site</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-text" id="site" placeholder="--- Ketik Nomor Dokumen Dahulu ---" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Judul Dokumen</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-text" id="judulDokumen" placeholder="--- Ketik Nomor Dokumen Dahulu ---" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Jenis Dokumen</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control input-text" id="jenisDokumen" placeholder="--- Ketik Nomor Dokumen Dahulu ---" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Alasan Penghapusan</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control input-text" id="alasanPengajuan" name="alasanPengajuan" placeholder="--- Masukkan Alasan Pengajuan ---">
                        </div>
                    </div>
                </div>

                <div class="card-footer pt-0">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitForm">
                            <i class="fas fa-save"></i>
                            Submit Form
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>

    <script type="text/javascript">
        $( function() {
            $('#noDokumen').change( function(e) {
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: `{{ route('dokumen-mutu.detail') }}?no_dokumen=${ $('#noDokumen').val().trim() }`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();
                        $('#site').val(response.NamaSite);
                        $('#judulDokumen').val(response.judul_dokumen);
                        $('#jenisDokumen').val(response.jenis_dokumen);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(thrownError);
                        Swal.close();

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `Terjadi kesalahan tidak terduga`,
                        });
                    }
                });
            });
        });
    </script>

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `{{ session('error') }}`,
            });
        </script>

    @elseif(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Yeay!',
                text: `{{ session('success') }}`,
            });
        </script>
    @endif
@endsection
