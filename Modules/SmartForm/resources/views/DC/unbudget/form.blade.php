@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .w-full {
            width: 100%;
        }
        legend {
            display: block;
            width: auto;
            float: none;
        }
        fieldset {
            padding: 4px 10px 8px 10px;
            margin: 0;
            width: auto;
            border: 1px solid #cccccc;
        }
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            /* margin-bottom: 15px; */
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
        .select2-selection .select2-selection--single {
            margin-bottom: 0;
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

        .row>* {
            padding: 0;
        }
        
        .btn-action-format {
            margin: 0;
            padding: 10px 16px;
        }
        .btn-no-action:hover {
            cursor: default;
        }
        .filter-section {
            display: flex;
            width: 100%;
            justify-content: end;
            gap: 8px;
        }
        /* .page-item .page-link {
            color: #FFFFFF;
        } */
        /* .active > .page-link {
            color: #cccccc;
        } */
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
                        <h6 class="text-white text-capitalize ps-3">Form BA Unbudget</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    
                    <div class="px-4 row">
                        <h5>Tambah Material</h5>
                        <div class="col-md-4 col-lg-3 px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="addKodeMaterial">Kode Material</label>
                                <input type="text" class="form-control" id="addKodeMaterial" name="addKodeMaterial">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="addNamaMaterial">Nama Material</label>
                                <input type="text" class="form-control" id="addNamaMaterial" name="addNamaMaterial">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 px-2">
                            <div class="input-group mb-2">
                                <label for="addCOA" class="w-full m-0">COA</label>
                                <select type="text" class="form-control w-full" id="addCOA" name="addCOA"></select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="addQTY">QTY</label>
                                <input type="text" class="form-control" id="addQTY" name="addQTY">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="addHargaSatuan">Harga Satuan</label>
                                <input type="text" class="form-control" id="addHargaSatuan" name="addHargaSatuan">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="addKeterangan">Keterangan</label>
                                <input type="text" class="form-control" id="addKeterangan" name="addKeterangan">
                            </div>
                        </div>
                        
                    </div>
                    <button id="btn-add-item" class="btn btn-primary" onclick="addMaterial(event)" 
                        style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                        Tambah
                    </button>

                    <div class="table-responsive p-0">
                        <table id="table-data" data-toggle="table" data-side-pagination="server"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="kode_material" data-align="left">Kode Material</th>
                                    <th data-field="nama_material" data-align="left">Nama Material</th>
                                    <th data-field="kode_coa" data-align="left">Kode COA</th>
                                    <th data-field="nama_coa" data-align="left">COA</th>
                                    <th data-field="qty" data-align="left">QTY</th>
                                    <th data-field="harga_satuan" data-align="left">Harga Satuan</th>
                                    <th data-field="keterangan" data-align="left">Keterangan</th>
                                    <th data-align="center" data-formatter="actionFormatter">Action</th>
                            </thead>
                        </table>
                    </div>
                  
                    <div class="px-4 mt-3 row">
                        <h5>SEFTO</h5>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputStrategi">Strategi</label>
                                <input type="text" class="form-control" id="inputStrategi" name="inputStrategi">
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputEkonomi">Ekonomi</label>
                                <input type="text" class="form-control" id="inputEkonomi" name="inputEkonomi">
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputFinance">Finance</label>
                                <input type="text" class="form-control" id="inputFinance" name="inputFinance">
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputTechnology">Technology</label>
                                <input type="text" class="form-control" id="inputTechnology" name="inputTechnology">
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputOperation">Operation</label>
                                <input type="text" class="form-control" id="inputOperation" name="inputOperation">
                            </div>
                        </div>
                    </div>

                    <div class="px-4 mt-3 row">
                        <h5>Lokasi & Validasi</h5>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputTempat">Tempat</label>
                                <input type="text" class="form-control" id="inputTempat" name="inputTempat">
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputKabag">Kepala Bagian</label>
                                <select type="text" class="form-control w-full" id="inputKabag" name="inputKabag"></select>
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputIA">IA Site</label>
                                <select type="text" class="form-control w-full" id="inputIA" name="inputIA"></select>
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputPM">Project Manager</label>
                                <select type="text" class="form-control w-full" id="inputPM" name="inputPM"></select>
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputKadep">Kepala Department</label>
                                <select type="text" class="form-control w-full" id="inputKadep" name="inputKadep"></select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer flex">
                    <button id="btn-submit" class="btn btn-primary" onclick="submitUnbudget(event)">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }
    </script>
    <script>
        $('#addCOA').select2({
            // allowClear: true,
            // minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#addCOA').closest('.input-group'),
            placeholder: '',
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('dc.unbudget.helper-coa')) }},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        _token: {{ Illuminate\Support\Js::from(csrf_token()) }},
                        query: params.term
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
                // console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        })

        $('#inputKabag').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputKabag').closest('.input-group'),
            placeholder: '',
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('dc.unbudget.helper-mp')) }},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        _token: {{ Illuminate\Support\Js::from(csrf_token()) }},
                        query: params.term
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
                // console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        })
        
        $('#inputIA').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputIA').closest('.input-group'),
            placeholder: '',
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('dc.unbudget.helper-mp')) }},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        _token: {{ Illuminate\Support\Js::from(csrf_token()) }},
                        query: params.term
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
                // console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        })

        $('#inputPM').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputPM').closest('.input-group'),
            placeholder: '',
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('dc.unbudget.helper-mp')) }},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        _token: {{ Illuminate\Support\Js::from(csrf_token()) }},
                        query: params.term
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
                // console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        })

        $('#inputKadep').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputKadep').closest('.input-group'),
            placeholder: '',
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('dc.unbudget.helper-mp')) }},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        _token: {{ Illuminate\Support\Js::from(csrf_token()) }},
                        query: params.term
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
                // console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        })

        function validateNumber(input, type) {
            let dataNilai = {
                error: true,
                nilai: 0
            }

            if (type === 'int') {
                // Validasi bilangan bulat
                if (/^-?\d+$/.test(input)) {
                    dataNilai.error = false
                    dataNilai.nilai = parseInt(input)
                }
            } else if (type === 'float') {
                // Validasi bilangan float
                if (/^-?\d+(\.\d+)?$/.test(input)) {
                    dataNilai.error = false
                    dataNilai.nilai = parseFloat(input)
                }
            } else {
                console.log("Tipe validasi tidak dikenali. Gunakan 'int' atau 'float'.")
            }

            return dataNilai
        }

        function addMaterial(event) {
            let dataQTY = validateNumber($("#addQTY").val(), 'int')
            let dataHarga = validateNumber($("#addHargaSatuan").val(), 'float')
            let errList = []

            if(dataQTY.error) errList.push('QTY tidak valid')
            if(dataHarga.error) errList.push('Harga Satuan tidak valid')

            if(errList.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error validasi!',
                    html: errList.join("<br>")
                })

                return
            }

            $("#table-data").bootstrapTable('append', {
                kode_material: $("#addKodeMaterial").val(),
                nama_material: $("#addNamaMaterial").val(),
                kode_coa: $("#addCOA").val(),
                nama_coa: $('#addCOA').find(':selected').text(),
                qty: parseInt(dataQTY.nilai),
                harga_satuan: parseFloat(dataHarga.nilai),
                keterangan: $("#addKeterangan").val()
            })
        }

        function actionFormatter(value, row, index) {
            let btnReject = `<button type="button" class="btn btn-danger btn-action-format" onclick="aksiHapus(event, ${index})"><i class="bi bi-x-circle-fill"></i></button>`

            let action = '<div style="display: flex; gap:6px; justify-content: center;">' + btnReject + '</div>'
            
            return action
        }

        function aksiHapus(event, index) {
            $("#table-data").bootstrapTable('remove', {
                field: '$index',
                values: [index]
            })
        }

        function validateForm() {
            let tgl = new Date()
            let tanggal = tgl.getDate()
            let bulan = tgl.getMonth() + 1
            if(tanggal.toString().length < 2) tanggal = `0${tanggal}`
            if(bulan.toString().length < 2) bulan = `0${bulan}`

            let dataValidasi = {
                // nik: {{ Illuminate\Support\Js::from(session('user_id')) }},
                // KodeST: {{ Illuminate\Support\Js::from(session('kode_site')) }},
                // KodeDP: {{ Illuminate\Support\Js::from(session('kode_department')) }},
                tanggal: `${tgl.getFullYear()}-${bulan}-${tanggal}`,
                strategi: $("#inputStrategi").val($("#inputStrategi").val().trim()).val(),
                ekonomi: $("#inputEkonomi").val($("#inputEkonomi").val().trim()).val(),
                finance: $("#inputFinance").val($("#inputFinance").val().trim()).val(),
                technology: $("#inputTechnology").val($("#inputTechnology").val().trim()).val(),
                operation: $("#inputOperation").val($("#inputOperation").val().trim()).val(),
                tempat: $("#inputTempat").val($("#inputTempat").val().trim()).val(),
                listMaterial: $("#table-data").bootstrapTable('getData'),
                approval: [
                    { nik: $("#inputKabag").val(), approvalOrder: 1, role: 'Kepala Bagian'},
                    { nik: $("#inputIA").val(), approvalOrder: 3, role: 'IA Site'},
                    { nik: $("#inputPM").val(), approvalOrder: 4, role: 'Project Manager'},
                    { nik: $("#inputKadep").val(), approvalOrder: 5, role: 'Kepala Department'}
                ]
            }

            let hasilValidasi = {
                isSuccess: false,
                errMsg: [],
                data: dataValidasi
            }

            if(!dataValidasi.strategi) hasilValidasi.errMsg.push("Strategi kosong!")
            if(!dataValidasi.ekonomi) hasilValidasi.errMsg.push("Ekonomi kosong!")
            if(!dataValidasi.finance) hasilValidasi.errMsg.push("Finance kosong!")
            if(!dataValidasi.technology) hasilValidasi.errMsg.push("Technology kosong!")
            if(!dataValidasi.operation) hasilValidasi.errMsg.push("Operation kosong!")
            if(!dataValidasi.tempat) hasilValidasi.errMsg.push("Tempat kosong!")
            if(dataValidasi.listMaterial.length < 1) hasilValidasi.errMsg.push("List material kosong!")

            if(hasilValidasi.errMsg < 1) hasilValidasi.isSuccess = true

            return hasilValidasi
        }

        function submitUnbudget(event) {
            let validasiForm = validateForm()
            event.target.disabled = true

            if(!validasiForm.isSuccess) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    html: validasiForm.errMsg.join('<br>'),
                })
                event.target.disabled = false

                return
            } else {
                showLoading()
                axios.post({{ Illuminate\Support\Js::from(route('dc.unbudget.form-submit')) }}, 
                    validasiForm.data, 
                    {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    }
                ).then(function(resp) {
                    let dataAlert = {
                        icon: "error",
                        title: "Gagal"
                    }

                    if(resp.data.isSuccess) {
                        dataAlert.icon = "success"
                        dataAlert.title = "Berhasil"
                    } 

                    dataAlert.text = resp.data.message
                    Swal.fire(dataAlert)
                        .then(data => {
                            if(resp.data.isSuccess) {
                                location.reload()
                            }
                        })
                }).catch(function(err) {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Terjadi kesalahan, coba beberapa saat lagi!"
                    })
                }).finally(function() {
                    stopLoading()
                    event.target.disabled = false
                })
            }
        }
    </script>
@endsection