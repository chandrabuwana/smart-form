@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .form-control {
            border: 0;
            margin-bottom: 0;
        }
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
        .suggestion {
            position: absolute;
            top: 100%;
            max-height: 200px;
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

        .search-icon {
            position: absolute;
            top: 50%;
            right: 8px;
            z-index: 99;
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
                    <div class="table-responsive p-0">
                        <table id="table-dashboard-vendor" data-toggle="table" data-ajax="getDataMappingVendor" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="id" data-align="left" data-halign="center">ID Mapping</th>
                                    {{-- <th data-field="id_vendor" data-align="left">ID Vendor</th> --}}
                                    <th data-field="nama_vendor" data-align="left">Nama Vendor</th>
                                    {{-- <th data-field="lokasi" data-align="left">Lokasi</th> --}}
                                    <th data-field="nama_lokasi" data-formatter="lokasiFormatter" data-align="left">Lokasi</th>
                                    <th data-field="jenis_pemesanan" data-align="left">Waktu Pemesanan</th>
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
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Tambah mapping vendor</h5>
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
                                        <span style="display: none" id="id_mapping"></span>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addSite" style="width: 100%;">Site</label>
                                                    <select class="form-control form-select" name="addSite" id="addSite" style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addLokasi">Lokasi</label>
                                                    <select class="form-control form-select" name="addLokasi" id="addLokasi" style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addJenisPemesanan">Waktu makan</label>
                                                    <select class="form-control form-select" name="addJenisPemesanan" id="addJenisPemesanan" style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="addVendor">ID Vendor</label>
                                                    <select class="form-control form-select" name="addVendor" id="addVendor" style="width: 100%;">
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
                        <button onclick="submitMapping(this)" data-action="add" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitMapping">
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
    <script src="{{ asset('master/js/helper-search.js') }}"></script>
    <script>
        var baseUrl = "/bss-form/catering/vendor"
        var addLokasi = document.getElementById('addLokasi');
        var btnSubmitMapping = document.getElementById('btnSubmitMapping');

        var filterParams = {

        }

        var modalElement = $("#modalAddVendor")

        $('#addSite').on("select2:select", function (e) { 
            fetchLokasi(e.params.data.id, function(data) {
                $('#addLokasi').empty();

                data.forEach(function(mess) {
                    $('#addLokasi').append(new Option(mess.text, mess.id))
                })

                $('#addLokasi').trigger('change')
            })
        });

        $('#addSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#addSite').closest('.input-group'),
            placeholder: '--- Cari Site ---'
        });

        $('#addJenisPemesanan').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#addJenisPemesanan').closest('.input-group'),
            placeholder: '--- Pilih Waktu Pemesanan ---',
            data: [
                {id: "", text: "--- Pilih Waktu Pemesanan ---"},
                {id: "pagi", text: "Pagi"},
                {id: "siang", text: "Siang"},
                {id: "malam", text: "Malam"}
            ]
        });

        $('#addLokasi').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#addLokasi').closest('.input-group'),
            placeholder: '--- Cari Lokasi ---'
        });

        $('#addVendor').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#addVendor').closest('.input-group'),
            placeholder: '--- Cari Vendor ---',
            ajax: {
                url: baseUrl + "/helper-vendor",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        query: params.term, // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response.data
                    };
                },
                cache: true
            }
        });
        
        function validateAddMapping() {
            var validationData = {
                valid: false,
                errors : [],
                data: {
                    site: $('#addSite').val(),
                    lokasi: $('#addLokasi').val(),
                    vendor: $('#addVendor').val(),
                    jenisPemesanan: $('#addJenisPemesanan').val(),
                }  
            }

            // if(validationData.data.site == "" || validationData.data.site == null) validationData.errors.push("Site tidak boleh kosong")
            if(validationData.data.site == "" || validationData.data.site == null) validationData.errors.push("SITE tidak boleh kosong")
            if(validationData.data.lokasi == "" || validationData.data.lokasi == null) validationData.errors.push("Lokasi Vendor tidak boleh kosong")
            if(validationData.data.vendor == "" || validationData.data.vendor == null) validationData.errors.push("Vendor Vendor tidak boleh kosong")
            if(validationData.data.jenisPemesanan == "" || validationData.data.jenisPemesanan == null) validationData.errors.push("Vendor Vendor tidak boleh kosong")

            validationData.errors.length > 0 ? validationData.valid = false : validationData.valid = true

            return validationData
        }

        function submitMapping(e) {
            var _action = e.getAttribute('data-action')
            var _actionURL = _action == "edit" ? "/edit-mapping-vendor" : "/add-mapping-vendor"
            var _successMessage = _action == "edit" ? "Berhasil update mapping vendor" : "Berhasil menambahkan data mapping vendor"
            var _method = _action == "edit" ? "put" : "post"
            var submitURL = baseUrl + _actionURL
            
            var validateInputMapping = validateAddMapping()
            var header = {
                "DATA-ACTION": _action
            }

            $('#addLokasi').select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                dropdownParent: $('#addLokasi').closest('.input-group'),
                placeholder: '--- Cari Kamar ---'
            });
            
            if(validateInputMapping.valid) {
                e.disabled = true
                if(_action == "edit") validateInputMapping.data.idMapping = $("#id_mapping").text()
                axios(
                    {
                        url: submitURL,
                        method: _method,
                        data: validateInputMapping.data,
                        headers: {
                            "DATA-ACTION": _action,
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                
                    }
                )
                .then(function(resp) {
                    var errorResp = [];
                    var dataAlert = {};

                    if(resp.data.isSuccess) {
                        // clearModal()
                        dataAlert = {
                            icon: 'success',
                            title: "Berhasil!",
                            text: _successMessage,
                        }
                        // $("#table-dashboard-vendor").bootstrapTable('refresh')
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
                validateInputMapping.errors.forEach(function(data) {
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

        function lokasiFormatter(value, row, index) {

            return value == null ? "Working / Lapangan" : value
        }

        function actionFormatter(value, row, index) {
            // console.log(row)

            var _id = ", '"+ row.id + "'"
            var _id_vendor = ", '"+ row.id_vendor + "'"
            var _site = ", '"+ row.site + "'"
            var _jenis_pemesanan = ", '"+ row.jenis_pemesanan + "'"
            var _lokasi = ", '"+ row.lokasi + "'"
            var _nama_vendor = ", '"+ row.nama_vendor + "'"

            var _clickEvent = 'onclick="modalDetail(this'  + _id + _id_vendor + _site + _jenis_pemesanan + _lokasi + _nama_vendor +')"'
            var _clickEventDelete = 'onclick="actionDelete(this'  + _id +')"'

            var btnDetail = '<a href="#" '+ _clickEvent +' data-action="detail" data-show="false" data-url="" style="color: black;margin: 0px 4px;"><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true" style="color: grey;margin: 0px 4px;"><i class="fa fa-pen cursor-pointer"></i></a>';
            var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-url="" data-show="true" data-action="delete" style="color: red;margin: 0px 4px;"><i class="fa-solid fa-trash-can cursor-pointer"></i></a>';
            
            return btnDetail + btnEdit + btnHapus
        }

        function modalDetail(e, _id, _id_vendor, _site, _jenis_pemesanan, _lokasi, _nama_vendor) {
            // console.log(e.getAttribute("data-action"), _lokasi)
            
            fetchVendor(_id_vendor, function(data) {
                $("#addVendor").empty()
                data.forEach(element => {
                    $('#addVendor').append(new Option(element.text, element.id))
                })
                $('#addVendor').val(_id_vendor).trigger('change')
            })
            $('#addSite').off('select2:select')
            $("#addSite").trigger({
                type: "select2:select",
                params: {data: {id: _site}}
            })
            $("#addSite").val(_site).trigger("change")
            fetchLokasi(_site, function(data) {
                $('#addLokasi').empty();

                data.forEach(function(mess) {
                    $('#addLokasi').append(new Option(mess.text, mess.id))
                })
                $('#addLokasi').val(_lokasi).trigger('change')
                $('#addLokasi').trigger('change')
            })
            $('#addJenisPemesanan').val(_jenis_pemesanan).trigger('change')
            $('#addLokasi').val(_lokasi).trigger('change')
            $("#id_mapping").text(_id)
            
            $("#btnSubmitMapping").attr("data-action", "edit")
            $('#exampleModalToggleLabel').text("Edit mapping vendor")

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
                            url: baseUrl + "/delete-mapping-vendor",
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

        function getDataMappingVendor(params) {
            var listVendorMappingURL = baseUrl + '/list-vendor-mapping'
            // console.log("halojuga")
            // params.data.site = filter.site
            // params.data.mess = filter.mess

            // if(params.data.site != null || params.data.mess != null) {
                $.get(listVendorMappingURL + '?' + $.param(params.data)).then(function(res) {
                    params.success(res.data)
                })
            // } else {
            //     params.success([])
            // }
        }

        function fetchSite(cb=function(site) {}) {
            axios.post("/helper/department", {
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

        function fetchLokasi(query, cb=function(site) {}) {
            axios.get(baseUrl + "/helper-lokasi?query="+query, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                var optionLokasi = []
                // optionLokasi.push(new Option("--- Cari Site ---", "", true, true))
                optionLokasi.push({
                    id: "",
                    text: "--- Cari Lokasi ---"
                })

                data.data.data.forEach(element => {
                    optionLokasi.push({
                        id: element.id,
                        text: element.text
                    })

                    // optionLokasi.push(new Option(element.text, element.id))
                });
                
                cb(optionLokasi)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }

        function fetchVendor(query, cb=function(site) {}) {
            axios.get(baseUrl + "/helper-vendor?query="+query, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                // console.log(data)
                var optionLokasi = []
                // optionLokasi.push(new Option("--- Cari Site ---", "", true, true))
                optionLokasi.push({
                    id: "",
                    text: "--- Cari Lokasi ---"
                })

                optionLokasi.push({
                    id: "working",
                    text: "Working / Lapangan"
                })

                data.data.data.forEach(element => {
                    optionLokasi.push({
                        id: element.id,
                        text: element.text
                    })

                    // optionLokasi.push(new Option(element.text, element.id))
                });
                
                cb(optionLokasi)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }

        function clearModal() {
            $('#addSite').val(null).trigger("change")
            $('#addLokasi').val(null).trigger("change")
            $('#addVendor').val(null).trigger("change")
            $('#addJenisPemesanan').val(null).trigger("change")
            $('#exampleModalToggleLabel').text("Tambah mapping vendor")
        }

        modalElement.on('hide.bs.modal', function (e) {
            // console.log($("#btnSubmitMapping").attr("data-action"))
            if($("#btnSubmitMapping").attr("data-action") == "edit" ) clearModal()
            $("#btnSubmitMapping").attr("data-action", "add")
        })

        fetchSite(function(data) {
            // console.log(data)
            data.forEach(function(opt) {
                $('#addSite').append(new Option(opt.text, opt.id))
            })
            // data.forEach(function(opt) {
            //     $('#editSite').append(opt)
            // })
        })
        
    </script>
@endsection