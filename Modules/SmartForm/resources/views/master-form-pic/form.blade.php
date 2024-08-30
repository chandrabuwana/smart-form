@extends('master.master_page')

@section('custom-css')
<style>
    .tab-content>.tab-pane.show {
        display: block;
    }

    .w-fit-content {
        width: fit-content;
    }

    input:not([type="checkbox"]):read-only {
        opacity: .85;
        cursor: default !important;
        background-color: rgba(0, 0, 0, 0.02) !important;
    }
</style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="card my-4" method="POST" id="formPIC">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Create Form PIC</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="input-group input-group-static mb-4">
                        <label for="form_name">Form Name</label>
                        <input type="text" class="form-control" id="form_name" name="form_name"
                            value="{{ $formPIC->form_name ?? '' }}" required>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label for="form_slug">Form Slug</label>
                        <input type="text" class="form-control" id="form_slug" value="{{ $formPIC->form_slug ?? '' }}" readonly>
                    </div>

                    <div class="input-group input-group-static">
                        <label for="pic_username">NIK Penanggung Jawab</label>
                        <input type="number" class="form-control" id="pic_username" name="pic_username" value="{{ $formPIC->pic_username ?? '' }}" required>
                    </div>
                </div>

                <div class="card-footer py-3">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitFormPIC">
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
        function slugify(str) {
            str = str.replace(/^\s+|\s+$/g, '');
            str = str.toLowerCase();
            str = str.replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            return str;
        }

        $('#form_name').change( function() {
            $('#form_slug').val( slugify(this.value) );
        });

        $('#btnSubmitFormPIC').click( function(e) {
            e.preventDefault();
            const formData = $('#formPIC').serialize();

            axios.post(`{{ isset($formPIC) ? route('master-form-pic.store-edit', ['id' => $formPIC->id]) : route('master-form-pic.store-create') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form Transmission Test Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('master-form-pic.dashboard') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form Transmission Test'
                });
            });
        });
    </script>
@endsection
