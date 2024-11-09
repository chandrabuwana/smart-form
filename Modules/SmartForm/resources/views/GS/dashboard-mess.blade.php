@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Management Mess</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <button class="btn btn-primary ms-auto" id="tambah-menu">Tambah Mess</button>
                        </a>
                    </div>
                    <div>
                        <div class="mx-4 row">
                            <div class="col-6 col-md-3">
                                <div class="input-group input-group-static mb-4">
                                    <label for="filterSite">Site</label>
                                    <select class="form-control form-select" name="filterSite" id="filterSite">
                                        <option value="">-- Filter Site --</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" id="btnFilter1" onclick="applyFilter(this)">
                                    Filter
                                </button>
                                <button class="btn btn-primary" id="btnClearFilter1" onclick="resetFilter(this)">
                                    Clear Filter
                                </button>
                            </div>
                        </div>
                    <div class="table-responsive p-0">
                        <table id="table-dashboard-mess" data-toggle="table" data-ajax="getAllMess" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="nama_mess" data-align="left" data-halign="center">Nama Mess</th>
                                    <th data-field="site" data-align="left">Site</th>
                                    <th data-field="status" data-align="left" data-formatter="statusFormatter">Status</th>
                                    <th data-field="jumlah_kamar" data-align="center">Jumlah Kamar</th>
                                    {{-- <th data-field="daya_tampung" data-align="left">Daya Tampung</th> --}}
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
    <div class="modal fade" id="addMess" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Add Mess</h5>
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
                                            <div class="col-6 col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputSite" style="width: 100%;">Site</label>
                                                    <select class="js-example-responsive" style="width: 100%" id="inputSite" name="inputSite"></select>
                                                    {{-- <input type="text" class="form-control form-select" id="inputSite"
                                                        name="inputSite" placeholder="Cari Site"> --}}
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputNoDoc">No Doc</label>
                                                    <input type="text" class="form-control" id="inputNoDoc"
                                                        name="inputNoDoc" placeholder="Nomor Doc">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputNamaMess">Nama Mess</label>
                                                    <input type="text" class="form-control" id="inputNamaMess"
                                                        name="inputNamaMess" placeholder="Nama Mess">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputStatus">Status</label>
                                                    <select class="form-control form-select" name="inputStatus" id="inputStatus" required>
                                                        <option value="">-- Pilih Status --</option>
                                                        <option value="0" selected>Aktif</option>
                                                        <option value="1" selected>Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="col-6 col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputDayaTampung">Daya Tampung</label>
                                                    <input type="text" class="form-control" id="inputDayaTampung"
                                                        name="inputDayaTampung" placeholder="Daya Tampung Mess">
                                                </div>
                                            </div> --}}
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputJumlahKamar">Jumlah Kamar</label>
                                                    <input type="text" class="form-control" id="inputJumlahKamar"
                                                        name="inputJumlahKamar" placeholder="Jumlah Kamar">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputAlamat">Alamat Mess</label>
                                                    <input type="text" class="form-control" id="inputAlamat"
                                                        name="inputAlamat" placeholder="Alamat Mess">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputKeterangan">Keterangan</label>
                                                    <input type="text" class="form-control" id="inputKeterangan"
                                                        name="inputKeterangan" placeholder="Keterangan">
                                                </div>
                                            </div>
                                            <!--<div class="">
                                                <a href="" id="linkDetailHuni">
                                                    <button  data-action="add" data-url="" class="btn btn-primary ms-auto uploadBtn" style="display: none;" id="btnDetailHuni">
                                                        <i class="fas fa-save"></i>
                                                        Detail huni
                                                    </button>
                                                </a>
                                            </div>-->
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
                        <button onclick="submitMess(this)" data-action="add" data-url="" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitMenu">
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
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        var loadingAnimation = document.getElementById("loading-animation")
        var btnSubmit = document.getElementById("btnSubmitMenu")
        // var btnDetailHuni = document.getElementById("btnDetailHuni")
        var linkDetailHuni = document.getElementById("linkDetailHuni")
        var baseUrlDetailHuni = "/bss-form/catering/mess/detail-huni"
        const tableDashboardMess = $("#table-dashboard-mess")
        const filterParams = {
            site: null
        }
        var data = {
            data: []
        }

        var selected = {}

        $('#filterSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterSite').closest('.input-group'),
            placeholder: '--- Cari SITE ---'
        })

        $("#tambah-menu").click(function(e) {
            btnSubmit.innerText = "Submit";
            btnSubmit.style.display = ""
            clearModal()
            $('#addMess').modal("show");
        })

        function submitMess(e) {
            var reqBody = {
                site: $("#inputSite").val(),
                no_doc: $("#inputNoDoc").val(),
                nama_mess: $("#inputNamaMess").val(),
                status: $("#inputStatus").val(),
                // daya_tampung: $("#inputDayaTampung").val(),
                jumlah_kamar: $("#inputJumlahKamar").val(),
                alamat: $("#inputAlamat").val(),
                keterangan: $("#inputKeterangan").val(),
                _action: e.getAttribute("data-action")
            }

            axios.post("/bss-form/catering/mess/add-mess", reqBody, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                var dataAlert = {
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "",
                }
                // console.log(data)
                if(data.data.isSuccess) {
                    dataAlert.text = data.data.message + " " + reqBody.no_doc
                    $('#table-dashboard-menu').bootstrapTable("refresh")
                } else {
                    dataAlert.icon = "error"
                    dataAlert.title = "Gagal!"
                    dataAlert.text = data.data.message
                }

                Swal.fire(dataAlert).then((result) => {

                })
            })
            .catch(function (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "Terjadi kesalahan, coba beberapa saat lagi",
                }).then((result) => {
                    
                })
            })
        }

        $('#inputSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputSite').closest('.input-group'),
            placeholder: '--- Cari Site ---'
        });

        function actionFormatter(value, row, index) {
            // console.log(JSON.stringify(row))
            var _site = ", '"+ row.site + "'"
            var _kode_mess = ", '"+ row.kode_mess + "'"
            var _nama_mess = ", '"+ row.nama_mess + "'"
            var _status = ", '"+ row.status + "'"
            var _jumlah_kamar = ", '"+ row.jumlah_kamar + "'"
            var _daya_tampung = ", '"+ row.daya_tampung + "'"
            var _keterangan = ", '"+ row.keterangan + "'"
            var _alamat = ", '"+ row.alamat + "'"

            var _clickEvent = 'onclick="modalDetail(this' + _site + _kode_mess + _nama_mess + _status + _jumlah_kamar + _daya_tampung + _keterangan +_alamat +')"'
            // var _clickEvent = '"';
            var btnDetail = '<a href="#" data-caption="" '+ _clickEvent +' data-action="detail" data-show="false" data-url=""><i class="fa fa-info-circle cursor-pointer"></i></a>'
            var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true"><i class="fa fa-pen cursor-pointer"></i></a>'
            var btnHapus = '<a href="#" '+ _clickEvent +' data-caption="" data-url="" data-show="true" data-action="delete"><i class="fa-solid fa-trash-can cursor-pointer"></i></a>'
            
            return btnDetail + btnEdit + btnHapus
        }

        function modalDetail(e, site, kd_mess, nm_mess, stts, jml_kmr, dy_tampung, ket, almt) {
            console.log(jml_kmr)
            var _action = e.getAttribute("data-action")
            var _caption = e.getAttribute("data-caption")
            $("#inputSite").val(site).trigger('change')
            $("#inputNoDoc").val(kd_mess)
            $("#inputNamaMess").val(nm_mess)
            $("#inputStatus").val(stts)
            // $("#inputDayaTampung").val(dy_tampung)
            $("#inputJumlahKamar").val(jml_kmr)
            $("#inputAlamat").val(almt)
            $("#inputKeterangan").val(ket)

            if(_action == "edit") {
                btnSubmit.setAttribute("data-action", "edit")
                btnSubmit.style.display = ""
                $("#inputNoDoc").prop("disabled", true)
                btnSubmit.innerText = _caption;
                $('#addMess').modal("show");
            }
            
            if(_action == "detail") {
                // btnSubmit.disabled = true
                // btnDetailHuni.style.display = ""
                btnSubmit.style.display = "none"
                // btnDetailHuni.setAttribute("data-code", kd_mess)
                $('#addMess').modal("show");
                // linkDetailHuni.href = baseUrlDetailHuni + "?kode_mess=" + encodeURIComponent(kd_mess)
            }

            if(_action == "delete") {
                Swal.fire({
                    title: "Konfirmasi hapus?",
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                    denyButtonText: "Batal",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    text: "Apakah yakin ingin mengapus mess " + kd_mess + " ?"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var reqBody = {
                            _action: "delete",
                            nama_mess: nm_mess,
                            status: stts,
                            jumlah_kamar: jml_kmr,
                            alamat: almt,
                            keterangan: ket,
                            site: site,
                            no_doc: kd_mess,
                        }
                        axios.post("/bss-form/catering/mess/add-mess", reqBody, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .then(function(data) {
                            var dataAlert = {
                                icon: 'success',
                                title: 'Berhasil!',
                                text: "",
                            }
                            console.log(data.data.isSuccess)
                            if(data.data.isSuccess) {
                                dataAlert.text = data.data.message + " " + reqBody.no_doc
                                $('#table-dashboard-menu').bootstrapTable("refresh")
                            } else {
                                dataAlert.icon = "error"
                                dataAlert.title = "Gagal!"
                                dataAlert.text = data.data.message
                            }

                            Swal.fire(dataAlert).then((result) => {

                            })
                        })
                        .catch(function (err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: "Terjadi kesalahan, coba beberapa saat lagi",
                            }).then((result) => {
                                
                            })
                        })
                    }
                });
            }
        }

        function statusFormatter(value, row, index) {
            return value == "0" ? "Aktif" : "Nonaktif";
        }

        function getAllMess(params) {
            var url = '/bss-form/catering/mess/list-mess'
            if(filterParams.site) params.data.site = filterParams.site
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        $('#table-dashboard-menu').on('click-cell.bs.table', function (field, value, row, $element) {
            // console.log({$element, value, field, row})
            selected = $element
        })
        
        function fetchSite(cb=function(site) {}) {
            axios.post("/bss-form/catering/helper-site", {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                var opstionSite = []
                // opstionSite.push(new Option("--- Cari Site ---", "", true, true))
                opstionSite.push({
                    id: "",
                    text: "--- Cari Site ---"
                })

                data.data.data.forEach(element => {
                    opstionSite.push({
                        id: element.id,
                        text: element.text
                    })

                    // opstionSite.push(new Option(element.text, element.id))
                });
                
                cb(opstionSite)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }
        
        function clearModal() {
            $("#inputSite").val("").trigger('change')
            $("#inputNoDoc").val("")
            $("#inputNoDoc").val("")
            $("#inputNamaMess").val("")
            $("#inputStatus").val("")
            // $("#inputDayaTampung").val("")
            $("#inputJumlahKamar").val("")
            $("#inputAlamat").val("")
            $("#inputKeterangan").val("")
        }
        $('#addMess').on('hidden.bs.modal', function (e) {
            btnSubmit.setAttribute("data-action", "add")
            $("#inputNoDoc").prop("disabled", false)
            // btnDetailHuni.style.display = "none"
            clearModal()
        })
        $( document ).ready(function() {
            // console.log( "document loaded" );
        });

        $('#filterSite').change( function(e) {
            filterParams.site = e.target.value;
        });

        function applyFilter(e) {
            tableDashboardMess.bootstrapTable('refresh')
        }

        function resetFilter(e) {
            filterParams.site = null
            $('#filterSite').val('').trigger('change');

            tableDashboardMess.bootstrapTable('refresh')
        }

        fetchSite(function(data) {
            data.forEach(function(opt) {
                $('#filterSite').append(new Option(opt.text, opt.id))
                $('#inputSite').append(new Option(opt.text, opt.id))
            })
        })
    </script>
@endsection