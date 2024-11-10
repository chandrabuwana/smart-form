@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <style>
        .center-container {
            display: none;
            align-items: center;
            justify-content: center;
            height: 8em;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #0000001f
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
    <div class="text-center center-container" id="loading-animation">
        <div class="spinner-border" style="width: 10rem; height: 10rem; border-width: 1rem" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Pemesanan Catering</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row mx-2">
                        <div class="col-6 col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputTanggalPemesanan">Tanggal</label>
                                <input type="date" class="form-control" id="inputTanggalPemesanan"
                                    name="inputTanggalPemesanan" placeholder="Management Menu">
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputSite">Site</label>
                                <select class="form-control form-select" name="inputSite" id="inputSite" required>
                                    <!--<option value="">-- Filter Site --</option>
                                    <option value="AGM">AGM</option>
                                    <option value="MBL">MBL</option>
                                    <option value="MME">MME</option>
                                    <option value="MAS">MAS</option>
                                    <option value="PMSS">PMSS</option>
                                    <option value="TAJ">TAJ</option>
                                    <option value="BSSR">BSSR</option>
                                    <option value="TDM">TDM</option>
                                    <option value="MSJ">MSJ</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputJenisPemesanan">Jenis Pemesanan</label>
                                <select class="form-control form-select" name="inputJenisPemesanan" id="inputJenisPemesanan" required>
                                    <option value="pagi" selected>Pagi</option>
                                    <option value="siang">Siang</option>
                                    <option value="sore">Sore</option>
                                    <option value="malam">Malam</option>
                                </select>
                            </div>
                        </div>
                        <a href="#" id="generate-detail-pemesanan" class="w-auto">
                            <button class="btn btn-primary ms-auto">Generate</button>
                        </a>
                    </div>
                    <h3 class="text-black text-capitalize ps-3">Tanggal Pemesanan : <span id="tglPemesanan"></span></h3>
                    <h3 class="text-black text-capitalize ps-3">Jenis Pemesanan : <span id="jenisPemesanan"></span></h3>
                    <h5 class="text-black text-capitalize ps-3">Mess</h5>
                    <h6 class="text-black text-capitalize ps-3">Total data Mess : </h6>
                    <div class="table-responsive p-0 mb-4">
                        <table id="table" data-toggle="table" data-ajax="" data-side-pagination="client"
                            data-query-params="" data-search="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-filter-control="true" data-show-export="true"
                            data-unique-id="nik" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="nik" data-align="center">NIK</th>
                                    <th data-field="nama" data-align="center">Nama</th>
                                    <th data-field="kodesite" data-align="center">Site</th>
                                    <th data-field="lokasi" data-align="left" data-formatter="lokasiFormatter">Lokasi</th>
                                    <th data-field="status" data-align="left" data-formatter='statusFormatter' data-filter-control="select">Status</th>
                                    <th data-field="cuti" data-align="left" data-formatter='cutiFormatter'>Cuti</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <h5 class="text-black text-capitalize ps-3">Data Working</h5>
                    <h6 class="text-black text-capitalize ps-3">Total working : </h6>
                    <div class="table-responsive p-0 mb-4">
                        <table id="table-working" data-toggle="table" data-ajax="" data-side-pagination="client"
                            data-query-params="" data-search="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nik" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="nik" data-align="center">NIK</th>
                                    <th data-field="nama" data-align="center">Nama</th>
                                    <th data-field="tanggal" data-align="left">Tanggal</th>
                                    <th data-field="masuk" data-align="left">Masuk</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <h5 class="text-black text-capitalize ps-3">Data Request Makan</h5>
                    <h6 class="text-black text-capitalize ps-3">Total request makan mess : </h6>
                    <div class="table-responsive p-0 mb-4">
                        <table id="table-request-makan" data-toggle="table" data-ajax="" data-side-pagination="client"
                            data-query-params="" data-search="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="nik" data-align="center">NIK</th>
                                    <th data-field="tanggal" data-align="left">Tanggal</th>
                                    <th data-field="lokasi_name" data-align="left">lokasi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <h5 class="text-black text-capitalize ps-3">Data Adjustment</h5>
                    <h6 class="text-black text-capitalize ps-3">Total Adjustment : </h6>
                    <div class="col-md-4 mx-3">
                        <label for="uploadExcell"><i class="fa-solid fa-file-excel"></i> <a href="/storage/FORMAT_ORDER_PACKMEAL.xlsx">Download Template Excell</a></label>
                        <div class="input-group mb-4">
                            <input type="file" class="form-control" id="uploadExcell" name="uploadExcell">
                            {{-- <button class="btn btn-danger" type="button" style="padding: 8px 12px; border-radius: 4px;"><i class="fa-solid fa-file-excel"></i></button> --}}
                        </div>
                        
                    </div>
                    <div class="table-responsive p-0 mb-4">
                        <table id="table-adjustment-makan" data-toggle="table" data-ajax="" data-side-pagination="client"
                            data-query-params="" data-search="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="nama" data-align="center">Nama</th>
                                    <th data-field="nik" data-align="left">NIK</th>
                                    {{-- <th data-field="lokasi" data-align="left">lokasi</th> --}}
                                    <th data-field="keterangan" data-align="left">keterangan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <div class="card shadow border mx-3 my-2">
                            <div class="card-header px-2 py-3">
                                <h6 class="text-capitalize ps-3">Perbandingan Status</h6>
                            </div>
                            <div class="card-body p-3">
                                <canvas id="chart-status" class="chart-canvas" height="300px"></canvas>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-black text-capitalize ps-3">Summary Pemesanan</h5>
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2">Lokasi</td>
                                <td>By Request</td>
                                <td>By System</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mess</td>
                                <td>:</td>
                                <td class="text-center" id="totalMessSummary"></td>
                                <td class="text-center" id="totalMessSummaryBySystem"></td>
                            </tr>
                            <tr>
                                <td>Working</td>
                                <td>:</td>
                                <td class="text-center" id="totalWorkingSummary"></td>
                                <td class="text-center" id="totalWorkingSummaryBySystem" colspan="2"></td>
                            </tr>
                            <tr>
                                <td>Adjustment</td>
                                <td>:</td>
                                <td class="text-center" style="background-color: #e91e63; color: antiquewhite"  colspan="2" id="totalAdjustment"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total</td>
                                <td class="text-center" id="totalPesanan"></td>
                                <td class="text-center" id="totalPesananBySystem"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Jenis Pemesanan</td>
                                <td colspan="2">
                                    {{-- <div class="input-group input-group-static mb-4"> --}}
                                        <select class="form-control form-select" required id="selectedJenisPemesanan">
                                            <option value="" selected>-- Pilih Jenis Pemesanan --</option>
                                            <option value="request">By Request</option>
                                            <option value="system">By System</option>
                                        </select>
                                    {{-- </div> --}}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <a href="#" id="submit-pemesanan" class="w-auto">
                        <button class="btn btn-primary ms-auto">Submit Pemesanan</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modalPemesanan" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Add Pemesanan</h5>
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
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputTanggal">Tanggal</label>
                                                    <input type="date" class="form-control" id="inputTanggal"
                                                        name="inputTanggal" placeholder="Management Menu">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputSite">Site</label>
                                                    <select class="form-control form-select" name="inputSite" id="inputSite" required>
                                                        <option value="AGM">AGM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="inputJenisPemesanan">Jenis Pemesanan</label>
                                                    <select class="form-control form-select" name="inputJenisPemesanan" id="inputJenisPemesanan" required>
                                                        <option value="pagi" selected>Pagi</option>
                                                        <option value="siang">Siang</option>
                                                        <option value="malam">Malam</option>
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
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitMenu">
                            <i class="fas fa-save"></i>
                            Submit Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/shim.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script>
        var inputTanggalPemesanan = $("#inputTanggalPemesanan");
        var inputJenisPemesanan = $("#inputJenisPemesanan");
        var inputSite = $("#inputSite");
        // var inputJenisPemesanan = document.getElementById("jenisPemesanan")
        var btnGenerateDetailPemesanan = document.getElementById("generate-detail-pemesanan");
        var loadingAnimation = document.getElementById("loading-animation")
        var totalMessSummary = document.getElementById("totalMessSummary")
        var totalWorkingSummary = document.getElementById("totalWorkingSummary")
        var totalMessSummaryBySystem = document.getElementById("totalMessSummaryBySystem")
        var totalWorkingSummaryBySystem = document.getElementById("totalWorkingSummaryBySystem")
        var totalPesanan = document.getElementById("totalPesanan")
        var totalPesananBySystem = document.getElementById("totalPesananBySystem")
        var totalAdjustment = document.getElementById("totalAdjustment")
        var selectedJenisPemesanan = document.getElementById("selectedJenisPemesanan")
        var $table = $('#table')
        var $tableWorking = $('#table-working')
        var $tableRequestMakan = $('#table-request-makan')
        var $tableAdjustmentMakan = $('#table-adjustment-makan')
        var elChartStatus = document.getElementById("chart-status").getContext("2d");
        const mappingPemesanan = {
            'siang': 'DS',
            'malam': 'NS'
        }

        var chart = new Chart(elChartStatus, {
            type: "pie",
            data: {
                labels: ["Mess", "Working", "Adjustment"],
                datasets: [{
                    label: "Projects",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 2,
                    hoverOffset: 4,
                    backgroundColor: ['#49a3f1', '#EF5350', '#FFA726', '#66BB6A'],
                    data: [0, 0, 0 ],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(item) {
                                return item.label + ' : ' + item.parsed + '';
                            }
                        }
                    }
                },
            },
        });

        selectedJenisPemesanan.addEventListener("change", function(e) {
            var jumlahDiMess = 0;
            if(e.target.value == "request") jumlahDiMess = totalMessSummary.innerText
            if(e.target.value == "system") jumlahDiMess = totalMessSummaryBySystem.innerText

            // console.log(jumlahDiMess)
            chart.clear()
            if(e.target.value == "request" || e.target.value == "system") {
                chart.data.datasets[0].data = [jumlahDiMess, totalWorkingSummary.innerText, totalAdjustment.innerText]
                chart.update("active")
            }  
        })

        inputJenisPemesanan.on('change', function(e) {
            // console.log(e.target.value)
        })

        document.getElementById("submit-pemesanan").addEventListener("click", function(e) {
            showLoading()
            var detail = []
            var dataMess = $('#table').bootstrapTable('getData').filter((data) => data.lokasi == "mess").filter((data) => data.cuti == 0); 
            var dataWorking = $('#table-working').bootstrapTable('getData'); 
            var dataRequestMakan = $('#table-request-makan').bootstrapTable('getData'); 
            var dataAdjustmen = $('#table-adjustment-makan').bootstrapTable('getData');
            var summaryByLokasi = {}

            dataMess.forEach(element => {
                detail.push({
                    nama: '',
                    nik: element.nik,
                    lokasi: element.lokasi,
                    keterangan: '',
                    kategori: 'system',
                })

                if(selectedJenisPemesanan.value == "system") {
                    if(element.noDoc in summaryByLokasi) {
                        summaryByLokasi[element.noDoc].jumlah++
                    } else {
                        summaryByLokasi[element.noDoc] = {
                            site: inputSite.val(),
                            jenis: inputJenisPemesanan.val(),
                            tanggalOrder: inputTanggalPemesanan.val(),
                            jumlah: 1
                        }
                    }
                }
            });
            dataWorking.forEach(element => {
                detail.push({
                    nama: '',
                    nik: element.nik,
                    lokasi: 'working',
                    keterangan: '',
                    kategori: 'working',
                })

                if('working' in summaryByLokasi) {
                    summaryByLokasi['working'].jumlah++
                } else {
                    summaryByLokasi['working'] = {
                        site: inputSite.val(),
                        jenis: inputJenisPemesanan.val(),
                        tanggalOrder: inputTanggalPemesanan.val(),
                        jumlah: 1
                    }
                }
            });
            dataRequestMakan.forEach(element => {
                detail.push({
                    nama: element.nama || "",
                    nik: element.nik,
                    lokasi: element.lokasi,
                    keterangan: '',
                    kategori: 'request',
                })

                if(selectedJenisPemesanan.value == "request") {
                    if(element.lokasi in summaryByLokasi) {
                        summaryByLokasi[element.lokasi].jumlah++
                    } else {
                        summaryByLokasi[element.lokasi] = {
                            site: inputSite.val(),
                            jenis: inputJenisPemesanan.val(),
                            tanggalOrder: inputTanggalPemesanan.val(),
                            jumlah: 1
                        }
                    }
                }
            });
            dataAdjustmen.forEach(element => {
                detail.push({
                    nama: element.nama.toString(),
                    nik: element.nik,
                    lokasi: "working",
                    keterangan: element.keterangan,
                    kategori: 'adjustment',
                })
                if('working' in summaryByLokasi) {
                    summaryByLokasi['working'].jumlah++
                } else {
                    summaryByLokasi['working'] = {
                        site: inputSite.val(),
                        jenis: inputJenisPemesanan.val(),
                        tanggalOrder: inputTanggalPemesanan.val(),
                        jumlah: 1
                    }
                }
            });

            // console.log(summaryDetail)
            console.log("summary by lokasi", summaryByLokasi)
            const resultContoh = Object.entries(summaryByLokasi).map(([lokasi, detail]) => ({
                lokasi,
                ...detail
            }));
            console.log("summary by lokasi mapping : ", resultContoh)
            var reqBody = {
                jenisPemesanan: inputJenisPemesanan.val(),
                tanggal: inputTanggalPemesanan.val(),
                messBySystem: dataMess.length,
                messByRequest: dataRequestMakan.length,
                working: dataWorking.length,
                adjustment: dataAdjustmen.length,
                listAdjustment: $('#table-adjustment-makan').bootstrapTable('getData'),
                selected: selectedJenisPemesanan.value,
                site: inputSite.val(),
                // detail: detail,
                summaryOrder: resultContoh
            };
            // console.log({mess: dataMess, working: dataWorking, requestMakan: dataRequestMakan, adjustmen: dataAdjustmen, jenisPemesanan: inputJenisPemesanan.val()});
            axios.post("/bss-form/catering/order", reqBody, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function(response) {
                var dataAlert = {
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan, coba beberapa saat lagi'
                }

                if(!response.data.isError) {
                    dataAlert = {
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.data.message
                    }
                } else {
                    dataAlert = {
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.data.message
                    }
                }

                Swal.fire(dataAlert).then((result) => {
                    if(!response.data.isError) window.location.reload();
                })
                // console.log(response.data)
            })
            .catch(function(err) {
                console.log(err)
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan, coba beberapa saat lagi'
                }).then((result) => {
                })
            })
            .finally(function() {
                stopLoading()
            })
        })

        $('#inputSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputSite').closest('.input-group'),
            placeholder: '--- Cari Site ---',
            ajax: {
                url: "/helper/site",
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
                cache: true
            }
        });

        function statusFormatter(value) {
            var nilai = null;
            if(value==0) nilai="Belum pesan"
            if(value==1) nilai="Done"

            return nilai
        }

        function cutiFormatter(value) {
            var nilai = null;
            if(value==0) nilai="Masuk/Off"
            if(value==1) nilai="Cuti"

            return nilai
        }
        
        function lokasiFormatter(value, row, index) {
            // console.log({value: value, row: row.NamaMess})
            var lokasiHuniMess = value
            if(value == 'mess')  lokasiHuniMess = row.NamaMess 

            return lokasiHuniMess
        }

        $tableWorking.on('post-body.bs.table', function(data) {
            
        })

        $tableRequestMakan.on('post-body.bs.table', function(data) {

        })

        function getTodayDate(tgl = new Date()) {
            const year = tgl.getFullYear();
            const month = String(tgl.getMonth() + 1).padStart(2, '0');
            const day = String(tgl.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        inputTanggalPemesanan.val(getTodayDate());

        $("#tambah-pemesanan").click(function(e) {
            $('#modalPemesanan').modal("show");
        })

        btnGenerateDetailPemesanan.addEventListener("click", function(e) {
            e.preventDefault()
            let validateTglPesan = isNaN(new Date(inputTanggalPemesanan.val()))
            let validateInputSite = inputSite.val() == null

            if( validateTglPesan || validateInputSite) {
                let listErr = []
                if(validateTglPesan) listErr.push('Tanggal pemesanan belum dipilih')
                if(validateInputSite) listErr.push('Site belum dipilih')

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: listErr.join('<br>')
                })

                return
            }

            showLoading()
            // console.log("halo")
            axios.post('/bss-form/catering/generate-detail', 
                {
                    tanggalPemesanan: inputTanggalPemesanan.val(),
                    site: inputSite.val(),
                    jenisPemesanan: inputJenisPemesanan.val()
                }, 
                {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                }
            )
            .then(function (response) {
                totalMessSummary.innerText = 0
                totalWorkingSummary.innerText = 0
                totalPesanan.innerText = 0
                totalWorkingSummaryBySystem.innerText = 0
                totalMessSummaryBySystem.innerText =0
                totalPesananBySystem.innerText = 0
                var data_tabel = []
                var data_working = []
                var data_request_makan_mess = []
                var data = {
                    icon: 'error',
                    title: '',
                    text: ''
                }
                var workingNIK = []
                var cutiNIK = []
                document.getElementById('uploadExcell').value = null
                $tableAdjustmentMakan.bootstrapTable('removeAll')
                document.getElementById("totalAdjustment").innerText = 0
                // if(response.data.isSuccess) {
                //     data.icon = 'success'
                //     data.title = "Berhasil!"
                //     data.text = response.data.message
                //     $("#tglPemesanan").text(getTodayDate().split('-').reverse().join('-'))
                // } else {
                //     data.icon = 'error'
                //     data.title = "Gagal!"
                //     data.text = response.data.message
                // }
                for (var dataMess in response.data.dataMess) {
                    // console.log(response.data.dataMess[dataMess].cuti)
                    data_tabel.push({
                        nik: response.data.dataMess[dataMess].Nik,
                        nama: response.data.dataMess[dataMess].nama,
                        kodesite: response.data.dataMess[dataMess].KodeSite,
                        lokasi: response.data.dataMess[dataMess].lokasi,
                        status: response.data.dataMess[dataMess].status,
                        cuti: response.data.dataMess[dataMess].cuti,
                        noDoc: response.data.dataMess[dataMess].NoDoc,
                        NamaMess: response.data.dataMess[dataMess].NamaMess,
                    })
                    if(response.data.dataMess[dataMess].cuti == 1) cutiNIK.push(response.data.dataMess[dataMess].Nik)
                }
                for (var working in response.data.dataWorking) {
                    // console.log(response.data.dataWorking[working])
                    workingNIK.push(response.data.dataWorking[working].NIK)
                    data_working.push({
                        nik: response.data.dataWorking[working].NIK,
                        nama: response.data.dataWorking[working].Nama,
                        tanggal: response.data.dataWorking[working].Tanggal,
                        masuk: response.data.dataWorking[working].Masuk
                    })
                }
                for (var pesanMakan in response.data.dataPesanMakanMess) {
                    // console.log(response.data.dataPesanMakanMess[working])
                    data_request_makan_mess.push({
                        nik: response.data.dataPesanMakanMess[pesanMakan].NIK,
                        tanggal: response.data.dataPesanMakanMess[pesanMakan].TanggalOrder,
                        lokasi: response.data.dataPesanMakanMess[pesanMakan].lokasi,
                        lokasi_name: response.data.dataPesanMakanMess[pesanMakan].lokasi_name
                    })
                }
                // data mess dikurangi cuti
                var filteredCutiNik = response.data.dataMess.filter(function(item) {
                    return !cutiNIK.includes(item.Nik)
                })
                // hasil data mess dikurangi cuti, dikurangi yang bekerja
                var filteredWorkingNik = filteredCutiNik.filter(function(item) {
                    return !workingNIK.includes(item.Nik)
                })

                console.log({dataMess: dataMess, workingNIK: workingNIK, cutiNIK: cutiNIK, filteredCutiNik: filteredCutiNik, filteredWorkingNik: filteredWorkingNik})

                $table.bootstrapTable('load', {total: data_tabel.length, totalNotFiltered: data_tabel.length, rows: data_tabel})
                $tableWorking.bootstrapTable('load', {total: data_working.length, totalNotFiltered: data_working.length, rows: data_working})
                $tableRequestMakan.bootstrapTable('load', {total: data_request_makan_mess.length, totalNotFiltered: data_request_makan_mess.length, rows: data_request_makan_mess})
                
                totalMessSummary.innerText = data_request_makan_mess.length
                totalWorkingSummary.innerText = data_working.length
                totalPesanan.innerText = data_request_makan_mess.length + data_working.length
                totalWorkingSummaryBySystem.innerText = data_working.length
                totalMessSummaryBySystem.innerText = filteredWorkingNik.length
                // totalPesananBySystem.innerText = filteredWorkingNik.length + data_working.length + $tableAdjustmentMakan.bootstrapTable("getData").length
                totalPesananBySystem.innerText = filteredWorkingNik.length + data_working.length 
                
                // document.getElementById("totalAdjustment").innerText = $tableAdjustmentMakan.bootstrapTable("getData").length

                if(response.data.isError) {
                    data.icon='error';
                    data.text=response.data.message
                    data.title='Gagal!'
                } else {
                    data.icon='success';
                    data.text=response.data.message
                    data.title='Berhasil!'
                    $("#tglPemesanan").text(getTodayDate(new Date(inputTanggalPemesanan.val())).split('-').reverse().join('-'))
                    $("#jenisPemesanan").text(inputJenisPemesanan.val())
                }

                Swal.fire(data).then((result) => {

                })
            })
            .catch(function (error) {
                console.log(error)
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan, coba beberapa saat lagi'
                }).then((result) => {
                    // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                })
            })
            .finally(function() {
                stopLoading()
            });
        })

        document.getElementById('uploadExcell').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                
                if(($("#jenisPemesanan").text() != 'siang' || $("#jenisPemesanan").text() != 'malam') && inputSite.val() == null && isNaN(new Date($("#tglPemesanan").text()))) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Adjustment hanya bisa siang / malam'
                    })

                    console.log('error')
                    document.getElementById('uploadExcell').value = null

                    return
                }

                
                var colIndexStart = 4 
                // console.log({selectedTgl: selectedTgl, colIndexStart: colIndexStart})
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, {type: 'array'});
                var loadedData = [];

                // Ambil sheet pertama
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];

                // Konversi sheet ke JSON
                var excelRows = XLSX.utils.sheet_to_json(firstSheet, {header: 1});
                var selectedTgl = new Date($("#tglPemesanan").text().split("-").reverse().join("/"))
                var selectedData = {selectedTgl: selectedTgl.getDate(), colIndexStart: colIndexStart}
                // {nik: row[1], nama: row[2], shift: row[selectedData.selectedTgl + selectedData.colIndexStart]}

                // Ambil referensi tabel
                // var table = document.getElementById('excelDataTable').getElementsByTagName('tbody')[0];

                // Hapus baris lama (jika ada)
                // table.innerHTML = '';

                // Loop untuk menambah baris baru dari data Excel
                var jumlahData = 0
                var duplicatePenghuniMess = []
                var cty = 0
                excelRows.forEach(function(row, index) {
                    if(index > 3 && ( row[1] || row[2])) { // Skip header row
                        // console.log({shiftExcell: row[selectedData.selectedTgl + selectedData.colIndexStart]})
                        // let extractedData = {nik: row[1], nama: row[2], shift: row[selectedData.selectedTgl + selectedData.colIndexStart]}
                        let nikExcell = row[1] !== undefined ? row[1] : ""
                        let namaExcell = row[2] !== undefined ? row[2] : ""
                        let keteranganNik = row[3] !== undefined ? row[3] : ""
                        
                        var dataDuplicate = $table.bootstrapTable('getRowByUniqueId', nikExcell)
                        // console.log({dataDuplicate: dataDuplicate})
                        let shiftExcell = new String(row[selectedData.selectedTgl + selectedData.colIndexStart]).toString()
                        if (dataDuplicate) {
                            if(dataDuplicate.cuti == 0 && dataDuplicate.lokasi == "mess" && (shiftExcell.toUpperCase() == mappingPemesanan[$("#jenisPemesanan").text()])) {
                                dataDuplicate.lokasi = 'working'
                                $table.bootstrapTable('updateCellByUniqueId', {
                                    id: nikExcell,
                                    field: 'lokasi',
                                    value: 'working',
                                    reinit: true
                                })
                                cty++
                                console.log({cty: cty})
                            }
                        } 
                        
                        if($tableWorking.bootstrapTable('getRowByUniqueId', nikExcell) == null) {
                            // var selectedData = {selectedTgl: new Date($("#tglPemesanan").text()).getDate(), colIndexStart: 4}
                            let shiftExcell = new String(row[selectedData.selectedTgl + selectedData.colIndexStart]).toString()
                            // console.log({mappingPemesanan: mappingPemesanan[$("#jenisPemesanan").text()], shiftExcell: shiftExcell, idx: selectedData.selectedTgl + selectedData.colIndexStart})
                            // console.log({shiftExcell: shiftExcell})
                            if (!shiftExcell) {}
                            else if (shiftExcell.toUpperCase() == mappingPemesanan[$("#jenisPemesanan").text()]) {
                                loadedData.push({
                                    nik: nikExcell,
                                    nama: namaExcell,
                                    keterangan: keteranganNik
                                })
                                jumlahData++
                            }
                        }
                        // var newRow = table.insertRow();
                        // row.forEach(function(cell) {
                        //     // var newCell = newRow.insertCell();
                        //     // newCell.textContent = cell;
                        //     console.log(cell)
                        // });
                    }
                });
                // duplicatePenghuniMess.forEach(value => {
                //     value.lokasi = "working"
                // });
                // console.log(filterMessByAdjustment)
                var filteredWorkingAndCutiNik = $table.bootstrapTable('getData').filter(function(item) {
                    return item.lokasi == 'mess' && item.cuti == 0
                })
                totalMessSummaryBySystem.innerText = filteredWorkingAndCutiNik.length
                console.log({filtered: filteredWorkingAndCutiNik, totalMessSummaryBySystem : totalMessSummaryBySystem.innerText, jumlahData: jumlahData, totalAdjustment: loadedData.length})
                $tableAdjustmentMakan.bootstrapTable('load', loadedData)
                document.getElementById("totalAdjustment").innerText = new String(jumlahData)
                console.log({totalPesananBySystem: totalPesananBySystem.innerText})
                totalPesananBySystem.innerText = filteredWorkingAndCutiNik.length + jumlahData + $tableWorking.bootstrapTable('getData').length
                totalPesanan.innerText = jumlahData + $tableRequestMakan.bootstrapTable('getData').length + $tableWorking.bootstrapTable('getData').length
                // excelRows.forEach(function(row, index) {
                //     if (index > 3) {
                //         var selectedData = {selectedTgl: selectedTgl.getDate(), colIndexStart: colIndexStart}
                //         if(row[1] || row[2]) {
                //             if(row[selectedData.selectedTgl + selectedData.colIndexStart] == 'NS') {
                //                 console.log({nik: row[1], nama: row[2], shift: row[selectedData.selectedTgl + selectedData.colIndexStart]})
                //             }
                //         }
                //     }
                // })
            };

            reader.readAsArrayBuffer(file);
        })

        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }
    </script>
@endsection
