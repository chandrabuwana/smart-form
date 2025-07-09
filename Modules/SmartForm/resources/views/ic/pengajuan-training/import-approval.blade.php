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
                                    <th data-field="nik" data-align="left">NIK</th>
                                    <th data-field="nama" data-align="left" data-sortable="true">Nama</th>
                                    <th data-field="site" data-align="left">Site</th>
                                    <th data-field="dept" data-align="center">Departemen</th>
                                    <th data-field="levelValidasi" data-align="center">Level Validasi</th>
                                    <th data-field="rowNum" data-align="center" data-visible="false"></th>
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
        let listApproval = []

        document.getElementById('uploadExcell').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            showLoading()
            reader.onload = function(e) {
                listApproval = []
                $("#table-data").bootstrapTable('removeAll')
                const data = new Uint8Array(event.target.result);
                const workbook = XLSX.read(data, { type: 'array', cellDates: true });
                // console.log("Sheets:", workbook.SheetNames);
                // Menyimpan data dari semua sheet
                const sheetsData = {};

                workbook.SheetNames.forEach(sheetName => {
                    const worksheet = workbook.Sheets[sheetName];
                    const jsonData = XLSX.utils.sheet_to_json(worksheet);
                    sheetsData[sheetName] = jsonData;
                });
                let workingSheet = workbook.Sheets['VALIDASI REV'];
                let jsonData = XLSX.utils.sheet_to_json(workingSheet)
                // console.log(jsonData)
                jsonData.forEach((data) => {
                    listApproval.push({
                        nik: data['Nik'],
                        nama: data['Nama'],
                        site: data['Site'],
                        dept: data['DEPT VALIDASI'],
                        levelValidasi: data['LEVEL VALIDASI_1'],
                        rowNum: data['__rowNum__']
                    })
                    // console.log({
                    //     nik: data['Nik'],
                    //     nama: data['Nama'],
                    //     site: data['Site'],
                    //     dept: data['DEPT VALIDASI'],
                    //     rowNum: data['__rowNum__']
                    // })
                })
                
                $("#table-data").bootstrapTable('load', listApproval)
                // let sheetName = '03. DAFTAR KARYAWAN TRAINING 20'; // Ganti dengan nama sheet yang ingin dipilih
                // let worksheet = workbook.Sheets[sheetName];
                stopLoading()
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

        function importData(event) {
            // console.log(listApproval)
            // return
            event.target.disabled = true
            showLoading()
            axios.post( {{ Illuminate\Support\Js::from(route('ic.training.import-approval-submit')) }},{
                approval: listApproval
            }, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(resp) {
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

        $('#table-data').bootstrapTable({
            search: true,
            onPostBody: function () {
                // Seleksi input pencarian yang dihasilkan Bootstrap Table
                let searchInput = $('.search-input');

                // Ubah type="search" menjadi type="text"
                searchInput.attr('type', 'text');

                // Tambahkan autocomplete="off"
                searchInput.attr('autocomplete', 'off');

                // Tambahkan readonly yang akan dihapus saat focus untuk mencegah autofill
                searchInput.attr('readonly', true).on('focus', function () {
                    $(this).removeAttr('readonly');
                });
            }
        })
    </script>
@endsection
