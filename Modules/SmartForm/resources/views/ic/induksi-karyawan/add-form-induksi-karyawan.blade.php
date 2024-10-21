@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .display-block {
            display: contents !important;
        }

        .select2-dropdown {
            overflow: scroll;
            height: 300px;
        }

        .custom-width-1 {
            width: 90%;
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
                                    <br>
                                    Link :
                                <p class="{{ $link == '' ? 'd-none' : '' }}" id="linkKaryawanList"></p>
                                </p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-4">
                        <div class="input-group input-group-static my-4">
                            <label for="pc_site" class="ms-0">Site </label>
                            <select class="form-control dept" name="pc_site" id="pc_site">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <button id="buttonGenerateLinkButton" class="btn btn-primary ms-auto uploadBtn"
                                onclick="GenerateLink()" {{ $link == '' ? '' : 'disabled' }}>
                                Generate Link</button>
                        </div>
                    </div>

                    <input type="hidden" name="pc_no" value="1">
                    <div class="card-body">
                        <div class="row" id="tabel_tambah">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nNama" class="ms-0">Nama</label>
                                        <input class="form-control" type="text" name="nNama" required id="nNama">
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nNik" class="ms-0">NIK</label>
                                        <input class="form-control" type="text" name="nNik" required id="nNik">
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="input-group select-div input-group-static my-2">
                                        <label for="nNik" class="ms-0">NIK</label>
                                        <select class="form-control s2lea" name="nNik" id="nNik" required></select>
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
                                <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                    onclick="AddDAtaKaryawan()">
                                    <i class="fas fa-save"></i>
                                    Add Karyawan Induksi</button>
                            </div>

                        </div>
                        <hr class="horizontal dark my-sm-4">
                        <div class="row" id="tabel_list_karyawan">
                            <input type="hidden" name="FILTERCODE" id="FILTERCODE" value="{{ $code == '' ? '' : $code }}">
                            <div class="row" style="padding-left: 0px !important;">
                                <div class="col" style="padding-left: 0px !important;">
                                    <fieldset class="color-fieldset form-horizontal">
                                        <legend class="color-legend">
                                            <span>List Of Karyawan</span>
                                        </legend>
                                        <div id="toolbar">
                                            <button id="button" class="btn btn-secondary"
                                                onclick="RefreshTableListOfKaryawan()">refresh</button>
                                        </div>
                                        <div class="form-horizontal">
                                            <table class="" id="TableKaryawanList" data-toggle="table"
                                                data-ajax="dataListKaryawan" data-data-type="json"
                                                data-query-params-type="limit" data-unique-id="nik" refre
                                                data-query-params="dataListKaryawanParamsGenerate" data-pagination="true">
                                                <thead>
                                                    <tr>
                                                        <th data-field="nik" data-halign="center" data-sortable="true">
                                                            NIK</th>
                                                        <th data-field="Nama" data-halign="center" data-sortable="true">
                                                            Nama</th>
                                                        <th data-field="Department" data-halign="center"
                                                            data-sortable="true">
                                                            Department</th>
                                                        <th data-halign="center" data-align="center"
                                                            data-formatter="FormaterActionListKaryawan">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <hr class="horizontal dark my-sm-3">
                            <div class="row">
                                <div class="col">
                                    <h3> -- ICGS -- </h3>
                                </div>
                            </div>
                            <table class="tableOfPertanyaan" data-click-to-select="true" id="DataListInduksiICGS"
                                data-toggle="table" data-data-type="json" data-unique-id="IdQuestionaire">
                                <thead>
                                    <tr>
                                        <th data-field="IdQuestionaire" data-width="10px" data-checkbox="true"></th>
                                        <th data-field="Questionaire" data-halign="center" class="custom-width-1"
                                            data-sortable="true">
                                            Complaint</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <hr class="horizontal dark my-sm-2">
                            <div class="row">
                                <div class="col">
                                    <h3> -- SHE --</h3>
                                </div>
                            </div>
                            <table class="tableOfPertanyaan " data-click-to-select="true" id="DataListInduksiSHE"
                                width="50px" data-toggle="table" data-data-type="json"
                                data-unique-id="IdQuestionaire">
                                <thead>
                                    <tr>
                                        <th data-field="IdQuestionaire" data-checkbox="true"></th>
                                        <th data-field="Questionaire" data-halign="center" class="custom-width-1"
                                            data-sortable="true">
                                            Complaint</th>
                                        {{-- <th data-field="QuestionaireGroup" data-width="1" data-halign="center"
                                            data-align="center" data-formatter="formaterInputNamaInduktor">
                                            Nama Mentor</th>
                                        <th data-field="QuestionaireGroup" data-halign="center" data-width="150"
                                            data-formatter="formaterInputTanggalInduksi" data-align="center">
                                            Tanggal</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <hr class="horizontal dark my-sm-2">
                            <div class="row">
                                <div class="col">
                                    <h3> -- OD -- </h3>
                                </div>
                            </div>
                            <table class="tableOfPertanyaan" data-click-to-select="true" id="DataListInduksiOD"
                                width="50px" data-toggle="table" data-data-type="json"
                                data-unique-id="IdQuestionaire">
                                <thead>
                                    <tr>
                                        <th data-field="IdQuestionaire" data-checkbox="true"></th>
                                        <th data-field="Questionaire" data-halign="center" class="custom-width-1"
                                            data-sortable="true">
                                            Complaint</th>
                                        {{-- <th data-field="QuestionaireGroup" data-width="1" data-halign="center"
                                            data-align="center" data-formatter="formaterInputNamaInduktor">
                                            Nama Mentor</th>
                                        <th data-field="QuestionaireGroup" data-halign="center" data-width="150"
                                            data-formatter="formaterInputTanggalInduksi" data-align="center">
                                            Tanggal</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <hr class="horizontal dark my-sm-2">
                            <div class="row">
                                <div class="col">
                                    <h3> -- DEPT -- </h3>
                                </div>
                            </div>
                            <table class="tableOfPertanyaan" data-click-to-select="true" id="DataListInduksiDEPT"
                                width="50px" data-toggle="table" data-data-type="json"
                                data-unique-id="IdQuestionaire">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="Questionaire" data-halign="center" class="custom-width-1"
                                            data-sortable="true">
                                            Complaint</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <hr class="horizontal dark my-sm-4">
                        <div class="row" id="tabel_tambah">
                            <div class="row" style="padding-left: 0px !important;">
                                <div class="col" style="padding-left: 0px !important;">
                                    <fieldset class="color-fieldset form-horizontal">
                                        <legend class="color-legend">
                                            <span>Materi Tambahan</span>
                                        </legend>
                                        <div class="form-horizontal">
                                            <table class="" id="MateriTambahanInputData" data-toggle="table"
                                                data-data-type="json" data-query-params-type="limit"
                                                data-unique-id="concat" data-pagination="true">
                                                <thead>
                                                    <tr>
                                                        <th data-field="description" data-halign="center"
                                                            data-sortable="true">
                                                            Materi</th>
                                                        <th data-field="nikMateriTambahan" data-halign="center">NIK</th>
                                                        <th data-halign="center" data-align="center"
                                                            data-formatter="MateriTambahanInputDataActionFormater">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot class="display-block" style="display: block !important">
                                                    <tr>
                                                        <!-- Description ---->
                                                        <th data-field="description" data-align="left">
                                                            <div class="input-group input-group-static my-2">
                                                                <input id="materiInduksiTambahan" style="margin:5px"
                                                                    placeholder=" -- Masukkan Materi Induksi -- "
                                                                    type="text" class="form-control uppercase"
                                                                    maxlength="50">
                                                            </div>
                                                        </th>

                                                        {{-- nik --}}
                                                        <th data-field="nikMateriTambahan" data-align="left">
                                                            <div class="input-group input-group-static my-2">
                                                                <input id="nikInduksiTambahan" style="margin:5px"
                                                                    placeholder=" -- Masukkan NIK Induktor -- "
                                                                    type="number"
                                                                    oninput="this.value = Math.abs(this.value)"
                                                                    class="form-control uppercase" maxlength="50">
                                                            </div>
                                                        </th>

                                                        <!-- action ---->
                                                        <th data-align="center"
                                                            style="text-align: center; vertical-align : middle !important">
                                                            <button
                                                                onclick="MateriTambahanInputData_InitAddDataTable_obj(this);"><a
                                                                    class="like" title="Like">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </a></button>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-between">
                            <div class="col-md-3">
                                <button class="btn btn-primary ms-auto back-button-by-history">
                                    <i class="fas fa-back"></i>
                                    Back Page</button>
                            </div>
                            <div class="col-md-3">
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
    </div>
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        var MateriTambahanInputData_Obj_datas = [];
        var linkKaryawan = <?php echo json_encode($link); ?>

        $('#pc_site').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#pc_site').closest('.input-group'),
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

        function AddDAtaKaryawan() {
            if ($("#FILTERCODE").val() == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harus Generate Link Terlebih Dahulu!'
                });
                return false;
            }

            var nJenisInduksi = $('#nJenisInduksi').val();
            var nNama = $('#nNama').val().trim();
            var nNik = $('#nNik').val().trim();
            var nJabatan = $('#nJabatan').val().trim();
            var nDept = $('#nDept').val().trim();
            var nInstansi = $('#nInstansi').val().trim();

            // Validasi masing-masing field
            if (nJenisInduksi === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Jenis Induksi harus dipilih!'
                });
                return false;
            }

            if (nNama === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nama harus diisi!'
                });
                return false;
            }

            if (nNik === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'NIK harus diisi!'
                });
                return false;
            }

            if (nJabatan === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Jabatan harus diisi!'
                });
                return false;
            }

            if (nDept === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Department harus diisi!'
                });
                return false;
            }

            if (nInstansi === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Instansi harus diisi!'
                });
                return false;
            }

            let dataMaster = {
                nama: $('#nNama').val(),
                nik: $('#nNik').val(),
                jabatan: $('#nJabatan').val(),
                department: $('#nDept').val(),
                instansi: $('#nInstansi').val(),
                jenisInduksi: $('#nJenisInduksi').val(),
                group: $('#fm_jenisInduksi').val(),
                code: $('#FILTERCODE').val()
            }

            let dataKirim = {
                master: dataMaster,
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/induksi-karyawan/listing-karyawan-add",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: "Karyawan Sudah Ditambahkan",
                        })
                        $('#nJenisInduksi').val("");
                        $('#nNama').val("");
                        $('#nNik').val("");
                        $('#nJabatan').val("");
                        $('#nDept').val("");
                        $('#nInstansi').val("");
                        RefreshTableListOfKaryawan();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error While Add Data',
                            html: message,
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

        }

        function dataListKaryawan(params) {
            var url = '/bss-form/induksi-karyawan/lst-karyawan-induksi'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }

        function RefreshTableListOfKaryawan() {
            $('#TableKaryawanList').bootstrapTable('refresh');
        }

        function dataListKaryawanParamsGenerate(params) {

            params.search = {
                'FILTERCODE': $('#FILTERCODE').val()
            };

            if (params.sort == undefined) {
                return {
                    limit: params.limit,
                    offset: params.offset,
                    search: params.search
                }
            }
            return params;
        }

        function MateriTambahanInputData_InitAddDataTable_obj(obj) {
            if ($('#materiInduksiTambahan').val() == '') {
                Swal.fire(
                    'Validation Failed', "Materi cannot be empty", 'error'
                )
                return false;
            }
            if ($('#nikInduksiTambahan').val() == '') {
                Swal.fire(
                    'Validation Failed', "NIK cannot be empty", 'error'
                )
                return false;
            }

            let data_obj = {};
            data_obj.description = $('#materiInduksiTambahan').val();
            data_obj.nikMateriTambahan = $('#nikInduksiTambahan').val();
            data_obj.concat = $('#materiInduksiTambahan').val() + " - " + $(
                '#nikInduksiTambahan').val();
            data_obj.concat = $('#materiInduksiTambahan').val() + " - ";
            $('#materiInduksiTambahan').val('')
            $('#nikInduksiTambahan').val('')
            MateriTambahanInputData_Obj_datas.push(data_obj);
            $('#MateriTambahanInputData').bootstrapTable('refresh');
            $('#MateriTambahanInputData').bootstrapTable('load',
                MateriTambahanInputData_Obj_datas);
        }

        function MateriTambahanInputDataActionFormater(value, row, index) {
            return `
                    <a class="like" href="javascript:void(0)" onclick="MateriTambahanInputData_InitDeletedDataTable_obj(this)" title="Like">
                        <i class="fa fa-trash"></i>
                    </a>
                `
        }

        function FormaterActionListKaryawan(value, row, index) {
            return `
                    <a class="like" href="javascript:void(0)" onclick="DeletedDataDetailKaryawanListing(this)" title="Like">
                        <i class="fa fa-trash"></i>
                    </a>
                `
        }

        function DeletedDataDetailKaryawanListing(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            let getUniqId = $('#TableKaryawanList').bootstrapTable('getData')[indexDt];

            let dataKirim = {
                code: getUniqId.code,
                nik: getUniqId.nik
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/induksi-karyawan/listing-karyawan-deleted",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: "Karyawan Sudah Dihapus",
                        })
                        RefreshTableListOfKaryawan();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error While Deleted Data',
                            html: message,
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
        }

        function MateriTambahanInputData_InitDeletedDataTable_obj(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            let getUniqId = $('#MateriTambahanInputData').bootstrapTable('getData')[indexDt];


        }

        $(document).ready(function() {
            $('#FILTERCODE').val("")

            $("#linkKaryawanList").html(window.location.origin + linkKaryawan)

            function formatSelectingAfterSelectNIK(repo) {
                $("#nNama").val(repo.name);
                $("#nDept").val(repo.dept);

                return repo.text;
            }

            $('#nNik').select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                dropdownParent: $('#nNik').closest('.select-div'),
                placeholder: '--- Cari/Pilih NIK ---',
                ajax: {
                    url: "/bss-form/induksi-karyawan/helper-data-nik",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            query: params.term, // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                },
                templateSelection: formatSelectingAfterSelectNIK
            });


            var dataPertanyaan = [];
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/induksi-karyawan/form-induksi",
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
            let html =
                `<input type="text" id="input_${value}_${row.iden}" placeholder="NIK Induktor" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />`
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

        function GenerateLink() {
            let site = $('#pc_site').val();

            if (site == "" || site == null) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Mohon Isikan Site",
                });
                return false
            }

            let dataKirimGenerateLink = {
                site: site
            }
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/induksi-karyawan/generate-link",
                dataType: 'json',
                data: dataKirimGenerateLink,
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: "success",
                            title: "Your Link",
                            text: window.location.origin + response.data,
                        });
                        $("#linkKaryawanList").html(window.location.origin + response.data);
                        $("#linkKaryawanList").removeClass("d-none");
                        $("#buttonGenerateLinkButton").prop("disabled", true);
                        $('#FILTERCODE').val(response.codeR)
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.data,
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
        }

        function collectCheckedData(selections) {
            return selections.map(item => ({
                id: item.iden,
                group: item.QuestionaireGroup
            }));
        }

        function collectData() {
            let dataJenisInduksi = $('#fm_jenisInduksi').val()
            let checkedDataICGS = [];
            let checkedDataOD = [];
            let checkedDataSHE = [];
            let checkedDataDEPT = [];

            checkedDataICGS = collectCheckedData($(`#DataListInduksiICGS`).bootstrapTable('getSelections'));
            checkedDataOD = collectCheckedData($(`#DataListInduksiOD`).bootstrapTable('getSelections'));
            checkedDataSHE = collectCheckedData($(`#DataListInduksiSHE`).bootstrapTable('getSelections'));
            checkedDataDEPT = collectCheckedData($(`#DataListInduksiDEPT`).bootstrapTable('getSelections'));


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
                code: $('#FILTERCODE').val(),
                dataICGS: checkedDataICGS,
                dataOD: checkedDataOD,
                dataSHE: checkedDataSHE,
                dataDEPT: checkedDataDEPT,
                pertanyaanTambahan: MateriTambahanInputData_Obj_datas
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/induksi-karyawan/form-add",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            window.location.href = "/bss-form/induksi-karyawan/dashboard"
                        })
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
