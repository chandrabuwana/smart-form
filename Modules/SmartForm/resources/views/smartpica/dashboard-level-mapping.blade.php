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
                        <table id="table-level-user" data-toggle="table" data-ajax="getListData" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodocpica">
                            <thead>
                                <tr>
                                    <th data-field="dept" data-align="left" data-halign="center">Departmen</th>
                                    <th data-field="section_name" data-align="left" data-halign="center">Section</th>
                                    <th data-field="level1" data-align="left" data-halign="center">Level 1</th>
                                    <th data-field="level2" data-align="left" data-halign="center">Level 2</th>
                                    <th data-field="level3" data-align="left" data-halign="center">Level 3</th>
                                    <th data-field="level4" data-align="left" data-halign="center">Level 4</th>
                                    <th data-field="level5" data-align="left" data-halign="center">Level 5</th>
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
                                                    <label for="inputDept" style="width: 100%;">Department</label>
                                                    <select class="form-control form-select" name="inputDept" id="inputDept" style="width: 100%">
                                                        <option value="">-- Pilih Department --</option>
                                                        @foreach($data_department as $department)
                                                            <option value="{{ $department->KodeDP }}">{{ $department->KodeDP . ' - ' . $department->Nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputSection">Section</label>
                                                    <select class="form-control form-select" name="inputSection" id="inputSection" style="width: 100%">
                                                        <option value="">-- Pilih Section --</option>
                                                        @foreach($data_section as $section)
                                                            <option value="{{ $section->KodeSection }}">{{ $section->Nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputLevel1">Level 1</label>
                                                    <select class="form-control form-select" name="inputLevel1" id="inputLevel1" style="width: 100%"></select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputLevel2">Level 2</label>
                                                    <select class="form-control form-select" name="inputLevel2" id="inputLevel2" style="width: 100%"></select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputLevel3">Level 3</label>
                                                    <select class="form-control form-select" name="inputLevel3" id="inputLevel3" style="width: 100%"></select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputLevel4">Level 4</label>
                                                    <select class="form-control form-select" name="inputLevel4" id="inputLevel4" style="width: 100%"></select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputLevel5">Level 5</label>
                                                    <select class="form-control form-select" name="inputLevel5" id="inputLevel5" style="width: 100%"></select>
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
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        var baseUrl = ''
        var filterNIK = document.getElementById("filterNIK")
        var dataFilter = {
            nik: null
        }

        $('#inputDept').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputDept').closest('.input-group'),
            placeholder: '--- Cari Department ---'
        });

        $('#inputSection').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputSection').closest('.input-group'),
            placeholder: '--- Cari Section ---'
        });

        $('#inputLevel1').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputLevel1').closest('.input-group'),
            placeholder: '--- Cari NIK / Nama ---',
            ajax: {
                url: "/helper/karyawan",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
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
                cache: true,
            },
            templateResult: function (data) {
                console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        });

        $('#inputLevel2').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputLevel2').closest('.input-group'),
            placeholder: '--- Cari NIK / Nama ---',
            ajax: {
                url: "/helper/karyawan",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
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
                cache: true,
            },
            templateResult: function (data) {
                console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        });

        $('#inputLevel3').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputLevel3').closest('.input-group'),
            placeholder: '--- Cari NIK / Nama ---',
            ajax: {
                url: "/helper/karyawan",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
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
                cache: true,
            },
            templateResult: function (data) {
                console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        });

        $('#inputLevel4').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputLevel4').closest('.input-group'),
            placeholder: '--- Cari NIK / Nama ---',
            ajax: {
                url: "/helper/karyawan",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
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
                cache: true,
            },
            templateResult: function (data) {
                console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        });

        $('#inputLevel5').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputLevel5').closest('.input-group'),
            placeholder: '--- Cari NIK / Nama ---',
            ajax: {
                url: "/helper/karyawan",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
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
                cache: true,
            },
            templateResult: function (data) {
                console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        });

        function actionFormatter(value, row, index) {
            var _nomor = ", '"+ row.nomor + "'"
            var _department = ", '"+ row.dept + "'"
            var _section = ", '"+ row.section + "'"
            var _level1 = ", '"+ row.level1 + "'"
            var _level2 = ", '"+ row.level2 + "'"
            var _level3 = ", '"+ row.level3 + "'"
            var _level4 = ", '"+ row.level4 + "'"
            var _level5 = ", '"+ row.level5 + "'"
            // _nama = _nama.replace("'", "")

            var _clickEvent = 'onclick="actionEdit(this' + _nomor + _department + _section + _level1 + _level2 + _level3 + _level4 + _level5 +')"'
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
                            url: baseUrl + "/delete-level-mapping",
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
                        // Swal.fire(dataResp)
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

        function actionEdit(e, _nomor, _department, _section, _level1, _level2, _level3, _level4, _level5) {
            if(_level1 == "null") _level1 = ""
            if(_level2 == "null") _level2 = ""
            if(_level3 == "null") _level3 = ""
            if(_level4 == "null") _level4 = ""
            if(_level5 == "null") _level5 = ""
            
            $("#inputNomor").val(_nomor)
            $("#inputDept").val(_department).trigger('change')
            $("#inputSection").val(_section).trigger('change')

            if ($('#inputLevel1').find("option[value='" + _level1 + "']").length) {
                $('#inputLevel1').val(_level1).trigger('change');
            } else { 
                // Create a DOM Option and pre-select by default
                var newOption = new Option(_level1, _level1, true, true);
                // Append it to the select
                $('#inputLevel1').append(newOption).trigger('change');
            } 

            if ($('#inputLevel2').find("option[value='" + _level2 + "']").length) {
                $('#inputLevel2').val(_level2).trigger('change');
            } else { 
                // Create a DOM Option and pre-select by default
                var newOption = new Option(_level2, _level2, true, true);
                // Append it to the select
                $('#inputLevel2').append(newOption).trigger('change');
            }

            if ($('#inputLevel3').find("option[value='" + _level3 + "']").length) {
                $('#inputLevel3').val(_level3).trigger('change');
            } else { 
                // Create a DOM Option and pre-select by default
                var newOption = new Option(_level3, _level3, true, true);
                // Append it to the select
                $('#inputLevel3').append(newOption).trigger('change');
            }

            if ($('#inputLevel4').find("option[value='" + _level4 + "']").length) {
                $('#inputLevel4').val(_level4).trigger('change');
            } else { 
                // Create a DOM Option and pre-select by default
                var newOption = new Option(_level4, _level4, true, true);
                // Append it to the select
                $('#inputLevel4').append(newOption).trigger('change');
            }

            if ($('#inputLevel5').find("option[value='" + _level5 + "']").length) {
                $('#inputLevel5').val(_level5).trigger('change');
            } else { 
                // Create a DOM Option and pre-select by default
                var newOption = new Option(_level5, _level5, true, true);
                // Append it to the select
                $('#inputLevel5').append(newOption).trigger('change');
            }


            $("#btnSubmitLevelUser").attr("data-action", "edit")
            $('#modal-level-user').modal("show")
        }

        $('#modal-level-user').on('hidden.bs.modal', function (e) {
            $("#inputNomor").val("")
            $("#inputDept").val("")
            $("#inputSection").val("")
            $("#inputLevel1").val("")
            $("#inputLevel2").val("")
            $("#inputLevel3").val("")
            $("#inputLevel4").val("")
            $("#inputLevel5").val("")
        })

        function getListData(params) {
            // if(filter.nik) params.data.nik = filter.nik
            // if(filter.status) params.data.status = filter.status
            // if(filter.department) params.data.department = filter.department
            // console.log("filter : ", filter)

            var url = baseUrl + '/list-level-mapping'
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
                    department: $("#inputDept").val(),
                    section: $("#inputSection").val(),
                    level1: $("#inputLevel1").val(),
                    level2: $("#inputLevel2").val(),
                    level3: $("#inputLevel3").val(),
                    level4: $("#inputLevel4").val(),
                    level5: $("#inputLevel5").val(),
                }  
            }

            if(validationData.data.department == "" || validationData.data.department == null) validationData.errors.push("Department tidak boleh kosong")
            if(validationData.data.section == "" || validationData.data.section == null) validationData.errors.push("Section tidak boleh kosong")

            validationData.errors.length > 0 ? validationData.valid = false : validationData.valid = true

            return validationData
        }

        function submitLevelUser(e) {
            var actionSubmit = e.getAttribute("data-action")
            var urlSubmit = actionSubmit == "add" ? "/add-level-mapping" : "/edit-level-mapping"
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
                        dataResp.text = resp.data.message
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

        function fetchDept(cb=function(site) {}) {
            axios.post("/helper/site", {
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
        
    </script>
@endsection
