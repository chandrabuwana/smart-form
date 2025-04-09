@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- RowGroup Extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker-bs5.min.css">
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
        .select2-selection__clear {
            position: absolute;
            right: 0;
            top: 12px;
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
        .btn-action-format {
            margin: 0;
            padding: 10px 16px;
        }
        .btn-no-action:hover {
            cursor: default;
        }
        .btn-action-font {
            font-size: 1rem;
        }
    </style>
@endsection

@section('content')
{{-- <input type="text" name="foo"> --}}
    {{-- {{ dd($data) }} --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4 pb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form CPM</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row container">
                        <div class="col-6 col-lg-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputSite" style="width: 100%;">Site</label>
                                {{-- <select class="js-example-responsive" style="width: 100%" id="inputSite" name="inputSite"></select> --}}
                                <input type="text" class="form-control form-select" id="inputSite"
                                    name="inputSite" placeholder="Cari Site" value="{{ $dataCPM->KodeST }} - {{ $dataCPM->site }}" disabled>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="input-group input-group-static">
                                <label for="inputPeriode">Tahun</label>
                                <input type="text" class="form-control form-select" id="inputPeriode"
                                    name="inputPeriode" placeholder="Cari Site" value="{{ $dataCPM->TanggalSubmit }}" disabled>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputObjective" style="width: 100%;">Tambah Objective</label>
                                <select class="js-example-responsive" style="width: 100%" id="inputObjective" name="inputObjective"></select>
                                {{-- <input type="text" class="form-control form-select" id="inputSite"
                                    name="inputSite" placeholder="Cari Site"> --}}
                            </div>
                        </div>
                    </div>
                    <div class="m-2">
                        {{-- <div class="col-6 col-lg-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputObjective" style="width: 100%;">Tambah Objective</label>
                                <select class="js-example-responsive" style="width: 100%" id="inputObjective" name="inputObjective"></select>
                            </div>
                        </div> --}}
                        <table id="jsonTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">id</th>
                                    <th rowspan="2">category</th>
                                    <th rowspan="2">Objective</th>
                                    <th rowspan="2">UOM</th>
                                    <th rowspan="2">HIG/HIB</th>
                                    <th colspan="2">Januari</th>
                                    <th colspan="2">Februari</th>
                                    <th colspan="2">Maret</th>
                                    <th colspan="2">April</th>
                                    <th colspan="2">Mei</th>
                                    <th colspan="2">Juni</th>
                                    <th colspan="2">Juli</th>
                                    <th colspan="2">Agustus</th>
                                    <th colspan="2">September</th>
                                    <th colspan="2">Oktober</th>
                                    <th colspan="2">November</th>
                                    <th colspan="2">Desember</th>
                                    <th colspan="2">Q1</th>
                                    <th colspan="2">Q2</th>
                                    <th colspan="2">Q3</th>
                                    <th colspan="2">Q4</th>
                                    <th colspan="2">Yearly</th>
                                    <th rowspan="2">Action</th>
                                </tr>
                                <tr>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <div style="display: flex; justify-content: end;">
                        <button class="btn btn-primary mb-0" onclick="simpanData(event)">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('master/js/helper-site.js') }}"></script>
    <script src="{{ asset('master/js/loading.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- RowGroup Extension JS -->
    <script src="https://cdn.datatables.net/rowgroup/1.3.1/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
    <script>
        function deepCompare(obj1, obj2) {
            // console.log(obj1, obj2)
            // Jika kedua objek adalah primitif atau null
            if (obj1 === obj2) return null;

            // Jika salah satu dari objek adalah null atau bukan objek
            if (obj1 === null || typeof obj1 !== 'object' || obj2 === null || typeof obj2 !== 'object') {
                return obj2;
            }

            // Mengambil keys dari kedua objek
            const keys1 = Object.keys(obj1);
            const keys2 = Object.keys(obj2);

            // Jika jumlah keys berbeda, kembalikan obj2
            if (keys1.length !== keys2.length) return obj2;

            const diff = {};

            for (let key of keys1) {
                if (keys2.includes(key)) {
                    const value1 = obj1[key];
                    const value2 = obj2[key];

                    const result = deepCompare(value1, value2);

                    if (result !== null) {
                        diff[key] = result;
                    }
                } else {
                    diff[key] = obj2[key];
                }
            }

            // Jika tidak ada perbedaan, kembalikan null
            return Object.keys(diff).length > 0 ? diff : null;
        }
    </script>
    <script>
        const formCPM = {{ Illuminate\Support\Js::from($dataCPM->id) }}
        var myTable
        var dataAsli
        var originalData = []
        // const elem = document.getElementById("inputPeriode")
        // const datepicker = new Datepicker(elem, {
        //     format: "yyyy",
        //     pickLevel: 2
        // })

        // $('#inputSite').select2({
        //     theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
        //     dropdownParent: $('#inputSite').closest('.input-group'),
        //     placeholder: '--- Cari SITE ---',
        //     allowClear: true
        // })

        // fetchSite(function(data) {
        //     data.forEach(function(opt) {
        //         $('#inputSite').append(new Option(opt.text, opt.id))
        //     })
        // })

        $('#inputObjective').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputObjective').closest('.input-group'),
            placeholder: '--- Cari Objective ---',
            allowClear: true,
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('cpm.helper-objective')) }},
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
                        results: response.data.rows
                    };
                },
                cache: true,
            },
            templateResult: function (data) {
                // console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>(' + data.category + ') ' + data.text + '</span>');
                return $result;
            }
        })

        // $(document).ready(function() {
            // Data JSON
            // var jsonData = [
            //     {"department": "HR", "name": "John Doe", "position": "Recruiter", "salary": 50000},
            //     {"department": "IT", "name": "Jane Smith", "position": "Developer", "salary": 70000},
            //     {"department": "HR", "name": "Mary Johnson", "position": "HR Manager", "salary": 65000},
            //     {"department": "Finance", "name": "Robert Brown", "position": "Accountant", "salary": 55000},
            //     {"department": "IT", "name": "Michael Davis", "position": "System Admin", "salary": 60000},
            //     {"department": "Finance", "name": "Emily Wilson", "position": "Financial Analyst", "salary": 58000},
            //     {"department": "IT", "name": "Chris Taylor", "position": "DevOps Engineer", "salary": 75000}
            // ];

        // var myTable = new DataTable('#jsonTable');
        // Inisialisasi DataTable dengan JSON dan RowGroup
        // $.ajax({
        //     url: {{ Illuminate\Support\Js::from(route('cpm.form-dtl.data') . '?id=' . $dataCPM->id)}}, // Ganti dengan API kamu
        //     type: "GET",
        //     dataType: "json",
        //     success: function(response) {
        //         originalData = response.data // Simpan data asli di variabel
        //         initDataTable(originalData);
        //     }
        // })

        // function initDataTable(data) {
            myTable = $('#jsonTable').on('xhr.dt', function (e, settings, json, xhr) {
                // console.log(json.data)
                originalData = JSON.parse(JSON.stringify(json.data))
                json.data = json.data.filter(function (nilai) {
                    return nilai.is_deleted == 0
                })
                // originalData = Object.assign([], json.data)
                // dataAsli = Object.assign([], originalData)
            })
            .DataTable({
                ajax: {
                    url: {{ Illuminate\Support\Js::from(route('cpm.form-dtl.data') . '?id=' . $dataCPM->id)}},
                    type: "GET",
                    dataSrc: "data"
                },
                // data: data,
                columnDefs: [
                    { visible: false, targets: [0, 1] }, {width: "500px", target: 2},
                    // {
                    //     targets: -1, // Menargetkan kolom terakhir untuk action button
                    //     data: null,
                    //     render: function(data, type, row, meta) {
                    //         return `
                    //         <div onclick="preventParent(event)">
                    //             <button class="btn btn-sm btn-danger edit-btn" data-id="${meta.row}" onclick="removeObj(event)" style="margin: 0px;">
                    //                 <i class="bi bi-trash" style="font-size: 0.725rem"></i>
                    //             </button>
                    //         </div>`;
                    //     }
                    // }
                ],
                columns: [
                    {data: 'id'},
                    {data: 'category'},
                    {data: 'objective_name'},
                    {data: 'UOM'},
                    {data: 'HIG_HIB'},
                    {data: 'plan_b_1'},
                    {data: 'act_b_1'},
                    {data: 'plan_b_2'},
                    {data: 'act_b_2'},
                    {data: 'plan_b_3'},
                    {data: 'act_b_3'},
                    {data: 'plan_b_4'},
                    {data: 'act_b_4'},
                    {data: 'plan_b_5'},
                    {data: 'act_b_5'},
                    {data: 'plan_b_6'},
                    {data: 'act_b_6'},
                    {data: 'plan_b_7'},
                    {data: 'act_b_7'},
                    {data: 'plan_b_8'},
                    {data: 'act_b_8'},
                    {data: 'plan_b_9'},
                    {data: 'act_b_9'},
                    {data: 'plan_b_10'},
                    {data: 'act_b_10'},
                    {data: 'plan_b_11'},
                    {data: 'act_b_11'},
                    {data: 'plan_b_12'},
                    {data: 'act_b_12'},
                    {data: 'plan_q1'},
                    {data: 'act_q1'},
                    {data: 'plan_q2'},
                    {data: 'act_q2'},
                    {data: 'plan_q3'},
                    {data: 'act_q3'},
                    {data: 'plan_q4'},
                    {data: 'act_q4'},
                    {data: 'plan_yearly'},
                    {data: 'act_yearly'},
                    {
                        "data": null, // Kolom Actions (tidak ada data langsung dari API)
                        "render": function(data, type, row, meta) {
                            // Render tombol Actions
                            // console.log(meta)
                            return `<div onclick="preventParent(event)"><button class="btn btn-sm btn-danger edit-btn" data-id="${meta.row}" onclick="removeObj(event)" style="margin: 0px;"><i class="bi bi-trash" style="font-size: 0.725rem"></i></button></div>`
                        }
                    }
                ],
                // order: [[0, 'asc']], // Urutkan berdasarkan department
                rowGroup: {
                    dataSrc: 'category' // Grouping berdasarkan field department
                },
                scrollX: true,
                paging: false
            })
        // }
            
        $('#jsonTable tbody').on('click', 'td', function() {
            if (!myTable.data().any()) {
                alert("Data masih kosong, tidak bisa mengedit.");
                return;  // Hentikan fungsi jika data kosong
            }

            var cell = myTable.cell(this);
            var originalValue = cell.data();
            
            // console.log(myTable.columns()[0].length) 
            if(cell.index().column == 2 || cell.index().column == myTable.columns()[0].length-1) return


            // Cek apakah sudah ada input di dalam sel
            if ($(this).find('input').length === 0) {
                $(this).html('<input type="text" value="' + originalValue + '" style="width:100%">');
                $(this).find('input').focus();
            }

            // Update data setelah input kehilangan fokus (blur)
            $(this).find('input').on('blur', function() {
                var newValue = $(this).val();

                // Cek jika ada perubahan nilai
                if (newValue !== originalValue) {
                    // Jika kolom Salary, ubah ke angka
                    // if (cell.index().column === 3) {
                    //     newValue = parseFloat(newValue.replace(/[^0-9.-]+/g,"")); // Hapus simbol $
                    // }
                    cell.data(newValue).draw();
                } else {
                    // Jika tidak ada perubahan, kembalikan nilai asli
                    cell.data(originalValue).draw();
                }
            });

            // Update data saat menekan Enter
            $(this).find('input').on('keypress', function(e) {
                if (e.which === 13) {  // Enter key
                    $(this).blur();    // Trigger blur event untuk menyimpan data
                }
            });
        })

        $('#jsonTable tbody').on('click', '.edit-btn', function() {
            console.log(this)
            const rowId = $(this).data('id');
            alert('Edit row: ' + rowId);
            // Tambahkan logika untuk edit data
        });

        // Event Listener untuk tombol Delete
        $('#jsonTable tbody').on('click', '.delete-btn', function() {
            const rowId = $(this).data('id');
            if (confirm('Yakin ingin menghapus data ini?')) {
                alert('Deleted row: ' + rowId);
                // Tambahkan logika untuk delete data
            }
        });
            // console.log(myTable.data())
        // })

        $('#inputObjective').on("select2:select", function (e) { 
            console.log("inputObjective", e.params.data); 
            objectiveExist = myTable.data().filter(function(data) {
                return data.objective_id ==  e.params.data.id
            })

            if(objectiveExist.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Data objective sudah ada!'
                })
            } else {
                let isRestored = isRestoreFormOriginal(e.params.data.id)
                console.log("debug restored : ")
                console.log(isRestored)
                let insertedData = {}
                if(isRestored.isRestored) {
                    insertedData = isRestored.data
                } else {
                    insertedData = {
                        "id": 0, 
                        "objective_id": e.params.data.id, 
                        "objective_name": e.params.data.text, 
                        "category": e.params.data.category, 
                        "id_m_cpm": formCPM, 
                        "UOM": "", 
                        "HIG_HIB": "", 
                        "created_by": null, 
                        "is_deleted": 0, 
                        "stts": 0, 
                        "plan_b_1": 0, 
                        "act_b_1": 0, 
                        "plan_b_2": 0, 
                        "act_b_2": 0, 
                        "plan_b_3": 0, 
                        "act_b_3": 0, 
                        "plan_b_4": 0, 
                        "act_b_4": 0, 
                        "plan_b_5": 0, 
                        "act_b_5": 0, 
                        "plan_b_6": 0, 
                        "act_b_6": 0, 
                        "plan_b_7": 0, 
                        "act_b_7": 0, 
                        "plan_b_8": 0, 
                        "act_b_8": 0, 
                        "plan_b_9": 0, 
                        "act_b_9": 0, 
                        "plan_b_10": 0, 
                        "act_b_10": 0, 
                        "plan_b_11": 0, 
                        "act_b_11": 0,
                        "plan_b_12": 0, 
                        "act_b_12": 0, 
                        "plan_q1": 0, 
                        "act_q1": 0, 
                        "plan_q2": 0, 
                        "act_q2": 0, 
                        "plan_q3": 0, 
                        "act_q3": 0, 
                        "plan_q4": 0, 
                        "act_q4": 0, 
                        "plan_yearly": 0, 
                        "act_yearly": 0 
                    }   
                }
                myTable.row.add(insertedData)
                .draw();
            }
            
            
        })

        function validateData() {
            let validationResult = {
                isSuccess: false,
                message: "",
                errList: [],
                data: {
                    idCPM: formCPM,
                    dtl: {
                        deleted: [],
                        changed: [],
                        added: [],
                        restored: [],
                    }
                }
            }
            let temData = []

            for (let index = 0; index < myTable.rows().data().length; index++) {
                const element = myTable.rows().data()[index];
                temData.push(element)
                if(element.id == 0) {
                    validationResult.data.dtl.added.push(element)
                } else {
                    let dataAsli = {}
                    for (let j = 0; j < originalData.length; j++) {
                        const elementJ = originalData[j];
                        if(elementJ.id == element.id) dataAsli = Object.assign({}, elementJ)
                    }

                    const diff = deepCompare(dataAsli, element)
                    // console.log({asli: dataAsli, current: element, beda: diff})
                    if(diff) validationResult.data.dtl.changed.push({id: element.id, detail: diff})
                    if(element.is_deleted == 1) validationResult.data.dtl.restored.push(element.id)
                }
            }

            if(validationResult.errList.length > 0) {
                validationResult.message = "Error mandatory field"
            } else {
                validationResult.isSuccess = true
            }

            let deletedData = []
            for (let i = 0; i < originalData.length; i++) {
                let isDeleted = []
                const element = originalData[i];

                for (let j = 0; j < temData.length; j++) {
                    const element2 = temData[j];
                    if(element.id == element2.id) isDeleted.push(element.id)
                }

                if(isDeleted.length < 1) deletedData.push({
                    id: element.id,
                    objective_id: element.objective_id
                })

            }
            validationResult.data.dtl.deleted = deletedData

            // console.log(validationResult)
            // return

            if(validationResult.data.dtl.added.length < 1 && validationResult.data.dtl.deleted.length < 1 && validationResult.data.dtl.changed.length < 1 ) {
                validationResult.errList.push('Tidak ada perubahan')
            }

            if(validationResult.errList.length < 1) {
                validationResult.message = 'Error validasi data'
                validationResult.isSuccess = true
            }

            return validationResult
        }

        function simpanData(e) {
            let validasiData = validateData()

            // console.log(validasiData)

            if(!validasiData.isSuccess) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: validasiData.errList.join("<br>")
                })
                e.target.disabled = false
            } else {
                Swal.fire({
                    title: "Submit data ?",
                    text: "Mengubah data akan mengulangi flow validasi dari awal",
                    showCancelButton: true,
                    cancelButtonText: "batal",
                    cancelButtonColor: "#fd5c70",
                    confirmButtonText: "Submit",
                    confirmButtonColor: "#4CAF50",
                    icon: "question"
                }).then((result) => {
                    // console.log(result)
                    if (result.isConfirmed) {
                        showLoading()
                        axios.post(
                            {{ Illuminate\Support\Js::from(route('cpm.form-edit.submit') . '?idCPM=' . $dataCPM->id) }},
                            validasiData.data, 
                            {
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            }
                        )
                        .then(function(resp) { 
                            let dataSwal = {}
                            if(resp.data.isSuccess) {
                                dataSwal = {
                                    backdrop: false,
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: resp.data.message || 'Berhasil'
                                }
                            } else {
                                dataSwal = {
                                    backdrop: false,
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: resp.data.message || 'Error, coba beberapa saat lagi'
                                }
                            }
                            Swal.fire(dataSwal)
                                .then((result) => {
                                    // if (result.isConfirmed && resp.data.isSuccess) {
                                    //     location.reload()
                                    // }
                                })
                            
                        })
                        .catch(function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan, coba beberapa saat lagi'
                            })
                        })
                        .finally(function() {
                            stopLoading()
                            e.target.disabled = false
                        })
                        
                    }
                    e.target.disabled = false
                })
            }
        }

        function preventParent(event) {
            event.stopPropagation()
        }

        function removeObj(event) {
            myTable.row(event.target.getAttribute('data-id')).remove().draw()
        }

        function isRestoreFormOriginal(objectiveId) {
            let restoredData = {
                isRestored: false, 
                data: null
            }

            for (let i = 0; i < originalData.length; i++) {
                let isDeleted = []
                const element = originalData[i];

                if(element.objective_id == objectiveId) {
                    restoredData.isRestored = true
                    restoredData.data = element
                }
            }

            return restoredData
        }

    </script>
@endsection