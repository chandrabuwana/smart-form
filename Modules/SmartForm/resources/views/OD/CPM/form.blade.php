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
                                <select class="js-example-responsive" style="width: 100%" id="inputSite" name="inputSite"></select>
                                {{-- <input type="text" class="form-control form-select" id="inputSite"
                                    name="inputSite" placeholder="Cari Site"> --}}
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="input-group input-group-static">
                                <label for="inputPeriode">Tahun</label>
                                <input type="text" class="form-control" id="inputPeriode" name="inputPeriode" placeholder="Tahun">
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
                                    <th>id</th>
                                    <th>category</th>
                                    <th>Objective</th>
                                    <th>UOM</th>
                                    <th>HIG/HIB</th>
                                    <th>Januari</th>
                                    <th>Februari</th>
                                    <th>Maret</th>
                                    <th>April</th>
                                    <th>Mei</th>
                                    <th>Juni</th>
                                    <th>Juli</th>
                                    <th>Agustus</th>
                                    <th>September</th>
                                    <th>Oktober</th>
                                    <th>November</th>
                                    <th>Desember</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>Yearly</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <!--
                    <div class="table-responsive p-0">
                        <table id="table-syarat" data-toggle="table" data-side-pagination="client"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="approval_role" data-align="left"></th>
                                    {{-- <th data-field="jabatan" data-align="left">Jabatan</th> --}}
                                    <th data-field="pic" data-align="left">PIC</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dibuat oleh</td>
                                    {{-- <td>Kabag / Kasi Dept</td> --}}
                                    <td>
                                        <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                            {{-- TODO : enable ini ketika mau deploy --}}
                                            {{-- <select class="form-control form-select form-approval" name="persetujuan" id="persetujuan"> --}}
                                            <select class="form-control form-select form-approval" name="level1" id="level1">
                                                <option value="">-- Pilih PIC --</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Disetujui oleh</td>
                                    {{-- <td>Kabag / Kasi ICGS</td> --}}
                                    <td>
                                        <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                            {{-- TODO : enable ini ketika mau deploy --}}
                                            {{-- <select class="form-control form-select form-approval" name="disetujui1" id="disetujui1"> --}}
                                            <select class="form-control form-select form-approval" name="level2" id="level2">
                                                <option value="">-- Pilih PIC --</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diketahui oleh</td>
                                    {{-- <td>Kadep HO / Direktorat</td> --}}
                                    <td>
                                        <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                            {{-- TODO : enable ini ketika mau deploy --}}
                                            {{-- <select class="form-control form-select form-approval" name="diketahui2" id="diketahui2"> --}}
                                            <select class="form-control form-select form-approval" name="level3" id="level3">
                                                <option value="">-- Pilih PIC --</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    -->
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
    <script>
        const elem = document.getElementById("inputPeriode")
        const datepicker = new Datepicker(elem, {
            format: "yyyy",
            pickLevel: 2
        })

        $('#inputSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputSite').closest('.input-group'),
            placeholder: '--- Cari SITE ---',
            allowClear: true
        })

        fetchSite(function(data) {
            data.forEach(function(opt) {
                $('#inputSite').append(new Option(opt.text, opt.id))
            })
        })

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
        var myTable = $('#jsonTable').DataTable({
            columnDefs: [
                { visible: false, targets: [0, 1] }, {width: "500px", target: 2},
                {
                    targets: -1, // Menargetkan kolom terakhir untuk action button
                    data: null,
                    render: function(data, type, row, meta) {
                        return `
                        <div onclick="preventParent(event)">
                            <button class="btn btn-sm btn-danger edit-btn" data-id="${meta.row}" onclick="removeObj(event)" style="margin: 0px;">
                                <i class="bi bi-trash" style="font-size: 0.725rem"></i>
                            </button>
                        </div>`;
                    }
                }
            ],
            columns: [
                {data: 'id'},
                {data: 'category'},
                {data: 'objective'},
                {data: 'uom'},
                {data: 'hig_hib'},
                {data: 'januari'},
                {data: 'februari'},
                {data: 'maret'},
                {data: 'april'},
                {data: 'mei'},
                {data: 'juni'},
                {data: 'juli'},
                {data: 'agustus'},
                {data: 'september'},
                {data: 'oktober'},
                {data: 'november'},
                {data: 'desember'},
                {data: 'q1'},
                {data: 'q2'},
                {data: 'q3'},
                {data: 'q4'},
                {data: 'yearly'},
                {data: 'actions'}
            ],
            // order: [[0, 'asc']], // Urutkan berdasarkan department
            rowGroup: {
                dataSrc: 'category' // Grouping berdasarkan field department
            },
            scrollX: true,
            paging: false
        })

        $('#jsonTable tbody').on('click', 'td', function() {
            if (!myTable.data().any()) {
                alert("Data masih kosong, tidak bisa mengedit.");
                return;  // Hentikan fungsi jika data kosong
            }

            var cell = myTable.cell(this);
            var originalValue = cell.data();
            
            console.log(myTable.columns()[0].length) 
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

        $('#jsonTable tbody').on('click', '.edit-btn', function(e) {
            // console.log(e)
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

            myTable.row.add({
                id: e.params.data.id,
                category: e.params.data.category,
                objective: e.params.data.text,
                uom: '',
                hig_hib: '',
                januari: 0,
                februari: 0,
                maret: 0,
                april: 0,
                mei: 0,
                juni: 0,
                juli: 0,
                agustus: 0,
                september: 0,
                oktober: 0,
                november: 0,
                desember: 0,
                q1: 0,
                q2: 0,
                q3: 0,
                q4: 0,
                yearly: 0,
                action: null
            }).draw();
        })

        function validateData() {
            let validationResult = {
                isSuccess: false,
                message: "",
                errList: [],
                data: {
                    KodeST: $("#inputSite").val(),
                    tahun:  datepicker.getDate("yyyy"),
                    dtl: []
                }
            }
            for (let index = 0; index < myTable.rows().data().length; index++) {
                const element = myTable.rows().data()[index];
                validationResult.data.dtl.push(element)
            }

            if(!validationResult.data.KodeST) validationResult.errList.push("Site belum dipilih!")
            if(!validationResult.data.tahun) validationResult.errList.push("Tahun belum dipilih!")
            if(validationResult.data.dtl.length < 1) validationResult.errList.push("Objective masih kosong!")

            if(validationResult.errList.length > 0) {
                validationResult.message = "Error mandatory field"
            } else {
                validationResult.isSuccess = true
            }

            // console.log(validationResult.data.dtl)
            // return

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
                            {{ Illuminate\Support\Js::from(route('cpm.form-submit')) }},
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
                                    if (result.isConfirmed && resp.data.isSuccess) {
                                        location.reload()
                                    }
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
    </script>
@endsection