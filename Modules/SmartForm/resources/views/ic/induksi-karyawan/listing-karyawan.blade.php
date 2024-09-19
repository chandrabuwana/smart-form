@extends('master.master_page_ext')

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
                                    Pelapor : Karyawan Induksi
                                </p>
                            </div>
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
                                        <input class="form-control" type="text" placeholder=" - Masukkan Nama -"
                                            name="nNama" required id="nNama">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nNik" class="ms-0">NIK</label>
                                        <input class="form-control" type="text" name="nNik"
                                            placeholder=" - Masukkan NIK -" required id="nNik">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nJabatan" class="ms-0">Jabatan</label>
                                        <input class="form-control" type="text" name="nJabatan"
                                            placeholder=" - Masukkan Jabatan -" required id="nJabatan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nDept" class="ms-0">Devisi / Department</label>
                                        <input class="form-control" type="text" placeholder=" - Masukkan Department -"
                                            name="nDept" required id="nDept">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-2">
                                        <label for="nInstansi" class="ms-0">Nama Instansi</label>
                                        <input class="form-control" type="text" name="nInstansi"
                                            placeholder=" - Masukkan Instansi -" required id="nInstansi">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-between">
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


        $(document).ready(function() {

            function formatSelectingAfterSelectNIK(repo) {
                $("#nNama").val(repo.name);
                $("#nDept").val(repo.dept);

                return repo.text;
            }
        })

        function collectData() {
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
                code: <?php echo json_encode($code); ?>
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
                            text: response.message,
                        })
                        $('#nJenisInduksi').val("");
                        $('#nNama').val("");
                        $('#nNik').val("");
                        $('#nJabatan').val("");
                        $('#nDept').val("");
                        $('#nInstansi').val("");
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
    </script>
    <script type="text/javascript">
        function checkMaxValue(input) {
            if (input.value > 24) {
                input.value = 24;
            }
        }
    </script>
@endsection
