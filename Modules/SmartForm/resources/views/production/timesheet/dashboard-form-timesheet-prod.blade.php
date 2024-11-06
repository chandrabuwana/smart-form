@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <style>
        /* .form-control {
            border: 1px solid;
            padding: 4px;
        }
        .form-control:focus {
            border: 1px solid;
        } */
        .filter-btn {
            display: inline;
            width: auto
        }
        .position-relative {
            position: relative;
        }
        .position-absolute {
            position: absolute;
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
        .text-light {
            color: #f0f2f5;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Timesheet</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('form-timesheet-produksi') }}">
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
                                <select class="form-control form-select" name="filterSite" id="filterSite">
                                    <option value="">-- Filter Site --</option>
                                    <option value="AGM">AGM</option>
                                    <option value="MBL">MBL</option>
                                    <option value="MME">MME</option>
                                    <option value="MAS">MAS</option>
                                    <option value="PMSS">PMSS</option>
                                    <option value="TAJ">TAJ</option>
                                    <option value="BSSR">BSSR</option>
                                    <option value="TDM">TDM</option>
                                    <option value="MSJ">MSJ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4 position-relative">
                                <label for="filterNama">NIK</label>
                                <input type="text" class="form-control" name="filterNama" id="filterNama" placeholder="Cari Nama / NIK">
                                </input>
                                <div class="suggestion" id="suggest-nik" style="display: none">
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-static mb-4">
                                <label for="filterStatus">Status</label>
                                <select class="form-control form-select" name="filterStatus" id="filterStatus" required>
                                    <option value="" selected>-- Filter Status --</option>
                                    <option value="1">Need Approval</option>
                                    <option value="2">Approved</option>
                                    <option value="0">Rejected</option>
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
                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData"
                            data-side-pagination="server" data-filter-control="true"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-show-export="true" data-show-toggle="true">
                            <thead>
                                <tr>
                                    <th data-field="id" data-align="left" data-halign="text-center"
                                        data-sortable="true">No. Document
                                    </th>
                                    {{-- <th data-field="driver" data-align="center" data-halign="center" >Driver</th> --}}
                                    <th data-field="nik" data-align="center" data-halign="center" >NIK</th>
                                    <th data-field="site" data-align="center" data-halign="center" >Site</th>
                                    <th data-field="tanggal" data-align="left" data-halign="center">Tanggal</th>
                                    <th data-field="shift" data-align="left" data-halign="center">Shift</th>
                                    <th data-field="no_unit" data-align="center">No unit
                                    </th>
                                    <th data-field="hm_awal" data-align="center">HM Awal
                                    </th>
                                    <th data-field="hm_akhir" data-align="center">HM AKhir
                                    </th>
                                    <th data-field="total_rit" data-align="center"
                                        data-halign="center" data-sortable="true">Total RIT
                                    </th>
                                    <th data-field="status" data-align="center"
                                        data-halign="center" data-sortable="true" data-formatter="statusFormatter">Status
                                    </th>
                                    <th data-field="action" data-formatter="actionFormatter" >Actions</th>
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
    <script type="text/javascript">
        var $table = $("#list-form");
        var filterNama = document.getElementById("filterNama")
        var suggestNik = document.getElementById("suggest-nik")
        var btnFilterSubmit = document.getElementById("btnFilterSubmit")
        var btnClearFilter = document.getElementById("btnClearFilter")
        var filterTanggal = document.getElementById("filterTanggal")
        var filterSite = document.getElementById("filterSite")
        var filterNama = document.getElementById("filterNama")
        var filterStatus = document.getElementById("filterStatus")
        var additonalQuery = {
            tanggal: null,
            site: null,
            nama: null,
            status: null
        }

        btnClearFilter.addEventListener("click", function(e) {

        })
        btnFilterSubmit.addEventListener("click", function(e) {
            var searchQuery = {
                tanggal: filterTanggal.value == '' ? null : filterTanggal.value,
                site: filterSite.value == '' ? null : filterSite.value,
                nama: filterNama.value == '' ? null : filterNama.value,
                status: filterStatus.value == '' ? null : filterStatus.value,
            }
            additonalQuery = searchQuery;
            $table.bootstrapTable('refresh')
            // var queryParams = new URLSearchParams(searchQuery).toString();
            // axios.get('/get-forms-timesheet?'+ queryParams, {
            //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            //     })
            //     .then(function(response) {
            //         console.log(response)
            //     })
            //     .catch(function(err) {
            //         console.log(err)
            //     })
        })
        suggestNik.addEventListener("click", function(e) {
            e.target.style.display="none";
        })
        function searchKaryawan(nama) {
            axios.get('/bss-form/timesheet/search-karyawan?search='+nama, {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                })
                .then(function(response) {
                    // console.log(response.data)
                    suggestNik.style.display="inline"
                    var elementSuggestedKaryawan = [];
                    if(!response.data.isError) {
                        if(response.data.data.length < 1) {
                            elementSuggestedKaryawan.push('<div class="suggestion-child" onclick="clickResultCariKaryawan(this)">Not Found<i class="fa-solid fa-xmark"></i></div>')
                        } else {
                            for (const key in response.data.data) {
                                if (Object.hasOwnProperty.call(response.data.data, key)) {
                                    const element = response.data.data[key];
                                    // console.log(element)
                                    elementSuggestedKaryawan.push('<div onclick="clickResultCariKaryawan(this)" data-nama="'+ element.Nama +'" data-nik="' + element.NIK +'" class="suggestion-child">'+element.NIK +' '+ element.Nama +'</div>')
                                }
                            }
                        }
                        
                        suggestNik.innerHTML = elementSuggestedKaryawan.join("")
                    }
                })
                .catch(function(err) {
                    console.log(err)
                })

        }
        
        function debounce (func, wait){
            let timeout;
            
            return function executedFunction(...args) {
                var later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };

                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        };

        function clickResultCariKaryawan(event) {
            var nikKaryawan = event.getAttribute("data-nik");
            var namaKaryawan = event.getAttribute("data-nama");
            if(nikKaryawan != null && namaKaryawan != null) filterNama.value = nikKaryawan;
            
            suggestNik.style.display = "none";

            // console.log(nikKaryawan)
        }

        function cariKaryawan(event) {
            var value = event.target.value
            // console.log(value);
            searchKaryawan(value)
        }
        const debounceHandler = debounce(cariKaryawan, 1000);
        
        filterNama.addEventListener("focusin", function(e) {
            filterNama.addEventListener("input", debounceHandler, true)
        })
        filterNama.addEventListener("focusout", function(e) {
            filterNama.removeEventListener("input", debounceHandler, true)
            // suggestNik.style.display = "none";
        })
        
        function suggestionClick(e) {
            var nik = e.getAttribute("data-nik");
            console.log(nik)
        }

        function actionFormatter(value, row, index) {
            return '<a href="/bss-form/timesheet/detail?id=' + row.id + '"><button class="btn btn-primary btn-action text-white">detail</button></a>';
        }

        function statusFormatter(value, row, index) {
            var formatData = '<button class="btn btn-info text-white">status</button>'
            // console.log(value)
            if(value == null || value == 1) {
                formatData = '<button class="btn btn-warning text-white">Need Aprroval</button>'
            }
            if(value == 2) {
                formatData = '<button class="btn btn-success text-white">Approved</button>'
            }
            if(value == 0) {
                formatData = '<button class="btn btn-danger text-white">Rejected</button>'
            }

            return formatData;
        }
        

        function fetchFormsData(params) {
            params.data = {...params.data, ...additonalQuery}
            var url = '/bss-form/timesheet/form'
            // console.log(params.data)
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

    </script>
@endsection
