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
                    <div class="mx-4 row mb-3">
                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="filterPelatihan" style="width: 100%;"><strong>Pelatihan</strong></label>
                                <select class="form-control form-select" name="filterPelatihan" id="filterPelatihan">
                                    <option value="">-- Cari Pelatihan --</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="">
                            <button class="btn btn-primary" id="btnPilih">
                                Pilih
                            </button>
                        </div> --}}
                    </div>
                    <div class="mx-4 mb-4">
                        <fieldset>
                            <legend>Detail Pelatihan</legend>
                            <table>
                                <tr>
                                    <td style="vertical-align: top;">Pelatihan</td>
                                    <td>: <span id="textPelatihan"></span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Mandatory</td>
                                    <td>: <span id="textMandatory"></span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Kategori</td>
                                    <td>: <span id="textKategori"></span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Offline / Online</td>
                                    <td>: <span id="textOffOnline"></span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Syarat</td>
                                    <td>: <span id="textSyarat"></span></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">STD Jabatan</td>
                                    <td>: <span id="textJabatan"></span></td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div class="mx-4 mb-3 row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static">
                                <label for="inputPeriode"><strong>Periode</strong></label>
                                <input type="text" class="form-control" id="inputPeriode"
                                    name="inputPeriode" placeholder="Bulan Tahun">
                            </div>
                        </div>
                    </div>

                    <div class="mx-4 mb-3 row">
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
                    
                    <div class="table-responsive p-0" style="display: none;">
                        <table id="table-syarat" data-toggle="table" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="syarat_nama" data-align="left">nama</th>
                                    <th data-field="syarat_operasi" data-align="left">operasi</th>
                                    <th data-field="syarat_nilai" data-align="left">nilai</th>
                                    <th data-field="syarat_uom" data-align="left">uom</th>
                            </thead>
                        </table>
                    </div>
                    <div class="table-responsive p-0" style="display: none;">
                        <table id="table-std-jabatan" data-toggle="table" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="KodeJB" data-align="left">KodeJB</th>
                                    <th data-field="jabatan" data-align="left">jabatan</th>
                            </thead>
                        </table>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="table-data" data-toggle="table" data-side-pagination="client"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="NIK" data-header-style="headerStyle">
                            <thead>
                                <tr>
                                    <th data-field="NIK" data-align="left">NIK</th>
                                    <th data-field="nama" data-align="left">Nama</th>
                                    <th data-field="jabatan" data-align="left" data-halign="center">Jabatan</th>
                                    <th data-field="department" data-align="left">Departmen</th>
                                    <th data-field="site" data-align="left">Site</th>
                                    <th data-field="tmk" data-align="left">TMK</th>
                                    <th data-field="training_matrix" data-align="left" data-formatter="trainingFormatter">Training</th>
                                    <th data-field="kalibrasi_matrix" data-align="left" data-formatter="matrixFormatter">Matrix</th>
                                    <th data-field="masa_kerja" data-align="left" data-formatter="masaKerjaFormatter">Masa kerja</th>
                                    <th data-field="action" data-formatter="actionFormatter" data-align="center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <div style="display: flex; justify-content: end;">
                        <button class="btn btn-primary mb-0" onclick="submitPengajuan(event)">Submit Pelatihan</button>
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
        })();
        const elem = document.getElementById("inputPeriode");
        
        const datepicker = new Datepicker(elem, {
            format: "MM yyyy",
            pickLevel: 1
        }); 
        const baseUrl = '/ic/training';
        const mTrainingHelper = baseUrl + "/helper/select-mtraining";
        
        elem.addEventListener('changeDate', function (event) {
            const selectedDate = event.detail.date; // Mendapatkan tanggal yang dipilih
            const month = selectedDate.getMonth() + 1; // Mendapatkan bulan (1-12)
            const year = selectedDate.getFullYear();  // Mendapatkan tahun

            console.log(`Bulan yang dipilih: ${month}`);
            console.log(`Tahun yang dipilih: ${year}`);

            let _tempData = Object.assign([], $("#table-data").bootstrapTable("getData"))
            $("#table-data").bootstrapTable("removeAll")
            $("#table-data").bootstrapTable("load", _tempData)

        });

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

        $('#filterPelatihan').select2({
            minimumInputLength: 3,
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#filterPelatihan').closest('.input-group'),
            placeholder: '--- Cari Pelatihan ---',
            ajax: {
                url: mTrainingHelper,
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

        $('#cariKaryawan').on("select2:select", function(e){
            console.log("cariKaryawan : ", e.params.data)
            $('#cariKaryawan').val(null).trigger('change')
            let isValid = validateInputPelatihan()
            
            e.params.data.kalibrasi_matrix = $("#table-std-jabatan").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == e.params.data.KodeJB).length > 0 ? "1" : "0"

            if($("#table-data").bootstrapTable('getRowByUniqueId', e.params.data.NIK)) isValid.push('MP sudah ditambahkan!')

            if(isValid.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: isValid.join("<br>")
                })
            }
            else {
                checkPelatihanMP(e.params.data.NIK, $('#filterPelatihan').val(), function(dd) {
                    e.params.data.training_matrix = dd.alreadyTraining
                    console.log(e.params.data)
                    $('#table-data').bootstrapTable('append', e.params.data)
                })
            }
        })

        $('#filterPelatihan').on("select2:select", function(e){
            console.log("filterPelatihan : ", e.params.data)
            datepicker.setDate({clear: true})
            $('#textPelatihan').text(e.params.data.text)
            $('#textMandatory').text(e.params.data.mandatory)
            $('#textKategori').text(e.params.data.kategori)
            $('#textOffOnline').text(e.params.data.offline_online_nama)

            getSyaratAndStdJab(e.params.data.id, function(data) {
                let syarat = []
                let stdJab = []
                $("#table-data").bootstrapTable('removeAll')
                $("#table-syarat").bootstrapTable('removeAll')
                $("#table-std-jabatan").bootstrapTable('removeAll')
                $("#table-syarat").bootstrapTable('load', data.syarat)
                $("#table-std-jabatan").bootstrapTable('load', data.std_jabatan)

                data.syarat.forEach(nilai => {
                    syarat.push(`${nilai.syarat_nama} ${nilai.syarat_operasi} ${nilai.syarat_nilai}${nilai.syarat_uom}`)
                })
                data.std_jabatan.forEach(std => {
                    stdJab.push(`${std.jabatan}`)
                })

                $("#textSyarat").text(syarat.join(", "))
                $("#textJabatan").text(stdJab.join(", "))
            })
        })

        function checkPelatihanMP(NIK, trainingID, cbFunc) {
            let sudahPelatihan = true
            
            axios.get(baseUrl + '/helper/check-pelatihan-mp', {
                params: {
                    NIK: NIK,
                    trainingID: trainingID
                }
            })
            .then(function(resp) {
                cbFunc(resp.data)
            })
            .catch(function(err) {
                console.log('Error : ' + err)
            })
            .finally(function() {
            })
        }

        function resetNIK(e) {
            $('#cariKaryawan').val(null).trigger('change'); 
        }

        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }

        function getSyaratAndStdJab(trainingID, funcCB=null) {
            console.log("starting getSyaratAndStdJab : ")
            showLoading()
            axios.get(baseUrl + '/helper/training-syarat-std', {
                params: {
                    trainingID: trainingID
                }
            })
            .then(function(resp) {
                // console.log(resp)
                if(funcCB) {
                    funcCB(resp.data)
                }
            })
            .catch(function(err) {
                console.log('Error : ' + err)
            })
            .finally(function() {
                stopLoading()
            })
        }

        function validateInputPelatihan() {
            let errMsg = [];
            if ($("#filterPelatihan").val() == '') errMsg.push('Training belum dipilih !')
            if ($("#inputPeriode").val() == '')  errMsg.push('Waktu pelatihan belum dipilih !')
            
            return errMsg
        }

        function validateStdJabatan(KodeJB) {

        }

        function calculateMasaKerja(tmk, tglPelatihan) {
            const firstDate = new Date(tmk)

            const firstDateInMs = firstDate.getTime()
            const secondDateInMs = tglPelatihan.getTime()

            const differenceBtwDates = secondDateInMs - firstDateInMs

            const aDayInMs = 24 * 60 * 60 * 1000

            const daysDiff = Math.round(differenceBtwDates / aDayInMs)

            console.log(daysDiff)
            return daysDiff
        }

        function trainingFormatter(value, row, index) {
            return value ? "Sudah Pernah" : "Belum Pernah";
        }

        function masaKerjaFormatter(value, row, index) {
            let masaKerja = calculateMasaKerja(row.tmk, datepicker.getDate()) / 365
            if(row.tmk) return masaKerja.toFixed(2)
        }

        function matrixFormatter(value, row, index) {
            // let nilai = $("#table-std-jabatan").bootstrapTable('getData').filter((nilai) => nilai.KodeJB == row.KodeJB) 
            // console.log({
            //     nilai: nilai,
            //     value: row.KodeJB
            // })

            // return nilai.length < 1 ? 'Tidak Sesuai' : 'Sesuai'
            if(value == 0) return 'Tidak Sesuai'
            if(value == 1) return 'Sesuai'

            return value
        }

        function actionFormatter(value, row, index) {
            return `<button class="btn btn-danger btn-action-format" onclick="hapusItem(${index})"><i class="bi bi-trash-fill"></i></button>`
        }

        function hapusItem(index) {
            $("#table-data").bootstrapTable('remove', {
                field: '$index',
                values: [index]
            })
        }

        function submitPengajuan(e) {
            showLoading()
            let tgl = datepicker.getDate()
            let bulan = 0
            let tahun = 0
            // console.log(datepicker.getDate())
            if(tgl) {
                bulan = tgl.getMonth() + 1
                tahun = tgl.getFullYear()
            }

            const dataBody = {
                pelatihanID: $('#filterPelatihan').val(),
                bulan: bulan,
                tahun: tahun,
                detail: $("#table-data").bootstrapTable("getData")
            }

            axios.post(baseUrl + "/submit-pengajuan", dataBody, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(resp) {
                console.log(resp)
            })
            .catch(function(err) {
                console.log(err)
            })
            .finally(function() {
                stopLoading()
            })
        }
    </script>
@endsection