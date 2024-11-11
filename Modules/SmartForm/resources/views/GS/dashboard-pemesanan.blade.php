@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
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
        .text-light {
            color: #f0f2f5;
        }
        .suggestion {
            position: absolute;
            top: 100%;
            max-height: 100px;
            width: 100%;
            /* background-color: rgba(39, 39, 38, 0.192); */
            overflow-y: auto;
            z-index: 99;
            color: black;
            border: 1px solid rgba(85, 83, 83, 0.534);
            border-radius: 4px 4px 4px 4px;
        }
        .suggestion-child {
            cursor: pointer;
            font-size: 12px;
            padding: 2px 4px;
            border-bottom: 1px solid rgba(85, 83, 83, 0.534);
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Pemesanan Catering</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row px-3 mb-3">
                        <div class="col-md-6">
                            <div class="row">

                                <div class="col-6 col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Mess
                                                    </p>
                                                    <h2 class="fw-bolder" id="totalMess"></h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div
                                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                                        <i class="fas fa-times-circle text-lg opacity-10"
                                                            aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Lapangan / Site</p>
                                                    <h2 class="fw-bolder" id="totalLapangan"></h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div
                                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                        <i class="fas fa-clock text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Adjustment
                                                    </p>
                                                    <h2 class="fw-bolder" id="totalAdjustment"></h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div
                                                        class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                        <i class="fas fa-calendar-alt text-lg opacity-10"
                                                            aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow border">
                                <div class="card-header px-2 py-3">
                                    <h6 class="text-capitalize ps-3">Perbandingan Status</h6>
                                </div>
                                <div class="card-body p-3">
                                    <canvas id="chart-status" class="chart-canvas" height="300px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('add-pemesanan-catering') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>
                    <h4 class="mx-3">Filter Data</h4>
                    <div class="mx-4 row">
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterTanggal">Tanggal</label>
                                <input type="date" class="form-control" name="filterTanggal" id="filterTanggal">
                                </input>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterSite">Site</label>
                                <select class="form-control form-select" name="filterSite" id="filterSite" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="filterNama">Selected</label>
                                <select class="form-control form-select" name="filterSelected" id="filterSelected" required>
                                    <option value="" selected>-- Filter Jenis Pemesanan --</option>
                                    <option value="system">By System</option>
                                    <option value="request">By Request</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterJenis">Waktu</label>
                                <select class="form-control form-select" name="filterJenis" id="filterJenis" required>
                                    <option value="" selected>-- Filter Waktu --</option>
                                    <option value="pagi">Pagi</option>
                                    <option value="siang">Siang</option>
                                    <option value="sore">Sore</option>
                                    <option value="malam">Malam</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnFilterSubmit">
                                Filter
                            </button>
                            <button class="btn btn-primary ms-auto filter-btn" id="btnClearFilter">
                                Clear Filter
                            </button>
                        </div>
                    </div>

                    <div class="mx-4 row">
                        <h4 class="mx-3">Generate Report</h4>
                        <div class="col-md-6 col-lg-4">
                            <div class="input-group" style="border-radius: 0px 10px 10px 0px; border: 2px solid #d4d4d4;" onclick="clickPeriode(event)">
                                <input type="month" class="form-control" id="inputPeriode" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                <button class="btn btn-primary" style="border: 0px; border-left: 1px solid #d4d4d4; margin: 0px;" type="button" onclick="downloadReport(event)"><i class="fa-solid fa-file-export" style="color: rgb(2, 240, 149)"></i> Report</button>
                              </div>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server" data-filter-control="true" data-ajax-options="ajaxOptions"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="kode_pemesanan" data-show-export="true" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="kode_pemesanan" data-align="left" data-halign="text-center"
                                        data-sortable="true">Kode Pemesanan
                                    </th>
                                    <th data-field="tanggal" data-align="center" data-halign="center" data-formatter="tglFormatter">Tanggal</th>
                                    <th data-field="site" data-align="center" data-halign="center" >Site</th>
                                    <th data-field="selected" data-align="center" data-halign="center" >Selected</th>
                                    <th data-field="jenis_pemesanan" data-align="left" data-halign="center">Jenis Pemesanan</th>
                                    <th data-align="left" data-formatter="actionFormatter" data-halign="center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        window.ajaxOptions = {
            beforeSend: function (xhr) {
                console.log("before send")
                // xhr.setRequestHeader('custom-auth-token', 'custom-auth-token')
            }
        }
        var baseUrl = "/bss-form/catering"
        var $table = $("#list-form")
        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
        var btnClearFilter = document.getElementById("btnClearFilter")
        var additonalQuery = {
            tanggal: null,
            site: null,
            selected: null,
            jenis: null
        }
        var filterTanggal = document.getElementById("filterTanggal")
        var filterSite = document.getElementById("filterSite")
        var filterSelected = document.getElementById("filterSelected")
        var filterJenis = document.getElementById("filterJenis")

        const elChartStatus = document.getElementById("chart-status").getContext("2d");
        const chart = new Chart(elChartStatus, {
            type: "pie",
            data: {
                labels: ["Mess", "Lapangan / Site", "Adjustment"],
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

        $('#filterSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterSite').closest('.input-group'),
            placeholder: '--- Cari Site ---'
        });
        
        btnClearFilter.addEventListener("click", function(e) {
            document.getElementById("filterTanggal").value = ""
            document.getElementById("filterSite").value = ""
            document.getElementById("filterSelected").value = ""
            document.getElementById("filterJenis").value = ""

            var searchQuery = {
                tanggal: filterTanggal.value = null,
                site: filterSite.value = null,
                selected: filterSelected.value = null,
                jenis: filterJenis.value = null,
            }

            additonalQuery = searchQuery;
            $table.bootstrapTable('refresh')

        })

        btnFilterSubmit.addEventListener("click", function(e) {
            var searchQuery = {
                tanggal: filterTanggal.value == '' ? null : filterTanggal.value,
                site: filterSite.value == '' ? null : filterSite.value,
                selected: filterSelected.value == '' ? null : filterSelected.value,
                jenis: filterJenis.value == '' ? null : filterJenis.value,
            }
            additonalQuery = searchQuery;
            $table.bootstrapTable('refresh')
        })
        
        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = '/bss-form/catering/list-pemesanan'
            // console.log(params.data)
            showLoading()
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
                chart.clear()
                let totalMess = 0
                let totalLapangan = 0
                let totalAdjustment = 0

                res.data.rows.forEach(element => {
                    console.log(parseInt(element.working))
                    if(element.selected == 'system') {totalMess = totalMess + parseInt(element.mess_by_system)}
                    if(element.selected == 'request') {totalMess = totalMess + parseInt(element.mess_by_request)}

                    totalLapangan = totalLapangan + parseInt(element.working)
                    totalAdjustment = totalAdjustment + parseInt(element.adjustment)
                    
                });
                
                $("#totalMess").text(totalMess)
                $("#totalLapangan").text(totalLapangan)
                $("#totalAdjustment").text(totalAdjustment)
                chart.data.datasets[0].data = [totalMess, totalAdjustment, totalAdjustment]
                chart.update("active")
                stopLoading()
            })
        }

        function actionFormatter(value, row, index) {
            var _id = ", '"+ row.kode_pemesanan + "'"
            // var _id_vendor = ", '"+ row.id_vendor + "'"
            // var _site = ", '"+ row.site + "'"
            // var _jenis_pemesanan = ", '"+ row.jenis_pemesanan + "'"
            // var _lokasi = ", '"+ row.lokasi + "'"
            // var _nama_vendor = ", '"+ row.nama_vendor + "'"

            // var _clickEvent = 'onclick="modalDetail(this'  + _id + _id_vendor + _site + _jenis_pemesanan + _lokasi + _nama_vendor +')"'
            // var _clickEventDelete = 'onclick="actionDelete(this'  + _id +')"'
            var _clickEvent = 'onclick="modalDetail(this' + _id + ')"'
            var _clickEventDelete = 'onclick="actionDelete(this)"'
            var _link_detail = baseUrl + '/detail-pemesanan?id=' + row.kode_pemesanan

            var btnDetail = '<a href="' + _link_detail + '" '+ _clickEvent +' data-action="detail" style="color: black;margin: 0px 4px;"><i class="fa fa-info-circle cursor-pointer"></i></a>';
            var btnHapus = '<a href="" '+ _clickEventDelete +' data-caption="" data-action="delete" style="color: red;margin: 0px 4px;"><i class="fa-solid fa-trash-can cursor-pointer"></i></a>';
            
            return btnDetail
        }

        function modalDetail(e, _id) {
            console.log(_id)
        }

        function fetchSite(cb=function(site) {}) {
            axios.post("/bss-form/catering/helper-site", {
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

        fetchSite(function(data) {
            // console.log(data)
            data.forEach(function(opt) {
                $('#filterSite').append(new Option(opt.text, opt.id))
            })
            // data.forEach(function(opt) {
            //     $('#editSite').append(opt)
            // })
        })

        function tglFormatter(value, row, index) {
            try{
                const tglObj = new Date(value)
                const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']

                return tglObj.getDate() + ' ' + bulan[tglObj.getMonth()] + ' ' + tglObj.getFullYear()
            } catch (err) {
                console.log(err)
                return value
            }
        }

        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }

        function clickPeriode(e) {

        }

        function downloadReport(e) {
            e.preventDefault()
            let periode = $("#inputPeriode").val()
            let site = filterSite.value
            let errorList = [];
            // periode = periode.split('-').reverse().join('-')
            if(periode == null || periode == '') {
                errorList.push('Periode belum dipilih')
            }
            if(site == null || site == '') {
                errorList.push('Site belum dipilih')
            }

            if(errorList.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: errorList.join('<br>')
                })
            } else {
                periode = periode.split('-').reverse().join('-')
                window.location.href = baseUrl + '/dashboard/download-report?periode=' + periode +'&site=' + site;
            }
        }
    </script>
@endsection