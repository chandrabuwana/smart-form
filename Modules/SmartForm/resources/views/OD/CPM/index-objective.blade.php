@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
        .select2-selection__clear {
            position: absolute;
            right: 0;
            top: 12px;
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
        /* .page-item .page-link {
            color: #FFFFFF;
        } */
        .active > .page-link {
            color: #cccccc;
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
                        <h6 class="text-white text-capitalize ps-3">Objective CPM</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <button style="border-radius: 0 0.5rem 0.5rem 0" class="btn btn-primary ms-auto" id="tambah-objective"><i class="bi bi-plus-circle-fill"></i> Objective</button>
                        </a>
                    </div>
                    {{-- <h4 class="mx-3">Filter Data</h4> --}}
                    <fieldset class="mx-3 p-3 mb-4">
                        <legend>Filter Data</legend>
                        <div class="row">
                            <div class="col-md-4 px-2 mb-2">
                                <div class="input-group input-group-static">
                                    <select class="form-control form-select" name="filterObjective" id="filterObjective">
                                        <option value="">-- Cari Objective --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 px-2" mb-2>
                                <div class="input-group input-group-static">
                                    {{-- <label for="filterSite" style="width: 100%;"><strong>Site</strong></label> --}}
                                    <select class="form-control form-select" name="filterCategory" id="filterCategory">
                                        <option value="">-- Cari Category --</option>
                                    </select>
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
                            data-page-list="[10, 25, 50, 100, all]" data-ajax="getData"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="NIK" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="nama" data-align="left">Nama</th>
                                    <th data-field="category" data-align="center">Category</th>
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

@section('modal')
    <div class="modal fade" id="modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel"></h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="card border mx-3 mt-3" style="">
                    <div class="card-body">
                        <hr class="horizontal dark my-sm-1">
                        <div class="row">
                            <div class="col-6 col-lg-4 px-1">
                                <div class="input-group input-group-static mb-4">
                                    <label for="inputNamaObjective">Nama Objective</label>
                                    <input type="text" class="form-control" id="inputNamaObjective"
                                        name="inputNamaObjective" placeholder="Nama Objective">
                                </div>
                            </div>
                            <div class="col-6 col-lg-4 px-1">
                                <div class="input-group input-group-static mb-4">
                                    <label for="inputCategoryObj" style="width: 100%;">Category</label>
                                    <select class="js-example-responsive" style="width: 100%" id="inputCategoryObj" name="inputSite"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            

                <hr class="horizontal dark my-sm-3">

                <div class="row" style="margin:10px">
                    <div class="col text-end" id="masukkanButtonSubmit">
                        <button onclick="submitObjective(event)" data-action="add" data-url="" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitMenu">
                            <i class="fas fa-save"></i>
                            Submit Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('master/js/loading.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const getDataURL = {{ Illuminate\Support\Js::from(route('cpm.objective-list')) }}
        
        const filterData = {
            site: null,
            periode: null
        }

        $('#filterObjective').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterObjective').closest('.input-group'),
            placeholder: '--- Cari Objective ---',
            allowClear: true,
            closeOnSelect: true,
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

        $('#filterCategory').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterCategory').closest('.input-group'),
            placeholder: '--- Cari Category ---',
            allowClear: true,
            closeOnSelect: true,
            tags: true,
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('cpm.helper-objective.category')) }},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                closeOnSelect: true,
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
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }

                return {
                    id: 0,
                    text: term,
                    newTag: true
                };
            }
        })

        $('#inputCategoryObj').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#inputCategoryObj').closest('.input-group'),
            placeholder: '--- Cari Category ---',
            allowClear: true,
            closeOnSelect: true,
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('cpm.helper-objective.category')) }},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                closeOnSelect: true,
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
            }
        })

        $('#filterCategory').on('select2:select', function(e) {
            var data = e.params.data;
            if (data.newTag) {
                if (data.newTag) {
                    $.ajax({
                        url: {{ Illuminate\Support\Js::from(route('cpm.objective.category-add')) }}, 
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { text: data.text },
                        beforeSend: function(xhr, settings) {
                            showLoading()
                        },
                        complete: function(xhr, status) {
                            stopLoading()
                        },
                        success: function(response) {
                            // Hapus opsi sementara
                            $('#filterCategory option[value="' + data.id + '"]').remove().trigger('change')
                            $('#filterCategory').val(null).trigger('change')
                            
                            // Tambahkan opsi baru dengan ID dari server
                            var newOption = new Option(response.text, response.id, true, true)
                            $('#filterCategory').append(newOption).trigger('change')
                            
                            console.log("Data berhasil ditambahkan:", response)
                        }
                    });
                }
                // Lakukan sesuatu jika data baru ditambahkan, misalnya kirim ke backend
                console.log("Data baru ditambahkan:", data.text);
            }
        })

        function applyFilter(e) {
            filterData.site = $('#filterSite').val()
            filterData.periode = datepicker.getDate('yyyy')

            console.log(filterData)
            $("#table-data").bootstrapTable('refresh', {pageNumber: 1})
        }

        function resetFilter(e) {
            datepicker.setDate({clear: true})
            $('#filterSite').val(null).change()
            filterData.site = null
            filterData.periode = null

            $("#table-data").bootstrapTable('refresh', {pageNumber: 1})
        }

        function getData(params) {
            // console.log(params.data)
            if(filterData.site) params.data.site = filterData.site
            if(filterData.periode) params.data.periode = filterData.periode

            $.get(getDataURL + '?' + $.param(params.data)).then(function(res) {
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            let btnCrossCheck = `<a href="/bss-form/od/cpm/form/${row.id}"> <button class="btn btn-secondary btn-action-format"><i class="bi bi-info-circle-fill"></i></button></a>`
            let btnEdit = `<a href="/bss-form/od/cpm/form-edit/${row.id}"> <button class="btn btn-info btn-action-format"><i class="bi bi-pencil"></i></button></a>`
            
            return '<div style="display: flex; gap:6px; justify-content: center;">' + btnEdit + '</div>'
        }

        $('#tambah-objective').on('click', function(e) {
            $('#modal').modal('show')
        })

        function validatSubmitObj() {
            $("#inputNamaObjective").val($("#inputNamaObjective").val().trim())
            
            let hasil = {
                isSuccess: false,
                errors: [],
                data: {
                    nama: $("#inputNamaObjective").val(),
                    categoryId: $("#inputCategoryObj").val()
                }
            }

            if(!$("#inputNamaObjective").val()) hasil.errors.push('Nama Objective kosong')
            if(!$("#inputCategoryObj").val()) hasil.errors.push('Category kosong')

            if(hasil.errors.length < 1) hasil.isSuccess = true

            return hasil
        }

        function submitObjective(e) {
            e.target.disabled = true
            let validasiData = validatSubmitObj()
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
                    if(result.isConfirmed) {
                        showLoading()
                        axios.post(
                            {{ Illuminate\Support\Js::from(route('cpm.objective-submit')) }},
                            validasiData.data, 
                            {
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            }
                        ).then(function(resp) { 
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
                            
                        }).catch(function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan, coba beberapa saat lagi'
                            })
                        }).finally(function() {
                            stopLoading()
                            e.target.disabled = false
                        })
                    }
                }).catch(function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan, coba beberapa saat lagi'
                    })
                })
                .finally(function() {
                    e.target.disabled = false
                })
            }
        }

    </script>
@endsection