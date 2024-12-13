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

        .input-text {

            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
        }
        .input-text:focus {
            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Import Master Training, STD Jab Training & MP Sudah training</h6>
                    </div>
                </div>
                <div class="card-body pb-2">

                    <form method="POST" enctype="multipart/form-data" id="form-import-gs">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">File Excel</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" class="form-control border w-full" name="file_excel" id="uploadExcell" onfocus="focused(this)" onfocusout="defocused(this)"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            
                        </div>
                    </form>
                    <div class="table-responsive p-0">
                        <table id="table-data" data-toggle="table" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle" data-search="true">
                            <thead>
                                <tr>
                                    <th data-field="NO" data-align="left">no</th>
                                    <th data-field="JABATAN" data-align="left" data-sortable="true">Jabatan</th>
                                    <th data-field="KodeJB" data-align="left">KodeJB</th>
                                    <th data-field="LIST TRAINING" data-align="center">Training</th>
                                    <th data-field="TABEL BANTU" data-align="center">Tabel Bantu</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary ms-auto d-flex align-items-center" onclick="importData(event)">
                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader-btn" ></span>
                        Submit
                    </button>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/shim.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script>
        let loadedMasterTraining = []
        let trainingKategori = []
        let masterjabatan = []
        let sudahTraining = []
        let stdJab = []
        document.getElementById('uploadExcell').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                const data = new Uint8Array(event.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                // console.log("Sheets:", workbook.SheetNames);
                // Menyimpan data dari semua sheet
                const sheetsData = {};

                workbook.SheetNames.forEach(sheetName => {
                    const worksheet = workbook.Sheets[sheetName];
                    const jsonData = XLSX.utils.sheet_to_json(worksheet);
                    sheetsData[sheetName] = jsonData;
                });

                let sheetName = 'Master Training'; // Ganti dengan nama sheet yang ingin dipilih
                // let sheetName = 'DB'; // Ganti dengan nama sheet yang ingin dipilih
                let worksheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(worksheet)
                // loadedMasterTraining = jsonData
                // jsonData.forEach((nilai) => {
                //     if(nilai.__EMPTY != "NO") {
                //         loadedMasterTraining.push({
                //             no: nilai.__EMPTY,
                //             jabatan: nilai.__EMPTY_1 || "",
                //             harga: nilai.__EMPTY_2 || ""
                //         })
                //     }
                // })

                loadedMasterTraining = filterDuplicateTraining(jsonData)
                trainingKategori = distinctKategoriTraining(loadedMasterTraining)

                sheetName = "master_jabatan"
                worksheet = workbook.Sheets[sheetName]
                masterjabatan = XLSX.utils.sheet_to_json(worksheet)

                sheetName = "STD JAB_TRAINING"
                worksheet = workbook.Sheets[sheetName]
                const jsonDataStdJab = XLSX.utils.sheet_to_json(worksheet)
                stdJab = jsonDataStdJab

                sheetName = "SHEET_BANTU"
                worksheet = workbook.Sheets[sheetName]
                const jsonDataSudahTraining = XLSX.utils.sheet_to_json(worksheet)
                sudahTraining = jsonDataSudahTraining

                // $("#table-data").bootstrapTable("load", masterjabatan)
                console.log("Data Sheet : ", sheetsData)
                console.log("Data Kategori training : ", trainingKategori)
                console.log("Data Training : ", loadedMasterTraining)
                console.log("Data Jabatan : ", masterjabatan)
                console.log("Data STD JAB_TRAINING : ", jsonDataStdJab)
                console.log("Data Sudah training : ", jsonDataSudahTraining)
            };

            reader.readAsArrayBuffer(file);
        })

        function distinctJabatan(arr) {
            let kategori = []
            const unique = arr.filter(
                (obj, index) =>
                    arr.findIndex((item) => item.JABATAN === obj.JABATAN) === index
            );
            
            unique.forEach((nilai) => {
                // let nilai_kategori = nilai.training_kategori_code ? "" : 
                kategori.push(nilai)
            })

            return kategori
        }

        function filterDuplicateTraining(arr) {
            const unique = arr.filter(
                (obj, index) =>
                    arr.findIndex((item) => item.nama === obj.nama) === index
            );
            return unique
        }

        function distinctKategoriTraining(arr) {
            let kategori = []
            const unique = arr.filter(
                (obj, index) =>
                    arr.findIndex((item) => item.training_kategori_code === obj.training_kategori_code) === index
            );
            
            unique.forEach((nilai) => {
                // let nilai_kategori = nilai.training_kategori_code ? "" : 
                kategori.push(nilai.training_kategori_code || "")
            })

            return kategori
        }

        function importData(event) {
            console.log("importData")
            axios.post("/ic/training/import-master-training",{
                training_kategori: trainingKategori,
                training: loadedMasterTraining,
                jabatan: masterjabatan,
                sudah_training: sudahTraining,
                std_jab: stdJab
            }, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(resp) {
                console.log(resp)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally(function() {

            })
        }
    </script>
@endsection
