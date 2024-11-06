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
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4 pb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Management Kamar Mess</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterSite">Site</label>
                                <select class="form-control form-select" name="filterSite" id="filterSite">
                                    <option value="">-- Filter Site --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterMess">Mess</label>
                                <select class="form-control form-select" name="filterMess" id="filterMess">
                                    <option value="">-- Filter Mess --</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnFilterSubmit">
                                Filter
                            </button>
                        </div>
                    </div>

                    <h4 class="mx-3">Tambah Kamar</h4>
                    <div class="mx-4 row">
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputKamar">No / Nama Kamar</label>
                                <input type="text" class="form-control" id="inputKamar" name="inputKamar" placeholder="Nomor Doc">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputKapasitas">Kapasitas</label>
                                <input type="text" class="form-control" id="inputKapasitas" name="inputKapasitas" placeholder="Nomor Doc">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary ms-auto filter-btn" id="btnSaveKamar">
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="table-dashboard-huni" data-toggle="table" data-ajax="getDetailHuniMess" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="site" data-align="left">Site</th>
                                    <th data-field="nama_mess" data-align="left" data-halign="center">Nama Mess</th>
                                    <th data-field="no_kamar" data-align="left" data-formatter="kamarFormatter">Kamar</th>
                                    <th data-field="kapasitas" data-align="left">Kapasitas</th>
                                    <th data-field="terisi" data-align="left">Terisi</th>
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
                                                    <input type="text" class="form-control" id="inputSite"
                                                        name="inputSite" placeholder="Site" disabled>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputNoDoc">Mess</label>
                                                    <input type="text" class="form-control" id="inputNoDoc"
                                                        name="inputNoDoc" placeholder="Nomor Doc" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="editKamar">kamar</label>
                                                    <input type="text" class="form-control" id="editKamar"
                                                        name="editKamar" placeholder="Nama Kamar">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="editKapasitas">Kapasitas Kamar</label>
                                                    <input type="text" class="form-control" id="editKapasitas"
                                                        name="editKapasitas" placeholder="Kapasitas">
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
                        <button onclick="simpanKamar(this)" data-kamar="" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitKamar">
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
        var baseUrl = '/bss-form/catering/mess/list-kamar'
        var helperMessURL = '/bss-form/catering/mess'
        var queryParams =  new URLSearchParams(window.location.search);
        var kode_mess_query = queryParams.get("kode_mess")
        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
        // var btnAddKamar = document.getElementById("btnAddKamar")
        var btnSaveKamar = document.getElementById("btnSaveKamar")
        var inputKamar = document.getElementById("inputKamar")
        var inputKapasitas = document.getElementById("inputKapasitas")
        var inputSite = document.getElementById("inputSite")
        var inputNoDoc = document.getElementById("inputNoDoc")
        var editKamar = document.getElementById("editKamar")
        var editKapasitas = document.getElementById("editKapasitas")
        var $tableDashboardHuni = $("#table-dashboard-huni");
        
        var filter = {
            site: null,
            mess: null
        }

        function validateAddKamar() {
            // var isValid = true
            var errMsg = {
                isValid: true,
                errorMsg: [],
                data: {
                    site: $('#filterSite').val(),
                    kode_mess: $('#filterMess').val(),
                    kamar: inputKamar.value,
                    kapasitas: inputKapasitas.value
                }
            }
            
            if($('#filterSite').val().trim() == "" || $('#filterSite').val().length < 1) {
                errMsg.isValid = false
                errMsg.errorMsg.push("Site tidak boleh kosong")
            }
            if($('#filterMess').val().trim() == "" || $('#filterMess').val().length < 1) {
                errMsg.isValid = false
                errMsg.errorMsg.push("Mess tidak boleh kosong")
            }
            if(inputKamar.value.trim() == "" || inputKamar.value.length < 1) {
                errMsg.isValid = false
                errMsg.errorMsg.push("Kamar tidak boleh kosong")
            }
            if(inputKapasitas.value.trim() == "" || inputKapasitas.value.length < 1 || isNaN(parseInt(inputKapasitas.value))) {
                errMsg.isValid = false
                errMsg.errorMsg.push("Kapasitas tidak boleh kosong / nilai tidak valid")
            }
            
            return errMsg 
        }

        btnSaveKamar.addEventListener("click", function(e) {
            // $('#addMess').modal("show");
            var validasiAddkamar = validateAddKamar()
            if(validasiAddkamar.isValid) {
                axios.post(helperMessURL + "/add-kamar", validasiAddkamar.data, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(function(resp) {
                    var alertData = {
                        icon: 'error',
                        title: 'Gagal!',
                        text: "Terjadi kesalahan, coba beberapa saat lagi",
                    }

                    alertData.text = resp.data.message
                    if(resp.data.isSuccess) {
                        alertData.icon = "success"
                        alertData.title = "Berhasil!"
                        $tableDashboardHuni.bootstrapTable('refresh')
                    } else {
                        alertData.icon = "error"
                        alertData.title = "Gagal!"
                    }

                    Swal.fire(alertData)
                })
                .catch(function(err) {
                    console.log(err)
                })
                
            } else {
                var _msg = []
                validasiAddkamar.errorMsg.forEach(function(data) {
                    _msg.push("<span>" + data +"</span>")
                })

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: _msg.join("<br>")
                })
            }
        })
        btnFilterSubmit.addEventListener("click", function(e) {
            $tableDashboardHuni.bootstrapTable('refresh')
        })

        $('#filterSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterSite').closest('.input-group'),
            placeholder: '--- Cari Site ---'
        });
        $('#filterMess').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterMess').closest('.input-group'),
            placeholder: '--- Cari Mess ---'
        });
        $('#filterSite').on("select2:select", function (e) { 
            // console.log("filterSite", e.params.data.id); 
            filter.site = e.params.data.id
            fetchMessBySite(e.params.data.id)
        });
        $('#filterMess').on("select2:select", function (e) { 
            // console.log("filterMess", e.params.data.id);
            filter.mess = e.params.data.id
        });

        function fetchSite() {
            axios.post("/bss-form/catering/helper-site", {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                // console.log(data)
                var newOption = new Option("--- Cari Site ---", "", true, true);
                $('#filterSite').append(newOption)
                data.data.data.forEach(element => {
                    var newOption = new Option(element.text, element.id);
                    $('#filterSite').append(newOption)
                });
                
                $('#filterSite').trigger('change');
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }

        function fetchMessBySite(site) {
            axios.get(helperMessURL + "/helper-mess", {
                params: {
                    site: site
                }
            }, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                // console.log(data)
                $('#filterMess').select2("destroy")
                $('#filterMess').empty()
                $('#filterMess').select2({
                    theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                    dropdownParent: $('#filterMess').closest('.input-group'),
                    placeholder: '--- Cari Mess ---'
                });
                var newOption = new Option("--- Cari Mess ---", "", true, true);
                $('#filterMess').append(newOption)
                data.data.data.forEach(element => {
                    var newOption = new Option(element.text, element.id);
                    $('#filterMess').append(newOption)
                });
                
                $('#filterMess').trigger('change');
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }

        fetchSite()

        function getDetailHuniMess(params) {
            // console.log("halojuga")
            params.data.site = filter.site
            params.data.mess = filter.mess

            if(params.data.site != null || params.data.mess != null) {
                $.get(baseUrl + '?' + $.param(params.data)).then(function(res) {
                    params.success(res.data)
                })
            } else {
                params.success([])
            }
        }

        function kamarFormatter(value) {
            return "Kamar " + value;
        }

        function actionFormatter(value, row, index) {
            var _site = ", '"+ row.site + "'"
            var _kode_mess = ", '"+ row.kode_mess + "'"
            var _no_kamar = ", '"+ row.no_kamar + "'"
            var _nama_mess = ", '"+ row.nama_mess + "'"
            var _kapasitas = ", '"+ row.kapasitas + "'"

            var _clickEvent = 'onclick="modalDetail(this' + _site + _kode_mess + _no_kamar + _nama_mess + _kapasitas +')"'
            var _clickEventDelete = 'onclick="actionDelete(this' + _site + _kode_mess + _no_kamar + _nama_mess + _kapasitas +')"'

            var btnDetail = '<a href="#" data-caption="" '+ _clickEvent +' data-action="detail" data-show="false" data-url=""><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true"><i class="fa fa-pen cursor-pointer"></i></a>';
            var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-url="" data-show="true" data-action="delete"><i class="fa-solid fa-trash-can cursor-pointer"></i></a>';
            
            return btnDetail + btnEdit + btnHapus
        }

        function actionDelete(e, st, kd_mess, nm_kmr, nm_mess, kpsts) {
            // console.log(st, kd_mess, nm_kmr, nm_mess, kpsts)
            var _reqBody = {
                site: st,
                no_doc: kd_mess,
                kamar: nm_kmr,
                _action: 'delete'
            }

            axios.post(helperMessURL + "/delete-kamar", _reqBody, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(response) {
                var alertData = {
                    icon: 'error',
                    title: 'Gagal!',
                    text: "Terjadi kesalahan, coba beberapa saat lagi",
                }

                alertData.text = response.data.message
                if(response.data.isSuccess) {
                    alertData.icon = "success"
                    alertData.title = "Berhasil!"
                    $tableDashboardHuni.bootstrapTable('refresh')
                } else {
                    alertData.icon = "error"
                    alertData.title = "Gagal!"
                }

                Swal.fire(alertData)
            })
            .catch(function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "Terjadi kesalahan, coba beberapa saat lagi",
                })
            })
            .finally(function() {

            })
        }

        function simpanKamar(e) {
            var kamar = e.getAttribute("data-kamar")
            axios.put(helperMessURL + "/edit-kamar", {
                site: inputSite.value,
                kode_mess: inputNoDoc.value,
                kamar: kamar,
                edited_kamar: editKamar.value,
                kapasitas: editKapasitas.value
            }, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(response) {
                var alertData = {
                    icon: 'error',
                    title: 'Gagal!',
                    text: "Terjadi kesalahan, coba beberapa saat lagi",
                }

                alertData.text = response.data.message
                if(response.data.isSuccess) {
                    alertData.icon = "success"
                    alertData.title = "Berhasil!"
                    $tableDashboardHuni.bootstrapTable('refresh')
                } else {
                    alertData.icon = "error"
                    alertData.title = "Gagal!"
                }

                Swal.fire(alertData)
            })
            .catch(function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "Terjadi kesalahan, coba beberapa saat lagi",
                })
            })
            .finally(function() {

            })
        }

        function modalDetail(e, st, kd_mess, nm_kmr, nm_mess, kpsts) {
            // console.log({e, st, kd_mess, nm_kmr, nm_mess, kpsts})
            inputSite.value = st
            inputNoDoc.value = kd_mess
            editKamar.value = nm_kmr
            editKapasitas.value = kpsts
            document.getElementById("btnSubmitKamar").setAttribute("data-kamar", nm_kmr)

            $('#addMess').modal("show")
        }

        $('#addMess').on('hidden.bs.modal', function (e) {
            document.getElementById("btnSubmitKamar").setAttribute("data-kamar", "")
            inputSite.value = ""
            inputNoDoc.value = ""
            editKamar.value = ""
        })
    </script>
@endsection