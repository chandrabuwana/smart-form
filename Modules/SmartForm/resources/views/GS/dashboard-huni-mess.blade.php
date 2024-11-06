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
        .position-relative {
            position: relative;
        }
        .position-absolute {
            position: absolute;
        }
        .suggestion {
            position: absolute;
            top: 100%;
            max-height: 100px;
            width: 100%;
            background-color: rgb(253, 247, 247);
            overflow-y: auto;
            z-index: 99;
            color: black;
            border: 1px solid rgba(85, 83, 83, 0.788);
            border-radius: 4px 4px 4px 4px;
        }
        .suggestion-child {
            cursor: pointer;
            font-size: 12px;
            padding: 2px 4px;
            border-bottom: 1px solid rgba(85, 83, 83, 0.534);
        }
        .text-light {
            color: #f0f2f5;
        }
        .w-full {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4 pb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Management Penghuni Mess</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label class="w-full" for="filterSite">Site</label>
                                <select class="form-control form-select w-full" name="filterSite" id="filterSite">
                                    <option value="">-- Filter Site --</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label class="w-full" for="filterMess">Mess</label>
                                <select class="form-control form-select w-full" name="filterMess" id="filterMess">
                                    <option value="">-- Filter Mess --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label class="w-full" for="filterKamar">Kamar</label>
                                <select class="form-control form-select w-full" name="filterKamar" id="filterKamar">
                                    <option value="">-- Filter Kamar --</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnFilterSubmit">
                                Filter
                            </button>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnClearFilter">
                                Clear Filter
                            </button>
                        </div>
                    </div>
                    <h4 class="mx-3">Tambah Penghuni</h4>
                    <div class="mx-4 row">
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="addNIK">NIK</label>
                                {{-- <input type="text" class="form-control" id="addNIK" name="addNIK" placeholder="Cari NIK / Nama"> --}}
                                <input type="text" class="form-control" name="addNIK" id="addNIK" placeholder="Cari Nama / NIK">
                                </input>
                                <div class="suggestion" id="suggest-nik" style="display: none">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary ms-auto filter-btn" id="btnAddPenghuni">
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
                                    <th data-field="nik" data-align="center">NIK</th>
                                    <th data-field="nama" data-align="left">Nama</th>
                                    <th data-field="nama_mess" data-align="left" data-halign="center">Nama Mess</th>
                                    <th data-field="site" data-align="left">Site</th>
                                    <th data-field="status" data-align="left" data-formatter="statusFormatter">Status</th>
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
    <div class="modal fade" id="editHuni" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
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
                                                    <label for="editSite" >Site</label>
                                                    <select class="form-control form-select" name="editSite" id="editSite" style="width: 100%;">
                                                        <option value="">-- Pilih Site --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-6 col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="editMess">Mess</label>
                                                    <select class="form-control form-select" name="editMess" id="editMess" style="width: 100%;">
                                                        <option value="">-- Pilih Site --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="editKamar">kamar</label>
                                                    <select class="form-control form-select" name="editKamar" id="editKamar" style="width: 100%;">
                                                        <option value="">-- Pilih Site --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="editNIK">NIK</label>
                                                    <input type="text" class="form-control" id="editNIK"
                                                        name="editNIK" placeholder="NIK" disabled>
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
        var baseUrl = '/bss-form/catering/mess/list-huni'
        var helperMessURL = '/bss-form/catering/mess'
        var queryParams =  new URLSearchParams(window.location.search);
        var kode_mess_query = queryParams.get("kode_mess")
        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
        var btnAddPenghuni = document.getElementById("btnAddPenghuni")
        var $tableDashboardHuni = $("#table-dashboard-huni");
        var opstionSite = []
        var opstionMess = []
        var opstionKamar = []
        
        var filter = {
            site: null,
            mess: null,
            kamar: null
        }

        btnFilterSubmit.addEventListener("click", function(e) {
            $tableDashboardHuni.bootstrapTable('refresh')
        })

        $('#filterSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterSite').closest('.input-group'),
            placeholder: '--- Cari Site ---'
        });
        $('#editSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#editSite').closest('.input-group'),
            placeholder: '--- Cari Site ---'
        });
        $('#filterMess').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterMess').closest('.input-group'),
            placeholder: '--- Cari Mess ---'
        });
        $('#editMess').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#editMess').closest('.input-group'),
            placeholder: '--- Cari Mess ---'
        });
        $('#filterKamar').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterKamar').closest('.input-group'),
            placeholder: '--- Cari Kamar ---'
        });
        $('#editKamar').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#editKamar').closest('.input-group'),
            placeholder: '--- Cari Kamar ---'
        });
        $('#filterSite').on("select2:select", function (e) { 
            // console.log("filterSite", e.params.data.id); 
            filter.site = e.params.data.id
            fetchMessBySite(e.params.data.id, function(data) {
                $('#filterMess').empty();
                $('#editMess').empty();

                data.forEach(function(mess) {
                    $('#filterMess').append(new Option(mess.text, mess.id))
                    $('#editMess').append(new Option(mess.text, mess.id))
                })

                $('#filterMess').trigger('change')
                $('#editMess').trigger('change')
            })
        });
        $('#filterMess').on("select2:select", function (e) { 
            // console.log("filterMess", e.params.data.id);
            filter.mess = e.params.data.id
            fetchKamarBySiteAndMess($('#filterSite').select2("data")[0].id, e.params.data.id, function(data){
                $('#filterKamar').empty()
                $('#editKamar').empty()

                data.forEach(function(kamar) {
                    $('#filterKamar').append(new Option(kamar.text, kamar.id))
                    $('#editKamar').append(new Option(kamar.text, kamar.id))
                })

                $('#filterKamar').trigger('change')
                $('#editKamar').trigger('change')
            }) 
        });
        $('#filterKamar').on("select2:select", function (e) { 
            // console.log("filterKamar", e.params.data.id); 
            filter.kamar = e.params.data.id
        });
        $('#editSite').on("select2:select", function (e) { 
            // console.log("editSite", e.params.data.id); 
            fetchMessBySite(e.params.data.id, function(data) {
                $('#editMess').empty();

                data.forEach(function(mess) {
                    $('#editMess').append(new Option(mess.text, mess.id))
                })

                $('#editMess').trigger('change')
            })
        });
        $('#editMess').on("select2:select", function (e) { 
            // console.log("editMess", $('#editSite').val())
            fetchKamarBySiteAndMess($('#editSite').select2("data")[0].id, e.params.data.id, function(data){
                $('#editKamar').empty()

                data.forEach(function(kamar) {
                    $('#editKamar').append(new Option(kamar.text, kamar.id))
                })

                $('#editKamar').trigger('change')
            }) 
        });
        $('#editKamar').on("select2:select", function (e) { 
            // console.log("filterKamar", e.params.data.id); 
        });

        function fetchSite(cb=function(site) {}) {
            axios.post("/bss-form/catering/helper-site", {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
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

        function fetchMessBySite(site, cb=function(data){}) {
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
                var listMess = []
                listMess.push(new Option("--- Cari Mess ---", "", true, true))
                listMess.push({
                    id: "",
                    text: "--- Cari Mess ---"
                })

                data.data.data.forEach(element => {
                    // console.log(element)
                    // listMess.push(new Option(element.text, element.id))
                    listMess.push({
                        id: element.id,
                        text: element.text
                    })
                });
                cb(listMess)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }

        function fetchKamarBySiteAndMess(site, mess, cb=function(data){}){
            axios.get(helperMessURL + "/helper-kamar", {
                params: {
                    site: site,
                    mess: mess
                }
            }, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                // console.log(data)
                var listKamar = []
                listKamar.push({
                    id: "",
                    text: "--- Cari Mess ---"
                })
                data.data.data.forEach(element => {
                    listKamar.push({
                        id: element.id,
                        text: element.text
                    })
                });
                cb(listKamar)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }

        fetchSite(function(data) {
            // console.log(data)
            data.forEach(function(opt) {
                $('#filterSite').append(new Option(opt.text, opt.id))
                $('#editSite').append(new Option(opt.text, opt.id))
            })
            // data.forEach(function(opt) {
            //     $('#editSite').append(opt)
            // })
        })

        function getDetailHuniMess(params) {
            // console.log("halo")
            // params.data.kode_mess = kode_mess_query
            params.data.site = filter.site
            params.data.mess = filter.mess
            params.data.kamar = filter.kamar

            if(params.data.site != null || params.data.mess != null || params.data.kamar != null) {
                $.get(baseUrl + '?' + $.param(params.data)).then(function(res) {
                    params.success(res.data)
                })
            } else {
                params.success([])
            }
        }

        function statusFormatter(value, row, index) {
            return value == 0  || value == null ? "Aktif" : "Nonaktif"
        }

        function actionFormatter(value, row, index) {
            // console.log(row)
            // {
            //     "site": "TAJ",
            //     "nik": "1020341",
            //     "status": "0",
            //     "keterangan": null,
            //     "nama_mess": "Mess Kelomang 12"
            //     "kode_mess": "asd"
            // }
            var _site = ", '"+ row.site + "'"
            var _kode_mess = ", '"+ row.kode_mess + "'"
            var _no_kamar = ", '"+ row.no_kamar + "'"
            var _nik = ", '"+ row.nik + "'"

            var _clickEvent = 'onclick="modalDetail(this' + _site + _kode_mess + _no_kamar + _nik +')"'
            var _clickEventDelete = 'onclick="actionDelete(this' + _site + _kode_mess + _no_kamar + _nik +')"'

            var btnDetail = '<a href="#" data-caption="" '+ _clickEvent +' data-action="detail" data-show="false" data-url=""><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true"><i class="fa fa-pen cursor-pointer"></i></a>';
            var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-url="" data-show="true" data-action="delete"><i class="fa-solid fa-trash-can cursor-pointer"></i></a>';
            
            return btnDetail + btnEdit + btnHapus
        }

        function simpanKamar(e) {
            var dataEdit = {
                site: $('#editSite').val(),
                kode_mess: $('#editMess').val(),
                kamar: $('#editKamar').val(),
                nik: $('#editNIK').val()
            
            }
            axios.put(helperMessURL + '/edit-penghuni', dataEdit, {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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
            // console.log(data)
        }

        function actionDelete(e, st, kd_mess, no_kmr, nik) {
            // console.log(st, kd_mess, no_kmr, nik)
            var _reqBody = {
                site: st,
                no_doc: kd_mess,
                kamar: no_kmr,
                nik_penghuni: nik,
                _action: 'delete'
            }
            Swal.fire({
                title: "Apakah yakin ingin menghapus?",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#d33"
            }).then((result) => {
                // console.log(result)
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire("Saved!", "", "success");
                    axios.post(helperMessURL + "/delete-penghuni-mess", _reqBody, {
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
            });

            
        }

        function modalDetail(e, st, kd_mess, no_kmr, nik) {
            $('#editSite').val(st).trigger('change');
            $('#editMess').val(kd_mess).trigger('change');
            $('#editKamar').val(no_kmr).trigger('change');
            $('#editNIK').val(nik).trigger('change');
            $('#editHuni').modal("show");
        }

        function validateAddPenghuni() {
            var isValid = {
                valid: false,
                errors: [],
                data: {
                    site: $('#filterSite').val(),
                    kode_mess: $('#filterMess').val(),
                    kamar: $('#filterKamar').val(),
                    nik: $('#addNIK').val()
                }
            }

            if($('#filterSite').val() == "" || $('#filterSite').val().length < 1) {
                isValid.errors.push({
                    field: "Site",
                    message: "Site tidak boleh kosong"
                })
            }
            if($('#filterMess').val() == "" || $('#filterMess').val().length < 1) {
                isValid.errors.push({
                    field: "Mess",
                    message: "Mess tidak boleh kosong"
                })
            }
            if($('#filterKamar').val() == "" || $('#filterKamar').val().length < 1) {
                isValid.errors.push({
                    field: "Kamar",
                    message: "Kamar tidak boleh kosong"
                })
            }
            if($('#addNIK').val() == "" || $('#addNIK').val().length < 1) {
                isValid.errors.push({
                    field: "NIK",
                    message: "NIK tidak boleh kosong"
                })
            }

            if(isValid.errors.length < 1) isValid.valid = true

            return isValid
        }

        btnAddPenghuni.addEventListener("click", function(e) {
            var validateInput = validateAddPenghuni()
            var reqBody = {
                mess: ""
            }

            if(validateInput.valid) {
                axios.post(helperMessURL + '/add-penghuni', validateInput.data, {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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
            } else {
                console.log("tidak valid")
            }
        })

        // fungsi autohint karyawan
        var filterNIK = document.getElementById("addNIK")
        var suggestNik = document.getElementById("suggest-nik")
        suggestNik.addEventListener("click", function(e) {
            e.target.style.display="none";
        })
        function searchKaryawan(nama) {
            axios.get('/bss-form/timesheet/search-karyawan?search='+nama, {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                })
                .then(function(response) {
                    // console.log(response.data)
                    suggestNik.style.display="inline"
                    var elementSuggestedKaryawan = [];
                    if(!response.data.isError) {
                        if(response.data.data.length < 1) {
                            elementSuggestedKaryawan.push('<div class="suggestion-child" onclick="clickResultCariKaryawan(this)">Not Found<i class="fa-solid fa-xmark"></i></div>')
                        } else {
                            for (const key in response.data.data) {
                                if (Object.hasOwnProperty.call(response.data.data, key)) {
                                    const element = response.data.data[key];
                                    // console.log(element)
                                    elementSuggestedKaryawan.push('<div onclick="clickResultCariKaryawan(this)" data-nama="'+ element.Nama +'" data-nik="' + element.NIK +'" class="suggestion-child">'+element.NIK +' '+ element.Nama +'</div>')
                                }
                            }
                        }
                        
                        suggestNik.innerHTML = elementSuggestedKaryawan.join("")
                    }
                })
                .catch(function(err) {
                    console.log(err)
                })

        }
        
        function debounce (func, wait){
            let timeout;
            
            return function executedFunction(...args) {
                var later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };

                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        };

        function clickResultCariKaryawan(event) {
            var nikKaryawan = event.getAttribute("data-nik");
            var namaKaryawan = event.getAttribute("data-nama");
            if(nikKaryawan != null && namaKaryawan != null) filterNIK.value = nikKaryawan;
            
            suggestNik.style.display = "none";

            // console.log(nikKaryawan)
        }

        function cariKaryawan(event) {
            var value = event.target.value
            // console.log(value);
            searchKaryawan(value)
        }
        const debounceHandler = debounce(cariKaryawan, 1000);
        
        filterNIK.addEventListener("focusin", function(e) {
            filterNIK.addEventListener("input", debounceHandler, true)
        })
        filterNIK.addEventListener("focusout", function(e) {
            filterNIK.removeEventListener("input", debounceHandler, true)
            // suggestNik.style.display = "none";
        })
        filterNIK.addEventListener("keyup", function(e) {
            // console.log(e)
            if(e.key == "Escape"){ // key press ESC detect
                filterNIK.removeEventListener("input", debounceHandler, true)
                suggestNik.style.display = "none";
            }
        })
        
        function suggestionClick(e) {
            var nik = e.getAttribute("data-nik");
            // console.log(nik)
        }
    </script>
@endsection