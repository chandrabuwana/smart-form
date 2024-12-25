@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker-bs5.min.css">
    <style>
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
                        <h6 class="text-white text-capitalize ps-3">Pengajuan Training</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    {{-- <h4 class="mx-3">Filter Data</h4> --}}
                    <fieldset class="mx-3 p-3 mb-4">
                        <legend>Filter Data</legend>
                        <div class="row">
                            <div class="col-md-4 px-2 mb-2">
                                <div class="input-group input-group-static">
                                    {{--a <label for="filterPelatihan" style="width: 100%;"><strong>Pelatihan</strong></label> --}}
                                    <select class="form-control form-select" name="filterPelatihan" id="filterPelatihan">
                                        <option value="">-- Pelatihan --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 px-2 mb-2">
                                <div class="input-group input-group-static">
                                    {{-- <label for="filterDept" style="width: 100%;"><strong>Department</strong></label> --}}
                                    <select class="form-control form-select" name="filterNIK" id="filterNIK">
                                        <option value="">-- Karyawan --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 px-2" mb-2>
                                <div class="input-group input-group-static">
                                    {{-- <label for="filterSite" style="width: 100%;"><strong>Site</strong></label> --}}
                                    <select class="form-control form-select" name="filterSite" id="filterSite">
                                        <option value="">-- Site --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 px-2 mb-2">
                                <div class="input-group input-group-static">
                                    {{-- <label for="filterDept" style="width: 100%;"><strong>Department</strong></label> --}}
                                    <select class="form-control form-select" name="filterDept" id="filterDept">
                                        <option value="">-- Department --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 px-2 mb-2">
                                <div class="input-group input-group-static">
                                    {{-- <label for="inputPeriode"><strong>Periode</strong></label> --}}
                                    <input type="text" class="form-control" id="inputPeriode"
                                        name="inputPeriode" placeholder="Waktu Pelatihan">
                                </div>
                            </div>
                            <div class="px-2 filter-section">
                                <button class="btn btn-primary m-0" onclick="applyFilter(event)">
                                    Apply
                                </button>
                                <button class="btn btn-primary m-0" onclick="resetFilter(event)">
                                    Clear
                                </button>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="table-responsive p-0">
                        <table id="table-data" data-toggle="table" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true" data-ajax="getData"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="NIK" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    {{-- <th data-field="pengajuan_training_id" data-align="left">ID Pengajuan</th> --}}
                                    <th data-field="nama_pelatihan" data-align="left">Pelatihan</th>
                                    {{-- <th data-field="id_training" data-align="l`eft" data-halign="center">ID Pelatihan</th> --}}
                                    {{-- <th data-field="KodeDP" data-align="left">Departement</th> --}}
                                    <th data-field="dept" data-align="left">Departement</th>
                                    <th data-field="KodeST" data-align="left">Site</th>
                                    <th data-field="bulan" data-align="left" data-sortable="true">Bulan</th>
                                    <th data-field="tahun" data-align="left" data-sortable="true">Tahun</th>
                                    <th data-field="status" data-align="center" data-formatter="statusFormatter">Status</th>
                                    <th data-field="action" data-formatter="actionFormatter" data-align="center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{-- <div class="card-footer">
                    <div style="display: flex; justify-content: end;">
                        <button class="btn btn-primary mb-0" onclick="submitPengajuan(event)">Submit Pelatihan</button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        (function () {
            Datepicker.locales.en = {
            days: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            daysShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            daysMin: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
            months: ["Januari", "Februari", "Maret", "Apri", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
            today: "Hari",
            monthsTitle: "Bulan",
            clear: "Clear",
            weekStart: 0,
            format: "dd/mm/yyyy"
        }
        })()
        const elem = document.getElementById("inputPeriode")
        
        const datepicker = new Datepicker(elem, {
            format: "MM yyyy",
            pickLevel: 1
        })

        // elem.addEventListener('changeMonth', function (event) {
        //     const selectedDate = event.detail.date; // Mendapatkan tanggal yang dipilih
        //     const month = selectedDate.getMonth() + 1 || ; // Mendapatkan bulan (1-12)
        //     const year = selectedDate.getFullYear();  // Mendapatkan tahun

        //     console.log(`${month}-${year}`)

        // });
        const getDataURL = {{ Illuminate\Support\Js::from(route('ic.training.data-crosscheck')) }}
        
        const filterData = {
            pelatihan: null,
            site: null,
            department: null,
            waktu: null,
            nik: null
        }

        $('#filterPelatihan').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterPelatihan').closest('.input-group'),
            placeholder: '--- Cari Pelatihan ---',
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('ic.training.helper.select-master')) }},
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
                cache: true,
            },
            // templateResult: function (data) {
            //     console.log(data)
            //     if (!data.id) {
            //         return data.text; // Tampilan default jika tidak ada data
            //     }

            //     var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
            //     return $result;
            // }
        })
        $('#filterNIK').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterNIK').closest('.input-group'),
            placeholder: '--- Cari MP ---',
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('ic.training.helper.mp')) }},
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
                cache: true,
            },
            templateResult: function (data) {
                console.log(data)
                if (!data.id) {
                    return data.text; // Tampilan default jika tidak ada data
                }

                var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                return $result;
            }
        })

        $('#filterSite').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterSite').closest('.input-group'),
            placeholder: '--- Cari SITE ---'
        })

        $('#filterDept').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterDept').closest('.input-group'),
            placeholder: '--- Cari Department ---'
        })

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

        function fetchDept(cb=function(site) {}) {
            axios.get({{ Illuminate\Support\Js::from(route('ic.training.helper.cari-dept')) }}, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(data) {
                var opstionDept = []
                opstionDept.push({
                    id: "",
                    text: "--- Cari Site ---"
                })

                data.data.data.forEach(element => {
                    opstionDept.push({
                        id: element.id,
                        text: element.text
                    })

                    // opstionDept.push(new Option(element.text, element.id))
                });
                
                cb(opstionDept)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally( function(){

            });
        }

        function getData(params) {
            console.log(params.data)
            if(filterData.pelatihan) params.data.pelatihan = filterData.pelatihan
            if(filterData.site) params.data.site = filterData.site
            if(filterData.department) params.data.department = filterData.department
            if(filterData.waktu) params.data.waktu = filterData.waktu
            if(filterData.nik) params.data.nik = filterData.nik

            $.get(getDataURL + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            let btnCrossCheck = `<a href="/ic/training/cross-check-dtl/${row.trj_id}"> <button class="btn btn-primary btn-action-format"><i class="bi bi-info-circle-fill"></i></button></a>`
            let btnJustifikasi= row.status != 0 ? `<a href="/ic/training/justifikasi/${row.trj_id}"> <button class="btn btn-action-format" style="background: #1A2365;"><i class="bi bi-arrow-right-circle text-white"></i></button> </a>` : ''
            return '<div style="display: flex; gap:6px; justify-content: center;">'+ btnCrossCheck + btnJustifikasi + '</div>'
        }

        function statusFormatter(value, row, index) {
            if(value == 1) return '<button class="btn btn-success btn-no-action btn-action-format">Validasi Komitmen</button>'
            if(value == 2) return '<button class="btn btn-success btn-no-action btn-action-format">Close</button>'
            // if(value == 3) return '<button class="btn btn-success btn-no-action btn-action-format">Done Justifikasi</button>'
            if(value == -2) return '<button class="btn btn-success btn-no-action btn-action-format">Rejected Justifikasi</button>'
            if(value == 0) return '<button class="btn btn-warning btn-no-action btn-action-format">Cross check Kabag</button>'
            
            return value
        }

        fetchSite(function(data) {
            data.forEach(function(opt) {
                $('#filterSite').append(new Option(opt.text, opt.id))
            })
        })

        fetchDept(function(data) {
            data.forEach(function(opt) {
                $('#filterDept').append(new Option(opt.text, opt.id))
            })
        })

        function applyFilter(e) {
            console.log({
                pelatihan: $('#filterPelatihan').val(),
                site: $('#filterSite').val(),
                department: $('#filterDept').val(),
                waktu: datepicker.getDate('mm-yyyy')
            })

            filterData.pelatihan = $('#filterPelatihan').val()
            filterData.site = $('#filterSite').val()
            filterData.department = $('#filterDept').val()
            filterData.nik = $('#filterNIK').val()
            filterData.waktu = datepicker.getDate('mm-yyyy')

            $("#table-data").bootstrapTable('refresh', {pageNumber: 1})
        }

        function resetFilter(e) {
            $('#filterPelatihan').val(null).trigger('change')
            $('#filterSite').val(null).trigger('change')
            $('#filterDept').val(null).trigger('change')
            $('#filterNIK').val(null).trigger('change')
            datepicker.setDate({clear: true})
            
            filterData.pelatihan = null
            filterData.site = null
            filterData.department = null
            filterData.waktu = null
            filterData.nik = null
            
            $("#table-data").bootstrapTable('refresh', {pageNumber: 1})
        }
    </script>
@endsection