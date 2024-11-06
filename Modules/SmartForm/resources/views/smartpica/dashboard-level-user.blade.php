@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Mapping Validation PICA</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row mx-3">
                        <h5>Cari NIK</h5>
                        <div class="col-lg-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterNIK" style="width: 100%;">NIK</label>
                                <div style="display: flex;width: 100%;gap: 20px">
                                    <input type="text" class="form-control" id="filterNIK" name="filterNIK" placeholder="Filter berdasarkan NIK">
                                    <button class="btn btn-primary ms-auto" style="min-width: 100px;margin: 0px;" onclick="resetFilter(this)">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <span>
                            <button class="btn btn-primary ms-auto uploadBtn" onclick="openModal(this)">Add new</button>
                        </span>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="table-level-user" data-toggle="table" data-ajax="dataListValidation" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodocpica">
                            <thead>
                                <tr>
                                    <th data-field="nik" data-align="left" data-halign="center">NIK</th>
                                    <th data-field="level" data-align="left" data-halign="center">Level</th>
                                    <th data-field="section" data-align="left" data-halign="center">Section</th>
                                    <th data-halign="center" data-align="center"
                                        data-formatter="actionFormatter">Action
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modal-level-user" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Level user</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        {{-- <h6 class="card-title">Biodata Karyawan</h6> --}}
                                        <hr class="horizontal dark my-sm-1">
                                        <div class="row">
                                            <input type="text" style="display: none;" id="inputNomor" name="inputNomor"type="hidden">
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputNik" style="width: 100%;">NIK</label>
                                                    <input type="text" class="form-control" id="inputNik"
                                                        name="inputNik" placeholder="NIK">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputLevel">Level</label>
                                                    <select class="form-control form-select" name="inputLevel" id="inputLevel">
                                                        <option value="">-- Pilih Level --</option>
                                                        <option value="0">Level 0</option>
                                                        <option value="1">Level 1</option>
                                                        <option value="2">Level 2</option>
                                                        <option value="3">Level 3</option>
                                                        <option value="4">Level 4</option>
                                                        <option value="5">Level 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputSection">Section</label>
                                                    <select class="form-control form-select" name="inputSection" id="inputSection">
                                                        <option value="">-- Pilih Section --</option>
                                                        @foreach($data_section as $section)
                                                            <option value="{{ $section->KodeSection }}">{{ $section->Nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <hr class="horizontal dark my-sm-3">

                <div class="row" style="margin:10px">
                    <div class="col text-end" id="masukkanButtonSubmit">
                        <button onclick="submitLevelUser(this)" data-action="add" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitLevelUser">
                            <i class="fas fa-save"></i>
                            Simpan Data</button>
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
        var baseUrl = ''
        var filterNIK = document.getElementById("filterNIK")
        var dataFilter = {
            nik: null
        }

        function actionFormatter(value, row, index) {
            var _nomor = ", '"+ row.nomor + "'"
            var _nik = ", '"+ row.nik + "'"
            var _level = ", '"+ row.level + "'"
            var _section = ", '"+ row.section + "'"
            // _nama = _nama.replace("'", "")

            var _clickEvent = 'onclick="actionEdit(this' + _nomor + _nik  + _level + _section +')"'
            var _clickEventDelete = 'onclick="actionDelete(this' + _nomor +')"'

            // var btnDetail = '<a href="#" data-caption="" '+ _clickEvent +' data-action="detail" data-show="false" data-url=""><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true"><i class="fa fa-pen cursor-pointer text-info"></i></a>'
            var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-url="" data-show="true" data-action="delete"><i class="fa-solid fa-trash-can cursor-pointer text-danger"></i></a>'
            
            return '<div style="display: flex;justify-content: center;gap: 8px;">' + btnEdit + btnHapus + '</div>'
        }

        function openModal(e) {
            $('#modal-level-user').modal("show")
        }

        function actionDelete(e, _nomor) {
            console.log(_nomor)

            Swal.fire({
                title: "Apakah yakin ingin menghapus?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#d33"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios(
                        {
                            url: baseUrl + "/delete-level-user",
                            method: "delete",
                            data: {
                                nomor: _nomor
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    
                        }
                    )
                    .then(function(resp) {
                        if(resp.data.isSuccess) {
                            dataResp.icon = "success"
                            dataResp.text = "Berhasil hapus data!"
                            dataResp.title = "Berhasil!"
                            $("#table-level-user").bootstrapTable('refresh')
                        } else {
                            dataResp.icon = "error"
                            dataResp.text = "Gagal hapus data"
                            dataResp.title = "Gagal!"
                        }
                    })
                    .catch(function(err) {
                        console.log(err)
                    })
                    .finally(function() {
                        e.disabled = false
                        Swal.fire(dataResp)
                    })
                }
            })
        }

        function actionEdit(e, _nomor, _nik, _level, _section) {
            console.log({nomor: _nomor, nik: _nik, level: _level})
            $("#inputLevel").val(_level)
            $("#inputNik").val(_nik)
            $("#inputSection").val(_section == "null" ? "" : _section)
            $("#inputNomor").val(_nomor)
            $("#inputNik").prop("disabled", true)

            $("#btnSubmitLevelUser").attr("data-action", "edit")
            $('#modal-level-user').modal("show")
        }

        $('#modal-level-user').on('hidden.bs.modal', function (e) {
            $("#btnSubmitLevelUser").attr("data-action", "add")
            $("#inputLevel").val("")
            $("#inputNik").val("")
            $("#inputNomor").val("")
            $("#inputNik").prop("disabled", false)
        })

        function dataListValidation(params) {
            // if(filter.nik) params.data.nik = filter.nik
            // if(filter.status) params.data.status = filter.status
            // if(filter.department) params.data.department = filter.department
            // console.log("filter : ", filter)

            var url = baseUrl + '/list-level-user'
            if (dataFilter.nik != null) params.data.filterNIK = dataFilter.nik

            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function validateInput() {
            var validationData = {
                valid: false,
                errors : [],
                data: {
                    nik: $("#inputNik").val().trim(),
                    level: $("#inputLevel").val().trim(),
                    section: $("#inputSection").val().trim()
                }  
            }

            if(validationData.data.nik == "" || validationData.data.nik == null) validationData.errors.push("NIK tidak boleh kosong")
            if(validationData.data.level == "" || validationData.data.level == null) validationData.errors.push("Level tidak boleh kosong")
            if(validationData.data.section == "" || validationData.data.section == null) validationData.errors.push("Section tidak boleh kosong")

            validationData.errors.length > 0 ? validationData.valid = false : validationData.valid = true

            return validationData
        }

        function submitLevelUser(e) {
            var actionSubmit = e.getAttribute("data-action")
            var urlSubmit = actionSubmit == "add" ? "/add-level-user" : "/edit-level-user"
            var submitMethod = actionSubmit == "add" ? "post" : "put"
            var messageTemplate = actionSubmit == "add" ? "tambah data level user" : "edit data level user"
            var validateInputData = validateInput()

            if( actionSubmit == "edit") validateInputData.data.nomor = $("#inputNomor").val()

            if(validateInputData.valid) {
                e.disabled = true
                var dataResp = {
                    text: "",
                    title: "",
                    icon: "error",
                }

                axios(
                    {
                        url: baseUrl + urlSubmit,
                        method: submitMethod,
                        data: validateInputData.data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }
                )
                .then(function(resp) {
                    // console.log(resp.data)
                    if(resp.data.isSuccess) {
                        dataResp.icon = "success"
                        dataResp.text = "Berhasil " + messageTemplate
                        dataResp.title = "Berhasil!"
                        $("#table-level-user").bootstrapTable('refresh')
                    } else {
                        dataResp.icon = "error"
                        dataResp.text = "Gagal " + messageTemplate
                        dataResp.title = "Gagal!"
                    }
                })
                .catch(function(err) {
                    dataResp.icon = "error"
                    dataResp.text = "Terjadi kesalahan, coba beberapa saat lagi!"
                    dataResp.title = "Gagal!"
                })
                .finally(function() {
                    e.disabled = false
                    Swal.fire(dataResp)
                })

            } else {
                var errValidationList = []
                validateInputData.errors.forEach(element => {
                    errValidationList.push(element)
                })

                Swal.fire({
                    icon: "error",
                    title: "Mandatory field kosong",
                    html: errValidationList.join("<br>")
                })
            }
        }

        function resetFilter(e) {
            dataFilter.nik = null
            $("#table-level-user").bootstrapTable('refresh')
        }

        filterNIK.addEventListener("keyup", function(e) {
            if(e.keyCode == 13 && e.target.value.trim().length > 0) {
                e.preventDefault()
                dataFilter.nik = e.target.value
                $("#table-level-user").bootstrapTable('refresh')
            }
        })
        
    </script>
@endsection
