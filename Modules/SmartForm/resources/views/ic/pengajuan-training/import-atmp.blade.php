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

        document.getElementById('uploadExcell').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            showLoading()
            reader.onload = function(e) {
                $("#table-data").bootstrapTable('removeAll')
                const data = new Uint8Array(event.target.result);
                const workbook = XLSX.read(data, { type: 'array', cellDates: true });
                // console.log("Sheets:", workbook.SheetNames);
                // Menyimpan data dari semua sheet
                const sheetsData = {};
                let viewDataATMP = []

                workbook.SheetNames.forEach(sheetName => {
                    const worksheet = workbook.Sheets[sheetName];
                    const jsonData = XLSX.utils.sheet_to_json(worksheet, {header: ["no", "nik", "nama", "jabatan", "department", "site", "jenis_training", "training", "tanggal", "alarm_matrix", 'alarm_absensi']});
                    sheetsData[sheetName] = jsonData;
                });
                // console.log(sheetsData)

                let sheetName = '03. DAFTAR KARYAWAN TRAINING 20'; // Ganti dengan nama sheet yang ingin dipilih
                let worksheet = workbook.Sheets[sheetName];
                
                let jsonData = XLSX.utils.sheet_to_json(worksheet)
                console.log(`jumlah data : ${jsonData.length}`)

                jsonData.forEach(nilai => {
                    if('TANGGAL PELAKSANAAN' in nilai) {
                        // let tglData = 'TANGGAL PELAKSANAAN' in nilai ? new Date(nilai['TANGGAL PELAKSANAAN']) : new Date("01/01/1900")
                        let tglData = new Date(nilai['TANGGAL PELAKSANAAN'])
                        let splitTgl = [tglData.getMonth()+1, tglData.getFullYear()].join("_")
                        // console.log(`${nilai.bulan}_${nilai.tahun}`)
                        if(!(splitTgl in groupByMonthYear)) groupByMonthYear[splitTgl] = []
    
                        groupByMonthYear[splitTgl].push(nilai)
                    }
                })

                // console.log(groupByMonthYear)
                let jmlData = 0

                for(const nilai in groupByMonthYear) {
                    console.log({
                        key: nilai,
                        value: groupByMonthYear[nilai]
                    })
                    let nilaiSPlit = nilai.split('_')
                    let bulan = nilaiSPlit[0]
                    let tahun = nilaiSPlit[1]

                    groupByMonthYear[nilai].forEach((data) => {
                        if(!listNIK.find((nilai) => nilai == data['NIK'])) listNIK.push(data['NIK'].toString())

                        viewDataATMP.push({
                            no: data['NO'],
                            nik: data['NIK'],
                            nama: data['NAMA'],
                            training: data['JENIS TRAINING'],
                            jabatan: data['JABATAN'],
                            department: data['DEPARTMENT'],
                            site: data['SITE'],
                            matrix_kompetensi: data['ALARM BY MATRIX KOMPETENSI'],
                            matrix_sertifikasi: data['ALARM BY REKAP SERTIFIKASI'],
                        })
                    })
                }
                $("#table-data").bootstrapTable('load', viewDataATMP)

                stopLoading()
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
            axios.post( "{{ route('ic.training.submit-atmp') }}",{
                atmp: groupByMonthYear,
                listNIK: listNIK
            }, {
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
