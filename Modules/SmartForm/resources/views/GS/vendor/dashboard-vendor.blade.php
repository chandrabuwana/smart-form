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
        .select2.select2-container{
            width: 100%;
        }
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
        .search-input {
            border-radius: 0;
            border-bottom: 1px solid #e91e63;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }
        .search-input:valid {
            border-radius: 0;
            border-bottom: 1px solid #e91e63;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4 pb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Management Vendor</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="#" onclick="openModal(this)">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>
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
                        <table id="table-dashboard-vendor" data-toggle="table" data-ajax="getDataVendor" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="site" data-align="left">Site</th>
                                    <th data-field="id" data-align="left" data-halign="center">ID Vendor</th>
                                    <th data-field="nama" data-align="left">Nama Vendor</th>
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
    <div class="modal fade" id="modalAddVendor" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Add Vendor</h5>
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
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addSite" style="width: 100%;">Site</label>
                                                    <select class="form-control form-select" name="addSite" id="addSite" style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addIDVendor">ID Vendor</label>
                                                    <input type="text" class="form-control" id="addIDVendor"
                                                        name="addIDVendor" placeholder="ID Vendor">
                                                </div>
                                            </div> --}}
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addNamaVendor">Nama Vendor</label>
                                                    <input type="text" class="form-control" id="addNamaVendor"
                                                        name="addNamaVendor" placeholder="Nama Vendor">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addKelurahanVendor">Kelurahan</label>
                                                    <input type="text" class="form-control" id="addKelurahanVendor"
                                                        name="addKelurahanVendor" placeholder="Kelurahan">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addKecVendor">Kecamatan</label>
                                                    <input type="text" class="form-control" id="addKecVendor"
                                                        name="addKecVendor" placeholder="Kecamatan">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addKotaVendor">Kota</label>
                                                    <input type="text" class="form-control" id="addKotaVendor"
                                                        name="addKotaVendor" placeholder="Kota">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addAlamatVendor">Alamat</label>
                                                    <input type="text" class="form-control" id="addAlamatVendor"
                                                        name="addAlamatVendor" placeholder="Alamat Vendor">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addWebsiteVendor">Website</label>
                                                    <input type="text" class="form-control" id="addWebsiteVendor"
                                                        name="addWebsiteVendor" placeholder="Website">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addEmailVendor">Email</label>
                                                    <input type="text" class="form-control" id="addEmailVendor"
                                                        name="addEmailVendor" placeholder="Email Vendor">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addKontakVendor">Kontak</label>
                                                    <input type="text" class="form-control" id="addKontakVendor"
                                                        name="addKontakVendor" placeholder="Kontak">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addKeteranganVendor">Keterangan</label>
                                                    <input type="text" class="form-control" id="addKeteranganVendor"
                                                        name="addKeteranganVendor" placeholder="Keterangan">
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
                        <button onclick="submitNewVendor(this)" data-action="add" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitKamar">
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
        var baseUrl = "/bss-form/catering/vendor"
        var addSite = document.getElementById('addSite');
        // var addIDVendor = document.getElementById('addIDVendor');
        var addNamaVendor = document.getElementById('addNamaVendor');
        var addKelurahanVendor = document.getElementById('addKelurahanVendor');
        var addKecVendor = document.getElementById('addKecVendor');
        var addKotaVendor = document.getElementById('addKotaVendor');
        var addAlamatVendor = document.getElementById('addAlamatVendor');
        var addWebsiteVendor = document.getElementById('addWebsiteVendor');
        var addEmailVendor = document.getElementById('addEmailVendor');
        var addKontakVendor = document.getElementById('addKontakVendor');
        var addKeteranganVendor = document.getElementById('addKeteranganVendor');
        var btnSubmitKamar = document.getElementById('btnSubmitKamar');
        const tableDashboardVendor = $('#table-dashboard-vendor')
        var filterParams = {
            site: null
        }
        var modalElement = $("#modalAddVendor")

        $('#filterSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterSite').closest('.input-group'),
            placeholder: '--- Cari SITE ---'
        })

        $('#addSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#addSite').closest('.input-group'),
            placeholder: '--- Cari SITE ---'
        })

        function validateAddVendor() {
            var validationData = {
                valid: false,
                errors : [],
                data: {
                    site: addSite.value,
                    // id: addIDVendor.value.trim(),
                    nama: addNamaVendor.value.trim(),
                    kelurahan: addKelurahanVendor.value.trim(),
                    kecamatan: addKecVendor.value.trim(),
                    kota: addKotaVendor.value.trim(),
                    alamat: addAlamatVendor.value.trim(),
                    website: addWebsiteVendor.value.trim(),
                    email: addEmailVendor.value.trim(),
                    kontak: addKontakVendor.value.trim(),
                    keterangan: addKeteranganVendor.value.trim()
                }  
            }

            if(validationData.data.site == "" || validationData.data.site == null) validationData.errors.push("Site tidak boleh kosong")
            // if(validationData.data.id == "" || validationData.data.id == null) validationData.errors.push("ID Vendor tidak boleh kosong")
            if(validationData.data.nama == "" || validationData.data.nama == null) validationData.errors.push("Nama Vendor tidak boleh kosong")
            if(validationData.data.email == "" || validationData.data.email == null) validationData.errors.push("Email Vendor tidak boleh kosong")
            if(!validateEmail(validationData.data.email)) validationData.errors.push("Email Vendor tidak valid")

            validationData.errors.length > 0 ? validationData.valid = false : validationData.valid = true

            return validationData
        }

        function submitNewVendor(e) {
            var _action = e.getAttribute('data-action')
            var _actionURL = _action == "edit" ? "/edit-vendor" : "/add-vendor"
            var _successMessage = _action == "edit" ? "Berhasil update vendor" : "Berhasil menambahkan data vendor"
            var _method = _action == "edit" ? "put" : "post"
            var submitURL = baseUrl + _actionURL
            
            var validateInput = validateAddVendor()
            
            if(validateInput.valid) {
                e.disabled = true
                axios(
                    {
                        url: submitURL,
                        method: _method,
                        data: validateInput.data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                
                    }
                )
                .then(function(resp) {
                    var errorResp = [];
                    var dataAlert = {};

                    if(resp.data.isSuccess) {
                        clearModal()
                        dataAlert = {
                            icon: 'success',
                            title: "Berhasil!",
                            text: _successMessage,
                        }
                        $("#table-dashboard-vendor").bootstrapTable('refresh')
                    } else {
                        resp.data.errorMessage.forEach(element => {
                            errorResp.push("<span>" + element + "</span>")
                        });

                        dataAlert = {
                            icon: 'error',
                            title: "Gagal!",
                            html: errorResp.join("<br>")
                        }

                    }

                    Swal.fire(dataAlert)
                })
                .catch(function(err) {
                    console.log(err)
                    Swal.fire({
                        icon: 'error',
                        title: "Gagal!",
                        text: 'Terjadi kesalahan, coba beberapa saat lagi',
                    })
                })
                .finally(function() {
                    e.disabled = false
                })
            } else {
                var errorList = []
                validateInput.errors.forEach(function(data) {
                    errorList.push("<span>" + data +"</span>")
                })

                Swal.fire({
                    icon: 'error',
                    title: 'Mandatory field kosong!',
                    html: errorList.join("<br>"),
                })
            }
            
        }

        function statusFormatter(value, row, index) {
            var nilai = ""
            if(value == "1" || value == null) nilai = "Aktif"
            if(value == "0") nilai = "Nonaktif"

            return nilai
        }

        function actionFormatter(value, row, index) {
            // console.log(row)
            // {
            //     "site": "AGM",
            //     "id": "vdr/001",
            //     "nama": "Vendor Pertamax Gan",
            //     "status": "0",
            //     "alamat": null,
            //     "kelurahan": null,
            //     "kecamatan": null,
            //     "kota": null,
            //     "telepon": null,
            //     "website": null,
            //     "email": "email@vendor.id",
            //     "kontak": null,
            //     "keterangan": null
            // }
            var _site = ", '"+ row.site + "'"
            var _id = ", '"+ row.id + "'"
            var _nama = ", '"+ row.nama + "'"
            var _status = ", '"+ row.status + "'"
            var _alamat = ", '"+ row.alamat + "'"
            var _kelurahan = ", '"+ row.kelurahan + "'"
            var _kecamatan = ", '"+ row.kecamatan + "'"
            var _kota = ", '"+ row.kota + "'"
            var _telepon = ", '"+ row.telepon + "'"
            var _website = ", '"+ row.website + "'"
            var _email = ", '"+ row.email + "'"
            var _kontak = ", '"+ row.kontak + "'"
            var _keterangan = ", '"+ row.keterangan + "'"

            // var _clickEvent = 'onclick="modalDetail(this)"'
            var _clickEvent = 'onclick="modalDetail(this'  + _site + _id + _nama + _status + _alamat + _kelurahan + _kecamatan + _kota + _telepon + _website + _email + _kontak + _keterangan +')"'
            var _clickEventDelete = 'onclick="actionDelete(this'  + _id +')"'
            // var _clickEventDelete = 'onclick="actionDelete(this' + _site + _kode_mess + _no_kamar + _nama_mess + _kapasitas +')"'

            var btnDetail = '<a href="#" '+ _clickEvent +' data-action="detail" data-show="false" data-url=""><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true"><i class="fa fa-pen cursor-pointer"></i></a>';
            var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-url="" data-show="true" data-action="delete"><i class="fa-solid fa-trash-can cursor-pointer"></i></a>';
            
            return btnDetail + btnEdit + btnHapus
        }

        function modalDetail(e,_site, _id, _nama, _status, _alamat, _kelurahan, _kecamatan, _kota, _telepon, _website, _email, _kontak, _keterangan) {
            btnSubmitKamar.setAttribute('data-action', 'edit')
            btnSubmitKamar.setAttribute('data-id', _id)
            
            if(e.getAttribute("data-action") == "detail") {
                btnSubmitKamar.style.display = 'none'
                // addIDVendor.disabled = true
                addSite.disabled = true
                addNamaVendor.disabled = true
                addKelurahanVendor.disabled = true
                addKecVendor.disabled = true
                addKotaVendor.disabled = true
                addAlamatVendor.disabled = true
                addWebsiteVendor.disabled = true
                addEmailVendor.disabled = true
                addKontakVendor.disabled = true
                addKeteranganVendor.disabled = true
            }

            // if(e.getAttribute("data-action") == "edit") {
            //     addIDVendor.disabled = true
            // }
            
            $("#addSite").val(_site).trigger("change")
            // addIDVendor.value = _id == "null" ? "" : _id
            addNamaVendor.value = _nama == "null" ? "" : _nama
            addKelurahanVendor.value = _kelurahan == "null" ? "" : _kelurahan
            addKecVendor.value = _kecamatan == "null" ? "" : _kecamatan
            addKotaVendor.value = _kota == "null" ? "" : _kota
            addAlamatVendor.value = _alamat == "null" ? "" : _alamat
            addWebsiteVendor.value = _website == "null" ? "" : _website
            addEmailVendor.value = _email == "null" ? "" : _email
            addKontakVendor.value = _kontak == "null" ? "" : _kontak
            addKeteranganVendor.value = _keterangan == "null" ? "" : _keterangan

            modalElement.modal('show')
        }

        function actionDelete(e, _id) {
            Swal.fire({
                icon: "warning",
                title: "Apakah yakin ingin menghapus?",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#d33"
            }).then(function(result) {
                if (result.isConfirmed) {
                    axios(
                        {
                            url: baseUrl + "/delete-vendor",
                            method: "delete",
                            data: {
                                id: _id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    
                        }
                    )
                    .then(function(resp) {
                        var dataAlert = {};
                        if(resp.data.isSuccess) {
                            clearModal()
                            dataAlert = {
                                icon: 'success',
                                title: "Berhasil!",
                                text: resp.data.message || "",
                            }
                            $("#table-dashboard-vendor").bootstrapTable('refresh')
                        } else {
                            dataAlert = {
                                icon: 'error',
                                title: "Gagal!",
                                text: resp.data.message || "",
                            }
                        }
                        Swal.fire(dataAlert)
                    })
                    .catch(function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: "Terjadi kesalahan, coba beberapa saat lagi"
                        })
                    })
                }
            })
            
        }

        function openModal(e) {
            modalElement.modal('show')
        }

        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function getDataVendor(params) {
            var listVendor = baseUrl + '/list-vendor'
            // console.log("halojuga")
            if(filterParams.site) params.data.site = filterParams.site
            // params.data.mess = filter.mess

            // if(params.data.site != null || params.data.mess != null) {
                $.get(listVendor + '?' + $.param(params.data)).then(function(res) {
                    params.success(res.data)
                })
            // } else {
            //     params.success([])
            // }
        }

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
            $("#addSite").val("").trigger("change")
            // addIDVendor.value = ""
            addNamaVendor = ""
            addKelurahanVendor = ""
            addKecVendor = ""
            addKotaVendor = ""
            addAlamatVendor = ""
            addWebsiteVendor = ""
            addEmailVendor = ""
            addKontakVendor = ""
            addKeteranganVendor = ""
        }

        modalElement.on('hide.bs.modal', function (e) {
            btnSubmitKamar.style.display = ''
            btnSubmitKamar.setAttribute('data-action', 'add')
            // addIDVendor.disabled = false
            addSite.disabled = false
            addNamaVendor.disabled = false
            addKelurahanVendor.disabled = false
            addKecVendor.disabled = false
            addKotaVendor.disabled = false
            addAlamatVendor.disabled = false
            addWebsiteVendor.disabled = false
            addEmailVendor.disabled = false
            addKontakVendor.disabled = false
            addKeteranganVendor.disabled = false
        })
        
        $('#filterSite').change( function(e) {
            filterParams.site = e.target.value;
        });

        function applyFilter(e) {
            tableDashboardVendor.bootstrapTable('refresh')
        }

        function resetFilter(e) {
            tableDashboardVendor.site = null
            $('#filterSite').val('').trigger('change');

            tableDashboardVendor.bootstrapTable('refresh')
        }

        fetchSite(function(data) {
            data.forEach(function(opt) {
                $('#filterSite').append(new Option(opt.text, opt.id))
                $('#addSite').append(new Option(opt.text, opt.id))
            })
        })
    </script>
@endsection