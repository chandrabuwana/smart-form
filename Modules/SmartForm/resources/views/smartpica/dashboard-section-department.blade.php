@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 32px;
            padding: 8px 0px;
        }
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
        .w-full {
            width: 100%;
        }
    </style>
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
                    <div class="d-flex align-items-center">
                        <span>
                            <button class="btn btn-primary ms-auto uploadBtn" onclick="openModal(this)">Add new</button>
                        </span>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="table-level-user" data-toggle="table" data-ajax="getListData" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodocpica">
                            <thead>
                                <tr>
                                    <th data-field="KodeSection" data-align="left" data-halign="center">Kode Section</th>
                                    <th data-field="Nama" data-align="left" data-halign="center">Nama Section</th>
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
    <div class="modal fade" id="modal-add" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
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
                                                    <label for="inputKodeSection" style="width: 100%;">Kode Section</label>
                                                    <input type="text" class="form-control" id="inputKodeSection"
                                                        name="inputKodeSection" placeholder="Kode Section">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputNamaSection" style="width: 100%;">Nama Section</label>
                                                    <input type="text" class="form-control" id="inputNamaSection"
                                                        name="inputNamaSection" placeholder="Nama Section">
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
                        <button onclick="submitData(this)" data-action="add" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitData">
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var baseUrl = ''

        function getListData(params) {
            // if(filter.nik) params.data.nik = filter.nik
            // if(filter.status) params.data.status = filter.status
            // if(filter.department) params.data.department = filter.department
            // console.log("filter : ", filter)

            var url = baseUrl + '/list-section-department'
            // if (dataFilter.nik != null) params.data.filterNIK = dataFilter.nik

            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            var _KodeSection = ", '"+ row.KodeSection + "'"
            var _Nama = ", '"+ row.Nama + "'"
            // _nama = _nama.replace("'", "")

            var _clickEvent = 'onclick="actionEdit(this' + _KodeSection + _Nama +')"'
            var _clickEventDelete = 'onclick="actionDelete(this' + _KodeSection +')"'

            // var btnDetail = '<a href="#" data-caption="" '+ _clickEvent +' data-action="detail" data-show="false" data-url=""><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true"><i class="fa fa-pen cursor-pointer text-info"></i></a>'
            var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-url="" data-show="true" data-action="delete"><i class="fa-solid fa-trash-can cursor-pointer text-danger"></i></a>'
            
            return '<div style="display: flex;justify-content: center;gap: 8px;">' + btnEdit + btnHapus + '</div>'
        }

        function actionEdit(e, kode, nama) {
            console.log({kode: kode, nama: nama})
            $("#btnSubmitData").attr('data-action', 'edit')
            $("#inputKodeSection").prop('disabled', true)
            $("#inputKodeSection").val(kode)
            $("#inputNamaSection").val(nama)
            openModal(e)
        }

        function actionDelete(e, _nomor) {
            console.log(_nomor)
            var dataResp = {
                text: "",
                title: "",
                icon: "error",
            }

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
                            url: baseUrl + "/delete-section-department",
                            method: "delete",
                            data: {
                                kode: _nomor
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
                        dataResp.icon = "error"
                        dataResp.text = "Terjadi kesalahan, coba beberapa saat lagi"
                        dataResp.title = "Gagal!"
                    })
                    .finally(function() {
                        e.disabled = false
                        Swal.fire(dataResp)
                    })
                }
            })
        }

        function openModal(e) {
            $('#modal-add').modal("show")
        }

        $('#modal-add').on('hidden.bs.modal', function (e) {
            if($("#btnSubmitData").attr('data-action') == 'edit') {
                $("#inputKodeSection").val("")
                $("#inputNamaSection").val("")
                $("#btnSubmitData").attr('data-action', 'add') 
                $("#inputKodeSection").prop('disabled', false)
            }
        })

        function validateInput() {
            var validationData = {
                valid: false,
                errors : [],
                data: {
                    kode: $("#inputKodeSection").val().trim(),
                    nama: $("#inputNamaSection").val().trim(),
                }  
            }

            if(validationData.data.kode == "" || validationData.data.kode == null) validationData.errors.push("Kode Section tidak boleh kosong")

            validationData.errors.length > 0 ? validationData.valid = false : validationData.valid = true

            return validationData
        }

        function submitData(e) {
            var actionSubmit = e.getAttribute("data-action")
            var urlSubmit = actionSubmit == "add" ? "/add-section-department" : "/edit-section-department"
            var submitMethod = actionSubmit == "add" ? "post" : "put"
            var messageTemplate = actionSubmit == "add" ? "tambah data section" : "edit data section"
            var validateInputData = validateInput()

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
                    Swal.fire(dataResp)
                })
                .catch(function(err) {
                    dataResp.icon = "error"
                    dataResp.text = "Terjadi kesalahan, coba beberapa saat lagi!"
                    dataResp.title = "Gagal!"
                })
                .finally(function() {
                    e.disabled = false
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
        
    </script>
@endsection

