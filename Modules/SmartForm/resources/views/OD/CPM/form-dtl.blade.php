@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.0/dist/extensions/group-by-v2/bootstrap-table-group-by.css">
    <!-- RowGroup Extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker-bs5.min.css">
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
        .select2.select2-container{
            width: 100%;
        }
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
        .select2-selection__clear {
            position: absolute;
            right: 0;
            top: 12px;
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
        .btn-action-format {
            margin: 0;
            padding: 10px 16px;
        }
        .btn-no-action:hover {
            cursor: default;
        }
        .btn-action-font {
            font-size: 1rem;
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
                        <h6 class="text-white text-capitalize ps-3">Form CPM</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row container">
                        <div class="col-6 col-lg-4">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputSite" style="width: 100%;">Site</label>
                                {{-- <select class="js-example-responsive" style="width: 100%" id="inputSite" name="inputSite"></select> --}}
                                <input type="text" class="form-control form-select" id="inputSite"
                                    name="inputSite" placeholder="Cari Site" value="{{ $dataCPM->KodeST }}" disabled>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="input-group input-group-static">
                                <label for="inputPeriode">Tahun</label>
                                {{-- <input type="text" class="form-control" id="inputPeriode" name="inputPeriode" placeholder="Tahun"> --}}
                                <input type="text" class="form-control form-select" id="inputPeriode"
                                    name="inputPeriode" placeholder="Cari Site" value="{{ $dataCPM->TanggalSubmit }}" disabled>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4" style="display: none;">
                            <div class="input-group input-group-static mb-4">
                                <label for="inputObjective" style="width: 100%;">Tambah Objective</label>
                                <select class="js-example-responsive" style="width: 100%" id="inputObjective" name="inputObjective"></select>
                                {{-- <input type="text" class="form-control form-select" id="inputSite"
                                    name="inputSite" placeholder="Cari Site"> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-3">
                            <div class="input-group input-group-static" style="margin: 0 12px;">
                                <label for="revisiKe" style="width: 100%;">Riwayat</label>
                                <select class="form-control form-select" style="width: 100%" id="revisiKe" name="revisiKe">
                                    <option value="" selected>-</option>
                                    @foreach ($riwayatCPM as $item)
                                        <option value="{{$item->revisi_ke}}">Revisi Ke - {{ $item->revisi_ke }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="m-2">
                        <table id="jsonTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">id</th>
                                    <th rowspan="2">category</th>
                                    <th rowspan="2">Objective</th>
                                    <th rowspan="2">UOM</th>
                                    <th rowspan="2">HIG/HIB</th>
                                    <th colspan="2">Januari</th>
                                    <th colspan="2">Februari</th>
                                    <th colspan="2">Maret</th>
                                    <th colspan="2">April</th>
                                    <th colspan="2">Mei</th>
                                    <th colspan="2">Juni</th>
                                    <th colspan="2">Juli</th>
                                    <th colspan="2">Agustus</th>
                                    <th colspan="2">September</th>
                                    <th colspan="2">Oktober</th>
                                    <th colspan="2">November</th>
                                    <th colspan="2">Desember</th>
                                    <th colspan="2">Q1</th>
                                    <th colspan="2">Q2</th>
                                    <th colspan="2">Q3</th>
                                    <th colspan="2">Q4</th>
                                    <th colspan="2">Yearly</th>
                                </tr>
                                <tr>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                    <th>Plan</th>
                                    <th>Actual</th>
                                </tr>
                            </thead>
                        </table>
                        
                    </div>
                </div>

                <div class="card-footer">
                    <div class="px-4 mt-3 row">
                        <table style="text-align: center; vertical-align: middle;">
                            <thead>
                                <tr>
                                    @foreach ($approval['column'] as $key => $value)
                                        <th colspan="{{$value}}">{{ $key }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($approval['data'] as $itemStatus)
                                        <td>{{ $itemStatus->sttsMapping }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach ($approval['data'] as $itemNama)
                                        <td>{{ $itemNama->Nama }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="display: flex; justify-content: end; gap: 12px;margin-top: 16px;">
                        @if ($dataCPM->stts == 0 )
                            @if (isset($approval['current']->nik))
                                @if ($approval['current']->nik== session('user_id'))
                                    <button id="btn-submit" class="btn btn-success" data-title="Konfirmasi approve" onclick="aksiApproval(event, 1)">Approve</button>
                                    <button id="btn-submit" class="btn btn-danger" data-title="Konfirmasi reject" onclick="aksiApproval(event, -1)">Reject</button> 
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('master/js/helper-site.js') }}"></script>
    <script src="{{ asset('master/js/loading.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- RowGroup Extension JS -->
    <script src="https://cdn.datatables.net/rowgroup/1.3.1/js/dataTables.rowGroup.min.js"></script>\
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.0/dist/extensions/group-by-v2/bootstrap-table-group-by.min.js"></script>
    <script>

        var myTable = $('#jsonTable')
        .on('preXhr.dt', function (e, settings, data) {
            showLoading()
        })
        .on('xhr.dt', function (e, settings, json, xhr) {
            stopLoading()
        })
        .DataTable({
            ajax: {
                url: {{ Illuminate\Support\Js::from(route('cpm.form-dtl.data') . '?id=' . $idForm)}},
                type: "GET",
                dataSrc: "data"
            },
            columnDefs: [
                { visible: false, targets: [0, 1] }, {width: "500px", target: 2},
                // {
                //     targets: -1, // Menargetkan kolom terakhir untuk action button
                //     data: null,
                //     render: function(data, type, row, meta) {
                //         return `
                //         <div onclick="preventParent(event)">
                //             <button class="btn btn-sm btn-danger edit-btn" data-id="${meta.row}" onclick="removeObj(event)" style="margin: 0px;">
                //                 <i class="bi bi-trash" style="font-size: 0.725rem"></i>
                //             </button>
                //         </div>`;
                //     }
                // }
            ],
            columns: [
                {data: 'id'},
                {data: 'category'},
                {data: 'objective_name'},
                {data: 'UOM'},
                {data: 'HIG_HIB'},
                {data: 'plan_b_1'},
                {data: 'act_b_1'},
                {data: 'plan_b_2'},
                {data: 'act_b_2'},
                {data: 'plan_b_3'},
                {data: 'act_b_3'},
                {data: 'plan_b_4'},
                {data: 'act_b_4'},
                {data: 'plan_b_5'},
                {data: 'act_b_5'},
                {data: 'plan_b_6'},
                {data: 'act_b_6'},
                {data: 'plan_b_7'},
                {data: 'act_b_7'},
                {data: 'plan_b_8'},
                {data: 'act_b_8'},
                {data: 'plan_b_9'},
                {data: 'act_b_9'},
                {data: 'plan_b_10'},
                {data: 'act_b_10'},
                {data: 'plan_b_11'},
                {data: 'act_b_11'},
                {data: 'plan_b_12'},
                {data: 'act_b_12'},
                {data: 'plan_q1'},
                {data: 'act_q1'},
                {data: 'plan_q2'},
                {data: 'act_q2'},
                {data: 'plan_q3'},
                {data: 'act_q3'},
                {data: 'plan_q4'},
                {data: 'act_q4'},
                {data: 'plan_yearly'},
                {data: 'act_yearly'}
            ],
            // order: [[0, 'asc']], // Urutkan berdasarkan department
            rowGroup: {
                dataSrc: 'category' // Grouping berdasarkan field department
            },
            scrollX: true,
            paging: false
        })

        function aksiApproval(event, nilai) {
            event.target.disabled = true

            let dataApprove = {
                document: {{ Illuminate\Support\Js::from($dataCPM->id) }},
                approvalValue: nilai
            }

            Swal.fire({
                title: event.target.getAttribute('data-title') + " ?",
                showCancelButton: true,
                confirmButtonText: "Save",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                denyButtonText: "Don't save",
                icon: "question",
                input: nilai == -1 ? 'text' : null,
                inputPlaceholder: nilai == -1 ? "Alasan melakukan reject" : null,
                inputValidator: function(value) {
                    value = value.trim()
                    if (nilai == -1 && !value) {
                        return "Alasan tidak boleh kosong";
                    }
                }
            })
            .then(function(data) {
                console.log(data)
                if(nilai == -1) dataApprove.keterangan = data.value.trim()
                if(data.isConfirmed) {
                    
                    showLoading()
                    axios.post({{ Illuminate\Support\Js::from(route('cpm.form-dtl.action')) }}, 
                        dataApprove, 
                        {
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        }
                    )
                    .then(function(resp) {
                        let dataAlert = {
                            icon: "error",
                            title: "Gagal"
                        }

                        if(resp.data.isSuccess) {
                            dataAlert.icon = "success"
                            dataAlert.title = "Berhasil"
                        } 

                        dataAlert.text = resp.data.message

                        Swal.fire(dataAlert)
                            .then(data => {
                                if(resp.data.isSuccess) {
                                    location.reload()
                                }
                            })
                    })
                    .catch(function(err) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: "Terjadi kesalahan, coba beberapa saat lagi"
                        })
                    })
                    .finally(function() {
                        event.target.disabled = false
                        stopLoading()
                    })
                } else {
                    event.target.disabled = false
                }
            })
        }

        $("#revisiKe").on('change', function(e) {
            let urlData = {{ Illuminate\Support\Js::from(route('cpm.form-dtl.data') . '?id=' . $idForm)}}
            if(e.target.value) console.log('benar')
            else console.log('salah')

            myTable.ajax.url(urlData + '&revisiKe=' + e.target.value).load();
        })
    </script>
@endsection