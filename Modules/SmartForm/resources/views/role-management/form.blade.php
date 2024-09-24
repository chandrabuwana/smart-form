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
            <form class="card my-4" method="POST" id="formRole">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form Role Management</h6>
                    </div>
                </div>
                <div class="card-body pb-0">
                    {{-- Form Master --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="role_name">Role Name</label>
                                <input type="text" class="form-control" id="role_name" name="role_name"
                                    value="{{ $roleMaster->role_name ?? '' }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="role_code">Role Code</label>
                                <input type="text" class="form-control" id="role_code" name="role_code"
                                    value="{{ $roleMaster->role_code ?? '' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-check ps-0 align-items-center mb-2">
                        <input class="form-check-input" type="checkbox" name="check_all_permission" value="true"
                            {{ isset($rolePermission) && count($rolePermission) == count($modulePermissions) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customCheck1">Check All Permission ({{ $modulePermissions->count() }})</label>
                    </div>

                    <div class="table-responsive">
                        <table id="dataPermission" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Module Name</th>
                                    <th width="10%">Permission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modulePermissions as $i => $module)
                                    <tr>
                                        <td scope="row" class="text-sm text-center">
                                            {{ $i + 1 }}
                                        </td>
                                        <td class="text-sm">
                                            {{ $module->nama }}
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check ps-0">
                                                <input class="form-check-input" type="checkbox" name="module_permission[]" value="{{ $module->id }}"
                                                    {{ isset($rolePermission) && in_array($module->id, $rolePermission->pluck('master_menu_id')->all()) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer py-3">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitRole">
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

        $('#role_code').keyup( function(e) {
            $(this).val(this.value.toLowerCase());
        });

        $('[name=check_all_permission]').change( function(e) {
            const isChecked = $(this).is(':checked');
            if(isChecked) {
                $('[name*=module_permission]').attr('checked', true);
            } else {
                $('[name*=module_permission]').removeAttr('checked');
            }
        });

        $('#btnSubmitRole').click( function(e) {
            e.preventDefault();
            const formData = $('#formRole').serialize();

            axios.post(`{{ isset($roleMaster) ? route('role-management.store-edit', ['id' => $roleMaster->id]) : route('role-management.store-create') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form Role Management Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('role-management.dashboard') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form Role Management'
                });
            });
        });
    </script>
@endsection
