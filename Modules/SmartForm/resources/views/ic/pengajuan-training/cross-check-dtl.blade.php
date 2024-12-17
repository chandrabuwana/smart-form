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
            padding: 8px 12px;
        }

    </style>
@endsection

@section('content')
{{-- {{ array_search(session('nik'), array_column($crossCheckPIC->toArray(), 'NIK')); }} --}}
{{-- <input type="text" name="foo"> --}}
    {{-- {{ dd($stdJab) }} --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4 pb-5">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ $pelatihan->pelatihan }} - {{ $pelatihan->id_training }} - {{ $pelatihan->pengajuan_id }} - {{ $pelatihan->bulan }}/{{ $pelatihan->tahun }}</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">

                    <h6 class="text-capitalize ps-3">STD Jab Training</h6>
                    <div class="table-responsive p-0">
                        <table id="table-std-jab" data-toggle="table" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="NIK" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="pelatihan" data-align="left" data-visible="false">pelatihan</th>
                                    {{-- <th data-field="id_training" data-align="left">id_training</th> --}}
                                    <th data-field="KodeJB" data-align="left">KodeJB</th>
                                    <th data-field="jabatan" data-align="left">Jabatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stdJab as $item)
                                    <tr>
                                        <td>{{ $item->pelatihan }}</td>
                                        <td>{{ $item->KodeJB }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    
                    <h6 class="text-capitalize ps-3" style="display: none;">Sudah Training</h6>
                    <div class="table-responsive p-0" style="display: none;">
                        <table id="table-sudah-training" data-toggle="table" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="NIK" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="NIK" data-align="left">NIK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sudahTraining as $item)
                                    <tr>
                                        <td>{{ $item->NIK }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    
                    <div class="mx-4 mb-3 row" style="{{  $crossCheckPIC->contains('NIK', session('user_id')) && $pelatihan->trj_status == 0 ? '' : 'display: none;' }}">
                        <div class="col-md-6" style="display: flex; gap: 8px;">
                            <div class="input-group input-group-static">
                                <label for="cariKaryawan" style="width: 100%"><strong>Tambah Data MP</strong></label>
                                <select class="form-control form-select" name="cariKaryawan" id="cariKaryawan" style="width: 100%">
                                    <option value="">-- Cari NIK / Nama MP --</option>
                                </select>
                            </div>
                            <button class="btn btn-danger mb-0" style="align-self: flex-end; padding: 10px 16px;" onclick="resetNIK(event)">X</button>
                        </div>
                    </div>

                    <div class="table-responsive p-0">
                        <table id="table-data" data-toggle="table" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true" data-ajax="getData"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="NIK" data-header-style="headerStyle" data-row-style="rowStyle">
                            <thead>
                                <tr>
                                    <th data-field="NIK" data-align="left">NIK</th>
                                    <th data-field="NIK_nama" data-align="left">Nama</th>
                                    <th data-field="KodeST" data-align="left">Site</th>
                                    {{-- <th data-field="KodeDP" data-align="left">Department</th> --}}
                                    <th data-field="departement" data-align="left">Department</th>
                                    {{-- <th data-field="KodeJB" data-align="left">KodeJB</th> --}}
                                    <th data-field="tmk" data-align="left" data-formatter="tmkFormatter">TMK</th>
                                    <th data-field="jabatan" data-align="left">Jabatan</th>
                                    <th data-field="matrix_kompetensi" data-align="left" data-formatter="kompetensiFormatter" data-cell-style="kompetensiStyle">Kompetensi</th>
                                    <th data-field="matrix_sertifikasi" data-align="left" data-formatter="sertifikasiFormatter" data-cell-style="sertifikasiStyle">Rekap Sertifikasi</th>
                                    <th data-field="matrix_mk" data-align="left" data-formatter="mkFormatter" data-cell-style="mkStyle">Masa Kerja</th>
                                    <th data-field="status_id" data-align="left" data-formatter="statusFormatter">Status</th>
                                    @if ($crossCheckPIC->contains('NIK', session('user_id')) && $pelatihan->trj_status == 0)
                                        <th data-field="action" data-formatter="actionFormatter" data-align="center">Actions</th>   
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{-- TODO : tampilkan approval yang sudah di sumbit --}}
                <div class="card-footer">
                    @if($pelatihan->trj_status == 0)
                    <div class="table-responsive p-0">
                        <table id="table-syarat" data-toggle="table" data-side-pagination="client"
                            data-content-type="application/json" data-data-type="json" data-pagination="false"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="approval_role" data-align="left"></th>
                                    <th data-field="jabatan" data-align="left">Jabatan</th>
                                    <th data-field="pic" data-align="left">PIC</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dibuat oleh</td>
                                    <td>Kabag / Kasi Dept</td>
                                    <td>
                                        <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                            {{-- TODO : enable ini ketika mau deploy --}}
                                            {{-- <select class="form-control form-select form-approval" name="persetujuan" id="persetujuan"> --}}
                                            <select class="form-control form-select form-approval" name="level1" id="level1">
                                                <option value="">-- Pilih PIC --</option>
                                                @foreach ($listApproval['1'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->NIK }} - {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Disetujui oleh</td>
                                    <td>Kabag / Kasi ICGS</td>
                                    <td>
                                        <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                            {{-- TODO : enable ini ketika mau deploy --}}
                                            {{-- <select class="form-control form-select form-approval" name="disetujui1" id="disetujui1"> --}}
                                            <select class="form-control form-select form-approval" name="level2" id="level2">
                                                <option value="">-- Pilih PIC --</option>
                                                @foreach ($listApproval['2'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->NIK }} - {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diketahui oleh</td>
                                    <td>PM / People Partner</td>
                                    <td>
                                        <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                            {{-- TODO : enable ini ketika mau deploy --}}
                                            {{-- <select class="form-control form-select form-approval" name="diketahui1" id="diketahui1"> --}}
                                            <select class="form-control form-select form-approval" name="level3" id="level3">
                                                <option value="">-- Pilih PIC --</option>
                                                @foreach ($listApproval['3'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->NIK }} - {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diketahui oleh</td>
                                    <td>Kadept HO</td>
                                    <td>
                                        <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                            {{-- TODO : enable ini ketika mau deploy --}}
                                            {{-- <select class="form-control form-select form-approval" name="diketahui2" id="diketahui2"> --}}
                                            <select class="form-control form-select form-approval" name="level4" id="level4">
                                                <option value="">-- Pilih PIC --</option>
                                                @foreach ($listApproval['4'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->NIK }} - {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><sup class="text-danger">*</sup>Diketahui oleh</td>
                                    <td>Think Tank</td>
                                    <td>
                                        <div class="input-group input-group-static" style="display: inline; width: fit-content;">
                                            {{-- TODO : enable ini ketika mau deploy --}}
                                            {{-- <select class="form-control form-select form-approval" name="diketahui2" id="diketahui2"> --}}
                                            <select class="form-control form-select form-approval" name="level5" id="level5">
                                                <option value="">-- Pilih PIC --</option>
                                                @foreach ($listApproval['5'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->NIK }} - {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <div style="display: flex; justify-content: end;">
                        @if ($crossCheckPIC->contains('NIK', session('user_id')) && $pelatihan->trj_status == 0)
                            <button class="btn btn-primary mb-0" onclick="submitCrossCheck(event)">Submit</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        var getDataURL = "/ic/training/data-cross-check-dtl"
        const baseUrl = '/ic/training'
        const trjId = {{ Illuminate\Support\Js::from($trjID) }}
        const KodeDP_trj = {{ Illuminate\Support\Js::from($pelatihan->KodeDP_trj) }}
        const KodeST_trj = {{ Illuminate\Support\Js::from($pelatihan->KodeST_trj) }}
        const pengajuanId = {{ Illuminate\Support\Js::from($pelatihan->pengajuan_id) }}
        const pengajuanBulan = {{ Illuminate\Support\Js::from($pelatihan->bulan) }}
        const pengajuanTahun = {{ Illuminate\Support\Js::from($pelatihan->tahun) }}
        
        function getData(params) {
            params.data.trj_id = '{{ $trjID }}'
            $.get(getDataURL + '?' + $.param(params.data)).then(function(res) {
                // console.log(res.rows)
                res.rows.forEach(element => {
                    // let stdJab = $("#table-std-jab").bootstrapTable('getData')
                    // element.matrix_kompetensi = stdJab.length > 0 ? (stdJab.filter((nilai) => nilai.KodeJB == element.KodeJB).length > 0 ? 1 : 0) : 1
                    element.matrix_kompetensi = $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == element.KodeJB).length > 0 ? 1 : 0
                    element.matrix_sertifikasi = $("#table-sudah-training").bootstrapTable('getData').filter((nilai) => nilai.NIK == element.NIK).length > 0 ? 0 : 1
                    element.matrix_mk = calculateMasaKerja(element.tmk, new Date(`${pengajuanTahun}/${pengajuanBulan}/1`))
                });
                params.success(res)
            })
        }

        function calculateMasaKerja(tmk, tglPelatihan) {
            const firstDate = new Date(tmk)

            const firstDateInMs = firstDate.getTime()
            const secondDateInMs = tglPelatihan.getTime()

            const differenceBtwDates = secondDateInMs - firstDateInMs

            const aDayInMs = 24 * 60 * 60 * 1000

            const daysDiff = Math.round(differenceBtwDates / aDayInMs)

            // console.log({daysDiff: daysDiff})
            let masaKerja = daysDiff/365

            return masaKerja.toFixed(2)
        }

        function actionFormatter(value, row, index) {
            // let btnApprove = `<button class="btn btn-secondary btn-action-format"><i class="bi bi-info-circle-fill"></i></button>`
            // let btnReject = `<button class="btn btn-secondary btn-action-format"><i class="bi bi-info-circle-fill"></i></button>`
            // let btnGanti = `<button class="btn btn-secondary btn-action-format"><i class="bi bi-info-circle-fill"></i></button>`
            let btnReject = `<button type="button" class="btn btn-danger btn-action-format" onclick="aksiReject(${row.NIK}, event, ${row.id})"><i class="bi bi-x-circle-fill"></i></button>`
            let btnApprove = row.status_id == 0 || row.status_id == 1 ? `<button type="button" class="btn btn-success btn-action-format" onclick="aksiApprove(${row.NIK}, event)"><i class="bi bi-check-circle-fill"></i></button>` : ""
            let btnGanti = row.status_id == 0 || row.status_id == 1 ? `<button type="button" class="btn btn-primary btn-action-format"><i class="bi bi-pencil-square"></i></button>` : ""

            let action = '<div style="display: flex; gap:6px; justify-content: center;">' + btnApprove + btnGanti + btnReject + '</div>'
            
            return action
        }

        function aksiReject(NIK, event, id) {
            // console.log(id)
            event.target.disabled = true
            let data = $("#table-data").bootstrapTable('getRowByUniqueId', NIK)
            if(id==0) {
                $("#table-data").bootstrapTable('removeByUniqueId', NIK)
            } else {
                $("#table-data").bootstrapTable('updateByUniqueId', {
                    id: NIK,
                    row: {
                       status_id: data.status_id == -1 ? 0 : -1 
                    }
                })
            }
            event.target.disabled = false
        }

        function aksiApprove(NIK, event) {
            event.target.disabled = true
            let data = $("#table-data").bootstrapTable('getRowByUniqueId', NIK)
            
            $("#table-data").bootstrapTable('updateByUniqueId', {
                id: NIK,
                row: {
                   status_id: data.status_id == 1 ? 0 : 1
                }
            })

            event.target.disabled = false
        }

        function kompetensiFormatter(value, row, index) {
            // return $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == row.KodeJB).length > 0 ? "1" : "0"
            if(value == 1) return 'OK'
            if(value == 0) return 'Tidak Sesuai'

            return value
        }

        function kompetensiStyle(value, row, index) {
            // return $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == row.KodeJB).length > 0 ? "1" : "0"
            if(value == 0) {
                return {
                    css: {
                        background: '#fd5c70',
                        color: 'white'
                    }
                }
            }

            return value
        }

        function sertifikasiStyle(value, row, index) {
            // return $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == row.KodeJB).length > 0 ? "1" : "0"
            if(value == 0) {
                return {
                    css: {
                        background: '#fd5c70',
                        color: 'white'
                    }
                }
            }

            return value
        }

        function mkStyle(value, row, index) {
            // return $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == row.KodeJB).length > 0 ? "1" : "0"
            if(value < 1) {
                return {
                    css: {
                        background: '#fd5c70',
                        color: 'white'
                    }
                }
            }

            return value
        }

        function sertifikasiFormatter(value, row, index) {
            // return $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == row.KodeJB).length > 0 ? "1" : "0"
            if(value == 0) return 'Sudah pernah'
            if(value == 1) return 'OK'

            return value
        }

        function statusFormatter(value, row, index) {
            // return $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == row.KodeJB).length > 0 ? "1" : "0"
            if(value == 0) return 'Perlu approval'
            if(value == 2) return 'Ditambahkan'
            if(value == -1) return 'Dihapus'
            if(value == 1) return 'Disetujui'

            return value
        }

        function tmkFormatter(value, row, index) {
            let formatTgl = ""
            let bulan = {
                1: 'Jan', 2: 'Feb', 3: 'Mar', 4: 'Apr', 5: 'Mei', 6: 'Jun',
                7: 'Jul', 8: 'Agu', 9: 'Sep', 10: 'Okt', 11: 'Nov', 12: 'Des'
            }

            try {
                let tgl = new Date(value)
                formatTgl = `${tgl.getDate()} ${bulan[tgl.getMonth()+1]} ${tgl.getFullYear()}`
            } catch(err) {
                console.log("error fomatting tmk ", err)
            }

            return formatTgl
        }

        function mkFormatter(value, row, index) {
            if(value >= 1) {
                return 'MK Clear'
            }
            if(value < 1) {
                return 'MK < 1Th'
            }

            return value
        }
        
        function mkiStyle(value, row, index) {
            // return $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == row.KodeJB).length > 0 ? "1" : "0"
            if(value < 1) {
                return {
                    css: {
                        background: '#fd5c70',
                        color: 'white'
                    }
                }
            }

            return value
        }

        function rowStyle(row, index) {
            // console.log(row.status_id)
            // if(row.status_id == -1 || row.matrix_kompetensi == 0 || row.matrix_sertifikasi == 0) {
            //     return {
            //         css: {
            //             background: '#fd5c70',
            //             color: 'white'
            //         }
            //     }
            // }

            // if(row.status_id == 3 || row.status_id == 2) {
            //     return {
            //         css: {
            //             background: '#3d9741',
            //             color: 'white'
            //         }
            //     }

            // }

            return {}
        }

        $('#cariKaryawan').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#cariKaryawan').closest('.input-group'),
            placeholder: '-- Cari NIK / Nama MP --',
            ajax: {
                url: baseUrl + '/helper/cari-mp',
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
                        KodeDP: KodeDP_trj,
                        KodeST: KodeST_trj
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
                    // console.log(data)
                    if (!data.id) {
                        return data.text; // Tampilan default jika tidak ada data
                    }

                    var $result = $('<span>' + data.id + ' - ' + data.text + '</span>');
                    return $result;
                }
        })

        $('#cariKaryawan').on("select2:select", function(e){
            console.log("cariKaryawan : ", e.params.data)
            $('#cariKaryawan').val(null).trigger('change')
            let data = {
                id: 0,
                KodeDP: "",
                departement: "",
                KodeST: "",
                NIK: "",
                NIK_nama: "",
                status_id: 2,
                KodeJB: "",
                jabatan: "",
                matrix_kompetensi: "",
                matrix_sertifikasi: "",
                matrix_mk: "",
                tmk: ""
            }
            data.KodeDP = e.params.data.KodeDP
            data.departement = e.params.data.department
            data.KodeST = e.params.data.site
            data.NIK = e.params.data.NIK
            data.NIK_nama = e.params.data.nama
            data.KodeJB = e.params.data.KodeJB
            data.jabatan = e.params.data.jabatan
            data.tmk = e.params.data.tmk
            // let stdJab = $("#table-std-jab").bootstrapTable('getData')
            // data.matrix_kompetensi = stdJab.length > 0 ? (stdJab.filter((nilai) => nilai.KodeJB == data.KodeJB).length > 0 ? 1 : 0) : 1
            data.matrix_kompetensi = $("#table-std-jab").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == data.KodeJB).length > 0 ? 1 : 0
            data.matrix_sertifikasi = $("#table-sudah-training").bootstrapTable('getData').filter((nilai) => nilai.NIK == data.NIK).length > 0 ? 0 : 1
            data.matrix_mk = calculateMasaKerja(e.params.data.tmk, new Date(`${pengajuanTahun}/${pengajuanBulan}/1`))

            $("#table-data").bootstrapTable('append', data)
        })

        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }

        function submitCrossCheck(e) {
            let baseURL = {{ Illuminate\Support\Js::from(route('ic.training.crosscheck-approve')) }}
            let dataBody = {
                trjId: trjId,
                pengajuanId: pengajuanId,
                detail: $("#table-data").bootstrapTable('getData'),
                approval: {
                    '1': $("#level1").val(),
                    '2': $("#level2").val(),
                    '3': $("#level3").val(),
                    '4': $("#level4").val(),
                }
            }
            let belumValidasi = []
            $('#table-data').bootstrapTable('getData').filter((data)=> {
                if(data.status_id == 0) belumValidasi.push(data.NIK)
                return data.status_id == 0
            })
            if(l=belumValidasi.length > 0) dataBody['5'] = $("#level5").val()
        
            console.log(dataBody)
            // return
            let validasiForm = validasi()

            if(validasiForm.length > 0) {
                Swal.fire({
                    backdrop: false,
                    icon: "error",
                    title: "Oops...",
                    html: validasiForm.join('<br>'),
                })
            } else {
                showLoading()
                axios.post(baseURL, dataBody, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(function(resp) {
                    console.log(resp)
                    let dataSwal = {}
                    if(resp.data.isSuccess) {
                        dataSwal = {
                            backdrop: false,
                            icon: "success",
                            title: "Berhasil",
                            text: 'Berhasil approve pengajuan'
                        }
                    } else {
                        dataSwal = {
                            icon: "error",
                            title: "Gagal",
                            text: resp.data.message
                        }
                    }

                    Swal.fire(dataSwal)
                        .then((result) => {
                            if (result.isConfirmed && resp.data.isSuccess) {
                                location.reload()
                            }
                        })
                })
                .catch(function(err) {
                    console.log(err)
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: 'Terjadi kesalahan, coba beberapa saat lagi'
                    })
                })
                .finally(function() {
                    stopLoading()
                })
            }
        }

        function validasi() {
            let errList = [];
            let isCreateBAjustifikasi = $("#table-data").bootstrapTable("getData").filter((data) => {
                return data.matrix_mk < 1
            })
            let belumValidasi = []

            if(!$("#level1").val()) errList.push("Belum pilih approval kabag / kasi dept")
            if(!$("#level2").val()) errList.push("Belum pilih approval kabag / kasi IC")
            if(!$("#level3").val()) errList.push("Belum pilih approval PM / People partner")
            if(!$("#level4").val()) errList.push("Belum pilih approval Kadep HO")
            if(isCreateBAjustifikasi.length > 0) {
                if(!$("#level1").val()) errList.push("Terdapat matrix masa kerja < 1 th, silahkan pilih approval Think tank")
            }

            $('#table-data').bootstrapTable('getData').filter((data)=> {
                if(data.status_id == 0) belumValidasi.push(data.NIK)
                return data.status_id == 0
            })
            if(belumValidasi.length > 0) errList.push(`NIK Belum di validasi : ${belumValidasi.join(', ')}`)

            return errList
            
        }
    </script>
@endsection