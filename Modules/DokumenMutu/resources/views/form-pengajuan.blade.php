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
            <form method="POST" action="{{ route('form-pengajuan.store') }}"
                class="card my-4" enctype="multipart/form-data">
                @csrf

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Form Pengajuan Dokumen Mutu
                        </h6>
                    </div>
                </div>

                <div class="card-body my-1">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Site</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control form-select" name="site" id="site" required>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Judul Dokumen</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control input-text" id="judulDokumen" name="judulDokumen" placeholder="--- Masukkan Judul Dokumen ---" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Jenis Dokumen</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select input-text" aria-label="Default select example" id="jenisDokumen" name="jenisDokumen" required>
                                <option value="" selected disabled>-- Pilih Site Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Alasan Pengajuan</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control input-text" id="alasanPengajuan" name="alasanPengajuan" placeholder="--- Masukkan Alasan Pengajuan ---" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="ms-0 fs-6">Upload Dokumen</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" class="form-control input-text" id="dokumen" name="dokumen" accept="application/pdf" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer pt-0">
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitForm">
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
            $('#site').select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                dropdownParent: $('#site').parent(),
                placeholder: '--- Cari Site ---',
                ajax: {
                    url: "/helper/site",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            query: params.term, // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                }
            });

            $('#site').change( function(e) {
                if(this.value == 'JKT') {
                    $('#jenisDokumen').html(`
                        <option value="" selected disabled>-- Pilih Jenis Dokumen --</option>
                        <option value="SOP">Standart Operating Procedur</option>
                        <option value="STD">Standart</option>
                        <option value="WI">Working Instruction</option>
                        <option value="FRM">Form</option>
                    `);
                } else {
                    $('#jenisDokumen').html(`
                        <option value="" selected disabled>-- Pilih Jenis Dokumen --</option>
                        <option value="FRM">Form</option>
                    `);
                }
            });

            $('#btnSubmitForm').on('click', function(e) {
                const $form = $(this).closest('form')
                const isFormValid = $form.length > 0 && $form[0].checkValidity()

                if(isFormValid) {
                    $(this).attr('disabled', true);
                    Swal.fire({
                        title: 'Loading...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    $form.submit();
                }
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
