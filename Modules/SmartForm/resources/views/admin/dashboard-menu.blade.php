@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        /* .bg-gradient-danger {
            background-image: none;
        } */
        .arrow {
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
        }
        .down {
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Management Menu</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <button class="btn btn-primary ms-auto" id="tambah-menu">Tambah Menu</button>
                        </a>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="table-dashboard-menu" data-toggle="table" data-ajax="getAllMenu" data-side-pagination="server"
                            data-query-params="dataListFormPicaParamsGenerate"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="id" data-align="center">ID</th>
                                    <th data-field="nama" data-align="left">Nama Menu</th>
                                    <th data-field="link" data-align="left">Link</th>
                                    <th data-field="order" data-align="left">Urutan</th>
                                    <th data-field="status" data-align="center" data-formatter="statusFormatter">Status</th>
                                    <th data-field="action" data-formatter="actionFormatter" data-align="center">Actions</th>
                                    
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
    <div class="modal fade" id="modalForm" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Add Menu</h5>
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
                                        <input type="hidden" id="idMenu" style="display: none">
                                        <hr class="horizontal dark my-sm-1">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="namaMenu">Nama Menu</label>
                                                    <input type="text" class="form-control" id="namaMenu"
                                                        name="namaMenu" placeholder="Management Menu">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="urutanMenu">Urutan Menu</label>
                                                    <input type="text" class="form-control" id="urutanMenu"
                                                        name="urutanMenu" placeholder="Urutan Menu">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="linkMenu">Link</label>
                                                    <input type="text" class="form-control" id="linkMenu"
                                                        name="linkMenu" placeholder="#">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="parentMenu">Parent</label>
                                                    <select class="form-control form-select" name="parentMenu" id="parentMenu" required>
                                                        <option value="">-- Pilih Parent --</option>
                                                        @foreach ($menu as $key => $item)
                                                            <option value="{{$key}}">{{ $item['nama'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="statusMenu">Status</label>
                                                    <select class="form-control form-select" name="statusMenu" id="statusMenu" required>
                                                        <option value="" selected>-- Pilih Status --</option>
                                                        <option value="1" selected>Aktif</option>
                                                        <option value="0" selected>Nonaktif</option>
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
                    <div class="col text-end" id="btnSubmitModal">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitMenu" data-action="add">
                            <i class="fas fa-save"></i>
                            Submit Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        var btnSubmitMenu = document.getElementById("btnSubmitMenu");
        var namaMenu = document.getElementById("namaMenu");
        var urutanMenu = document.getElementById("urutanMenu");
        var linkMenu = document.getElementById("linkMenu");
        var parentMenu = document.getElementById("parentMenu");
        var statusMenu = document.getElementById("statusMenu");

        btnSubmitMenu.addEventListener("click", function(e) {
            var baseURL = ""
            var actionSubmit = e.target.getAttribute("data-action")
            var urlSubmit = actionSubmit == "add" ? "/add-new-menu" : "/edit-menu"
            var submitMethod = actionSubmit == "add" ? "post" : "put"
            var messageTemplate = actionSubmit == "add" ? "tambah data menu" : "edit data menu"
            var validateInputData = validateInput()

            var payload = {
                nama: validateInputData.data.namaMenu,
                link: validateInputData.data.linkMenu,
                urutan: validateInputData.data.urutanMenu,
                parent: validateInputData.data.parentMenu == "null" ? null : validateInputData.data.parentMenu ,
                status: validateInputData.data.statusMenu
            }

            if(actionSubmit == "edit") payload.idMenu = validateInputData.data.idMenu

            console.log(payload)
            axios(
                {
                    url: urlSubmit,
                    method: submitMethod,
                    data: payload,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                }
            )
                .then(function (response) {
                    // console.log(response.data)
                    var alertData = {
                        icon: 'error',
                        title: '',
                        text: ''
                    }

                    if(response.data.isSuccess) {
                        alertData.icon = 'success'
                        alertData.title = 'Berhasil!'
                        alertData.text = response.data.message
                        $("#table-dashboard-menu").bootstrapTable("refresh")
                    } else {
                        alertData.icon = 'error'
                        alertData.title = 'Gagal!'
                        alertData.text = response.data.message
                    }

                    Swal.fire(alertData)
                })
                .catch(function (error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan, coba beberapa saat lagi!'
                    })
                });
        }) 

        $("#tambah-menu").click(function(e) {
            $('#modalForm').modal("show");
        })
        
        function actionFormatter(value, row, index) {
            var _id = ", '"+ row.id + "'"
            var _nama = ", '"+ row.nama + "'"
            var _link = ", '"+ row.link + "'"
            var _order = ", '"+ row.order + "'"
            var _status = ", '"+ row.status + "'"
            var _parent = ", '"+ row.parent + "'"
            var _parent_nama = ", '"+ row.parent_nama + "'"
            // _nama = _nama.replace("'", "")

            var _clickEvent = 'onclick="actionEdit(this' + _id +_nama + _link + _order + _status + _parent + _parent_nama +')"'
            var _clickEventDelete = 'onclick="actionDelete(this' + _id +')"'

            // var btnDetail = '<a href="#" data-caption="" '+ _clickEvent +' data-action="detail" data-show="false" data-url=""><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true"><i class="fa fa-pen cursor-pointer text-info"></i></a>'
            var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-url="" data-show="true" data-action="delete"><i class="fa-solid fa-trash-can cursor-pointer text-danger"></i></a>'
            
            return '<div style="display: flex;justify-content: center;gap: 8px;">' + btnEdit + btnHapus + '</div>'
        }

        function actionEdit(e, _id, _nama, _link, _order, _status, _parent, _parent_nama) {
            if(_id == "null") _id = ""
            if(_nama == "null") _nama = ""
            if(_link == "null") _link = ""
            if(_order == "null") _order = ""
            if(_status == "null") _status = ""
            if(_parent == "null") _parent = ""
            if(_parent_nama == "null") _parent_nama = ""

            $("#idMenu").val(_id)
            $("#namaMenu").val(_nama)
            $("#urutanMenu").val(_order)
            $("#linkMenu").val(_link)
            $("#parentMenu").val(_parent)
            $("#statusMenu").val(_status)
            $("#btnSubmitMenu").attr("data-action", "edit")

            $("#modalForm").modal("show")
        }

        function actionDelete(e, _id) {
            console.log(_id)
            var dataResp = {
                icon: "error",
                text: "",
                title: ""
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
                            url: "/delete-menu",
                            method: "delete",
                            data: {
                                idMenu: _id
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
                            $("#table-dashboard-menu").bootstrapTable("refresh")
                        } else {
                            dataResp.icon = "error"
                            dataResp.text = "Gagal hapus data"
                            dataResp.title = "Gagal!"
                        }
                        // Swal.fire(dataResp)
                    })
                    .catch(function(err) {
                        Swal.fire({
                            icon: "error",
                            text: "Terjadi kesalahan, coba beberapa saat lagi",
                            title: "Gagal"
                        })
                    })
                    .finally(function() {
                        e.disabled = false
                        Swal.fire(dataResp)
                    })
                }
            })
        }

        $('#modalForm').on('hidden.bs.modal', function (e) {
            if($("#btnSubmitMenu").attr("data-action") == "edit") {
                $("#idMenu").val("")
                $("#namaMenu").val("")
                $("#urutanMenu").val("")
                $("#linkMenu").val("")
                $("#parentMenu").val("")
                $("#statusMenu").val("")

                $("#btnSubmitModal").attr("data-action", "add")
            }
        })

        function validateInput() {
            var validationData = {
                valid: false,
                errors : [],
                data: {
                    idMenu: $("#idMenu").val(),
                    namaMenu: $("#namaMenu").val(),
                    urutanMenu: $("#urutanMenu").val(),
                    linkMenu: $("#linkMenu").val(),
                    parentMenu: $("#parentMenu").val(),
                    statusMenu: $("#statusMenu").val(),
                }  
            }

            if(validationData.data.namaMenu == "" || validationData.data.namaMenu == null) validationData.errors.push("Nama Menu tidak boleh kosong")
            if(validationData.data.urutanMenu == "" || validationData.data.urutanMenu == null) validationData.errors.push("Urutan Menu tidak boleh kosong")
            if(validationData.data.linkMenu == "" || validationData.data.linkMenu == null) validationData.errors.push("Link Menu tidak boleh kosong")
            if(validationData.data.statusMenu == "" || validationData.data.statusMenu == null) validationData.errors.push("Status Menu tidak boleh kosong")

            validationData.errors.length > 0 ? validationData.valid = false : validationData.valid = true

            return validationData
        }

        function submitData() {
            var baseURL = ""
            var actionSubmit = e.getAttribute("data-action")
            var urlSubmit = actionSubmit == "add" ? "/add-level-mapping" : "/edit-level-mapping"
            var submitMethod = actionSubmit == "add" ? "post" : "put"
            var messageTemplate = actionSubmit == "add" ? "tambah data level user" : "edit data level user"
            var validateInputData = validateInput()
        }

        function statusFormatter(value, row, index) {
            return value == "1" ? "Aktif" : "Nonaktif";
        }

        function getAllMenu(params) {
            var url = '/get-all-menu'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

        function dataListFormPicaParamsGenerate(params) {

            params.search = {
                'CARNAME': "",
            };

            if (params.sort == undefined) {
                return {
                    limit: params.limit,
                    offset: params.offset,
                    search: params.search
                }
            }
            return params;
        }
        
        function headerStyle(column) {
            return {
            nama: {
                classes: 'text-center'
            },
            link: {
                classes: 'text-center'
            }
            }[column.field]
        }
    </script>
@endsection
