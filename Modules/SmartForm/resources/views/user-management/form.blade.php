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
                        <h6 class="text-white text-capitalize ps-3">Form User Management</h6>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="input-group input-group-static mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ $userMaster->username ?? '' }}">
                    </div>

                    <div class="input-group input-group-static mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            {{ isset($userMaster) ? '' : 'required' }}>
                    </div>

                    <div class="input-group input-group-static">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id">
                            <option value="" selected disabled>Pilih Role</option>

                            @foreach($roleMaster as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
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
        function slugify(str) {
            str = str.replace(/^\s+|\s+$/g, '');
            str = str.toLowerCase();
            str = str.replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            return str;
        }

        $('#role_name').change( function(e) {
            $('#role_slug').val( slugify(this.value) );
        });

        $('[name=check_all_permission]').change( function(e) {
            const isChecked = $(this).is(':checked');
            if(isChecked) {
                $('[name*=module_permission]').attr('checked', true);
            } else {
                $('[name*=module_permission]').removeAttr('checked');
            }
        });

        $('#btnSubmitUser').click( function(e) {
            e.preventDefault();
            const formData = $('#formUser').serialize();

            axios.post(`{{ isset($userMaster) ? route('user-management.store-edit', ['id' => $userMaster->userid]) : route('user-management.store-create') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form User Management Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('user-management.dashboard') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form User Management'
                });
            });
        });
    </script>
@endsection
