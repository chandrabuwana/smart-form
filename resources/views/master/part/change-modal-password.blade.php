<div class="modal fade" id="changePasswordUserModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col">
                        <h5>Change Password</h5>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="card border" style="">
                <div class="card-body">
                    <h5 class="card-title">Perubahan Password Untuk User : {{ session('username') }}
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static my-4">
                                <label for="old_passwordChangePassword" class="ms-0">Password Lama</label>
                                <input class="form-control" type="password" placeholder="Masukkan Password yang Lama"
                                    name="old_passwordChangePassword" required id="old_passwordChangePassword">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static my-4">
                                <label for="new_passwordChangePassword" class="ms-0">Password Baru</label>
                                <input class="form-control" type="password" placeholder="Masukkan Password Yang Baru"
                                    name="new_passwordChangePassword" required id="new_passwordChangePassword">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static my-4">
                                <label for="konfirmation_passwordChangePassword" class="ms-0">Konfirmasi Password
                                    Baru</label>
                                <input class="form-control" type="password" placeholder="Konfirmasi Password Yang Baru"
                                    name="konfirmation_passwordChangePassword" required
                                    id="konfirmation_passwordChangePassword">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-sm-3">

            <div class="row" style="margin:10px">
                <div class="col text-end">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" style="margin : 20px"
                            onclick="sendDataChangePasswordUser()">
                            <i class="fas fa-save"></i>
                            Save All Data</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
