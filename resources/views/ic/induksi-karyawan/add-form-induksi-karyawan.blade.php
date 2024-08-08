@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .select2-dropdown {
            overflow: scroll;
            height: 300px;
        }

        .custom-width-1 {
            width: 30%;
            /* Example width, adjust as needed */
        }


        .close-button-why {
            position: absolute;
            top: 0;
            right: 0;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background-color: black;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate(50%, -50%);
        }

        .close-button-why:hover {
            background-color: darkred;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            /* Menyesuaikan dengan form-control di Bootstrap 5 */
        }

        /* Menyesuaikan tinggi baris teks dalam pilihan */
        .select2-container--bootstrap-5 .select2-selection__rendered {
            line-height: calc(1.5em + .75rem + 2px);
        }

        .scrollable-div {
            width: 100%;
            height: 400px;
            overflow: auto;
            position: relative;
        }

        fieldset {
            border: 2px solid #ddd;
            /* Border for the fieldset */
            padding: 1.5em;
            /* Padding inside the fieldset */
            margin-bottom: 1.5em;
            /* Margin below the fieldset */
            position: relative;
            /* Position relative to handle absolute positioned legend */
        }

        legend {
            font-size: 1.25em;
            /* Font size for the legend */
            font-weight: bold;
            /* Make the legend text bold */
            padding: 0 10px;
            /* Padding to give some space on left and right */
            background-color: white;
            /* Background color to match the page's background */
            position: absolute;
            /* Position the legend absolutely */
            top: -1em;
            /* Move it up above the border */
            left: 10px;
            /* Adjust left position */
        }

        .zoomable-content {
            transform-origin: 0 0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form Induksi Karyawan</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Pelapor : {{ session('username') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="pc_no" value="1">
                    <div class="card-body">
                        <div class="row" id="tabel_tambah">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nNama" class="ms-0">Nama</label>
                                        <input class="form-control" type="text" name="nNama" required id="nNama">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nNik" class="ms-0">NIK</label>
                                        <input class="form-control" type="text" name="nNik" required id="nNik">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nJabatan" class="ms-0">Jabatan</label>
                                        <input class="form-control" type="text" name="nJabatan" required id="nJabatan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nDept" class="ms-0">Devisi / Department</label>
                                        <input class="form-control" type="text" name="nDept" required id="nDept">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nInstansi" class="ms-0">Nama Instansi</label>
                                        <input class="form-control" type="text" name="nInstansi" required id="nInstansi">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="nJenisInduksi">Jenis Induksi</label>
                                        <select class="form-control" name="nJenisInduksi" id="nJenisInduksi" required>
                                            <option value="" selected> -- Pilih --</option>
                                            <option value="1">Karyawan Baru</option>
                                            <option value="2">Karyawan</option>
                                            <option value="3">Siswa Magang</option>
                                            <option value="4">Subkontraktor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- untuk jenis induksi ICGS --}}

                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group input-group-static my-4">
                                    <label class="ms-0" for="fm_jenisInduksi">Jenis Form Induksi</label>
                                    <select class="form-control" name="fm_jenisInduksi" id="fm_jenisInduksi"
                                        onchange="triggerDataInduksi()" required>
                                        <option value="" selected> -- Pilih --</option>
                                        <option value="ICGS">ICGS</option>
                                        <option value="SHE">SHE</option>
                                        <option value="OD">OD</option>
                                        <option value="DEPT">Dept. Terkait</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark my-sm-1">
                        <div class="row">
                            <table class="tableOfPertanyaan d-none" data-click-to-select="true" id="DataListInduksiICGS"
                                width="50px" data-toggle="table" data-data-type="json" data-unique-id="IdQuestionaire">
                                <thead>
                                    <tr>
                                        <th data-field="IdQuestionaire" data-checkbox="true"></th>
                                        <th data-field="Questionaire" data-halign="center" class="custom-width-1"
                                            data-sortable="true">
                                            Complaint</th>
                                        <th data-field="QuestionaireGroup" data-width="1" data-halign="center"
                                            data-align="center" data-formatter="formaterInputNamaInduktor">
                                            Nama Mentor</th>
                                        <th data-field="QuestionaireGroup" data-halign="center" data-width="150"
                                            data-formatter="formaterInputTanggalInduksi" data-align="center">
                                            Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <table class="tableOfPertanyaan d-none" data-click-to-select="true" id="DataListInduksiSHE"
                                width="50px" data-toggle="table" data-data-type="json"
                                data-unique-id="IdQuestionaire">
                                <thead>
                                    <tr>
                                        <th data-field="IdQuestionaire" data-checkbox="true"></th>
                                        <th data-field="Questionaire" data-halign="center" class="custom-width-1"
                                            data-sortable="true">
                                            Complaint</th>
                                        <th data-field="QuestionaireGroup" data-width="1" data-halign="center"
                                            data-align="center" data-formatter="formaterInputNamaInduktor">
                                            Nama Mentor</th>
                                        <th data-field="QuestionaireGroup" data-halign="center" data-width="150"
                                            data-formatter="formaterInputTanggalInduksi" data-align="center">
                                            Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <table class="tableOfPertanyaan d-none" data-click-to-select="true" id="DataListInduksiOD"
                                width="50px" data-toggle="table" data-data-type="json"
                                data-unique-id="IdQuestionaire">
                                <thead>
                                    <tr>
                                        <th data-field="IdQuestionaire" data-checkbox="true"></th>
                                        <th data-field="Questionaire" data-halign="center" class="custom-width-1"
                                            data-sortable="true">
                                            Complaint</th>
                                        <th data-field="QuestionaireGroup" data-width="1" data-halign="center"
                                            data-align="center" data-formatter="formaterInputNamaInduktor">
                                            Nama Mentor</th>
                                        <th data-field="QuestionaireGroup" data-halign="center" data-width="150"
                                            data-formatter="formaterInputTanggalInduksi" data-align="center">
                                            Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <table class="tableOfPertanyaan d-none" data-click-to-select="true" id="DataListInduksiDEPT"
                                width="50px" data-toggle="table" data-data-type="json"
                                data-unique-id="IdQuestionaire">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="Questionaire" data-halign="center" class="custom-width-1"
                                            data-sortable="true">
                                            Complaint</th>
                                        <th data-field="QuestionaireGroup" data-width="1" data-halign="center"
                                            data-align="center" data-formatter="formaterInputNamaInduktor">
                                            Nama Mentor</th>
                                        <th data-field="QuestionaireGroup" data-halign="center" data-width="150"
                                            data-formatter="formaterInputTanggalInduksi" data-align="center">
                                            Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                onclick="collectData()">
                                <i class="fas fa-save"></i>
                                Save All Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        $(document).ready(function() {
            var dataPertanyaan = [];
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-ref-IC-form-induksi",
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        dataPertanyaan = response.data

                        var pertanyaanICGS = $.grep(dataPertanyaan, function(item) {
                            return item.QuestionaireGroup === 'ICGS';
                        });
                        $('#DataListInduksiICGS').bootstrapTable('load', pertanyaanICGS);

                        var pertanyaanSHE = $.grep(dataPertanyaan, function(item) {
                            return item.QuestionaireGroup === 'SHE';
                        });
                        $('#DataListInduksiSHE').bootstrapTable('load', pertanyaanSHE);

                        var pertanyaanOD = $.grep(dataPertanyaan, function(item) {
                            return item.QuestionaireGroup === 'OD';
                        });
                        $('#DataListInduksiOD').bootstrapTable('load', pertanyaanOD);

                        var pertanyaanDept = $.grep(dataPertanyaan, function(item) {
                            return item.QuestionaireGroup === 'DEPT';
                        });
                        $('#DataListInduksiDEPT').bootstrapTable('load', pertanyaanDept);


                        $('.due-date-picker').each(function() {
                            $(this).datepicker({
                                format: 'dd - mmm - yyyy', // Set format to "12 - Oct - 1998"
                                // uiLibrary: 'bootstrap5' // Optional: use Bootstrap 4 for styling
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'thrownError',
                            html: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            })








        })

        function triggerDataInduksi() {
            $(".tableOfPertanyaan").addClass("d-none");
            if ($("#fm_jenisInduksi").val() == "ICGS") {
                $("#DataListInduksiICGS").removeClass("d-none");
            } else if ($("#fm_jenisInduksi").val() == "SHE") {
                $("#DataListInduksiSHE").removeClass("d-none");
            } else if ($("#fm_jenisInduksi").val() == "OD") {
                $("#DataListInduksiOD").removeClass("d-none");
            } else if ($("#fm_jenisInduksi").val() == "DEPT") {
                $("#DataListInduksiDEPT").removeClass("d-none");
            }
        }

        function formaterInputNamaInduktor(value, row, index) {
            let html = `<input type="text" id="input_${value}_${row.iden}" placeholder="Nama Induktor" />`
            return html;
        }

        function formaterInputTanggalInduksi(value, row, index) {
            let html = `
                    <input class="form-control due-date-picker" type="text"
                        placeholder="" name="tanggal_${value}_${index+1}" required
                        id="tanggal_${value}_${row.iden}">
            `
            return html;
        }

        function collectData() {
            let dataJenisInduksi = $('#fm_jenisInduksi').val()
            let checkedData = [];

            var dataListSelection = $(`#DataListInduksi${dataJenisInduksi}`).bootstrapTable('getSelections');

            dataListSelection.forEach(function(item, index) {
                var data = {
                    id: item.iden, // Menambahkan 1 karena index dimulai dari 0
                    group: item.QuestionaireGroup, // Menambahkan 1 karena index dimulai dari 0
                    mentor: $(`#input_${dataJenisInduksi}_` + item.iden).val(),
                    tanggal: $(`#tanggal_${dataJenisInduksi}_` + item.iden).val(),
                };
                checkedData.push(data);
            });

            let dataMaster = {
                nama: $('#nNama').val(),
                nik: $('#nNik').val(),
                jabatan: $('#nJabatan').val(),
                department: $('#nDept').val(),
                instansi: $('#nInstansi').val(),
                jenisInduksi: $('#nJenisInduksi').val(),
                group: $('#fm_jenisInduksi').val(),
            }

            let dataKirim = {
                master: dataMaster,
                data: checkedData
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form-IC-form-induksi-add",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {})
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            })

        }
    </script>
    <script type="text/javascript">
        function checkMaxValue(input) {
            if (input.value > 24) {
                input.value = 24;
            }
        }
    </script>
@endsection
