@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard Form Request Master</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                    <div class="d-flex align-items-center ms-3">
                        <a href="{{ route('bss-form.log.form') }}">
                            <button class="btn btn-primary ms-auto uploadBtn" id="coba">
                                New Form
                            </button>
                        </a>
                    </div>

                    <!-- START LIST REQUEST MASTER -->
                    <div class="table-responsive p-0">
                        <table id="list-form" data-toggle="table" data-ajax="fetchFormsData">
                            <thead>
                                <tr>
                                    <th data-field="no_dok" data-align="left" data-halign="text-center" data-sortable="true">No. Document</th>
                                    <th data-field="site" data-align="left" data-halign="text-center" data-sortable="true">Site</th>
                                    <th data-field="status_req" data-align="left" data-halign="text-center" data-sortable="true">Status Req</th>
                                    <th data-field="kode_master" data-align="left" data-halign="text-center" data-sortable="true">Kode Master</th>
                                    <th data-field="part_name" data-align="left" data-halign="text-center" data-sortable="true">Part Name</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- END LIST REQUEST MASTER -->
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
            var url = '/bss-form/log/list'
            // console.log(params.data)
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

    </script>
@endsection
