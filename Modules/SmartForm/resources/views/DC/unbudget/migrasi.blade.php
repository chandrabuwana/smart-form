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
        .search-input {
            border-radius: 0;
            border-bottom: 1px solid #7b809a;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }
        .search-input:focus {
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
    <div class="row justify-content-center">
        <div class="">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Import ATMP</h6>
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
                                <input type="file" class="form-control border w-full" name="file_excel" id="uploadExcell"
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
                                    <th data-field="no" data-align="left">No</th>
                                    <th data-field="nik" data-align="left">NIK</th>
                                    <th data-field="nama" data-align="left">Nama</th>
                                    <th data-field="training" data-align="left">Training</th>
                                    <th data-field="jabatan" data-align="left">Jabatan</th>
                                    <th data-field="department" data-align="left">Department</th>
                                    <th data-field="site" data-align="left">Site</th>
                                    <th data-field="matrix_kompetensi" data-align="center">Matrix Kompetensi</th>
                                    <th data-field="matrix_sertifikasi" data-align="center">Matrix Sertifikasi</th>
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
    <script src="{{ asset('master/js/loading.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/shim.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script>
        let loadedMasterTraining = []
        let trainingKategori = []
        let groupByMonthYear = {}
        let listNIK = []
        let dataBody = []

        document.getElementById('uploadExcell').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            showLoading()
            reader.onload = function(e) {
                const dataUpdate = {
                    master: {},
                    detail: []
                }
                $("#table-data").bootstrapTable('removeAll')
                const data = new Uint8Array(event.target.result)
                const workbook = XLSX.read(data, { type: 'array', cellDates: true })
                const sheetsData = {}
                let viewDataATMP = []

                workbook.SheetNames.forEach(sheetName => {
                    const worksheet = workbook.Sheets[sheetName]
                    // console.log(XLSX.utils.sheet_to_json(workbook.Sheets[sheetName]))
                })

                let dataMaster = XLSX.utils.sheet_to_json(workbook.Sheets['master'])
                let dataDetail = XLSX.utils.sheet_to_json(workbook.Sheets['detail'])

                // console.log({master: XLSX.utils.sheet_to_json(workbook.Sheets['master']), detail: XLSX.utils.sheet_to_json(workbook.Sheets['detail'])})
                console.log("mulai")
                dataMaster.forEach((data) => {
                    let dataDtl = dataDetail.filter((dtl) => dtl.TBL_T_BA_UnbudgetId == data.Id)
                    let dtlUpdate = []
                    dataDtl.forEach((nilai) => {
                        dtlUpdate.push({
                            KodeMaterial: nilai.Kode_Material,
                            NamaMaterial: nilai.Nama_Material,
                            Code_COA: nilai.Code_COA,
                            COA: nilai.COA,
                            QTY: nilai.Qty,
                            HargaSatuan: nilai.Harga_Satuan,
                            keterangan: nilai.Keterangan,
                        })
                    })

                    dataBody.push({
                        master: {
                            strategi: data.Strategi,
                            ekonomi: data.Ekonomi,
                            finance: data.Finance,
                            technology: data.Technology,
                            operation: data.Operation,
                            tempat: data.Tempat,
                            KodeST: data.Site,
                            KodeDP: data.Departement,
                            tanggal: data.Tanggal,
                            nik: data.Nik
                        },
                        detail: dtlUpdate,
                        approval: [
                            { nik: data.KepalaBagian ? data.KepalaBagian : '-', approvalOrder: 1, role: 'Kepala Bagian'},
                            { nik: data.IASite ? data.IASite : '-', approvalOrder: 3, role: 'IA Site'},
                            { nik: data.PManager ? data.PManager : '-', approvalOrder: 4, role: 'Project Manager'},
                            { nik: data.KepalaDept ? data.KepalaDept : '-', approvalOrder: 5, role: 'Kepala Department'}
                        ]
                    })
                })
                

                
                // let jsonData = XLSX.utils.sheet_to_json(worksheet)
                // console.log(`jumlah data : ${jsonData.length}`)

                // console.log(groupByMonthYear)
                let jmlData = 0

                // $("#table-data").bootstrapTable('load', viewDataATMP)

                stopLoading()
                console.log(dataBody)
            };

            try {
                reader.readAsArrayBuffer(file);
            } catch(err) {
                stopLoading()
            }
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

        function importData(event) {
            console.log("submit atmp")
            event.target.disabled = true
            showLoading()
            axios.post( {{ Illuminate\Support\Js::from(route('dc.unbudget.migrasi-submit')) }}, {migrasi: dataBody}, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(resp) {
                console.log(resp)
                let alertData = {
                    icon: 'error',
                    title: 'Gagal!',
                    text: resp.data.message
                }
                if(resp.data.isSuccess) {
                    alertData.icon = 'success'
                    alertData.title = 'Berhasil!'
                } else {
                    alertData.icon = 'error'
                    alertData.title = 'Gagal!'
                }
                Swal.fire(alertData)
            })
            .catch(function(err) {
                console.log(err)
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan, coba beberapa saat lagi!'
                })
            })
            .finally(function() {
                event.target.disabled = false
                stopLoading()
            })
        }
    </script>
@endsection
