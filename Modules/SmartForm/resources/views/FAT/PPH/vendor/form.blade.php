@extends('master.master_page')

@section('custom-css')
<style>
    .w-fit-content {
        width: fit-content;
    }

    input:not([type="checkbox"]):read-only {
        opacity: .85;
        cursor: default !important;
        background-color: rgba(0, 0, 0, 0.02) !important;
    }

    input:read-only:focus {
        background-image: linear-gradient(0deg, #e91e63 2px, rgba(156, 39, 176, 0) 0), linear-gradient(0deg, #d2d2d2 1px, rgba(209, 209, 209, 0) 0) !important;
    }
</style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="card my-4" method="POST" id="formUser">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form User Vendor PPH</h6>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="npwp">NPWP</label>
                                <input type="text" class="form-control" id="npwp" name="npwp"
                                    value="{{ $vendorPPH->npwp ?? '' }}" placeholder="--- Masukkan NPWP ---" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ $vendorPPH->email ?? '' }}" placeholder="--- Masukkan Email ---" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ $vendorPPH->Nama ?? '' }}" placeholder="--- Masukkan Nama ---" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="--- Buat Password ---" {{ isset($vendorPPH) ? 'required' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer py-3">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitUser">
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $('#btnSubmitUser').click( function(e) {
            e.preventDefault();
            const formData = $('#formUser').serialize();

            axios.post(`{{ isset($vendorPPH) ? route('bss-pph-vendor.update', ['id' => $vendorPPH->id]) : route('bss-pph-vendor.store') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form User Vendor Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('bss-pph-vendor.dashboard') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form User Vendor'
                });
            });
        });
    </script>
@endsection
