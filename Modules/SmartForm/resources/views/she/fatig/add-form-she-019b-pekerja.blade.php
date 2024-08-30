@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .select2-dropdown {
            overflow: scroll;
            height: 300px;
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
                        <h6 class="text-white text-capitalize ps-3">Form Pra-Check Fatigue</h6>
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
                                    <div class="input-group input-group-static my-4">
                                        <label for="location" class="ms-0">Lokasi</label>
                                        <input class="form-control" type="text" name="location" required id="location">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-4">
                                        <label for="no_unit" class="ms-0">No. Unit</label>
                                        <input class="form-control" type="text" name="no_unit" required id="no_unit">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-4">
                                        <label for="jml_tdr" class="ms-0">Jumlah Jam Tidur</label>
                                        <input class="form-control" type="number" inputmode="decimal"
                                            onkeypress="return /[0-9.)]/i.test(event.key)" pattern="[0-9]*[.]?[0-9]*"
                                            name="jml_tdr" required id="jml_tdr" max="24"
                                            onkeyup="checkMaxValue(this)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="fm_1">Mengantuk</label>
                                        <select class="form-control" name="fm_1" id="fm_1" required>
                                            <option value="" selected> -- Pilih --</option>
                                            <option value="Y">Ya</option>
                                            <option value="T">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="fm_2">Sakit</label>
                                        <select class="form-control" name="fm_2" id="fm_2" required>
                                            <option value="" selected> -- Pilih --</option>
                                            <option value="Y">Ya</option>
                                            <option value="T">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="fm_3">Minum Obat</label>
                                        <select class="form-control" name="fm_3" id="fm_3" required>
                                            <option value="" selected> -- Pilih --</option>
                                            <option value="Y">Ya</option>
                                            <option value="T">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="fm_4">Sedang Memiliki Masalah</label>
                                        <select class="form-control" name="fm_4" id="fm_4" required>
                                            <option value="" selected> -- Pilih --</option>
                                            <option value="Y">Ya</option>
                                            <option value="T">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
    <script type="text/javascript">
        function collectData() {
            let dataKirim = {
                location: $('#location').val(),
                no_unit: $('#no_unit').val(),
                jml_tdr: $('#jml_tdr').val(),
                fm_1: $('#fm_1').val(),
                fm_2: $('#fm_2').val(),
                fm_3: $('#fm_3').val(),
                fm_4: $('#fm_4').val()
            };

            let fieldNames = {
                location: 'location',
                no_unit: 'Nomor Unit',
                jml_tdr: 'Jumlah TDR',
                fm_1: 'Form Mengantuk',
                fm_2: 'Form Sakit',
                fm_3: 'Form Minum Obat',
                fm_4: 'Form Permasalahan'
            };

            for (let key in dataKirim) {
                if (!dataKirim[key]) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: `Mohon isi inputan ${fieldNames[key]} terlebih dahulu`
                    });
                    return; // Stop the validation if a field is empty
                }
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/she-019B/store",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            $('#location').val('');
                            $('#no_unit').val('');
                            $('#jml_tdr').val('');
                            $('#fm_1').val('');
                            $('#fm_2').val('');
                            $('#fm_3').val('');
                            $('#fm_4').val('');
                            window.location.href = `/bss-form/she-019B/dashboard`;
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
