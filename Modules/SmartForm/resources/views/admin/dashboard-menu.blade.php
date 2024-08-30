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
    <div class="modal fade" id="modalFormMedis" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
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
                                                        <option value="null">-- Pilih Parent --</option>
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
                    <div class="col text-end" id="masukkanButtonSubmit">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitMenu">
                            <i class="fas fa-save"></i>
                            Submit Data</button>
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
            var payload = {
                nama: namaMenu.value,
                link: linkMenu.value,
                urutan: urutanMenu.value,
                parent: parentMenu.value == "null" ? null : parentMenu.value,
                status: statusMenu.value
            }

            console.log(payload)
            axios.post('/add-new-menu', payload, 
                {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                })
                .then(function (response) {
                    console.log(response.data)
                    $('#modalFormMedis').modal("hide");
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: `${response.data.message} `,
                    }).then((result) => {
                        
                    })
                })
                .catch(function (error) {
                    console.log(error);
                });
        }) 
        $("#tambah-menu").click(function(e) {
            $('#modalFormMedis').modal("show");
        })
        function actionFormatter(value, row, index) {
            return '<button class="btn btn-primary btn-action"><a href="#">detail</a></button><button class="btn btn-primary btn-action"><a href="#">detail</a></button>';
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
