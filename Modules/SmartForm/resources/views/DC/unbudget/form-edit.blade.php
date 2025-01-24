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
                                    <th data-field="id" data-align="left" data-visible='false'>ID</th>
                                    <th data-field="kode_material" data-align="left">Kode Material</th>
                                    <th data-field="nama_material" data-align="left">Nama Material</th>
                                    <th data-field="kode_coa" data-align="left">Kode COA</th>
                                    <th data-field="nama_coa" data-align="left">COA</th>
                                    <th data-field="qty" data-align="left">QTY</th>
                                    <th data-field="harga_satuan" data-align="left">Harga Satuan</th>
                                    <th data-field="keterangan" data-align="left">Keterangan</th>
                                    <th data-field="action" data-align="center" data-formatter="actionFormatter">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($data['detail'] as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->NamaMaterial }}</td>
                                        <td>{{ $item->KodeMaterial }}</td>
                                        <td>{{ $item->Code_COA }}</td>
                                        <td>{{ $item->COA }}</td>
                                        <td>{{ $item->QTY }}</td>
                                        <td>{{ $item->HargaSatuan }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
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
                                <label for="inputKabag" style="width: 100%">Kepala Bagian</label>
                                <select type="text" class="form-control w-full" id="inputKabag" name="inputKabag">
                                    <option value="i">purple</option>
                                </select>
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputIA" style="width: 100%">IA Site</label>
                                <select type="text" class="form-control w-full" id="inputIA" name="inputIA"></select>
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputPM" style="width: 100%">Project Manager</label>
                                <select type="text" class="form-control w-full" id="inputPM" name="inputPM"></select>
                            </div>
                        </div>
                        <div class="px-2">
                            <div class="input-group input-group-static mb-2">
                                <label for="inputKadep" style="width: 100%">Kepala Department</label>
                                <select type="text" class="form-control w-full" id="inputKadep" name="inputKadep"></select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer flex">
                    @if ($isEditable)
                        <button id="btn-submit" class="btn btn-primary" onclick="submitUnbudget(event)">Simpan</button>
                    @endif
                    {{-- <button id="btn-submit" class="btn btn-primary" onclick="getDataUpdate()">Simpan</button> --}}
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
        const originalData = {{ Illuminate\Support\Js::from($data) }}
        // function fetchCOA(cb=function(coa) {}) {
        //     axios.get({{ Illuminate\Support\Js::from(route('dc.unbudget.helper-coa')) }}, {
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     })
        //     .then(function(data) {
        //         var opstionDept = []

        //         data.data.data.forEach(element => {
        //             opstionDept.push({
        //                 id: element.id,
        //                 text: element.text
        //             })

        //             // opstionDept.push(new Option(element.text, element.id))
        //         });
                
        //         cb(opstionDept)
        //     })
        //     .catch(function(err) {
        //         console.log(err)
        //     })
        //     .finally( function(){

        //     });
        // }

        // fetchCOA(function(data) {
        //     data.forEach(function(opt) {
        //         $('#addCOA').append(new Option(opt.text, opt.id))
        //     })
        // })

        // $('#addCOA').select2({
        //     // allowClear: true,
        //     // minimumInputLength: 3,
        //     theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
        //     dropdownParent: $('#addCOA').closest('.input-group'),
        //     placeholder: ''
        // })
        
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
            // minimumInputLength: 3,
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
            console.log({qty: dataQTY, harga: dataHarga})
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
                id: 0,
                kode_material: $("#addKodeMaterial").val(),
                nama_material: $("#addNamaMaterial").val(),
                kode_coa: $("#addCOA").val(),
                nama_coa: $('#addCOA').find(':selected').text(),
                qty: parseInt(dataQTY.nilai),
                harga_satuan: parseFloat(dataHarga.nilai),
                keterangan: $("#addKeterangan").val(),
                action: null
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
            let updatedData = getDataUpdate()
            console.log(updatedData)
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
                axios.post({{ Illuminate\Support\Js::from(route('dc.unbudget.form-edit-submit')) }}, 
                    updatedData, 
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

        function getDataUpdate() {
            const dataAsli = {
                master: {
                    tempat: $('#inputTempat').val().trim(),
                    strategi: $('#inputStrategi').val().trim(),
                    ekonomi: $('#inputEkonomi').val().trim(),
                    finance: $('#inputFinance').val().trim(),
                    technology: $('#inputTechnology').val().trim(),
                    operation: $('#inputOperation').val().trim()
                },
                detail: [],
                approval: [
                    { nik: $("#inputKabag").val(), approvalOrder: 1, role: 'Kepala Bagian'},
                    { nik: $("#inputIA").val(), approvalOrder: 3, role: 'IA Site'},
                    { nik: $("#inputPM").val(), approvalOrder: 4, role: 'Project Manager'},
                    { nik: $("#inputKadep").val(), approvalOrder: 5, role: 'Kepala Department'}
                ]
            }
            const editedDetailId = []
            const dataUpdate = {
                noDocument: originalData.noDocument,
                master: {},
                detail: {
                    insert: [],
                    update: []
                },
                approval: []
            }

            $("#table-data").bootstrapTable("getData").forEach((data) => {
                if(data.id != 0) editedDetailId.push(data.id)
                if(data.id == 0) dataUpdate.detail.insert.push({
                    id: data.id,
                    kode_material: data.kode_material,
                    nama_material: data.nama_material,
                    kode_coa: data.kode_coa,
                    nama_coa: data.nama_coa,
                    qty: data.qty,
                    harga_satuan: data.harga_satuan,
                    keterangan: data.keterangan,
                    action: null
                })

                dataAsli.detail.push({
                    id: data.id,
                    KodeMaterial: data.kode_material,
                    NamaMaterial: data.nama_material,
                    Code_COA: data.kode_coa,
                    COA: data.nama_coa,
                    QTY: data.qty,
                    HargaSatuan: data.harga_satuan,
                    keterangan: data.keterangan,
                    action: null
                })
            })
            $('#inputTempat').val($('#inputTempat').val().trim())
            $('#inputStrategi').val($('#inputStrategi').val().trim())
            $('#inputEkonomi').val($('#inputEkonomi').val().trim())
            $('#inputFinance').val($('#inputFinance').val().trim())
            $('#inputTechnology').val($('#inputTechnology').val().trim())
            $('#inputOperation').val($('#inputOperation').val().trim())

            if($('#inputTempat').val().trim() != originalData.master.tempat) dataUpdate.master.tempat = $('#inputTempat').val().trim()
            if($('#inputStrategi').val().trim() != originalData.master.strategi) dataUpdate.master.strategi = $('#inputStrategi').val().trim()
            if($('#inputEkonomi').val().trim() != originalData.master.ekonomi) dataUpdate.master.ekonomi = $('#inputEkonomi').val().trim()
            if($('#inputFinance').val().trim() != originalData.master.finance) dataUpdate.master.finance = $('#inputFinance').val().trim()
            if($('#inputTechnology').val().trim() != originalData.master.technology) dataUpdate.master.technology = $('#inputTechnology').val().trim()
            if($('#inputOperation').val().trim() != originalData.master.operation) dataUpdate.master.operation = $('#inputOperation').val().trim()

            if($('#inputKabag').val() != originalData.approval[0].NIK) {
                let lv1 = originalData.approval.filter(data => data.urutan == 1).map(data => data.id)
                let dataLv1 = { nik: $("#inputKabag").val(), approvalOrder: 1, role: 'Kepala Bagian'}
                lv1.length > 0 ? dataLv1.replacing = lv1[0] : null
                console.log(lv1);
                
                
                dataUpdate.approval.push(dataLv1)
            }
            if($('#inputIA').val() != originalData.approval[2].NIK) {
                let lv3 = originalData.approval.filter(data => data.urutan == 3).map(data => data.id)
                let dataLv3 = { nik: $("#inputIA").val(), approvalOrder: 3, role: 'IA Site'}
                lv3.length > 0 ? dataLv3.replacing = lv3[0] : null

                dataUpdate.approval.push(dataLv3)
            }
            if($('#inputPM').val() != originalData.approval[3].NIK) {
                let lv4 = originalData.approval.filter(data => data.urutan == 4).map(data => data.id)
                let dataLv4 = { nik: $("#inputPM").val(), approvalOrder: 4, role: 'Project Manager'}
                lv4.length > 0 ? dataLv4.replacing = lv4[0] : null

                dataUpdate.approval.push(dataLv4)
            }
            
            if($('#inputKadep').val() != originalData.approval[4].NIK) {
                let lv5 = originalData.approval.filter(data => data.urutan == 5).map(data => data.id)
                let dataLv5 = { nik: $("#inputKadep").val(), approvalOrder: 5, role: 'Kepala Department'}
                lv5.length > 0 ? dataLv5.replacing = lv5[0] : null

                dataUpdate.approval.push(dataLv5)
            }

            // originalData.detail.forEach((data) => {
            //     dataAsli.detail.find((nilai) => data.id == nilai.id)
            // })
            dataUpdate.detail.update = originalData.detail.filter(item => !editedDetailId.includes(item.id)).map(item => item.id)
            
            return dataUpdate
        }

        $('#table-data').on('load-success.bs.table', function (data) {
            console.log(ready)
        })

        let approval = {
            kabag: {id: "", text: ""},
            ia: {id: "", text: ""},
            pm: {id: "", text: ""},
            kadep: {id: "", text: ""}
        }
        
        $( document ).ready(function() {
            originalData.approval.forEach(function(data) {
                console.log(data)
                if(data.urutan == 1) approval.kabag = {id: data.NIK, text: data.Nama}
                if(data.urutan == 3) approval.ia = {id: data.NIK, text: data.Nama}
                if(data.urutan == 4) approval.pm = {id: data.NIK, text: data.Nama}
                if(data.urutan == 5) approval.kadep = {id: data.NIK, text: data.Nama}
            })
            

            var optionkabag = new Option(approval.kabag.text, approval.kabag.id, true, true);
            var optionIA = new Option(approval.ia.text, approval.ia.id, true, true);
            var optionPM = new Option(approval.pm.text, approval.pm.id, true, true);
            var optionKadep = new Option(approval.kadep.text, approval.kadep.id, true, true);

            $('#inputStrategi').val(originalData.master.strategi)
            $('#inputEkonomi').val(originalData.master.ekonomi)
            $('#inputFinance').val(originalData.master.finance)
            $('#inputTechnology').val(originalData.master.technology)
            $('#inputOperation').val(originalData.master.operation)

            $('#inputTempat').val(originalData.master.tempat)
            $('#inputKabag').append(optionkabag).trigger('change');
            $('#inputIA').append(optionIA).trigger('change');
            $('#inputPM').append(optionPM).trigger('change');
            $('#inputKadep').append(optionKadep).trigger('change');

            getDataUpdate()
        })
        
    </script>
@endsection